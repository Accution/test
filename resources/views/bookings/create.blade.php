@extends('layouts.app')

@section('title', 'Create Booking')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <!-- Header -->
        <div class="bg-gradient-to-r from-slate-600 to-gray-700 rounded-2xl p-8 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold mb-2">Create New Booking</h1>
                    <p class="text-gray-200 text-lg">Schedule your reservation</p>
                </div>
                <div class="hidden md:block">
                    <div class="p-4 bg-white bg-opacity-20 rounded-full">
                        <i class="fas fa-plus text-3xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <form method="POST" action="{{ route('bookings.store') }}" class="p-8 space-y-8">
            @csrf
            
            <!-- Basic Information -->
            <div class="space-y-6">
                <h3 class="text-lg font-semibold text-gray-900 border-b border-gray-200 pb-2">
                    <i class="fas fa-info-circle text-slate-500 mr-2"></i>Basic Information
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label for="title" class="block text-sm font-medium text-gray-700">
                            <i class="fas fa-tag text-gray-400 mr-1"></i>Booking Title
                        </label>
                        <input type="text" id="title" name="title" required 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-slate-500 focus:border-slate-500 transition-all duration-200"
                               placeholder="Enter a descriptive title for your booking"
                               value="{{ old('title') }}">
                        @error('title')
                            <p class="text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div class="space-y-2">
                        <label for="description" class="block text-sm font-medium text-gray-700">
                            <i class="fas fa-align-left text-gray-400 mr-1"></i>Description (Optional)
                        </label>
                        <textarea id="description" name="description" rows="3" 
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-slate-500 focus:border-slate-500 transition-all duration-200"
                                  placeholder="Add any additional details about your booking">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Date & Time Selection -->
            <div class="space-y-6">
                <h3 class="text-lg font-semibold text-gray-900 border-b border-gray-200 pb-2">
                    <i class="fas fa-clock text-slate-500 mr-2"></i>Date & Time Selection
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Check-in -->
                    <div class="bg-gradient-to-br from-slate-50 to-gray-50 p-6 rounded-xl border border-slate-100">
                        <h4 class="text-lg font-medium text-slate-900 mb-4 flex items-center">
                            <i class="fas fa-sign-in-alt mr-2"></i>Check-in Details
                        </h4>
                        
                        <div class="space-y-4">
                            <div>
                                <label for="check_in_date" class="block text-sm font-medium text-slate-700 mb-2">
                                    <i class="fas fa-calendar text-slate-500 mr-1"></i>Check-in Date
                                </label>
                                <input type="text" id="check_in_date" name="check_in_date" required 
                                       class="w-full px-4 py-3 border-2 border-blue-400 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-blue-50 transition-all duration-200"
                                       value="{{ old('check_in_date') }}">
                                @error('check_in_date')
                                    <p class="text-sm text-red-600 flex items-center mt-1">
                                        <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                    </p>
                                @enderror
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-2">
                                    <i class="fas fa-clock text-slate-500 mr-1"></i>Check-in Time
                                </label>
                                <div class="relative">
                                    <input type="text" id="check_in_time_display" readonly
                                           class="w-full px-4 py-3 border border-slate-200 rounded-lg bg-white cursor-pointer transition-all duration-200"
                                           placeholder="Click to select time"
                                           value="{{ old('check_in_time') }}">
                                    <input type="hidden" id="check_in_time" name="check_in_time" value="{{ old('check_in_time') }}">
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                        <i class="fas fa-clock text-slate-400"></i>
                                    </div>
                                </div>
                                
                                <!-- Time Picker Modal for Check-in -->
                                <div id="check_in_time_modal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
                                    <div class="bg-white rounded-xl p-6 w-80 max-w-sm mx-4">
                                        <div class="flex justify-between items-center mb-4">
                                            <h3 class="text-lg font-semibold text-gray-900">Select Check-in Time</h3>
                                            <button type="button" onclick="closeTimeModal('check_in_time_modal')" class="text-gray-400 hover:text-gray-600">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                        
                                        <div class="grid grid-cols-4 gap-2 mb-4">
                                            <div class="col-span-4 text-center mb-2">
                                                <span class="text-2xl font-bold text-gray-900" id="check_in_selected_time">12:00</span>
                                                <span class="text-lg text-gray-600 ml-2" id="check_in_am_pm">AM</span>
                                            </div>
                                        </div>
                                        
                                        <div class="grid grid-cols-3 gap-2 mb-4">
                                            <div class="col-span-3">
                                                <label class="block text-sm font-medium text-gray-700 mb-2">Hour</label>
                                                <select id="check_in_hour" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-slate-500">
                                                    <option value="12">12</option>
                                                    <option value="1">1</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                    <option value="4">4</option>
                                                    <option value="5">5</option>
                                                    <option value="6">6</option>
                                                    <option value="7">7</option>
                                                    <option value="8">8</option>
                                                    <option value="9">9</option>
                                                    <option value="10">10</option>
                                                    <option value="11">11</option>
                                                </select>
                                            </div>
                                        </div>
                                        
                                        <div class="grid grid-cols-3 gap-2 mb-4">
                                            <div class="col-span-3">
                                                <label class="block text-sm font-medium text-gray-700 mb-2">Minute</label>
                                                <select id="check_in_minute" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-slate-500">
                                                    <option value="00">00</option>
                                                    <option value="15">15</option>
                                                    <option value="30">30</option>
                                                    <option value="45">45</option>
                                                </select>
                                            </div>
                                        </div>
                                        
                                        <div class="grid grid-cols-2 gap-2 mb-4">
                                            <button type="button" id="check_in_am" class="px-4 py-2 bg-slate-500 text-white rounded-lg hover:bg-slate-600 transition-colors">AM</button>
                                            <button type="button" id="check_in_pm" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors">PM</button>
                                        </div>
                                        
                                        <div class="flex gap-2">
                                            <button type="button" onclick="closeTimeModal('check_in_time_modal')" class="flex-1 px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50">Cancel</button>
                                            <button type="button" onclick="setTime('check_in')" class="flex-1 px-4 py-2 bg-slate-500 text-white rounded-lg hover:bg-slate-600">Set Time</button>
                                        </div>
                                    </div>
                                </div>
                                
                                @error('check_in_time')
                                    <p class="text-sm text-red-600 flex items-center mt-1">
                                        <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Check-out -->
                    <div class="bg-gradient-to-br from-gray-50 to-slate-50 p-6 rounded-xl border border-gray-100">
                        <h4 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                            <i class="fas fa-sign-out-alt mr-2"></i>Check-out Details
                        </h4>
                        
                        <div class="space-y-4">
                            <div>
                                <label for="check_out_date" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-calendar text-gray-500 mr-1"></i>Check-out Date
                                </label>
                                <input type="text" id="check_out_date" name="check_out_date" required 
                                       class="w-full px-4 py-3 border-2 border-red-400 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 bg-red-50 transition-all duration-200"
                                       value="{{ old('check_out_date') }}">
                                @error('check_out_date')
                                    <p class="text-sm text-red-600 flex items-center mt-1">
                                        <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                    </p>
                                @enderror
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-clock text-gray-500 mr-1"></i>Check-out Time
                                </label>
                                <div class="relative">
                                    <input type="text" id="check_out_time_display" readonly
                                           class="w-full px-4 py-3 border border-gray-200 rounded-lg bg-white cursor-pointer transition-all duration-200"
                                           placeholder="Click to select time">
                                    <input type="hidden" id="check_out_time" name="check_out_time" value="{{ old('check_out_time') }}">
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                        <i class="fas fa-clock text-gray-400"></i>
                                    </div>
                                </div>
                                
                                <!-- Time Picker Modal for Check-out -->
                                <div id="check_out_time_modal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
                                    <div class="bg-white rounded-xl p-6 w-80 max-w-sm mx-4">
                                        <div class="flex justify-between items-center mb-4">
                                            <h3 class="text-lg font-semibold text-gray-900">Select Check-out Time</h3>
                                            <button type="button" onclick="closeTimeModal('check_out_time_modal')" class="text-gray-400 hover:text-gray-600">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                        
                                        <div class="grid grid-cols-4 gap-2 mb-4">
                                            <div class="col-span-4 text-center mb-2">
                                                <span class="text-2xl font-bold text-gray-900" id="check_out_selected_time">12:00</span>
                                                <span class="text-lg text-gray-600 ml-2" id="check_out_am_pm">AM</span>
                                            </div>
                                        </div>
                                        
                                        <div class="grid grid-cols-3 gap-2 mb-4">
                                            <div class="col-span-3">
                                                <label class="block text-sm font-medium text-gray-700 mb-2">Hour</label>
                                                <select id="check_out_hour" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-slate-500">
                                                    <option value="12">12</option>
                                                    <option value="1">1</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                    <option value="4">4</option>
                                                    <option value="5">5</option>
                                                    <option value="6">6</option>
                                                    <option value="7">7</option>
                                                    <option value="8">8</option>
                                                    <option value="9">9</option>
                                                    <option value="10">10</option>
                                                    <option value="11">11</option>
                                                </select>
                                            </div>
                                        </div>
                                        
                                        <div class="grid grid-cols-3 gap-2 mb-4">
                                            <div class="col-span-3">
                                                <label class="block text-sm font-medium text-gray-700 mb-2">Minute</label>
                                                <select id="check_out_minute" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-slate-500">
                                                    <option value="00">00</option>
                                                    <option value="15">15</option>
                                                    <option value="30">30</option>
                                                    <option value="45">45</option>
                                                </select>
                                            </div>
                                        </div>
                                        
                                        <div class="grid grid-cols-2 gap-2 mb-4">
                                            <button type="button" id="check_out_am" class="px-4 py-2 bg-slate-500 text-white rounded-lg hover:bg-slate-600 transition-colors">AM</button>
                                            <button type="button" id="check_out_pm" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors">PM</button>
                                        </div>
                                        
                                        <div class="flex gap-2">
                                            <button type="button" onclick="closeTimeModal('check_out_time_modal')" class="flex-1 px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50">Cancel</button>
                                            <button type="button" onclick="setTime('check_out')" class="flex-1 px-4 py-2 bg-slate-500 text-white rounded-lg hover:bg-slate-600">Set Time</button>
                                        </div>
                                    </div>
                                </div>
                                
                                @error('check_out_time')
                                    <p class="text-sm text-red-600 flex items-center mt-1">
                                        <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Booking Summary -->
            <div class="bg-gradient-to-r from-slate-50 to-gray-50 p-6 rounded-xl border border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-receipt text-slate-500 mr-2"></i>Booking Summary
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                    <div class="bg-white p-4 rounded-lg border border-gray-200">
                        <span class="font-medium text-gray-700">Check-in:</span>
                        <span id="summary-check-in" class="text-gray-600 ml-2">-</span>
                    </div>
                    <div class="bg-white p-4 rounded-lg border border-gray-200">
                        <span class="font-medium text-gray-700">Check-out:</span>
                        <span id="summary-check-out" class="text-gray-600 ml-2">-</span>
                    </div>
                    <div class="bg-white p-4 rounded-lg border border-gray-200">
                        <span class="font-medium text-gray-700">Duration:</span>
                        <span id="summary-duration" class="text-gray-600 ml-2">-</span>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex flex-col sm:flex-row gap-4 pt-6 border-t border-gray-200">
                <a href="{{ route('bookings.index') }}" 
                   class="flex-1 sm:flex-none inline-flex items-center justify-center px-6 py-3 border border-gray-300 text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-slate-500 transition-all duration-200">
                    <i class="fas fa-arrow-left mr-2"></i> Cancel
                </a>
                
                <button type="submit" 
                        class="flex-1 sm:flex-none inline-flex items-center justify-center px-6 py-3 border border-transparent text-sm font-medium rounded-lg text-white bg-gradient-to-r from-slate-600 to-gray-700 hover:from-slate-700 hover:to-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-slate-500 transition-all duration-200 shadow-lg">
                    <i class="fas fa-calendar-plus mr-2"></i> Create Booking
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Add Flatpickr CSS/JS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<style>
  .flatpickr-day.check-in { background: #3b82f6 !important; color: #fff !important; border-radius: 50% !important; }
  .flatpickr-day.check-out { background: #ef4444 !important; color: #fff !important; border-radius: 50% !important; }
</style>

<script>
    // Time picker functionality
    let currentTimeType = '';
    
    // Initialize time pickers
    document.addEventListener('DOMContentLoaded', function() {
        // Set up click handlers for time display fields
        document.getElementById('check_in_time_display').addEventListener('click', function() {
            openTimeModal('check_in_time_modal', 'check_in');
        });
        
        document.getElementById('check_out_time_display').addEventListener('click', function() {
            openTimeModal('check_out_time_modal', 'check_out');
        });
        
        // Set up AM/PM button handlers for check-in
        document.getElementById('check_in_am').addEventListener('click', function() {
            setAmPm('check_in', 'AM');
        });
        document.getElementById('check_in_pm').addEventListener('click', function() {
            setAmPm('check_in', 'PM');
        });
        
        // Set up AM/PM button handlers for check-out
        document.getElementById('check_out_am').addEventListener('click', function() {
            setAmPm('check_out', 'AM');
        });
        document.getElementById('check_out_pm').addEventListener('click', function() {
            setAmPm('check_out', 'PM');
        });
        
        // Set up change handlers for hour and minute selects
        ['check_in_hour', 'check_in_minute', 'check_out_hour', 'check_out_minute'].forEach(id => {
            document.getElementById(id).addEventListener('change', function() {
                updateTimeDisplay(id.split('_')[0] + '_' + id.split('_')[1]);
            });
        });
        
        // Initialize summary
        updateSummary();

        // Initialize Flatpickr for date pickers
        flatpickr("#check_in_date", {
            dateFormat: "Y-m-d",
            onChange: function(selectedDates, dateStr, instance) {
                setTimeout(() => {
                    document.querySelectorAll('.flatpickr-day').forEach(day => {
                        day.classList.remove('check-in');
                        if(day.dateObj && day.dateObj.toISOString().slice(0,10) === dateStr) {
                            day.classList.add('check-in');
                        }
                    });
                }, 10);
            }
        });
        flatpickr("#check_out_date", {
            dateFormat: "Y-m-d",
            onChange: function(selectedDates, dateStr, instance) {
                setTimeout(() => {
                    document.querySelectorAll('.flatpickr-day').forEach(day => {
                        day.classList.remove('check-out');
                        if(day.dateObj && day.dateObj.toISOString().slice(0,10) === dateStr) {
                            day.classList.add('check-out');
                        }
                    });
                }, 10);
            }
        });
    });
    
    function openTimeModal(modalId, timeType) {
        currentTimeType = timeType;
        document.getElementById(modalId).classList.remove('hidden');
        updateTimeDisplay(timeType);
    }
    
    function closeTimeModal(modalId) {
        document.getElementById(modalId).classList.add('hidden');
    }
    
    function setAmPm(timeType, amPm) {
        const amButton = document.getElementById(timeType + '_am');
        const pmButton = document.getElementById(timeType + '_pm');
        const amPmSpan = document.getElementById(timeType + '_am_pm');
        
        if (amPm === 'AM') {
            amButton.className = 'px-4 py-2 bg-slate-500 text-white rounded-lg hover:bg-slate-600 transition-colors';
            pmButton.className = 'px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors';
        } else {
            amButton.className = 'px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors';
            pmButton.className = 'px-4 py-2 bg-slate-500 text-white rounded-lg hover:bg-slate-600 transition-colors';
        }
        
        amPmSpan.textContent = amPm;
        updateTimeDisplay(timeType);
    }
    
    function updateTimeDisplay(timeType) {
        const hour = document.getElementById(timeType + '_hour').value;
        const minute = document.getElementById(timeType + '_minute').value;
        const amPm = document.getElementById(timeType + '_am_pm').textContent;
        
        document.getElementById(timeType + '_selected_time').textContent = hour + ':' + minute;
        document.getElementById(timeType + '_am_pm').textContent = amPm;
    }
    
    function setTime(timeType) {
        const hour = document.getElementById(timeType + '_hour').value;
        const minute = document.getElementById(timeType + '_minute').value;
        const amPm = document.getElementById(timeType + '_am_pm').textContent;
        
        // Convert to 24-hour format for the hidden input
        let hour24 = parseInt(hour);
        if (amPm === 'PM' && hour24 !== 12) {
            hour24 += 12;
        } else if (amPm === 'AM' && hour24 === 12) {
            hour24 = 0;
        }
        
        const time24 = hour24.toString().padStart(2, '0') + ':' + minute;
        const time12 = hour + ':' + minute + ' ' + amPm;
        
        // Set the hidden input (24-hour format for form submission)
        document.getElementById(timeType + '_time').value = time24;
        
        // Set the display input (12-hour format for user)
        document.getElementById(timeType + '_time_display').value = time12;
        
        // Close the modal
        closeTimeModal(timeType + '_time_modal');
        
        // Update summary
        updateSummary();
    }
    
    // Enhanced booking summary with better formatting
    function updateSummary() {
        const checkInDate = document.getElementById('check_in_date').value;
        const checkInTime = document.getElementById('check_in_time_display').value;
        const checkOutDate = document.getElementById('check_out_date').value;
        const checkOutTime = document.getElementById('check_out_time_display').value;

        if (checkInDate && checkInTime) {
            const formattedDate = new Date(checkInDate).toLocaleDateString('en-US', { 
                weekday: 'short', 
                year: 'numeric', 
                month: 'short', 
                day: 'numeric' 
            });
            document.getElementById('summary-check-in').textContent = `${formattedDate} at ${checkInTime}`;
        }

        if (checkOutDate && checkOutTime) {
            const formattedDate = new Date(checkOutDate).toLocaleDateString('en-US', { 
                weekday: 'short', 
                year: 'numeric', 
                month: 'short', 
                day: 'numeric' 
            });
            document.getElementById('summary-check-out').textContent = `${formattedDate} at ${checkOutTime}`;
        }

        if (checkInDate && checkOutDate) {
            const start = new Date(checkInDate);
            const end = new Date(checkOutDate);
            const diffTime = Math.abs(end - start);
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
            
            if (diffDays === 0) {
                document.getElementById('summary-duration').textContent = 'Same day';
            } else if (diffDays === 1) {
                document.getElementById('summary-duration').textContent = '1 day';
            } else {
                document.getElementById('summary-duration').textContent = `${diffDays} days`;
            }
        }
    }

    // Add event listeners for real-time updates
    document.getElementById('check_in_date').addEventListener('change', updateSummary);
    document.getElementById('check_out_date').addEventListener('change', updateSummary);
</script>
@endsection 