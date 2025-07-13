@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
@php
    $isFirstLogin = session('first_login', false);
@endphp
<div class="max-w-7xl mx-auto space-y-8">
    <!-- Header -->
    <div class="bg-gradient-to-r from-slate-700 to-gray-800 rounded-2xl p-8 text-white">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold mb-2">
                    @if($isFirstLogin)
                        Welcome, {{ auth()->user()->name ?? 'User' }}!
                    @else
                        Welcome back, {{ auth()->user()->name ?? 'User' }}!
                    @endif
                </h1>
                <p class="text-gray-200 text-lg">Here's what's happening with your bookings</p>
            </div>
            <div class="hidden md:block">
                <div class="p-4 bg-white bg-opacity-20 rounded-full">
                    <i class="fas fa-chart-line text-3xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-5 gap-6">
        <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-100 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-gradient-to-r from-blue-500 to-blue-600">
                    <i class="fas fa-users text-white text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Users</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $userCount ?? 0 }}</p>
                </div>
            </div>
            <div class="mt-4">
                <div class="flex items-center text-sm text-blue-600">
                    <i class="fas fa-user-friends mr-1"></i>
                    <span>All registered users</span>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-100 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-gradient-to-r from-slate-500 to-gray-600">
                    <i class="fas fa-calendar text-white text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Bookings</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $totalBookings ?? 0 }}</p>
                </div>
            </div>
            <div class="mt-4">
                <div class="flex items-center text-sm text-slate-600">
                    <i class="fas fa-chart-line mr-1"></i>
                    <span>All time bookings</span>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-100 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-gradient-to-r from-amber-500 to-orange-600">
                    <i class="fas fa-clock text-white text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Pending</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $pendingBookings ?? 0 }}</p>
                </div>
            </div>
            <div class="mt-4">
                <div class="flex items-center text-sm text-amber-600">
                    <i class="fas fa-clock mr-1"></i>
                    <span>Awaiting confirmation</span>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-100 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-gradient-to-r from-emerald-500 to-green-600">
                    <i class="fas fa-check text-white text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Confirmed</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $confirmedBookings ?? 0 }}</p>
                </div>
            </div>
            <div class="mt-4">
                <div class="flex items-center text-sm text-emerald-600">
                    <i class="fas fa-check-circle mr-1"></i>
                    <span>Successfully booked</span>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-100 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-gradient-to-r from-rose-500 to-red-600">
                    <i class="fas fa-times text-white text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Cancelled</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $cancelledBookings ?? 0 }}</p>
                </div>
            </div>
            <div class="mt-4">
                <div class="flex items-center text-sm text-rose-600">
                    <i class="fas fa-times-circle mr-1"></i>
                    <span>Cancelled bookings</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-100 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
            <div class="text-center">
                <div class="w-16 h-16 bg-gradient-to-r from-slate-500 to-gray-600 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-plus text-white text-2xl"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Create New Booking</h3>
                <p class="text-gray-600 mb-4">Schedule a new reservation for your needs</p>
                <a href="{{ route('bookings.create') }}" 
                   class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-slate-600 to-gray-700 text-white text-sm font-medium rounded-lg hover:from-slate-700 hover:to-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-slate-500 transition-all duration-200">
                    <i class="fas fa-plus mr-2"></i>
                    New Booking
                </a>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-100 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
            <div class="text-center">
                <div class="w-16 h-16 bg-gradient-to-r from-amber-500 to-orange-600 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-calendar-alt text-white text-2xl"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">View My Bookings</h3>
                <p class="text-gray-600 mb-4">Check all your current and past bookings</p>
                <a href="{{ route('bookings.index') }}" 
                   class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-amber-500 to-orange-600 text-white text-sm font-medium rounded-lg hover:from-amber-600 hover:to-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500 transition-all duration-200">
                    <i class="fas fa-eye mr-2"></i>
                    View Bookings
                </a>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-100 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
            <div class="text-center">
                <div class="w-16 h-16 bg-gradient-to-r from-emerald-500 to-green-600 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-user text-white text-2xl"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">My Profile</h3>
                <p class="text-gray-600 mb-4">Update your personal information</p>
                <a href="{{ route('profile.index') }}" 
                   class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-emerald-500 to-green-600 text-white text-sm font-medium rounded-lg hover:from-emerald-600 hover:to-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-all duration-200">
                    <i class="fas fa-user-edit mr-2"></i>
                    Edit Profile
                </a>
            </div>
        </div>
    </div>

    <!-- Recent Bookings -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100">
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold text-gray-900">Recent Bookings</h2>
                <a href="{{ route('bookings.index') }}" class="text-slate-600 hover:text-slate-800 text-sm font-medium">
                    View all <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>
        </div>
        
        @if(isset($recentBookings) && count($recentBookings) > 0)
            <div class="divide-y divide-gray-200">
                @foreach($recentBookings ?? [] as $booking)
                    <div class="py-2 flex items-center justify-between">
                        <div>
                            <p class="text-gray-700 font-semibold">{{ $booking->title ?? 'N/A' }}</p>
                            <p class="text-gray-500 text-sm">
                                {{ $booking->check_in_date ? $booking->check_in_date->format('M d, Y') : 'N/A' }}
                                at
                                {{ $booking->check_in_time ?? 'N/A' }}
                            </p>
                        </div>
                        <span class="px-2 py-1 rounded text-xs font-bold {{ $booking->status === 'confirmed' ? 'bg-green-100 text-green-800' : ($booking->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                            {{ ucfirst($booking->status ?? 'unknown') }}
                        </span>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-500">No recent bookings.</p>
        @endif
    </div>

    <!-- System Status -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
        <h2 class="text-xl font-semibold text-gray-900 mb-4">System Status</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="flex items-center space-x-3">
                <div class="w-3 h-3 bg-emerald-500 rounded-full"></div>
                <span class="text-sm text-gray-600">Booking System</span>
                <span class="text-sm font-medium text-emerald-600">Operational</span>
            </div>
            <div class="flex items-center space-x-3">
                <div class="w-3 h-3 bg-emerald-500 rounded-full"></div>
                <span class="text-sm text-gray-600">Notifications</span>
                <span class="text-sm font-medium text-emerald-600">Active</span>
            </div>
            <div class="flex items-center space-x-3">
                <div class="w-3 h-3 bg-emerald-500 rounded-full"></div>
                <span class="text-sm text-gray-600">Database</span>
                <span class="text-sm font-medium text-emerald-600">Connected</span>
            </div>
        </div>
    </div>
</div>
@endsection 