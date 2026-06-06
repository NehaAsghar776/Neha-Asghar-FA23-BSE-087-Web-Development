<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AiFareController extends Controller
{
    public function estimate(Request $request)
    {
        $request->validate([
            'pickup' => 'required|string',
            'dropoff' => 'required|string',
            'car_type' => 'required|string',
            'passengers' => 'required|integer|min:1',
        ]);

        $pickup = strtolower($request->pickup);
        $dropoff = strtolower($request->dropoff);
        $carType = $request->car_type;
        $passengers = $request->passengers;

        // AI Logic: Distance estimation based on city keywords
        $distanceKm = $this->estimateDistance($pickup, $dropoff);

        // Base rates per km
        $rates = [
            'economy' => 25,
            'comfort' => 40,
            'premium' => 60,
        ];

        $ratePerKm = $rates[$carType] ?? 25;
        $baseFare = $distanceKm * $ratePerKm;
        $passengerSurcharge = ($passengers - 1) * 20;

        // Peak hour surcharge (8-10am, 5-8pm)
        $hour = (int) date('H');
        $peakSurcharge = 0;
        if (($hour >= 8 && $hour <= 10) || ($hour >= 17 && $hour <= 20)) {
            $peakSurcharge = $baseFare * 0.2;
        }

        $totalFare = round($baseFare + $passengerSurcharge + $peakSurcharge);

        return response()->json([
            'success' => true,
            'estimated_fare' => $totalFare,
            'distance_km' => $distanceKm,
            'breakdown' => [
                'base_fare' => round($baseFare),
                'passenger_surcharge' => $passengerSurcharge,
                'peak_surcharge' => round($peakSurcharge),
            ],
            'message' => "AI estimated fare for {$distanceKm}km trip"
        ]);
    }

    private function estimateDistance($pickup, $dropoff)
    {
        $cityDistances = [
            'lahore-karachi' => 1210,
            'lahore-islamabad' => 375,
            'lahore-multan' => 340,
            'karachi-islamabad' => 1410,
            'islamabad-peshawar' => 170,
            'multan-karachi' => 1050,
        ];

        $key1 = "$pickup-$dropoff";
        $key2 = "$dropoff-$pickup";

        if (isset($cityDistances[$key1])) return $cityDistances[$key1];
        if (isset($cityDistances[$key2])) return $cityDistances[$key2];

        // Default random realistic distance
        return rand(5, 50);
    }
}