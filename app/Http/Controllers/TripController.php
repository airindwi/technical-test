<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Trip;
use App\Models\OrderTrip;
use Illuminate\Support\Facades\Auth;

class TripController extends Controller
{
    function __construct()
    {
        $this->middleware('auth:api');
    }

    public function create(Request $request)
    {
        $validatedData = $request->validate([
            'start_location' => 'required|string',
            'end_location' => 'required|string',
        ]);

        $user = auth()->user();

        $trip = $user->trips()->create([
            'start_location' => $validatedData['start_location'],
            'end_location' => $validatedData['end_location'],
        ]);

        return response()->json([
            'message' => 'Trip created successfully',
            'data' => $trip,
        ], 201);
    }

    public function viewUserTrips()
    {
        $trips = Trip::where('user_id', auth()->user()->id)->get();

        return response()->json([
            'data' => $trips
        ], 200);
    }

    public function viewAvailableTrips()
    {
        $trips = Trip::where('status', 'Menunggu')->get();

        return response()->json([
            'data' => $trips
        ], 200);
    }

    public function acceptTrip(Request $request, $id)
    {
        $trip = Trip::findOrFail($id);

        if ($trip->status !== 'Menunggu') {
            return response()->json([
                'message' => 'Trip is not available for acceptance'
            ], 400);
        }

        $trip->status = 'Diterima';
        $trip->driver_id = auth()->id(); // Assuming you have a driver_id field in trips table.

        $trip->save();

        OrderTrip::create([
            'trip_id' => $trip->id,
            'driver_id' => $trip->driver_id,
            'status' => 'Diterima'
        ]);

        return response()->json([
            'message' => 'Trip accepted successfully',
            'trip' => $trip
        ]);
    }
}

