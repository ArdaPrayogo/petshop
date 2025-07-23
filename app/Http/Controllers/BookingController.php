<?php

namespace App\Http\Controllers;

use App\Models\{Pet, Bill, Booking, Service};
use Illuminate\Http\{Request, RedirectResponse};
use Illuminate\Support\Facades\{DB, Auth};
use Illuminate\Support\Carbon;

class BookingController extends Controller
{
    public function index()
    {
        // Ambil semua booking yang punya service
        $bookingIds = DB::table('booking_service')
            ->select('booking_id')
            ->groupBy('booking_id')
            ->pluck('booking_id');

        // Ambil booking aktif (belum selesai/dibatalkan)
        $bookings = Booking::with(['pet.user'])
            ->whereIn('id', $bookingIds)
            ->whereNotIn('status', ['completed', 'cancelled'])
            ->orderBy('schedule_time')
            ->get();

        // Kelompokkan berdasarkan tanggal lengkap dalam bahasa Indonesia
        $grouped = $bookings->groupBy(function ($booking) {
            return Carbon::parse($booking->schedule_time)->translatedFormat('l, d F Y');
        });

        return view('bookings.index', compact('grouped'));
    }


    public function indexhistoryadmin()
    {
        // Ambil semua booking yang memiliki layanan
        $bookingIds = DB::table('booking_service')
            ->select('booking_id')
            ->groupBy('booking_id')
            ->pluck('booking_id');

        // Ambil booking yang statusnya sudah selesai atau dibatalkan
        $bookings = Booking::with(['pet.user'])
            ->whereIn('id', $bookingIds)
            ->whereIn('status', ['completed', 'cancelled'])
            ->orderBy('schedule_time')
            ->get();

        // Kelompokkan berdasarkan tanggal lengkap (dalam Bahasa Indonesia)
        $grouped = $bookings->groupBy(function ($booking) {
            return Carbon::parse($booking->schedule_time)->translatedFormat('l, d F Y');
        });

        return view('bookings.history', compact('grouped'));
    }


    public function indexcustomer()
    {
        $userId = Auth::id();

        $bookingIds = DB::table('booking_service')
            ->select('booking_id')
            ->groupBy('booking_id')
            ->pluck('booking_id');

        $bookings = Booking::with(['pet.user', 'services'])
            ->whereIn('id', $bookingIds)
            ->whereIn('status', ['pending', 'confirmed'])
            ->whereHas('pet', fn($q) => $q->where('user_id', $userId))
            ->orderByDesc('schedule_time')
            ->get();

        return view('customer.bookings.index', compact('bookings'));
    }

    public function indexHistoryCustomer()
    {
        $userId = Auth::id();

        $bookingIds = DB::table('booking_service')
            ->select('booking_id')
            ->groupBy('booking_id')
            ->pluck('booking_id');

        $bookings = Booking::with(['pet.user', 'services'])
            ->whereIn('id', $bookingIds)
            ->whereIn('status', ['completed', 'cancelled'])
            ->whereHas('pet', fn($q) => $q->where('user_id', $userId))
            ->orderByDesc('schedule_time')
            ->get();

        return view('customer.bookings.history', compact('bookings'));
    }


    public function create()
    {
        $pets = Pet::with('user')->get();
        $services = Service::all();

        return view('bookings.create', compact('pets', 'services'));
    }

    public function createcustomer()
    {
        $userId = Auth::id();
        $pets = Pet::where('user_id', $userId)->get();
        $services = Service::all();

        return view('customer.bookings.create', compact('pets', 'services'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'pet_id' => 'required|exists:pets,id',
            'services' => 'required|array|min:1',
            'services.*' => 'exists:services,id',
            'scheduled_at' => 'required|date|after:now',
            'pickup_service' => 'required|boolean',
        ]);

        // Pastikan waktu belum dipakai
        if (Booking::where('schedule_time', $validated['scheduled_at'])->exists()) {
            return back()->withErrors(['scheduled_at' => 'Waktu jadwal ini sudah terpakai.'])->withInput();
        }

        $booking = Booking::create([
            'pet_id' => $validated['pet_id'],
            'schedule_time' => $validated['scheduled_at'],
            'status' => 'pending',
            'pickup_service' => $validated['pickup_service'],
        ]);

        $booking->services()->attach($validated['services']);

        $previous = url()->previous();
        if (str_contains($previous, 'mybooking')) {
            return redirect('/mybooking')->with('success', 'Jadwal berhasil disimpan.');
        } else {
            return redirect()->route('bookings.index')->with('success', 'Jadwal berhasil disimpan.');
        }
    }



    public function show(Booking $booking)
    {
        return view('bookings.show', compact('booking'));
    }

    public function edit(Booking $booking)
    {
        if (request()->has('redirect_to')) {
            session(['redirect_to' => request('redirect_to')]);
        }

        $pets = Pet::with('user')->get();
        $services = Service::all();

        return view('bookings.edit', compact('booking', 'pets', 'services'));
    }



    public function update(Request $request, Booking $booking)
    {
        $validated = $request->validate([
            'schedule_time'    => 'required|date',
            'status'           => 'required|in:pending,confirmed,completed,cancelled',
            'pickup_service'   => 'required|boolean',
            'service_ids'      => 'nullable|array',
            'service_ids.*'    => 'exists:services,id',
            'pet_id'           => 'sometimes|exists:pets,id',
        ]);

        // Update utama
        $booking->update([
            'schedule_time'   => $validated['schedule_time'],
            'status'          => $validated['status'],
            'pickup_service'  => $validated['pickup_service'],
        ]);

        // Jika ada layanan, sync ulang
        if (isset($validated['service_ids'])) {
            $booking->services()->sync($validated['service_ids']);
        }

        // Jika admin mengubah pet
        if (auth()->user()->can('admin') && isset($validated['pet_id'])) {
            $booking->update(['pet_id' => $validated['pet_id']]);
        }

        // Jika completed dan belum ada bill
        if ($validated['status'] === 'completed' && !$booking->bill) {
            $total = $booking->services->sum('price');

            Bill::create([
                'booking_id'    => $booking->id,
                'total_amount'  => $total,
                'status'        => 'unpaid',
                'bill_date'     => now(),
            ]);
        }

        // Ambil asal dari session (diset saat buka form edit)
        $redirectTo = session()->pull('redirect_to', '/bookings'); // default fallback
        return redirect($redirectTo)->with('success', 'Jadwal berhasil diperbarui.');
    }



    public function destroy(Booking $booking)
    {
        $booking->delete();
        return redirect()->route('bookings.index')->with('success', 'Jadwal berhasil dihapus.');
    }

    public function cancel(Booking $booking, Request $request)
    {
        if (auth()->user()->cannot('customer') || $booking->pet->user_id !== auth()->id()) {
            abort(403);
        }

        $booking->update(['status' => 'cancelled']);
        $redirect = $request->input('redirect_to') ?? route('mybooking.index');
        return redirect($redirect)->with('success', 'Pemesanan berhasil dibatalkan.');
    }

    public function createbillcustomer(Booking $booking)
    {
        $total = $booking->services->sum('price');
        return view('customer.bills.create', compact('booking', 'total'));
    }

    public function storebillcustomer(Request $request)
    {
        $request->validate([
            'booking_id' => 'required|exists:bookings,id',
            'total_amount' => 'required|numeric|min:0',
            'paid_amount' => 'required|numeric|min:0',
            'payment_method' => 'required|in:cash,transfer,qris',
            'status' => 'required|in:paid,unpaid,cancelled',
            'bill_date' => 'required|date',
        ]);

        $booking = Booking::findOrFail($request->booking_id);
        $change = $request->paid_amount >= $request->total_amount ? $request->paid_amount - $request->total_amount : null;

        Bill::create([
            'booking_id' => $booking->id,
            'total_amount' => $request->total_amount,
            'paid_amount' => $request->paid_amount,
            'change_amount' => $change,
            'payment_method' => $request->payment_method,
            'status' => $request->status,
            'bill_date' => $request->bill_date,
        ]);

        return redirect()->route('mybill.index')->with('success', 'Tagihan berhasil dibuat dan dibayar.');
    }

    public function updateStatus(Booking $booking, $status)
    {
        $allowed = ['pending', 'confirmed', 'completed', 'cancelled'];
        if (!in_array($status, $allowed)) abort(400, 'Status tidak valid.');

        $booking->update(['status' => $status]);

        if ($status === 'completed' && !$booking->bill) {
            $total = $booking->services->sum('price');
            Bill::create([
                'booking_id' => $booking->id,
                'bill_date' => now(),
                'total_amount' => $total,
                'status' => 'unpaid',
            ]);
        }

        return redirect()->back()->with('success', 'Status berhasil diubah menjadi ' . ucfirst($status));
    }
}
