<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;

class ReportController extends Controller
{

    public function print()
    {
        $bookings = Booking::with(['user', 'vehicle', 'payment'])->latest()->get();
        return view('admin.reports.print', compact('bookings'));
    }
}
