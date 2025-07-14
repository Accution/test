@extends('layouts.app')

@section('title', 'My Profile')

@section('content')
<div class="max-w-4xl mx-auto space-y-8">
    <!-- Header -->
    <div class="bg-white rounded-xl shadow-lg p-8 border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">My Profile</h1>
                <p class="text-gray-600 text-lg">Manage your account information</p>
            </div>
            <div class="hidden md:block">
                <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-user-circle text-blue-600 text-2xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Profile Overview -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
        <div class="bg-gray-50 px-8 py-6 border-b border-gray-200">
            <div class="flex items-center space-x-6">
                <div class="w-20 h-20 bg-blue-100 rounded-full flex items-center justify-center">
                    <span class="text-blue-600 text-2xl font-bold">{{ substr(auth()->user()->name, 0, 1) }}</span>
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">{{ auth()->user()->name }}</h2>
                    <p class="text-gray-600">{{ auth()->user()->email }}</p>
                    <div class="flex items-center mt-2">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium 
                            @if(auth()->user()->isAdmin()) bg-orange-100 text-orange-800 @else bg-green-100 text-green-800 @endif">
                            <i class="fas fa-circle mr-2 text-xs"></i>
                            {{ auth()->user()->isAdmin() ? 'Administrator' : 'Regular User' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="p-8">
            <form method="POST" action="{{ route('profile.update') }}" class="space-y-8">
                @csrf
                @method('PUT')
                
                <!-- Personal Information -->
                <div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-6 flex items-center">
                        <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                            <i class="fas fa-user text-blue-600"></i>
                        </div>
                        Personal Information
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-user mr-1 text-blue-500"></i>
                                Full Name *
                            </label>
                            <input type="text" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name', auth()->user()->name) }}" 
                                   required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-gray-50 hover:bg-white focus:bg-white"
                                   placeholder="Enter your full name">
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-envelope mr-1 text-green-500"></i>
                                Email Address *
                            </label>
                            <input type="email" 
                                   id="email" 
                                   name="email" 
                                   value="{{ old('email', auth()->user()->email) }}" 
                                   required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200 bg-gray-50 hover:bg-white focus:bg-white"
                                   placeholder="Enter your email address">
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Account Statistics -->
                <div class="bg-blue-50 rounded-xl p-6 border border-blue-200">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center mr-2">
                            <i class="fas fa-chart-bar text-blue-600"></i>
                        </div>
                        Account Statistics
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="text-center p-4 bg-white rounded-lg border border-blue-200">
                            <div class="text-2xl font-bold text-blue-600">{{ auth()->user()->bookings->count() }}</div>
                            <div class="text-sm text-gray-600">Total Bookings</div>
                        </div>
                        <div class="text-center p-4 bg-white rounded-lg border border-green-200">
                            <div class="text-2xl font-bold text-green-600">{{ auth()->user()->bookings->where('status', 'confirmed')->count() }}</div>
                            <div class="text-sm text-gray-600">Confirmed</div>
                        </div>
                        <div class="text-center p-4 bg-white rounded-lg border border-orange-200">
                            <div class="text-2xl font-bold text-orange-600">{{ auth()->user()->bookings->where('status', 'pending')->count() }}</div>
                            <div class="text-sm text-gray-600">Pending</div>
                        </div>
                    </div>
                </div>

                <!-- Account Information -->
                <div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-6 flex items-center">
                        <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center mr-3">
                            <i class="fas fa-info-circle text-purple-600"></i>
                        </div>
                        Account Information
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-calendar mr-1 text-purple-500"></i>
                                Member Since
                            </label>
                            <div class="px-4 py-3 bg-gray-50 border border-gray-300 rounded-lg">
                                <p class="text-gray-900">{{ auth()->user()->created_at->format('F d, Y') }}</p>
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-clock mr-1 text-orange-500"></i>
                                Last Updated
                            </label>
                            <div class="px-4 py-3 bg-gray-50 border border-gray-300 rounded-lg">
                                <p class="text-gray-900">{{ auth()->user()->updated_at->format('F d, Y g:i A') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex flex-col sm:flex-row gap-4 pt-6 border-t border-gray-200">
                    <button type="submit" 
                            class="flex-1 sm:flex-none inline-flex items-center justify-center px-6 py-3 border border-transparent text-sm font-medium rounded-lg text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 shadow-lg">
                        <i class="fas fa-save mr-2"></i>
                        Update Profile
                    </button>
                    
                    <a href="{{ route('dashboard') }}" 
                       class="flex-1 sm:flex-none inline-flex items-center justify-center px-6 py-3 border border-gray-300 text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-all duration-200 shadow-sm">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Back to Dashboard
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
        <h3 class="text-xl font-semibold text-gray-900 mb-6 flex items-center">
            <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center mr-3">
                <i class="fas fa-history text-green-600"></i>
            </div>
            Recent Activity
        </h3>
        
        @if(auth()->user()->bookings->count() > 0)
            <div class="space-y-4">
                @foreach(auth()->user()->bookings->take(5) as $booking)
                    <div class="flex items-center p-4 bg-gray-50 rounded-lg border border-gray-200">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center mr-4
                            @if($booking->status === 'confirmed') bg-green-100
                            @elseif($booking->status === 'pending') bg-orange-100
                            @else bg-red-100 @endif">
                            <i class="fas 
                                @if($booking->status === 'confirmed') fa-check text-green-600
                                @elseif($booking->status === 'pending') fa-clock text-orange-600
                                @else fa-times text-red-600 @endif"></i>
                        </div>
                        <div class="flex-1">
                            <h4 class="font-medium text-gray-900">{{ $booking->title }}</h4>
                            <p class="text-sm text-gray-600">{{ $booking->created_at->diffForHumans() }}</p>
                        </div>
                        <span class="px-3 py-1 text-xs font-medium rounded-full 
                            @if($booking->status === 'confirmed') bg-green-100 text-green-800
                            @elseif($booking->status === 'pending') bg-orange-100 text-orange-800
                            @else bg-red-100 text-red-800 @endif">
                            {{ ucfirst($booking->status) }}
                        </span>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-8">
                <div class="mx-auto h-16 w-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                    <i class="fas fa-calendar-times text-gray-400 text-xl"></i>
                </div>
                <p class="text-gray-600">No recent activity</p>
                <a href="{{ route('bookings.create') }}" 
                   class="inline-flex items-center mt-4 px-4 py-2 text-sm font-medium text-blue-600 hover:text-blue-800">
                    <i class="fas fa-plus mr-2"></i>
                    Create your first booking
                </a>
            </div>
        @endif
    </div>
</div>
@endsection 