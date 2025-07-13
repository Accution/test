@extends('layouts.app')

@section('title', 'Edit Booking')

@section('content')
<div class="max-w-4xl mx-auto space-y-8">
    <!-- Header -->
    <div class="bg-gradient-to-r from-orange-600 to-orange-700 rounded-2xl p-8 text-white">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold mb-2">Edit Booking</h1>
                <p class="text-orange-100 text-lg">Update your reservation details</p>
            </div>
            <div class="hidden md:block">
                <div class="p-4 bg-white bg-opacity-20 rounded-full">
                    <i class="fas fa-edit text-3xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
        <form method="POST" action="{{ route('bookings.update', $booking) }}" class="p-8">
            @csrf
            @method('PUT')
            
            <!-- Basic Information Section -->
            <div class="mb-8">
                <h3 class="text-xl font-semibold text-gray-900 mb-6 flex items-center">
                    <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                        <i class="fas fa-info-circle text-blue-600"></i>
                    </div>
                    Basic Information
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-heading mr-1 text-blue-500"></i>
                            Booking Title *
                        </label>
                        <input type="text" 
                               id="title" 
                               name="title" 
                               value="{{ old('title', $booking->title) }}" 
                               required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-gray-50 hover:bg-white focus:bg-white"
                               placeholder="Enter booking title">
                        @error('title')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <!-- Removed status dropdown for users -->
                </div>
                
                <div class="mt-6">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-align-left mr-1 text-purple-500"></i>
                        Description
                    </label>
                    <textarea id="description" 
                              name="description" 
                              rows="4"
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all duration-200 bg-gray-50 hover:bg-white focus:bg-white resize-none"
                              placeholder="Enter booking description (optional)">{{ old('description', $booking->description) }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Date & Time Section -->
            <div class="mb-8">
                <h3 class="text-xl font-semibold text-gray-900 mb-6 flex items-center">
                    <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center mr-3">
                        <i class="fas fa-calendar-alt text-purple-600"></i>
                    </div>
                    Date & Time Details
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Check-in Details -->
                    <div class="bg-gradient-to-r from-blue-50 to-blue-100 rounded-xl p-6 border border-blue-200">
                        <h4 class="text-lg font-semibold text-blue-900 mb-4 flex items-center">
                            <i class="fas fa-sign-in-alt mr-2"></i>
                            Check-in Details
                        </h4>
                        
                        <div class="space-y-4">
                            <div>
                                <label for="check_in_date" class="block text-sm font-medium text-blue-800 mb-2">
                                    <i class="fas fa-calendar mr-1"></i>
                                    Check-in Date *
                                </label>
                                <input type="date" 
                                       id="check_in_date" 
                                       name="check_in_date" 
                                       value="{{ old('check_in_date', $booking->check_in_date->format('Y-m-d')) }}" 
                                       required
                                       class="w-full px-4 py-3 border border-blue-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white hover:bg-blue-50">
                                @error('check_in_date')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label for="check_in_time" class="block text-sm font-medium text-blue-800 mb-2">
                                    <i class="fas fa-clock mr-1"></i>
                                    Check-in Time *
                                </label>
                                <input type="time" 
                                       id="check_in_time" 
                                       name="check_in_time" 
                                       value="{{ old('check_in_time', $booking->check_in_time) }}" 
                                       required
                                       class="w-full px-4 py-3 border border-blue-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-white hover:bg-blue-50">
                                @error('check_in_time')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <!-- Check-out Details -->
                    <div class="bg-gradient-to-r from-red-50 to-red-100 rounded-xl p-6 border border-red-200">
                        <h4 class="text-lg font-semibold text-red-900 mb-4 flex items-center">
                            <i class="fas fa-sign-out-alt mr-2"></i>
                            Check-out Details
                        </h4>
                        
                        <div class="space-y-4">
                            <div>
                                <label for="check_out_date" class="block text-sm font-medium text-red-800 mb-2">
                                    <i class="fas fa-calendar mr-1"></i>
                                    Check-out Date *
                                </label>
                                <input type="date" 
                                       id="check_out_date" 
                                       name="check_out_date" 
                                       value="{{ old('check_out_date', $booking->check_out_date->format('Y-m-d')) }}" 
                                       required
                                       class="w-full px-4 py-3 border border-red-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all duration-200 bg-white hover:bg-red-50">
                                @error('check_out_date')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label for="check_out_time" class="block text-sm font-medium text-red-800 mb-2">
                                    <i class="fas fa-clock mr-1"></i>
                                    Check-out Time *
                                </label>
                                <input type="time" 
                                       id="check_out_time" 
                                       name="check_out_time" 
                                       value="{{ old('check_out_time', $booking->check_out_time) }}" 
                                       required
                                       class="w-full px-4 py-3 border border-red-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all duration-200 bg-white hover:bg-red-50">
                                @error('check_out_time')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex flex-col sm:flex-row gap-4 pt-6 border-t border-gray-200">
                <a href="{{ route('bookings.show', $booking) }}" 
                   class="flex-1 sm:flex-none inline-flex items-center justify-center px-6 py-3 border border-gray-300 text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-all duration-200 shadow-sm">
                    <i class="fas fa-times mr-2"></i>
                    Cancel
                </a>
                
                <button type="submit" 
                        class="flex-1 sm:flex-none inline-flex items-center justify-center px-6 py-3 border border-transparent text-sm font-medium rounded-lg text-white bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 shadow-lg transform hover:-translate-y-1">
                    <i class="fas fa-save mr-2"></i>
                    Update Booking
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Real-time validation for dates
    document.getElementById('check_in_date').addEventListener('change', function() {
        const checkInDate = new Date(this.value);
        const checkOutDateInput = document.getElementById('check_out_date');
        const checkOutDate = new Date(checkOutDateInput.value);
        
        if (checkOutDate <= checkInDate) {
            checkOutDateInput.value = '';
            alert('Check-out date must be after check-in date');
        }
    });
    
    document.getElementById('check_out_date').addEventListener('change', function() {
        const checkOutDate = new Date(this.value);
        const checkInDate = new Date(document.getElementById('check_in_date').value);
        
        if (checkOutDate <= checkInDate) {
            alert('Check-out date must be after check-in date');
            this.value = '';
        }
    });
</script>
@endsection 