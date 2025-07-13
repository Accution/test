<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\NotificationController;

// Home route
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Authentication routes
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', function () {
    $credentials = request()->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);
    
    if (auth()->attempt($credentials)) {
        return redirect()->intended('/dashboard');
    }
    
    return back()->withErrors(['email' => 'The provided credentials do not match our records.']);
})->name('login.post');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::post('/register', function () {
    $data = request()->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users',
        'password' => 'required|string|min:8|confirmed',
    ]);

    $user = \App\Models\User::create([
        'name' => $data['name'],
        'email' => $data['email'],
        'password' => bcrypt($data['password']),
        'is_admin' => false,
    ]);

    auth()->login($user);
    return redirect('/dashboard');
})->name('register.post');

// User routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', function () {
        auth()->logout();
        return redirect('/');
    })->name('logout');
    Route::get('/dashboard', function () {
        if (auth()->user()->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }
        
        $user = auth()->user();
        $totalBookings = $user->bookings()->count();
        $pendingBookings = $user->bookings()->where('status', 'pending')->count();
        $confirmedBookings = $user->bookings()->where('status', 'confirmed')->count();
        $cancelledBookings = $user->bookings()->where('status', 'cancelled')->count();
        $recentBookings = $user->bookings()->latest()->take(5)->get();
        
        return view('dashboard', compact(
            'totalBookings',
            'pendingBookings', 
            'confirmedBookings',
            'cancelledBookings',
            'recentBookings'
        ));
    })->name('dashboard');

    // Booking routes
    Route::resource('bookings', BookingController::class);
    
    // Profile routes
    Route::get('/profile', function () {
        return view('profile.index');
    })->name('profile.index');
    Route::put('/profile', function () {
        $data = request()->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . auth()->id(),
        ]);
        
        auth()->user()->update($data);
        return redirect()->route('profile.index')->with('success', 'Profile updated successfully!');
    })->name('profile.update');
    Route::put('/profile/password', function () {
        $data = request()->validate([
            'current_password' => 'required|current_password',
            'new_password' => 'required|string|min:8|confirmed',
        ]);
        
        auth()->user()->update(['password' => bcrypt($data['new_password'])]);
        return redirect()->route('profile.index')->with('success', 'Password changed successfully!');
    })->name('profile.password');
    
    // Notification routes
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{id}/mark-as-read', [NotificationController::class, 'markAsRead'])->name('notifications.mark-as-read');
    Route::post('/notifications/mark-all-as-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.mark-all-as-read');
    Route::get('/notifications/unread-count', [NotificationController::class, 'getUnreadCount'])->name('notifications.unread-count');
    Route::delete('/notifications/{id}', [NotificationController::class, 'destroy'])->name('notifications.destroy');
    Route::delete('/notifications/clear-all', [NotificationController::class, 'clearAll'])->name('notifications.clear-all');
});

// Admin routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // User management routes
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::get('/users/{user}', [AdminController::class, 'userDetails'])->name('user-details');
    Route::put('/users/{user}', [AdminController::class, 'updateUser'])->name('users.update');
    Route::delete('/users/{user}', [AdminController::class, 'deleteUser'])->name('users.delete');
    Route::patch('/users/{user}/toggle-admin', [AdminController::class, 'toggleAdmin'])->name('users.toggle-admin');
    
    // Booking management routes
    Route::get('/bookings', [AdminController::class, 'bookings'])->name('bookings');
    Route::get('/bookings/{booking}', [AdminController::class, 'showBooking'])->name('bookings.show');
    Route::patch('/bookings/{booking}/confirm', [AdminController::class, 'confirmBooking'])->name('bookings.confirm');
    Route::patch('/bookings/{booking}/cancel', [AdminController::class, 'cancelBooking'])->name('bookings.cancel');
    Route::put('/bookings/{booking}/status', [AdminController::class, 'updateBookingStatus'])->name('bookings.update-status');
    Route::delete('/bookings/{booking}', [AdminController::class, 'deleteBooking'])->name('bookings.delete');
});
