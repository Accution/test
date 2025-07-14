@extends('layouts.app')

@section('title', 'Administration Overview')

@section('content')
@php
    $isFirstLogin = session('first_login', false);
@endphp
<div class="max-w-7xl mx-auto space-y-8">
    <!-- Header -->
    <div class="bg-gradient-to-r from-blue-900 to-blue-700 rounded-2xl p-8 text-white shadow-xl">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold mb-2">
                    @if($isFirstLogin)
                        Welcome, {{ auth()->user()->name ?? 'Admin' }}!
                    @else
                        Welcome back, {{ auth()->user()->name ?? 'Admin' }}!
                    @endif
                </h1>
                <p class="text-blue-100 text-lg">System overview and management</p>
            </div>
            <div class="hidden md:block">
                <div class="p-4 bg-white bg-opacity-30 rounded-full shadow-lg">
                    <i class="fas fa-shield-alt text-blue-700 text-3xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="rounded-2xl shadow-xl p-6 bg-gradient-to-br from-blue-100 via-blue-50 to-white border border-blue-200">
            <div class="flex items-center">
                <div class="w-14 h-14 bg-gradient-to-br from-blue-700 to-blue-500 rounded-full flex items-center justify-center shadow-md">
                    <i class="fas fa-users text-white text-2xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-blue-900">Total Users</p>
                    <p class="text-2xl font-bold text-blue-900">{{ $totalUsers }}</p>
                </div>
            </div>
        </div>
        <div class="rounded-2xl shadow-xl p-6 bg-gradient-to-br from-blue-100 via-blue-50 to-white border border-blue-200">
            <div class="flex items-center">
                <div class="w-14 h-14 bg-gradient-to-br from-blue-700 to-blue-500 rounded-full flex items-center justify-center shadow-md">
                    <i class="fas fa-calendar text-white text-2xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-blue-900">Total Bookings</p>
                    <p class="text-2xl font-bold text-blue-900">{{ $totalBookings }}</p>
                </div>
            </div>
        </div>
        <div class="rounded-2xl shadow-xl p-6 bg-gradient-to-br from-blue-100 via-blue-50 to-white border border-blue-200">
            <div class="flex items-center">
                <div class="w-14 h-14 bg-gradient-to-br from-blue-700 to-blue-500 rounded-full flex items-center justify-center shadow-md">
                    <i class="fas fa-clock text-white text-2xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-blue-900">Pending</p>
                    <p class="text-2xl font-bold text-blue-900">{{ $pendingBookings }}</p>
                </div>
            </div>
        </div>
        <div class="rounded-2xl shadow-xl p-6 bg-gradient-to-br from-blue-100 via-blue-50 to-white border border-blue-200">
            <div class="flex items-center">
                <div class="w-14 h-14 bg-gradient-to-br from-blue-700 to-blue-500 rounded-full flex items-center justify-center shadow-md">
                    <i class="fas fa-check text-white text-2xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-blue-900">Confirmed</p>
                    <p class="text-2xl font-bold text-blue-900">{{ $confirmedBookings }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-xl shadow-lg p-6 border border-blue-100 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
            <div class="text-center">
                <div class="w-16 h-16 bg-gradient-to-r from-blue-700 to-blue-500 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-users text-white text-2xl"></i>
                </div>
                <h3 class="text-lg font-semibold text-blue-900 mb-2">User Management</h3>
                <p class="text-blue-700 mb-4">View and manage all system users</p>
                <a href="{{ route('admin.users') }}" 
                   class="inline-flex items-center px-4 py-2 bg-blue-700 text-white text-sm font-medium rounded-lg hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200">
                    <i class="fas fa-users-cog mr-2"></i>
                    Manage Users
                </a>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-lg p-6 border border-blue-100 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
            <div class="text-center">
                <div class="w-16 h-16 bg-gradient-to-r from-blue-700 to-blue-500 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-calendar-check text-white text-2xl"></i>
                </div>
                <h3 class="text-lg font-semibold text-blue-900 mb-2">Bookings Management</h3>
                <p class="text-blue-700 mb-4">Review and manage all bookings</p>
                <a href="{{ route('admin.bookings') }}" 
                   class="inline-flex items-center px-4 py-2 bg-blue-700 text-white text-sm font-medium rounded-lg hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200">
                    <i class="fas fa-list mr-2"></i>
                    View Bookings
                </a>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-lg p-6 border border-blue-100 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
            <div class="text-center">
                <div class="w-16 h-16 bg-gradient-to-r from-blue-700 to-blue-500 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-chart-bar text-white text-2xl"></i>
                </div>
                <h3 class="text-lg font-semibold text-blue-900 mb-2">Analytics</h3>
                <p class="text-blue-700 mb-4">View system performance metrics</p>
                <a href="#" 
                   class="inline-flex items-center px-4 py-2 bg-blue-700 text-white text-sm font-medium rounded-lg hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200">
                    <i class="fas fa-chart-line mr-2"></i>
                    View Analytics
                </a>
            </div>
        </div>
    </div>

    <!-- Booking Trends Chart -->
    <div class="bg-white rounded-xl shadow-lg border border-blue-100 p-6">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-xl font-semibold text-blue-900">Booking Trends (Last 30 Days)</h2>
            <div class="flex items-center space-x-2">
                <div class="w-3 h-3 bg-slate-500 rounded-full"></div>
                <span class="text-sm text-gray-600">Daily Bookings</span>
            </div>
        </div>
        <div class="h-64">
            <canvas id="bookingChart"></canvas>
        </div>
    </div>

    <!-- Recent Bookings -->
    <div class="bg-white rounded-xl shadow-lg border border-blue-100">
        <div class="p-6 border-b border-blue-100">
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold text-blue-900">Recent Bookings</h2>
                <a href="{{ route('admin.bookings') }}" class="text-blue-700 hover:text-blue-900 text-sm font-medium">
                    View all <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>
        </div>
        
        @if($recentBookings->count() > 0)
            <div class="divide-y divide-gray-200">
                @foreach($recentBookings as $booking)
                    <div class="p-6 hover:bg-gray-50 transition-colors duration-200">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                <div class="w-12 h-12 rounded-full flex items-center justify-center
                                    @if($booking->status === 'confirmed') bg-emerald-100
                                    @elseif($booking->status === 'pending') bg-amber-100
                                    @else bg-rose-100 @endif">
                                    <i class="fas 
                                        @if($booking->status === 'confirmed') fa-check text-emerald-600
                                        @elseif($booking->status === 'pending') fa-clock text-amber-600
                                        @else fa-times text-rose-600 @endif"></i>
                                </div>
                                <div>
                                    <h3 class="text-lg font-medium text-gray-900">{{ $booking->title }}</h3>
                                    <p class="text-sm text-gray-500">by {{ $booking->user->name }} • {{ $booking->check_in_date->format('M d, Y') }}</p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-2">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium
                                    @if($booking->status === 'confirmed') bg-emerald-100 text-emerald-800
                                    @elseif($booking->status === 'pending') bg-amber-100 text-amber-800
                                    @else bg-rose-100 text-rose-800 @endif">
                                    {{ ucfirst($booking->status) }}
                                </span>
                                <a href="{{ route('admin.bookings.show', $booking) }}" 
                                   class="text-slate-600 hover:text-slate-800 transition-colors duration-200">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="p-12 text-center">
                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-calendar-times text-gray-400 text-2xl"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No bookings yet</h3>
                <p class="text-gray-500">No bookings have been created in the system.</p>
            </div>
        @endif
    </div>

    <!-- System Status -->
    <div class="bg-white rounded-xl shadow-lg border border-blue-100 p-6">
        <h2 class="text-xl font-semibold text-blue-900 mb-4">System Status</h2>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="flex items-center space-x-3">
                <div class="w-3 h-3 bg-emerald-500 rounded-full"></div>
                <span class="text-sm text-gray-600">Booking System</span>
                <span class="text-sm font-medium text-emerald-600">Operational</span>
            </div>
            <div class="flex items-center space-x-3">
                <div class="w-3 h-3 bg-emerald-500 rounded-full"></div>
                <span class="text-sm text-gray-600">User Management</span>
                <span class="text-sm font-medium text-emerald-600">Active</span>
            </div>
            <div class="flex items-center space-x-3">
                <div class="w-3 h-3 bg-emerald-500 rounded-full"></div>
                <span class="text-sm text-gray-600">Notifications</span>
                <span class="text-sm font-medium text-emerald-600">Connected</span>
            </div>
            <div class="flex items-center space-x-3">
                <div class="w-3 h-3 bg-emerald-500 rounded-full"></div>
                <span class="text-sm text-gray-600">Database</span>
                <span class="text-sm font-medium text-emerald-600">Healthy</span>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Booking trends chart
    const ctx = document.getElementById('bookingChart').getContext('2d');
    const bookingChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($dates->keys()) !!},
            datasets: [{
                label: 'Bookings',
                data: {!! json_encode($dates->values()) !!},
                borderColor: '#475569',
                backgroundColor: 'rgba(71, 85, 105, 0.1)',
                borderWidth: 2,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: '#475569',
                pointBorderColor: '#ffffff',
                pointBorderWidth: 2,
                pointRadius: 4,
                pointHoverRadius: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)'
                    },
                    ticks: {
                        stepSize: 1
                    }
                },
                x: {
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)'
                    }
                }
            }
        }
    });
</script>
@endsection 