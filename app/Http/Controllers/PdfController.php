<?php

namespace App\Http\Controllers;

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
}
