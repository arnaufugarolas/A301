<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

// API Controller

class BookingController extends Controller
{
    public function index(): JsonResponse
    {
        var $response = dump(Booking::all());
        return response()->json(Booking::all(), 200);
    }

    public function store(Request $request): JsonResponse
    {
        $booking = Booking::create($request->all());
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
