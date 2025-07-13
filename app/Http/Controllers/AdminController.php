<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\User;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    /**
     * Display admin dashboard.
     */
    public function dashboard()
    {
        $totalUsers = User::where('is_admin', false)->count();
        $totalBookings = Booking::count();
        $pendingBookings = Booking::where('status', 'pending')->count();
        $confirmedBookings = Booking::where('status', 'confirmed')->count();
        $recentBookings = Booking::with('user')->latest()->take(5)->get();

        // Booking counts for the last 30 days (for graph)
        $bookingTrends = Booking::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->where('created_at', '>=', now()->subDays(29)->startOfDay())
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('count', 'date');

        // Fill missing days with 0
        $dates = collect();
        for ($i = 29; $i >= 0; $i--) {
            $date = now()->subDays($i)->toDateString();
            $dates->put($date, $bookingTrends[$date] ?? 0);
        }

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalBookings',
            'pendingBookings',
            'confirmedBookings',
            'recentBookings',
            'dates'
        ));
    }

    /**
     * Display all users.
     */
    public function users()
    {
        $users = User::with('bookings')->get();
        return view('admin.users', compact('users'));
    }

    /**
     * Display user details with bookings.
     */
    public function userDetails(User $user)
    {
        $user->load('bookings');
        return view('admin.user-details', compact('user'));
    }

    /**
     * Update user.
     */
    public function updateUser(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return redirect()->route('admin.users')->with('success', 'User updated successfully!');
    }

    /**
     * Delete user.
     */
    public function deleteUser(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users')->with('success', 'User deleted successfully!');
    }

    /**
     * Toggle admin status for user.
     */
    public function toggleAdmin(User $user)
    {
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users')->with('error', 'You cannot change your own admin status!');
        }

        $user->update(['is_admin' => !$user->is_admin]);
        
        $status = $user->is_admin ? 'admin' : 'regular user';
        return redirect()->route('admin.users')->with('success', "User {$user->name} is now a {$status}!");
    }

    /**
     * Display all bookings.
     */
    public function bookings()
    {
        $bookings = Booking::with('user')->latest()->paginate(12); // Paginate for view compatibility
        return view('admin.bookings', compact('bookings'));
    }

    /**
     * Show specific booking details.
     */
    public function showBooking(Booking $booking)
    {
        $booking->load('user');
        return view('admin.booking-details', compact('booking'));
    }

    /**
     * Confirm a booking.
     */
    public function confirmBooking(Booking $booking)
    {
        $booking->update(['status' => 'confirmed']);

        // Create notification for user
        $booking->user->notifications()->create([
            'data' => [
                'type' => 'booking_confirmed',
                'title' => 'Booking Confirmed',
                'message' => "Your booking '{$booking->title}' has been confirmed!",
                'booking_id' => $booking->id
            ]
        ]);

        return redirect()->route('admin.bookings')->with('success', 'Booking confirmed successfully!');
    }

    /**
     * Cancel a booking.
     */
    public function cancelBooking(Booking $booking)
    {
        $booking->update(['status' => 'cancelled']);

        // Create notification for user
        $booking->user->notifications()->create([
            'data' => [
                'type' => 'booking_cancelled',
                'title' => 'Booking Cancelled',
                'message' => "Your booking '{$booking->title}' has been cancelled.",
                'booking_id' => $booking->id
            ]
        ]);

        return redirect()->route('admin.bookings')->with('success', 'Booking cancelled successfully!');
    }

    /**
     * Update booking status.
     */
    public function updateBookingStatus(Request $request, Booking $booking)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,cancelled',
        ]);

        $booking->update(['status' => $request->status]);

        // Create notification for user
        $booking->user->notifications()->create([
            'data' => [
                'type' => 'booking_updated',
                'title' => 'Booking Status Updated',
                'message' => "Your booking '{$booking->title}' status has been updated to {$request->status}.",
                'booking_id' => $booking->id
            ]
        ]);

        return redirect()->route('admin.bookings')->with('success', 'Booking status updated successfully!');
    }

    /**
     * Delete booking.
     */
    public function deleteBooking(Booking $booking)
    {
        $bookingTitle = $booking->title;
        $booking->delete();

        return redirect()->route('admin.bookings')->with('success', 'Booking deleted successfully!');
    }
}
