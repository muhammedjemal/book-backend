<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;

class BookingController extends Controller
{
    // 1. SAVE A NEW BOOKING
    public function store(Request $request)
    {
        // A. Validate the incoming data
        $request->validate([
            'item_key' => 'required|string',
            'item_name' => 'required|string',
            'price' => 'required|numeric'
        ]);

        $user = $request->user();

        // B. Check if they already booked this specific item
        // (Even though the database prevents it, checking here gives a nicer error message)
        $exists = Booking::where('user_id', $user->id)
                         ->where('item_key', $request->item_key)
                         ->exists();

        if ($exists) {
            return response()->json(['message' => 'You have already booked this item.'], 409);
        }

        // C. Create the booking
        $booking = Booking::create([
            'user_id' => $user->id,
            'item_key' => $request->item_key,
            'item_name' => $request->item_name,
            'price' => $request->price
        ]);

        return response()->json(['message' => 'Booked successfully!', 'booking' => $booking], 201);
    }

    // 2. GET LIST OF ITEMS THIS USER OWNS
    // We need this so the frontend knows which buttons to turn Green/Disabled
    public function myBookings(Request $request)
    {
        // Fetch only the 'item_key' (e.g., 'studio', '2bed') of bookings belonging to this user
        $keys = Booking::where('user_id', $request->user()->id)
                       ->pluck('item_key');

        return response()->json($keys);
    }
}