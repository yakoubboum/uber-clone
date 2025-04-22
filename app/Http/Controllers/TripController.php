<?php

namespace App\Http\Controllers;

use App\Events\TripAccepted;
use App\Events\TripCreated;
use App\Events\TripEnded;
use App\Events\TripLocationUpdated;
use App\Events\TripStarted;
use App\Models\Trip;
use Illuminate\Http\Request;

class TripController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'origin' => 'required',
            'origin_name' => 'required',
            'destination' => 'required',
            'destination_name' => 'required'
        ]);

        $trip = $request->user()->trips()->create($request->only([
            'origin',
            'destination',
            'destination_name',
            'origin_name'
        ]));

        $trip->load('user');

        TripCreated::dispatch($trip, $request->user());

        return $trip;
    }

    public function getalltrips(){

        $trips = Trip::with('user')->get();
        // $trips = Trip::all();

        return response()->json([
            'success' => true,
            'trips' => $trips,
            'message' => 'Trips retrieved successfully'
        ], 200);
    }

    public function show(Request $request)
    {
        // is the trip is associated with the authenticated user?
        $user = $request->user(); // Get the authenticated user

        // Assuming you want to find a trip associated with this user
        $trip = Trip::where('user_id', $user->id)->first();

        if ($trip) {
            return $trip;
        } else {
            return response()->json([
                "message" => "Trip not found"
            ], 404);
        }




        if ($trip->driver && $request->user()->driver) {
            if ($trip->driver->id === $request->user()->driver->id) {
                return $trip;
            }
        }

        return response()->json(['message' => 'Cannot find this trip.'], 404);
    }

    public function accept(Request $request, Trip $trip)
    {


        // a driver accepts a trip
        $request->validate([
            'driver_location' => 'required'
        ]);

        $trip->update([
            'driver_id' => $request->user()->id,
            'driver_location' => $request->driver_location,
        ]);

        $trip->load('driver.user');



        TripAccepted::dispatch($trip, 40);

        return $trip;
    }

    public function start(Request $request, Trip $trip)
    {
        // a driver has started taking a passenger to their destination
        $trip->update([
            'is_started' => true
        ]);

        $trip->load('driver.user');

        TripStarted::dispatch($trip, $trip->user);

        return $trip;
    }

    public function end(Request $request, Trip $trip)
    {
        // a driver has ended a trip
        $trip->update([
            'is_complete' => true
        ]);

        $trip->load('driver.user');

        TripEnded::dispatch($trip, $trip->user);

        return $trip;
    }

    public function location(Request $request, Trip $trip)
    {
        // update the driver's current location
        $request->validate([
            'driver_location' => 'required'
        ]);

        $trip->update([
            'driver_location' => $request->driver_location
        ]);

        $trip->load('driver.user');

        TripLocationUpdated::dispatch($trip, $trip->user);

        return $trip;
    }

    public function delete(Request $request)
    {
        $user = $request->user();

        $trip = Trip::where('user_id', $user->id)
            ->where('id', $request->trip_id)
            ->first();

        if (!$trip) {
            return response()->json([
                "message" => "Trip not found"
            ], 404);
        }

        $trip->delete();

        return response()->json([
            "message" => "Trip deleted successfully"
        ], 200); // Use 200 for successful deletion
    }
}
