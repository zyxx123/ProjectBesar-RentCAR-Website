<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vehicle;
use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Support\Str;
use Carbon\Carbon;

class BookingController extends Controller
{
    public function create(Vehicle $vehicle)
    {
        return view('booking.create', compact('vehicle'));
    }

    public function store(Request $request, Vehicle $vehicle)
    {
        $request->validate([
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        // Check if vehicle is already booked
        if ($vehicle->status !== 'available') {
            return back()->withErrors(['error' => 'This vehicle is not available for booking.']);
        }

        $start = Carbon::parse($request->start_date);
        $end = Carbon::parse($request->end_date);
        $days = $start->diffInDays($end) + 1;
        $totalPrice = $days * $vehicle->price_per_day;
        $bookingCode = 'BK-' . strtoupper(Str::random(8));

        $booking = Booking::create([
            'user_id' => auth()->id(),
            'vehicle_id' => $vehicle->id,
            'booking_code' => $bookingCode,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'total_price' => $totalPrice,
            'status' => 'pending'
        ]);

        $vehicle->update(['status' => 'booked']);

        // Send Notification
        auth()->user()->notify(new \App\Notifications\BookingCreatedNotification($booking));

        return redirect()->route('booking.payment', $booking->id)->with('success', 'Booking created successfully. Please upload payment proof.');
    }

    public function payment(Booking $booking)
    {
        if ($booking->user_id !== auth()->id() || $booking->status !== 'pending') {
            abort(403);
        }

        return view('booking.payment', compact('booking'));
    }

    public function uploadPayment(Request $request, Booking $booking)
    {
        if ($booking->user_id !== auth()->id() || $booking->status !== 'pending') {
            abort(403);
        }

        $request->validate([
            'payment_proof' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $path = $request->file('payment_proof')->store('payments', 'public');

        Payment::create([
            'booking_id' => $booking->id,
            'amount' => $booking->total_price,
            'payment_proof_path' => $path,
        ]);

        $booking->update(['status' => 'waiting_verification']);

        return redirect()->route('dashboard')->with('success', 'Payment proof uploaded successfully. Please wait for admin verification.');
    }
}
