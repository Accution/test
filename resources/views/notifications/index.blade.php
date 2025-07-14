@extends('layouts.app')

@section('title', 'Notifications')

@section('content')
<div class="max-w-4xl mx-auto space-y-8">
    <!-- Header -->
    <div class="bg-white rounded-xl shadow-lg p-8 border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Notifications</h1>
                <p class="text-gray-600 text-lg">Stay updated with your latest alerts</p>
            </div>
            <div class="hidden md:block">
                <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-bell text-blue-600 text-2xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-100">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-bell text-purple-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Notifications</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $notifications->count() }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-100">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-eye text-blue-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Unread</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $notifications->where('read_at', null)->count() }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-100">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-check text-green-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Read</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $notifications->where('read_at', '!=', null)->count() }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="flex justify-between items-center">
        <div class="flex space-x-3">
            <button onclick="markAllAsRead()" 
                    class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 shadow-md">
                <i class="fas fa-check-double mr-2"></i>
                Mark All as Read
            </button>
            
            <button onclick="clearAll()" 
                    class="inline-flex items-center px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-all duration-200 shadow-md">
                <i class="fas fa-trash mr-2"></i>
                Clear All
            </button>
        </div>
        
        <div class="text-sm text-gray-500">
            <i class="fas fa-info-circle mr-1"></i>
            {{ $notifications->count() }} notification{{ $notifications->count() !== 1 ? 's' : '' }}
        </div>
    </div>

    <!-- Notifications List -->
    @if($notifications->count() > 0)
        <div class="space-y-4">
            @foreach($notifications as $notification)
                <div class="bg-white rounded-xl shadow-lg border border-gray-100 hover:shadow-xl transition-all duration-300 
                    @if(!$notification->read_at) border-l-4 border-blue-500 bg-blue-50 @endif">
                    <div class="p-6">
                        <div class="flex items-start justify-between">
                            <div class="flex items-start space-x-4 flex-1">
                                <!-- Notification Icon -->
                                <div class="flex-shrink-0">
                                    <div class="w-12 h-12 rounded-full flex items-center justify-center
                                        @if($notification->data['type'] === 'booking_created') bg-green-100
                                        @elseif($notification->data['type'] === 'booking_confirmed') bg-blue-100
                                        @elseif($notification->data['type'] === 'booking_cancelled') bg-red-100
                                        @else bg-purple-100 @endif">
                                        <i class="fas 
                                            @if($notification->data['type'] === 'booking_created') fa-calendar-plus text-green-600
                                            @elseif($notification->data['type'] === 'booking_confirmed') fa-check text-blue-600
                                            @elseif($notification->data['type'] === 'booking_cancelled') fa-times text-red-600
                                            @else fa-bell text-purple-600 @endif text-lg"></i>
                                    </div>
                                </div>
                                
                                <!-- Notification Content -->
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center space-x-2 mb-2">
                                        <h3 class="text-lg font-semibold text-gray-900">
                                            {{ $notification->data['title'] }}
                                        </h3>
                                        @if(!$notification->read_at)
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                <i class="fas fa-circle mr-1 text-xs"></i>
                                                New
                                            </span>
                                        @endif
                                    </div>
                                    
                                    <p class="text-gray-600 mb-3">{{ $notification->data['message'] }}</p>
                                    
                                    <div class="flex items-center space-x-4 text-sm text-gray-500">
                                        <span class="flex items-center">
                                            <i class="fas fa-clock mr-1"></i>
                                            {{ $notification->created_at->diffForHumans() }}
                                        </span>
                                        
                                        @if(isset($notification->data['booking_id']))
                                            <span class="flex items-center">
                                                <i class="fas fa-hashtag mr-1"></i>
                                                Booking #{{ $notification->data['booking_id'] }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Action Buttons -->
                            <div class="flex items-center space-x-2 ml-4">
                                @if(!$notification->read_at)
                                    <button onclick="markAsRead({{ $notification->id }})" 
                                            class="p-2 text-blue-600 hover:bg-blue-100 rounded-lg transition-colors duration-200"
                                            title="Mark as read">
                                        <i class="fas fa-check"></i>
                                    </button>
                                @endif
                                
                                <button onclick="deleteNotification({{ $notification->id }})" 
                                        class="p-2 text-red-600 hover:bg-red-100 rounded-lg transition-colors duration-200"
                                        title="Delete notification">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        <!-- Pagination -->
        @if($notifications->hasPages())
            <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-4">
                {{ $notifications->links() }}
            </div>
        @endif
    @else
        <!-- Empty State -->
        <div class="bg-white rounded-xl shadow-lg p-12 text-center border border-gray-100">
            <div class="mx-auto h-24 w-24 bg-gray-100 rounded-full flex items-center justify-center mb-6">
                <i class="fas fa-bell-slash text-gray-400 text-3xl"></i>
            </div>
            <h3 class="text-xl font-semibold text-gray-900 mb-2">No notifications yet</h3>
            <p class="text-gray-600 mb-8 max-w-md mx-auto">You're all caught up! New notifications will appear here when they arrive.</p>
            <div class="flex justify-center space-x-4">
                <a href="{{ route('dashboard') }}" 
                   class="inline-flex items-center px-6 py-3 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 shadow-lg">
                    <i class="fas fa-home mr-2"></i>
                    Go to Dashboard
                </a>
                <a href="{{ route('bookings.create') }}" 
                   class="inline-flex items-center px-6 py-3 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all duration-200 shadow-lg">
                    <i class="fas fa-plus mr-2"></i>
                    Create Booking
                </a>
            </div>
        </div>
    @endif
</div>

<script>
    function markAsRead(notificationId) {
        fetch(`/notifications/${notificationId}/mark-as-read`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
            },
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            }
        });
    }

    function markAllAsRead() {
        if (confirm('Mark all notifications as read?')) {
            fetch('/notifications/mark-all-as-read', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                },
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                }
            });
        }
    }

    function deleteNotification(notificationId) {
        if (confirm('Delete this notification?')) {
            fetch(`/notifications/${notificationId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                },
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                }
            });
        }
    }

    function clearAll() {
        if (confirm('Clear all notifications? This action cannot be undone.')) {
            fetch('/notifications/clear-all', {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                },
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                }
            });
        }
    }
</script>
@endsection 