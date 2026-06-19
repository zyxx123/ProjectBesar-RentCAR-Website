<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;

class AdminBookingController extends Controller
{
    public function verify(Booking $booking)
    {
        if (auth()->user()->role !== 'admin') abort(403);
        
        $booking->update(['status' => 'paid']);
        if ($booking->payment) {
            $booking->payment->update(['verified_at' => now()]);
        }

        // Send Notification
        $booking->user->notify(new \App\Notifications\PaymentVerifiedNotification($booking));

        return back()->with('success', 'Payment verified successfully.');
    }

    public function reject(Booking $booking)
    {
        if (auth()->user()->role !== 'admin') abort(403);
        
        $booking->update(['status' => 'rejected']);
        if ($booking->vehicle) {
            $booking->vehicle->update(['status' => 'available']);
        }

        // Send Notification
        $booking->user->notify(new \App\Notifications\PaymentRejectedNotification($booking));

        return back()->with('success', 'Payment rejected and vehicle freed.');
    }
}
