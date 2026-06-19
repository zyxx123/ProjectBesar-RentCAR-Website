<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;

class DashboardController extends Controller
{
    public function index()
    {
        if (auth()->user()->role === 'admin') {
            $bookings = Booking::with(['user', 'vehicle', 'payment'])->latest()->get();
            return view('dashboard.admin', compact('bookings'));
        }

        $bookings = Booking::with(['vehicle', 'payment'])->where('user_id', auth()->id())->latest()->get();
        return view('dashboard.customer', compact('bookings'));
    }
}
