@extends('layouts.app')

@section('title', 'User Details')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">User Details</h1>
            <p class="text-gray-600">View and manage user information</p>
        </div>
        <a href="{{ route('admin.users') }}" 
           class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200">
            <i class="fas fa-arrow-left mr-2"></i> Back to Users
        </a>
    </div>

    <!-- User Profile Card -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="bg-gradient-to-r from-blue-600 to-purple-600 px-6 py-4">
            <div class="flex items-center">
                <div class="w-16 h-16 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                    <span class="text-white text-2xl font-bold">{{ substr($user->name, 0, 1) }}</span>
                </div>
                <div class="ml-4">
                    <h2 class="text-xl font-bold text-white">{{ $user->name }}</h2>
                    <p class="text-blue-100">{{ $user->email }}</p>
                </div>
            </div>
        </div>
        
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="text-center p-4 bg-gray-50 rounded-lg">
                    <div class="text-2xl font-bold text-gray-900">{{ $user->bookings->count() }}</div>
                    <div class="text-sm text-gray-600">Total Bookings</div>
                </div>
                <div class="text-center p-4 bg-gray-50 rounded-lg">
                    <div class="text-2xl font-bold text-gray-900">{{ $user->created_at->format('M d, Y') }}</div>
                    <div class="text-sm text-gray-600">Joined</div>
                </div>
                <div class="text-center p-4 bg-gray-50 rounded-lg">
                    <div class="text-2xl font-bold text-gray-900">{{ $user->updated_at->format('M d, Y') }}</div>
                    <div class="text-sm text-gray-600">Last Updated</div>
                </div>
            </div>
        </div>
    </div>

    <!-- User's Bookings -->
    <div class="bg-white rounded-lg shadow-md">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex justify-between items-center">
                <h2 class="text-lg font-medium text-gray-900">User's Bookings</h2>
                <span class="text-sm text-gray-600">{{ $user->bookings->count() }} booking(s)</span>
            </div>
        </div>
        
        <div class="overflow-hidden">
            @if($user->bookings->count() > 0)
                <div class="divide-y divide-gray-200">
                    @foreach($user->bookings as $booking)
                        <div class="px-6 py-4 hover:bg-gray-50">
                            <div class="flex items-center justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center space-x-4">
                                        <div class="flex-shrink-0">
                                            <div class="w-10 h-10 rounded-full bg-gradient-to-r from-blue-600 to-purple-600 flex items-center justify-center">
                                                <i class="fas fa-calendar text-white text-sm"></i>
                                            </div>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <h3 class="text-sm font-medium text-gray-900">{{ $booking->title }}</h3>
                                            @if($booking->description)
                                                <p class="text-sm text-gray-600 truncate">{{ Str::limit($booking->description, 100) }}</p>
                                            @endif
                                            <div class="flex items-center space-x-4 mt-1">
                                                <span class="text-xs text-gray-500">
                                                    <i class="fas fa-sign-in-alt mr-1"></i>
                                                    {{ $booking->check_in_date->format('M d, Y') }} at {{ $booking->check_in_time }}
                                                </span>
                                                <span class="text-xs text-gray-500">
                                                    <i class="fas fa-sign-out-alt mr-1"></i>
                                                    {{ $booking->check_out_date->format('M d, Y') }} at {{ $booking->check_out_time }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-4">
                                    <span class="px-2 py-1 text-xs font-medium rounded-full 
                                        @if($booking->status === 'confirmed') bg-green-100 text-green-800
                                        @elseif($booking->status === 'pending') bg-yellow-100 text-yellow-800
                                        @else bg-red-100 text-red-800 @endif">
                                        {{ ucfirst($booking->status) }}
                                    </span>
                                    <span class="text-sm text-gray-500">{{ $booking->created_at->diffForHumans() }}</span>
                                    <div class="flex items-center space-x-2">
                                        <button onclick="updateBookingStatus({{ $booking->id }})" 
                                                class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <form method="POST" action="{{ route('admin.bookings.delete', $booking->id) }}" 
                                              class="inline" onsubmit="return confirm('Are you sure you want to delete this booking?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800 text-sm font-medium">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="px-6 py-8 text-center">
                    <div class="mx-auto h-12 w-12 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                        <i class="fas fa-calendar-times text-gray-400 text-xl"></i>
                    </div>
                    <h3 class="text-sm font-medium text-gray-900 mb-2">No bookings yet</h3>
                    <p class="text-sm text-gray-600">This user hasn't created any bookings</p>
                </div>
            @endif
        </div>
    </div>

    <!-- User Actions -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4">User Actions</h3>
        <div class="flex flex-col sm:flex-row gap-3">
            <button onclick="openEditModal()" 
                    class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200">
                <i class="fas fa-edit mr-2"></i> Edit User
            </button>
            
            <form method="POST" action="{{ route('admin.users.delete', $user->id) }}" class="inline"
                  onsubmit="return confirm('Are you sure you want to delete this user? This will also delete all their bookings.')">
                @csrf
                @method('DELETE')
                <button type="submit" 
                        class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-all duration-200">
                    <i class="fas fa-trash mr-2"></i> Delete User
                </button>
            </form>
        </div>
    </div>
</div>

<!-- Edit User Modal -->
<div id="editUserModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Edit User</h3>
            <form method="POST" action="{{ route('admin.users.update', $user->id) }}">
                @csrf
                @method('PUT')
                
                <div class="mb-4">
                    <label for="edit_name" class="block text-sm font-medium text-gray-700 mb-2">Name</label>
                    <input type="text" id="edit_name" name="name" required 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                           value="{{ $user->name }}">
                </div>
                
                <div class="mb-6">
                    <label for="edit_email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                    <input type="email" id="edit_email" name="email" required 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                           value="{{ $user->email }}">
                </div>
                
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeEditModal()" 
                            class="px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200">
                        Cancel
                    </button>
                    <button type="submit" 
                            class="px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200">
                        Update User
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function openEditModal() {
        document.getElementById('editUserModal').classList.remove('hidden');
    }
    
    function closeEditModal() {
        document.getElementById('editUserModal').classList.add('hidden');
    }
    
    function updateBookingStatus(bookingId) {
        const status = prompt('Enter new status (pending/confirmed/cancelled):');
        if (status && ['pending', 'confirmed', 'cancelled'].includes(status.toLowerCase())) {
            fetch(`/admin/bookings/${bookingId}/status`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ status: status.toLowerCase() })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert('Error updating booking status');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error updating booking status');
            });
        }
    }
    
    // Close modal when clicking outside
    document.getElementById('editUserModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeEditModal();
        }
    });
</script>
@endsection 