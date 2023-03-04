<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

// API Controller
class BookingController extends Controller
{
    public function index(): JsonResponse
    {
        try {
            $bookings = Booking::all();
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

        $jsonData = $bookings->map(function ($data) {
            return [
                'id' => $data->id,
                'user' => $data->user->email,
                'start_date' => $data->start_date,
                'start_time' => $data->start_time,
                'end_date' => $data->end_date,
                'end_time' => $data->end_time,
            ];
        });
        return response()->json($jsonData, 200);
    }

    public function store(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'start_date' => 'required|date',
                'start_time' => 'required|date_format:H:i',
                'end_date' => 'required|date',
                'end_time' => 'required|date_format:H:i',
                'user_id' => 'required|integer|exists:users,id',
            ]);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }


        $hoursCollisions01 = Booking::where('start_date', '=', $request->start_date)
            ->where('start_time', '>=', $request->start_time)
            ->where('start_time', '<=', $request->end_time)->get();

        $hoursCollisions02 = Booking::where('end_date', '=', $request->end_date)
            ->where('end_time', '>=', $request->start_time)
            ->where('end_time', '<=', $request->end_time)->get();

        $hoursCollisions = $hoursCollisions01->merge($hoursCollisions02)->unique();

        if ($hoursCollisions->count() > 0) {
            return response()->json(['error' => 'There are hoursCollisions with other bookings'], 400);
        }

        $daysCollisions01 = Booking::where('start_date', '>', $request->start_date)
            ->where('start_date', '<', $request->end_date)->get();
        $daysCollisions02 = Booking::where('start_date', '<', $request->start_date)
            ->where('end_date', '>', $request->start_date)->get();


        $daysCollisions = $daysCollisions01->merge($daysCollisions02)->unique();

        if ($daysCollisions->count() > 0) {
            return response()->json(['error' => 'There are daysCollisions with other bookings'], 400);
        }


        try {
            $booking = Booking::create($request->all());
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

        return response()->json($booking, 201);
    }

    public function show(Booking $booking): JsonResponse
    {
        return response()->json($booking, 200);
    }

    public function update(Request $request, Booking $booking): JsonResponse
    {
        $booking->update($request->all());
        return response()->json($booking, 200);
    }

    public function destroy(Booking $booking): JsonResponse
    {
        $booking->delete();
        return response()->json(null, 204);
    }
}
