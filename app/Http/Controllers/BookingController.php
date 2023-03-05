<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Carbon\Exceptions\InvalidDateException;
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

            $jsonData = $bookings->map(function ($data) {
                return [
                    'id' => $data->id,
                    'user_email' => $data->user->email,
                    'start_date' => $data->start_date,
                    'start_time' => $data->start_time,
                    'end_date' => $data->end_date,
                    'end_time' => $data->end_time,
                ];
            });
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

        return response()->json($jsonData, 200);
    }

    public function store(Request $request): JsonResponse
    {
        try {
            $this->validateBookingRequest($request);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
        try {
            $collisions = $this->checkCollisions($request);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

        if ($collisions) {
            return response()->json(['error' => 'there are collisions with other bookings'], 400);
        }

        try {
            $booking = Booking::create($request->all());
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

        return response()->json($booking, 201);
    }

    /**
     * @throws Exception
     */
    public function validateBookingRequest(Request $request): void
    {
        $request->validate([
            'start_date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_date' => 'required|date|after_or_equal:start_date',
            'end_time' => 'required|date_format:H:i',
            'user_id' => 'required|integer|exists:users,id',
        ]);
        if ($request->start_date === $request->end_date) {
            $request->validate([
                'end_time' => 'required|date_format:H:i|after:start_time',
            ]);
        }
        if ((strtotime($request->start_time) - strtotime($request->end_time)) % 3600 !== 0) {
            throw new InvalidDateException('start_time or end_time', 'the booking time must be multiple of one hour');
        }
    }

    public function checkCollisions(Request $request)
    {
        $collisions = 0;

        $collisions += count(Booking::where('start_date', '=', $request->start_date)
            ->where('start_time', '<', $request->start_time)->get());
        $collisions += count(Booking::where('start_date', '=', $request->start_date)
            ->where('start_date', '=', $request->end_date)
            ->where('start_time', '>=', $request->start_time)
            ->where('start_time', '<=', $request->end_time)->get());
        $collisions += count(Booking::where('start_date', '=', $request->start_date)
            ->where('start_date', '<', $request->end_date)
            ->get());
        $collisions += count(Booking::where('end_date', '=', $request->start_date)
            ->where('end_time', '>=', $request->start_time)->get());
        $collisions += count(Booking::where('start_date', '>', $request->start_date)
            ->where('start_date', '<', $request->end_date)->get());
        $collisions += count(Booking::where('start_date', '<', $request->start_date)
            ->where('end_date', '>', $request->start_date)->get());


        return $collisions > 0;
    }

    public function show(Booking $booking): JsonResponse
    {
        try {
            $bookingToShow = [
                'id' => $booking->id,
                'user_email' => $booking->user->email,
                'start_date' => $booking->start_date,
                'start_time' => $booking->start_time,
                'end_date' => $booking->end_date,
                'end_time' => $booking->end_time,
            ];
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
        return response()->json($bookingToShow, 200);
    }

    public function update(Request $request, Booking $booking): JsonResponse
    {
        try {
            $this->validateBookingRequest($request);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }

        try {
            $collisions = $this->checkCollisions($request);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

        if ($collisions) {
            return response()->json(['error' => 'there are collisions with other bookings'], 400);
        }

        try {
            $booking->update([
                'start_date' => $request->start_date,
                'start_time' => $request->start_time,
                'end_date' => $request->end_date,
                'end_time' => $request->end_time,
            ]);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
        return response()->json($booking, 200);
    }

    public function destroy(Booking $booking): JsonResponse
    {
        try {
            $booking->delete();
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
        return response()->json(['message' => 'Booking successfully deleted.'], 204);
    }
}
