<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Bill;
use App\Models\Booking;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class PdfController extends Controller
{

    public function generate($id)
    {
        // Ambil data bill dengan relasi
        $bill = Bill::with('booking.pet.user', 'booking.services')->findOrFail($id);

        // Load view PDF (tanpa layout)
        $pdf = PDF::loadView('bills.pdf', compact('bill'));

        // Tampilkan langsung di browser
        return $pdf->stream('detail-pembayaran-' . $bill->id . '.pdf');

        // Untuk download otomatis:
        // return $pdf->download('detail-pembayaran-' . $bill->id . '.pdf');
    }

    public function monthlyReport(Request $request)
    {
        // Ambil bulan dan tahun dari input
        $monthInput = $request->input('month'); // format: yyyy-mm
        if (!$monthInput) {
            return redirect()->back()->with('error', 'Bulan wajib dipilih.');
        }

        [$year, $month] = explode('-', $monthInput);

        $bills = Bill::with(['booking.pet.user', 'booking.services'])
            ->whereMonth('bill_date', $month)
            ->whereYear('bill_date', $year)
            ->get();

        $pdf = PDF::loadView('bills.report', [
            'bills' => $bills,
            'selectedMonth' => Carbon::createFromDate($year, $month, 1)->translatedFormat('F Y'),
        ]);

        return $pdf->stream("laporan_tagihan_{$month}_{$year}.pdf");
    }
}
