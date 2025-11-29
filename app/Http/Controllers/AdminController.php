<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    // --- BOOKING MANAGEMENT ---

    public function getAllBookings(Request $request)
    {
        if (!$request->user()->is_admin) return response()->json(['message' => 'Unauthorized'], 403);
        $bookings = Booking::with('user:id,name,email')->latest()->get();
        return response()->json($bookings);
    }

    public function deleteBooking(Request $request, $id)
    {
        if (!$request->user()->is_admin) return response()->json(['message' => 'Unauthorized'], 403);
        $booking = Booking::find($id);
        if (!$booking) return response()->json(['message' => 'Booking not found'], 404);
        $booking->delete();
        return response()->json(['message' => 'Booking removed successfully']);
    }

    // --- USER MANAGEMENT ---

    public function getAllUsers(Request $request)
    {
        if (!$request->user()->is_admin) return response()->json(['message' => 'Unauthorized'], 403);
        return response()->json(User::latest()->get());
    }

    public function createUser(Request $request)
    {
        if (!$request->user()->is_admin) return response()->json(['message' => 'Unauthorized'], 403);

        try {
            $validated = $request->validate([
                'name' => 'required|string',
                'email' => 'required|email|unique:users',
                'password' => 'required|min:6',
                'is_admin' => 'boolean'
            ]);

            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'is_admin' => $validated['is_admin'] ?? false
            ]);

            return response()->json(['message' => 'User created', 'user' => $user], 201);
        } catch (\Exception $e) {
            // Return JSON error instead of HTML 500
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function updateUser(Request $request, $id) 
    {
        if (!$request->user()->is_admin) return response()->json(['message' => 'Unauthorized'], 403);
        
        $user = User::find($id);
        if(!$user) return response()->json(['message' => 'Not found'], 404);
        
        $validated = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email,'.$id,
            'is_admin' => 'boolean'
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->is_admin = $validated['is_admin'];
        $user->save();

        return response()->json(['message' => 'User updated', 'user' => $user]);
    }

    public function deleteUser(Request $request, $id)
    {
        if (!$request->user()->is_admin) return response()->json(['message' => 'Unauthorized'], 403);

        $user = User::find($id);
        if (!$user) return response()->json(['message' => 'User not found'], 404);

        if ($user->id === $request->user()->id) {
             return response()->json(['message' => 'You cannot delete yourself'], 400);
        }

        $user->delete();
        return response()->json(['message' => 'User deleted successfully']);
    }
} 