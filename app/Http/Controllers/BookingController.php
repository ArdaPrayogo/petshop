<?php

namespace App\Http\Controllers;

use App\Models\Pet;
use App\Models\Bill;
use App\Models\Booking;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    public function index()
    {
        // Ambil ID booking yang muncul di tabel pivot (booking_service), hanya sekali per ID
        $bookingIds = DB::table('booking_service')
            ->select('booking_id')
            ->groupBy('booking_id')
            ->pluck('booking_id');
        // dd($bookingIds);

        // Ambil data booking yang ID-nya ada di hasil di atas, lengkap dengan pet, user, services
        $bookings = Booking::with(['pet.user', 'services'])
            ->whereIn('id', $bookingIds)
            ->orderByDesc('schedule_time')
            ->get();

        return view('bookings.index', compact('bookings'));
    }

    public function create()
    {
        $pets = Pet::with('user')->get();
        $services = Service::all();
        return view('bookings.create', compact('pets', 'services'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'pet_id' => 'required|exists:pets,id',
            'services' => 'required|array|min:1',
            'services.*' => 'exists:services,id',
            'schedule_time' => 'required|date',
        ]);

        $booking = Booking::create([
            'pet_id' => $validated['pet_id'],
            'schedule_time' => $validated['schedule_time'],
            'status' => 'pending',
        ]);

        // Simpan ke pivot table booking_service
        $booking->services()->attach($validated['services']);

        return redirect()->route('bookings.index')->with('success', 'Jadwal layanan berhasil disimpan.');
    }

    public function show(Booking $booking)
    {
        return view('bookings.show', compact('booking'));
    }

    public function edit(Booking $booking)
    {
        $pets = Pet::with('user')->get();
        $services = Service::all();
        return view('bookings.edit', compact('booking', 'pets', 'services'));
    }

    public function update(Request $request, Booking $booking)
    {
        $validated = $request->validate([
            'schedule_time' => 'required|date',
            'status' => 'required|in:pending,confirmed,completed,cancelled',
        ]);

        // Update status & jadwal
        $booking->update([
            'schedule_time' => $validated['schedule_time'],
            'status' => $validated['status'],
        ]);

        // Jika status menjadi 'completed' dan belum ada tagihan
        if ($validated['status'] === 'completed' && !$booking->bill) {
            $total = $booking->services->sum('price');

            Bill::create([
                'booking_id' => $booking->id,
                'total_amount' => $total,
                'status' => 'unpaid',
                'bill_date' => now(),
            ]);
        }

        return redirect()->route('bookings.index')->with('success', 'Booking berhasil diperbarui.');
    }

    public function destroy(Booking $booking)
    {
        $booking->delete();
        return redirect()->route('bookings.index')->with('success', 'Jadwal berhasil dihapus.');
    }
}
