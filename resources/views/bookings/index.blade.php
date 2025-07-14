@extends('layouts.app')

@section('title', 'My Bookings')

@section('content')
<div class="max-w-7xl mx-auto space-y-8">
    <!-- Header -->
    <div class="bg-white rounded-xl shadow-lg p-8 border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">My Bookings</h1>
                <p class="text-gray-600 text-lg">Manage and track all your reservations</p>
            </div>
            <div class="hidden md:block">
                <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-calendar-alt text-blue-600 text-2xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-100">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-calendar text-blue-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Bookings</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $bookings->count() }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-100">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-clock text-orange-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Pending</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $bookings->where('status', 'pending')->count() }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-100">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-check text-green-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Confirmed</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $bookings->where('status', 'confirmed')->count() }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Action Button -->
    <div class="flex justify-end">
        <a href="{{ route('bookings.create') }}" 
           class="inline-flex items-center px-6 py-3 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 shadow-lg">
            <i class="fas fa-plus mr-2"></i>
            Create New Booking
        </a>
    </div>

    <!-- Bookings Grid -->
    @if($bookings->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($bookings as $booking)
                <div class="bg-white rounded-xl shadow-lg border border-gray-100 hover:shadow-xl transition-all duration-300">
                    <!-- Card Header -->
                    <div class="p-6 border-b border-gray-100">
                        <div class="flex justify-between items-start mb-4">
                            <h3 class="text-lg font-semibold text-gray-900">{{ $booking->title }}</h3>
                            <span class="px-3 py-1 text-xs font-medium rounded-full 
                                @if($booking->status === 'confirmed') bg-green-100 text-green-800
                                @elseif($booking->status === 'pending') bg-orange-100 text-orange-800
                                @else bg-red-100 text-red-800 @endif">
                                {{ ucfirst($booking->status) }}
                            </span>
                        </div>
                        
                        @if($booking->description)
                            <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ Str::limit($booking->description, 100) }}</p>
                        @endif
                    </div>
                    
                    <!-- Card Content -->
                    <div class="p-6">
                        <div class="space-y-3 mb-6">
                            <div class="flex items-center text-sm text-gray-600">
                                <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                                    <i class="fas fa-sign-in-alt text-blue-600 text-xs"></i>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900">Check-in</p>
                                    <p>{{ $booking->check_in_date->format('M d, Y') }} at {{ $booking->check_in_time }}</p>
                                </div>
                            </div>
                            <div class="flex items-center text-sm text-gray-600">
                                <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center mr-3">
                                    <i class="fas fa-sign-out-alt text-red-600 text-xs"></i>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900">Check-out</p>
                                    <p>{{ $booking->check_out_date->format('M d, Y') }} at {{ $booking->check_out_time }}</p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Card Actions -->
                        <div class="flex space-x-2">
                            <a href="{{ route('bookings.show', $booking) }}" 
                               class="flex-1 text-center px-4 py-2 text-sm font-medium text-blue-600 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors duration-200">
                                <i class="fas fa-eye mr-1"></i> View
                            </a>
                            <a href="{{ route('bookings.edit', $booking) }}" 
                               class="flex-1 text-center px-4 py-2 text-sm font-medium text-orange-600 bg-orange-50 rounded-lg hover:bg-orange-100 transition-colors duration-200">
                                <i class="fas fa-edit mr-1"></i> Edit
                            </a>
                            <form method="POST" action="{{ route('bookings.destroy', $booking) }}" class="flex-1" 
                                  onsubmit="return confirm('Are you sure you want to cancel this booking?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="w-full px-4 py-2 text-sm font-medium text-red-600 bg-red-50 rounded-lg hover:bg-red-100 transition-colors duration-200">
                                    <i class="fas fa-trash mr-1"></i> Cancel
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <!-- Empty State -->
        <div class="bg-white rounded-xl shadow-lg p-12 text-center border border-gray-100">
            <div class="mx-auto h-24 w-24 bg-gray-100 rounded-full flex items-center justify-center mb-6">
                <i class="fas fa-calendar-times text-gray-400 text-3xl"></i>
            </div>
            <h3 class="text-xl font-semibold text-gray-900 mb-2">No bookings yet</h3>
            <p class="text-gray-600 mb-8 max-w-md mx-auto">Start your journey by creating your first booking. It's quick and easy!</p>
            <a href="{{ route('bookings.create') }}" 
               class="inline-flex items-center px-6 py-3 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 shadow-lg">
                <i class="fas fa-plus mr-2"></i>
                Create Your First Booking
            </a>
        </div>
    @endif
</div>

<style>
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
@endsection 