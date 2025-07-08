<?php

namespace App\Http\Controllers;

use App\Models\Pet;
use App\Models\Bill;
use App\Models\Booking;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class BookingController extends Controller
{

    public function index()
    {
        $bookingIds = DB::table('booking_service')
            ->select('booking_id')
            ->groupBy('booking_id')
            ->pluck('booking_id');

        $bookings = Booking::with(['pet.user'])
            ->whereIn('id', $bookingIds)
            ->orderBy('schedule_time')
            ->get();

        $grouped = $bookings->groupBy(function ($booking) {
            return \Carbon\Carbon::parse($booking->schedule_time)
                ->locale('id')
                ->isoFormat('dddd, D MMMM Y');
        });

        return view('bookings.index', compact('grouped'));
    }



    public function indexcustomer()
    {
        $userId = Auth::id(); // ID user login

        // Ambil ID booking yang memiliki service (jika diperlukan)
        $bookingIds = DB::table('booking_service')
            ->select('booking_id')
            ->groupBy('booking_id')
            ->pluck('booking_id');

        // Ambil booking milik user login dengan status 'pending' atau 'confirmed'
        $bookings = Booking::with(['pet.user', 'services'])
            ->whereIn('id', $bookingIds)
            ->whereIn('status', ['pending', 'confirmed']) // ✅ Filter status di sini
            ->whereHas('pet', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })
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
            ->whereIn('status', ['completed', 'cancelled']) // ✅ Hanya status riwayat
            ->whereHas('pet', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->orderByDesc('schedule_time')
            ->get();

        return view('customer.bookings.history', compact('bookings'));
    }



    public function create()
    {
        $pets = Pet::with('user')->get();
        $services = Service::all();

        $dayNames = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
        $carbonDays = [1, 2, 3, 4, 5, 6, 0]; // Carbon: 0 = Minggu, 1 = Senin, dst

        $now = Carbon::now();
        $days = [];

        foreach ($dayNames as $i => $dayName) {
            $targetDate = Carbon::now()->next($carbonDays[$i]);

            // Kalau hari ini, tetap pakai hari ini
            if ($targetDate->dayOfWeek === $now->dayOfWeek) {
                $targetDate = $now->copy();
            }

            $days[] = [
                'label' => $dayName,
                'date' => $targetDate->format('Y-m-d'),
                'display' => "$dayName ({$targetDate->format('d M Y')})"
            ];
        }

        return view('bookings.create', compact('pets', 'services', 'days'));
    }

    public function createcustomer()
    {
        $userId = Auth::id(); // ID user yang sedang login

        // Ambil hanya hewan milik user yang login
        $pets = Pet::where('user_id', $userId)->get();

        // Ambil semua layanan
        $services = Service::all();

        // Hitung daftar hari + tanggal terdekat
        $dayNames = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
        $carbonDays = [1, 2, 3, 4, 5, 6, 0]; // urutan sesuai Carbon

        $now = Carbon::now();
        $days = [];

        foreach ($dayNames as $i => $dayName) {
            $targetDate = Carbon::now()->next($carbonDays[$i]);

            // Jika hari ini, pakai hari ini
            if ($targetDate->dayOfWeek === $now->dayOfWeek) {
                $targetDate = $now->copy();
            }

            $days[] = [
                'label' => $dayName,
                'date' => $targetDate->format('Y-m-d'),
                'display' => "$dayName ({$targetDate->format('d M Y')})"
            ];
        }

        return view('customer.bookings.create', compact('pets', 'services', 'days'));
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'pet_id' => 'required|exists:pets,id',
            'services' => 'required|array|min:1',
            'services.*' => 'exists:services,id',
            'day' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu',
            'time' => 'required|date_format:H:i',
        ]);

        // Mapping hari ke format Carbon
        $dayMap = [
            'Minggu' => 0,
            'Senin' => 1,
            'Selasa' => 2,
            'Rabu' => 3,
            'Kamis' => 4,
            'Jumat' => 5,
            'Sabtu' => 6,
        ];

        $today = now();
        $targetDay = $dayMap[$validated['day']];

        // Temukan tanggal berikutnya dengan hari yang dipilih
        $scheduleDate = now()->next($targetDay);
        if ($today->dayOfWeek === $targetDay && $validated['time'] > $today->format('H:i')) {
            $scheduleDate = $today; // Hari ini jika waktu belum lewat
        }

        // Gabungkan tanggal + waktu ke datetime
        $schedule_time = $scheduleDate->format('Y-m-d') . ' ' . $validated['time'];

        // Cek apakah waktu sudah terpakai
        if (Booking::where('schedule_time', $schedule_time)->exists()) {
            return back()->withErrors(['time' => 'Waktu jadwal ini sudah terpakai.'])->withInput();
        }

        $booking = Booking::create([
            'pet_id' => $validated['pet_id'],
            'schedule_time' => $schedule_time,
            'status' => 'pending',
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

    public function cancel(Booking $booking, Request $request)
    {
        if (auth()->user()->cannot('customer') || $booking->pet->user_id !== auth()->id()) {
            abort(403);
        }

        $booking->update([
            'status' => 'cancelled'
        ]);

        $redirect = $request->input('redirect_to') ?? route('mybooking.index');

        return redirect($redirect)->with('success', 'Pemesanan berhasil dibatalkan.');
    }

    public function createbillcustomer(Booking $booking)
    {
        $total = $booking->services->sum('price');
        return view('customer.bills.create', compact('booking', 'total'));
    }

    // Simpan pembayaran tagihan
    public function storebillcustomer(Request $request)
    {
        $request->validate([
            'booking_id'     => 'required|exists:bookings,id',
            'total_amount'   => 'required|numeric|min:0',
            'paid_amount'    => 'required|numeric|min:0',
            'payment_method' => 'required|in:cash,transfer,qris',
            'status'         => 'required|in:paid,unpaid,cancelled',
            'bill_date'      => 'required|date',
        ]);

        $booking = Booking::findOrFail($request->booking_id);

        // Hitung kembalian jika ada
        $change = null;
        if ($request->paid_amount >= $request->total_amount) {
            $change = $request->paid_amount - $request->total_amount;
        }

        // Simpan tagihan
        Bill::create([
            'booking_id'     => $booking->id,
            'total_amount'   => $request->total_amount,
            'paid_amount'    => $request->paid_amount,
            'change_amount'  => $change,
            'payment_method' => $request->payment_method,
            'status'         => $request->status,
            'bill_date'      => $request->bill_date,
        ]);

        return redirect()->route('mybill.index')->with('success', 'Tagihan berhasil dibuat dan dibayar.');
    }


    public function updateStatus(Booking $booking, $status)
    {
        $allowedStatuses = ['pending', 'confirmed', 'completed', 'cancelled'];

        if (!in_array($status, $allowedStatuses)) {
            abort(400, 'Status tidak valid.');
        }

        // Update status booking
        $booking->update(['status' => $status]);

        // Jika status menjadi 'completed', generate tagihan (bill)
        if ($status === 'completed') {
            // Cek apakah sudah pernah dibuat bill
            if (!$booking->bill) {
                $total = $booking->services->sum('price');

                Bill::create([
                    'booking_id'    => $booking->id,
                    'bill_date'     => now(),
                    'total_amount'  => $total,
                    'status'        => 'unpaid',
                ]);
            }
        }

        return redirect()->back()->with('success', 'Status berhasil diubah menjadi ' . ucfirst($status));
    }
}
