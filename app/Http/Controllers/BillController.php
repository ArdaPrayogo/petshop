<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\User;
use App\Models\Booking;
use Illuminate\Http\Request;

class BillController extends Controller
{
    public function index()
    {
        $bills = Bill::with('booking.pet.user', 'booking.services')->latest()->get();
        return view('bills.index', compact('bills'));
    }

    public function create()
    {
        $bookings = Booking::with('pet.user', 'services')->get();
        return view('bills.create', compact('bookings'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'booking_id'   => 'required|exists:bookings,id',
            'total_amount' => 'required|numeric|min:0',
            'paid_amount'  => 'nullable|numeric|min:0',
            'status'       => 'required|in:unpaid,paid,cancelled',
            'bill_date'    => 'required|date',
        ]);

        // Hitung kembalian jika dibayar lebih
        $paid = $request->input('paid_amount');
        $total = $request->input('total_amount');
        $change = null;

        if ($paid !== null && $paid >= $total) {
            $change = $paid - $total;
        }

        Bill::create([
            'booking_id'    => $request->booking_id,
            'total_amount'  => $total,
            'paid_amount'   => $paid,
            'change_amount' => $change,
            'status'        => $request->status,
            'bill_date'     => $request->bill_date,
        ]);

        return redirect()->route('bills.index')->with('success', 'Tagihan berhasil ditambahkan.');
    }

    public function show(Bill $bill)
    {
        return view('bills.show', compact('bill'));
    }

    public function edit(Bill $bill)
    {
        $appointments = Booking::with('pet.user', 'services')->get();
        return view('bills.edit', compact('bill', 'appointments'));
    }

    public function update(Request $request, Bill $bill)
    {
        $request->validate([
            'booking_id'   => 'required|exists:bookings,id',
            'total_amount' => 'required|numeric|min:0',
            'paid_amount'  => 'nullable|numeric|min:0',
            'status'       => 'required|in:unpaid,paid,cancelled',
            'bill_date'    => 'required|date',
        ]);

        $paid = $request->input('paid_amount');
        $total = $request->input('total_amount');
        $change = null;

        if ($paid !== null && $paid >= $total) {
            $change = $paid - $total;
        }

        $bill->update([
            'booking_id'    => $request->booking_id,
            'total_amount'  => $total,
            'paid_amount'   => $paid,
            'change_amount' => $change,
            'status'        => $request->status,
            'bill_date'     => $request->bill_date,
        ]);

        return redirect()->route('bills.index')->with('success', 'Tagihan berhasil diperbarui.');
    }

    public function destroy(Bill $bill)
    {
        $bill->delete();
        return redirect()->route('bills.index')->with('success', 'Tagihan berhasil dihapus.');
    }

    public function payForm(Bill $bill)
    {
        // Pastikan relasi pet & service sudah eager-loaded
        $bill->load('booking.pet.user', 'booking.services');
        return view('bills.create', compact('bill'));
    }

    public function processPayment(Request $request, Bill $bill)
    {
        $request->validate([
            'paid_amount'    => 'required|numeric|min:' . $bill->total_amount,
            'payment_method' => 'required|in:cash,transfer,qris',
        ]);

        $paid = $request->paid_amount;
        $change = $paid - $bill->total_amount;

        $bill->update([
            'status'          => 'paid',
            'paid_amount'     => $paid,
            'change_amount'   => $change,
            'payment_method'  => $request->payment_method,
            'bill_date'       => now(), // just to update if needed
        ]);

        return redirect()->route('bills.index')->with('success', 'Pembayaran berhasil disimpan.');
    }
}
