@extends('layouts.app')

@section('title', 'Overview')

@section('content')
@php
    $isFirstLogin = session('first_login', false);
@endphp
<div class="max-w-7xl mx-auto space-y-8">
    <!-- Header -->
    <div class="bg-gradient-to-r from-blue-900 to-blue-700 rounded-2xl p-8 text-white">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold mb-2">
                    @if($isFirstLogin)
                        Welcome, {{ auth()->user()->name ?? 'User' }}!
                    @else
                        Welcome back, {{ auth()->user()->name ?? 'User' }}!
                    @endif
                </h1>
                <p class="text-blue-100 text-lg">Your corporate booking summary</p>
            </div>
            <div class="hidden md:block">
                <div class="p-4 bg-white bg-opacity-20 rounded-full">
                    <i class="fas fa-briefcase text-3xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-5 gap-6">
        <div class="bg-white rounded-2xl shadow-md p-6 border border-blue-100 flex items-center">
            <div class="flex-shrink-0">
                <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center">
                    <i class="fas fa-users text-blue-700 text-2xl"></i>
                </div>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Users</p>
                <p class="text-2xl font-bold text-blue-900">{{ $userCount ?? 0 }}</p>
                <a href="#" class="flex items-center text-blue-600 text-sm mt-1 font-medium"><i class="fas fa-users mr-1"></i>All users</a>
            </div>
        </div>
        <div class="bg-white rounded-2xl shadow-md p-6 border border-blue-100 flex items-center">
            <div class="flex-shrink-0">
                <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center">
                    <i class="fas fa-calendar text-blue-700 text-2xl"></i>
                </div>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Bookings</p>
                <p class="text-2xl font-bold text-blue-900">{{ $totalBookings ?? 0 }}</p>
                <a href="#" class="flex items-center text-blue-600 text-sm mt-1 font-medium"><i class="fas fa-calendar mr-1"></i>All bookings</a>
            </div>
        </div>
        <div class="bg-white rounded-2xl shadow-md p-6 border border-blue-100 flex items-center">
            <div class="flex-shrink-0">
                <div class="w-12 h-12 rounded-full bg-yellow-100 flex items-center justify-center">
                    <i class="fas fa-clock text-yellow-600 text-2xl"></i>
                </div>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Pending</p>
                <p class="text-2xl font-bold text-blue-900">{{ $pendingBookings ?? 0 }}</p>
                <span class="flex items-center text-yellow-600 text-sm mt-1 font-medium"><i class="fas fa-clock mr-1"></i>Awaiting approval</span>
            </div>
        </div>
        <div class="bg-white rounded-2xl shadow-md p-6 border border-blue-100 flex items-center">
            <div class="flex-shrink-0">
                <div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center">
                    <i class="fas fa-check text-green-700 text-2xl"></i>
                </div>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Confirmed</p>
                <p class="text-2xl font-bold text-blue-900">{{ $confirmedBookings ?? 0 }}</p>
                <span class="flex items-center text-green-700 text-sm mt-1 font-medium"><i class="fas fa-check mr-1"></i>Confirmed</span>
            </div>
        </div>
        <div class="bg-white rounded-2xl shadow-md p-6 border border-blue-100 flex items-center">
            <div class="flex-shrink-0">
                <div class="w-12 h-12 rounded-full bg-red-100 flex items-center justify-center">
                    <i class="fas fa-times text-red-600 text-2xl"></i>
                </div>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Cancelled</p>
                <p class="text-2xl font-bold text-blue-900">{{ $cancelledBookings ?? 0 }}</p>
                <span class="flex items-center text-red-600 text-sm mt-1 font-medium"><i class="fas fa-times mr-1"></i>Cancelled</span>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-2xl shadow-md p-6 border border-blue-100 flex flex-col items-center">
            <div class="w-16 h-16 rounded-full bg-blue-50 flex items-center justify-center mb-4">
                <i class="fas fa-plus text-blue-700 text-3xl"></i>
            </div>
            <h3 class="text-lg font-bold text-blue-900 mb-1">New Booking</h3>
            <p class="text-gray-500 text-sm mb-4 text-center">Schedule a new reservation for your business needs</p>
            <a href="#" class="px-6 py-2 rounded-lg bg-blue-700 text-white font-semibold text-sm shadow hover:bg-blue-800 transition">+ New Booking</a>
        </div>
        <div class="bg-white rounded-2xl shadow-md p-6 border border-blue-100 flex flex-col items-center">
            <div class="w-16 h-16 rounded-full bg-blue-50 flex items-center justify-center mb-4">
                <i class="fas fa-calendar-alt text-blue-700 text-3xl"></i>
            </div>
            <h3 class="text-lg font-bold text-blue-900 mb-1">Bookings Overview</h3>
            <p class="text-gray-500 text-sm mb-4 text-center">Review all your current and past bookings</p>
            <a href="#" class="px-6 py-2 rounded-lg bg-blue-700 text-white font-semibold text-sm shadow hover:bg-blue-800 transition">View Bookings</a>
        </div>
        <div class="bg-white rounded-2xl shadow-md p-6 border border-blue-100 flex flex-col items-center">
            <div class="w-16 h-16 rounded-full bg-blue-50 flex items-center justify-center mb-4">
                <i class="fas fa-user text-blue-700 text-3xl"></i>
            </div>
            <h3 class="text-lg font-bold text-blue-900 mb-1">Profile</h3>
            <p class="text-gray-500 text-sm mb-4 text-center">Manage your personal information</p>
            <a href="#" class="px-6 py-2 rounded-lg bg-blue-700 text-white font-semibold text-sm shadow hover:bg-blue-800 transition">Edit Profile</a>
        </div>
    </div>

    <!-- Recent Bookings -->
    <div class="bg-white rounded-xl shadow-lg border border-blue-100">
        <div class="p-6 border-b border-blue-100">
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold text-blue-900">Recent Bookings</h2>
                <a href="{{ route('bookings.index') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                    View all <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>
        </div>
        @if(isset($recentBookings) && count($recentBookings) > 0)
            <div class="divide-y divide-blue-50">
                @foreach($recentBookings ?? [] as $booking)
                    <div class="py-2 flex items-center justify-between">
                        <div>
                            <p class="text-blue-900 font-semibold">{{ $booking->title ?? 'N/A' }}</p>
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
    <div class="bg-white rounded-xl shadow-lg border border-blue-100 p-6">
        <h2 class="text-xl font-semibold text-blue-900 mb-4">System Status</h2>
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