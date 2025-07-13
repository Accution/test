@extends('layouts.app')

@section('title', 'All Bookings')

@section('content')
<div class="max-w-7xl mx-auto space-y-8">
    <!-- Header -->
    <div class="bg-gradient-to-r from-slate-600 to-slate-700 rounded-2xl p-8 text-white">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold mb-2">All Bookings</h1>
                <p class="text-slate-100 text-lg">Manage and monitor all reservations</p>
            </div>
            <div class="hidden md:block">
                <div class="p-4 bg-white bg-opacity-20 rounded-full">
                    <i class="fas fa-calendar-check text-3xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-100 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-gradient-to-r from-blue-500 to-blue-600">
                    <i class="fas fa-calendar text-white text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Bookings</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $bookings->count() }}</p>
                </div>
            </div>
            <div class="mt-4">
                <div class="flex items-center text-sm text-blue-600">
                    <i class="fas fa-chart-line mr-1"></i>
                    <span>All reservations</span>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-100 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-gradient-to-r from-yellow-500 to-yellow-600">
                    <i class="fas fa-clock text-white text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Pending</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $bookings->where('status', 'pending')->count() }}</p>
                </div>
            </div>
            <div class="mt-4">
                <div class="flex items-center text-sm text-yellow-600">
                    <i class="fas fa-clock mr-1"></i>
                    <span>Awaiting approval</span>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-100 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-gradient-to-r from-green-500 to-green-600">
                    <i class="fas fa-check text-white text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Confirmed</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $bookings->where('status', 'confirmed')->count() }}</p>
                </div>
            </div>
            <div class="mt-4">
                <div class="flex items-center text-sm text-green-600">
                    <i class="fas fa-check-circle mr-1"></i>
                    <span>Approved bookings</span>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-100 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-gradient-to-r from-red-500 to-red-600">
                    <i class="fas fa-times text-white text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Cancelled</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $bookings->where('status', 'cancelled')->count() }}</p>
                </div>
            </div>
            <div class="mt-4">
                <div class="flex items-center text-sm text-red-600">
                    <i class="fas fa-ban mr-1"></i>
                    <span>Cancelled bookings</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Search and Filters -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
        <div class="flex flex-col md:flex-row gap-4 items-center justify-between">
            <div class="flex-1 max-w-md">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-search text-gray-400"></i>
                    </div>
                    <input type="text" 
                           id="search" 
                           placeholder="Search bookings by title or user..." 
                           class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                </div>
            </div>
            
            <div class="flex space-x-3">
                <select id="status-filter" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                    <option value="">All Status</option>
                    <option value="pending">Pending</option>
                    <option value="confirmed">Confirmed</option>
                    <option value="cancelled">Cancelled</option>
                </select>
                
                <select id="date-filter" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                    <option value="">All Dates</option>
                    <option value="today">Today</option>
                    <option value="week">This Week</option>
                    <option value="month">This Month</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Bookings Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($bookings as $booking)
            <div class="bg-white rounded-xl shadow-lg border border-gray-100 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 group">
                <!-- Booking Header -->
                <div class="p-6 border-b border-gray-100">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-900 group-hover:text-blue-600 transition-colors duration-200">{{ $booking->title }}</h3>
                        <span class="px-3 py-1 text-xs font-medium rounded-full 
                            @if($booking->status === 'confirmed') bg-green-100 text-green-800
                            @elseif($booking->status === 'pending') bg-yellow-100 text-yellow-800
                            @else bg-red-100 text-red-800 @endif">
                            <i class="fas fa-circle mr-1 text-xs"></i>
                            {{ ucfirst($booking->status) }}
                        </span>
                    </div>
                    
                    @if($booking->description)
                        <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ Str::limit($booking->description, 100) }}</p>
                    @endif
                </div>
                
                <!-- User Info -->
                <div class="px-6 py-4 bg-gray-50 border-b border-gray-100">
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full flex items-center justify-center">
                            <span class="text-white text-sm font-bold">{{ substr($booking->user->name, 0, 1) }}</span>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-900">{{ $booking->user->name }}</p>
                            <p class="text-xs text-gray-600">{{ $booking->user->email }}</p>
                        </div>
                        <div class="ml-auto">
                            <span class="px-2 py-1 text-xs font-medium rounded-full 
                                @if($booking->user->isAdmin()) bg-yellow-100 text-yellow-800 @else bg-green-100 text-green-800 @endif">
                                {{ $booking->user->isAdmin() ? 'Admin' : 'User' }}
                            </span>
                        </div>
                    </div>
                </div>
                
                <!-- Booking Details -->
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
                    
                    <!-- Booking Meta -->
                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div class="text-center p-3 bg-gray-50 rounded-lg border border-gray-200">
                            <div class="text-lg font-bold text-gray-900">#{{ $booking->id }}</div>
                            <div class="text-xs text-gray-600">Booking ID</div>
                        </div>
                        <div class="text-center p-3 bg-gray-50 rounded-lg border border-gray-200">
                            <div class="text-lg font-bold text-gray-900">{{ $booking->created_at->format('M d') }}</div>
                            <div class="text-xs text-gray-600">Created</div>
                        </div>
                    </div>
                    
                    <!-- Action Buttons -->
                    <div class="flex space-x-2">
                        <a href="{{ route('admin.bookings.show', $booking) }}" 
                           class="flex-1 text-center px-4 py-2 text-sm font-medium text-blue-600 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors duration-200 group-hover:bg-blue-100">
                            <i class="fas fa-eye mr-1"></i> View
                        </a>
                        
                        @if($booking->status === 'pending')
                            <form method="POST" action="{{ route('admin.bookings.confirm', $booking) }}" class="flex-1">
                                @csrf
                                @method('PATCH')
                                <button type="submit" 
                                        class="w-full px-4 py-2 text-sm font-medium text-green-600 bg-green-50 rounded-lg hover:bg-green-100 transition-colors duration-200 group-hover:bg-green-100"
                                        onclick="return confirm('Confirm this booking?')">
                                    <i class="fas fa-check mr-1"></i> Confirm
                                </button>
                            </form>
                        @elseif($booking->status === 'confirmed')
                            <form method="POST" action="{{ route('admin.bookings.cancel', $booking) }}" class="flex-1">
                                @csrf
                                @method('PATCH')
                                <button type="submit" 
                                        class="w-full px-4 py-2 text-sm font-medium text-red-600 bg-red-50 rounded-lg hover:bg-red-100 transition-colors duration-200 group-hover:bg-red-100"
                                        onclick="return confirm('Cancel this booking?')">
                                    <i class="fas fa-times mr-1"></i> Cancel
                                </button>
                            </form>
                        @else
                            <div class="flex-1 text-center px-4 py-2 text-sm font-medium text-gray-400 bg-gray-50 rounded-lg">
                                <i class="fas fa-ban mr-1"></i> Cancelled
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Empty State -->
    @if($bookings->count() === 0)
        <div class="bg-white rounded-xl shadow-lg p-12 text-center border border-gray-100">
            <div class="mx-auto h-24 w-24 bg-gradient-to-r from-orange-100 to-red-100 rounded-full flex items-center justify-center mb-6">
                <i class="fas fa-calendar-times text-orange-500 text-3xl"></i>
            </div>
            <h3 class="text-xl font-semibold text-gray-900 mb-2">No bookings found</h3>
            <p class="text-gray-600 mb-8 max-w-md mx-auto">There are no bookings in the system yet.</p>
        </div>
    @endif

    <!-- Pagination -->
    @if($bookings->hasPages())
        <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-4">
            {{ $bookings->links() }}
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

<script>
    // Search functionality
    document.getElementById('search').addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        const bookingCards = document.querySelectorAll('.grid > div');
        
        bookingCards.forEach(card => {
            const bookingTitle = card.querySelector('h3').textContent.toLowerCase();
            const userName = card.querySelector('.text-gray-900').textContent.toLowerCase();
            
            if (bookingTitle.includes(searchTerm) || userName.includes(searchTerm)) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
    });

    // Status filter
    document.getElementById('status-filter').addEventListener('change', function() {
        const selectedStatus = this.value;
        const bookingCards = document.querySelectorAll('.grid > div');
        
        bookingCards.forEach(card => {
            const statusBadge = card.querySelector('span');
            const status = statusBadge.textContent.trim().toLowerCase();
            
            if (selectedStatus === '' || status === selectedStatus) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
    });

    // Date filter
    document.getElementById('date-filter').addEventListener('change', function() {
        const selectedDate = this.value;
        const bookingCards = document.querySelectorAll('.grid > div');
        const today = new Date();
        
        bookingCards.forEach(card => {
            const createdDate = new Date(card.querySelector('.text-gray-900').textContent);
            let show = true;
            
            if (selectedDate === 'today') {
                show = createdDate.toDateString() === today.toDateString();
            } else if (selectedDate === 'week') {
                const weekAgo = new Date(today.getTime() - 7 * 24 * 60 * 60 * 1000);
                show = createdDate >= weekAgo;
            } else if (selectedDate === 'month') {
                const monthAgo = new Date(today.getTime() - 30 * 24 * 60 * 60 * 1000);
                show = createdDate >= monthAgo;
            }
            
            card.style.display = show ? 'block' : 'none';
        });
    });
</script>
@endsection 