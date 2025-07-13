<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bookings = Auth::user()->bookings()->latest()->get();
        return view('bookings.index', compact('bookings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('bookings.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'check_in_date' => 'required|date|after_or_equal:today',
            'check_in_time' => 'required',
            'check_out_date' => 'required|date|after:check_in_date',
            'check_out_time' => 'required',
        ]);

        $booking = Auth::user()->bookings()->create([
            'title' => $request->title,
            'description' => $request->description,
            'check_in_date' => $request->check_in_date,
            'check_in_time' => $request->check_in_time,
            'check_out_date' => $request->check_out_date,
            'check_out_time' => $request->check_out_time,
            'status' => 'pending',
        ]);

        // Create notification for user
        Auth::user()->notifications()->create([
            'data' => [
                'booking_id' => $booking->id,
                'title' => 'Booking Created',
                'message' => "Your booking '{$booking->title}' has been created successfully.",
                'type' => 'booking_created',
            ],
        ]);

        // Create notification for admin
        $admin = \App\Models\User::where('is_admin', true)->first();
        if ($admin) {
            $admin->notifications()->create([
                'data' => [
                    'booking_id' => $booking->id,
                    'title' => 'New Booking',
                    'message' => "User {$booking->user->name} has created a new booking: {$booking->title}",
                    'type' => 'admin_notification',
                ],
            ]);
        }

        return redirect()->route('bookings.index')->with('success', 'Booking created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $booking = Auth::user()->bookings()->findOrFail($id);
        return view('bookings.show', compact('booking'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $booking = Auth::user()->bookings()->findOrFail($id);
        return view('bookings.edit', compact('booking'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $booking = Auth::user()->bookings()->findOrFail($id);
        
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'check_in_date' => 'required|date',
            'check_in_time' => 'required',
            'check_out_date' => 'required|date|after:check_in_date',
            'check_out_time' => 'required',
        ]);

        $booking->update([
            'title' => $request->title,
            'description' => $request->description,
            'check_in_date' => $request->check_in_date,
            'check_in_time' => $request->check_in_time,
            'check_out_date' => $request->check_out_date,
            'check_out_time' => $request->check_out_time,
        ]);

        // Create notification for booking update
        Auth::user()->notifications()->create([
            'data' => [
                'booking_id' => $booking->id,
                'title' => 'Booking Updated',
                'message' => "Your booking '{$booking->title}' has been updated successfully.",
                'type' => 'booking_updated',
            ],
        ]);

        return redirect()->route('bookings.index')->with('success', 'Booking updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $booking = Auth::user()->bookings()->findOrFail($id);
        $bookingTitle = $booking->title;
        $booking->delete();

        // Create notification for booking cancellation
        Auth::user()->notifications()->create([
            'data' => [
                'title' => 'Booking Cancelled',
                'message' => "Your booking '{$bookingTitle}' has been cancelled.",
                'type' => 'booking_cancelled',
            ],
        ]);

        return redirect()->route('bookings.index')->with('success', 'Booking cancelled successfully!');
    }
}
