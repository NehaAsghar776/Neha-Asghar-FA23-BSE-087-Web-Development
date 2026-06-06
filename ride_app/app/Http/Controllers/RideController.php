<?php

namespace App\Http\Controllers;

use App\Models\Ride;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RideController extends Controller
{
    public function index(Request $request)
    {
        $query = Ride::query();

        if ($request->filled('pickup')) {
            // Use loose matching for better results
            $query->where('route_from', 'like', '%' . $request->pickup . '%');
        }

        if ($request->filled('dropoff')) {
            $query->where('route_to', 'like', '%' . $request->dropoff . '%');
        }

        $rides = $query->latest()->get();

        // Transform to match frontend expected structure if needed, or handle in frontend
        // Frontend expects: id, driver, rating, trips, car, type, price, estTime
        // We will map it here to be safe
        $mappedRides = $rides->map(function ($ride) {
            return [
                'id' => $ride->id,
                'driver' => $ride->driver_name,
                'rating' => 5.0, // Default as we don't have ratings table yet
                'trips' => 0,    // Default
                'car' => $ride->car_model,
                'type' => $ride->car_type,
                'price' => (int) $ride->price_per_seat, // Ensure number
                'estTime' => '15 min', // Placeholder
                'seats' => $ride->seats,
                'notes' => $ride->notes,
                'is_backend' => true, // Flag to identify backend rides
            ];
        });

        return response()->json($mappedRides);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'driver_name' => ['required', 'string', 'max:255'],
            'driver_phone' => ['required', 'string', 'max:30'],
            'car_model' => ['required', 'string', 'max:255'],
            'car_type' => ['required', 'in:economy,comfort,premium'],
            'route_from' => ['required', 'string', 'max:255'],
            'route_to' => ['required', 'string', 'max:255'],
            'seats' => ['required', 'integer', 'min:1'],
            'price_per_seat' => ['required', 'numeric', 'min:0'],
            'notes' => ['nullable', 'string'],
        ]);

        $ride = Ride::create(array_merge($data, [
            'user_id' => Auth::id(),
        ]));

        return response()->json(['success' => true, 'ride' => $ride]);
    }
}

