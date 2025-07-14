@extends('layouts.app')

@section('title', 'Booking Details')

@section('content')
<div class="max-w-4xl mx-auto space-y-8">
    <!-- Header -->
    <div class="bg-white rounded-xl shadow-lg p-8 border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Booking Details</h1>
                <p class="text-gray-600 text-lg">View and manage your reservation</p>
            </div>
            <div class="hidden md:block">
                <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-file-alt text-blue-600 text-2xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Status Banner -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
        <div class="p-6 
            @if($booking->status === 'confirmed') bg-green-50 border-l-4 border-green-500
            @elseif($booking->status === 'pending') bg-orange-50 border-l-4 border-orange-500
            @else bg-red-50 border-l-4 border-red-500 @endif">
            <div class="flex items-center">
                <div class="w-12 h-12 rounded-full flex items-center justify-center
                    @if($booking->status === 'confirmed') bg-green-100
                    @elseif($booking->status === 'pending') bg-orange-100
                    @else bg-red-100 @endif">
                    <i class="fas 
                        @if($booking->status === 'confirmed') fa-check text-green-600
                        @elseif($booking->status === 'pending') fa-clock text-orange-600
                        @else fa-times text-red-600 @endif text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-gray-900">Booking Status</h3>
                    <p class="text-gray-600">Your booking is currently 
                        <span class="font-semibold 
                            @if($booking->status === 'confirmed') text-green-600
                            @elseif($booking->status === 'pending') text-orange-600
                            @else text-red-600 @endif">
                            {{ ucfirst($booking->status) }}
                        </span>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Booking Details -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Basic Information -->
            <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
                <h3 class="text-xl font-semibold text-gray-900 mb-6 flex items-center">
                    <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                        <i class="fas fa-info-circle text-blue-600"></i>
                    </div>
                    Basic Information
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Booking Title</label>
                        <div class="p-3 bg-gray-50 rounded-lg border border-gray-200">
                            <p class="text-gray-900 font-medium">{{ $booking->title }}</p>
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Booking ID</label>
                        <div class="p-3 bg-gray-50 rounded-lg border border-gray-200">
                            <p class="text-gray-900 font-mono text-sm">#{{ $booking->id }}</p>
                        </div>
                    </div>
                    
                    @if($booking->description)
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                        <div class="p-3 bg-gray-50 rounded-lg border border-gray-200">
                            <p class="text-gray-900">{{ $booking->description }}</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Date & Time Information -->
            <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
                <h3 class="text-xl font-semibold text-gray-900 mb-6 flex items-center">
                    <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center mr-3">
                        <i class="fas fa-calendar-alt text-purple-600"></i>
                    </div>
                    Date & Time Details
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-blue-50 rounded-xl p-6 border border-blue-200">
                        <div class="flex items-center mb-3">
                            <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center mr-3">
                                <i class="fas fa-sign-in-alt text-white"></i>
                            </div>
                            <h4 class="text-lg font-semibold text-gray-900">Check-in</h4>
                        </div>
                        <div class="space-y-2">
                            <p class="text-gray-700">
                                <span class="font-medium">Date:</span> {{ $booking->check_in_date->format('l, F d, Y') }}
                            </p>
                            <p class="text-gray-700">
                                <span class="font-medium">Time:</span> {{ $booking->check_in_time }}
                            </p>
                        </div>
                    </div>
                    
                    <div class="bg-red-50 rounded-xl p-6 border border-red-200">
                        <div class="flex items-center mb-3">
                            <div class="w-10 h-10 bg-red-600 rounded-full flex items-center justify-center mr-3">
                                <i class="fas fa-sign-out-alt text-white"></i>
                            </div>
                            <h4 class="text-lg font-semibold text-gray-900">Check-out</h4>
                        </div>
                        <div class="space-y-2">
                            <p class="text-gray-700">
                                <span class="font-medium">Date:</span> {{ $booking->check_out_date->format('l, F d, Y') }}
                            </p>
                            <p class="text-gray-700">
                                <span class="font-medium">Time:</span> {{ $booking->check_out_time }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Quick Actions -->
            <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <div class="w-8 h-8 bg-orange-100 rounded-full flex items-center justify-center mr-2">
                        <i class="fas fa-bolt text-orange-600 text-sm"></i>
                    </div>
                    Quick Actions
                </h3>
                
                <div class="space-y-3">
                    <a href="{{ route('bookings.edit', $booking) }}" 
                       class="w-full flex items-center justify-center px-4 py-3 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-all duration-200 shadow-md">
                        <i class="fas fa-edit mr-2"></i>
                        Edit Booking
                    </a>
                    
                    <form method="POST" action="{{ route('bookings.destroy', $booking) }}" 
                          onsubmit="return confirm('Are you sure you want to cancel this booking?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="w-full flex items-center justify-center px-4 py-3 bg-red-600 text-white text-sm font-medium rounded-lg hover:bg-red-700 transition-all duration-200 shadow-md">
                            <i class="fas fa-trash mr-2"></i>
                            Cancel Booking
                        </button>
                    </form>
                    
                    <a href="{{ route('bookings.index') }}" 
                       class="w-full flex items-center justify-center px-4 py-3 bg-gray-100 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-200 transition-all duration-200">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Back to Bookings
                    </a>
                </div>
            </div>

            <!-- Booking Timeline -->
            <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center mr-2">
                        <i class="fas fa-history text-green-600 text-sm"></i>
                    </div>
                    Booking Timeline
                </h3>
                
                <div class="space-y-4">
                    <div class="flex items-start">
                        <div class="w-3 h-3 bg-green-500 rounded-full mt-2 mr-3"></div>
                        <div>
                            <p class="text-sm font-medium text-gray-900">Booking Created</p>
                            <p class="text-xs text-gray-500">{{ $booking->created_at->format('M d, Y g:i A') }}</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start">
                        <div class="w-3 h-3 bg-blue-500 rounded-full mt-2 mr-3"></div>
                        <div>
                            <p class="text-sm font-medium text-gray-900">Status Updated</p>
                            <p class="text-xs text-gray-500">{{ $booking->updated_at->format('M d, Y g:i A') }}</p>
                        </div>
                    </div>
                    
                    @if($booking->status === 'confirmed')
                    <div class="flex items-start">
                        <div class="w-3 h-3 bg-green-500 rounded-full mt-2 mr-3"></div>
                        <div>
                            <p class="text-sm font-medium text-gray-900">Booking Confirmed</p>
                            <p class="text-xs text-gray-500">Ready for your stay!</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Contact Information -->
            <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center mr-2">
                        <i class="fas fa-user text-purple-600 text-sm"></i>
                    </div>
                    Contact Info
                </h3>
                
                <div class="space-y-3">
                    <div class="flex items-center text-sm text-gray-600">
                        <i class="fas fa-user-circle w-4 h-4 mr-2 text-gray-400"></i>
                        <span>{{ $booking->user->name }}</span>
                    </div>
                    <div class="flex items-center text-sm text-gray-600">
                        <i class="fas fa-envelope w-4 h-4 mr-2 text-gray-400"></i>
                        <span>{{ $booking->user->email }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 