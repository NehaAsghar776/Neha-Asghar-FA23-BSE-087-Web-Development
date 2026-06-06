<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::where('user_id', Auth::id())
            ->latest()
            ->get();
        return view('bookings.index', compact('bookings'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'pickup' => ['required', 'string', 'max:255'],
            'dropoff' => ['required', 'string', 'max:255'],
            'date' => ['required', 'date'],
            'time' => ['required'],
            'passengers' => ['required', 'integer', 'min:1'],
            'fare' => ['required', 'numeric', 'min:0'],
            'driver_name' => ['nullable', 'string', 'max:255'],
            'ride_id' => ['nullable', 'integer'],
            'status' => ['nullable', 'in:pending,confirmed,cancelled'],
        ]);

        $booking = Booking::create(array_merge($data, [
            'user_id' => Auth::id(),
            'status' => $data['status'] ?? 'pending',
        ]));

        return response()->json(['success' => true, 'booking' => $booking]);
    }
}
