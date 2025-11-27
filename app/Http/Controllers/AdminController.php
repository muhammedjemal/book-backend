<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;

class AdminController extends Controller
{
    // 1. Get ALL Bookings (with User info)
    public function getAllBookings(Request $request)
    {
        // Security Check: strictly for Admins
        if (!$request->user()->is_admin) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        // Fetch bookings AND the user name associated with them
        $bookings = Booking::with('user:id,name,email')->latest()->get();

        return response()->json($bookings);
    }

    // 2. Delete a Booking
    public function deleteBooking(Request $request, $id)
    {
        if (!$request->user()->is_admin) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $booking = Booking::find($id);

        if (!$booking) {
            return response()->json(['message' => 'Booking not found'], 404);
        }

        $booking->delete();

        return response()->json(['message' => 'Booking removed successfully']);
    }
} 