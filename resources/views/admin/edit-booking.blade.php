@extends('layouts.app')

@section('title', 'Edit Booking')

@section('content')
<div class="max-w-2xl mx-auto py-8">
    <h1 class="text-2xl font-bold mb-6">Edit Booking</h1>
    <form method="POST" action="{{ route('admin.bookings.update', $booking) }}">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Title</label>
            <input type="text" name="title" value="{{ old('title', $booking->title) }}" class="w-full border rounded px-3 py-2" required>
        </div>
        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Description</label>
            <textarea name="description" class="w-full border rounded px-3 py-2">{{ old('description', $booking->description) }}</textarea>
        </div>
        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Check-in Date</label>
            <input type="date" name="check_in_date" value="{{ old('check_in_date', $booking->check_in_date->format('Y-m-d')) }}" class="w-full border rounded px-3 py-2" required>
        </div>
        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Check-in Time</label>
            <input type="time" name="check_in_time" value="{{ old('check_in_time', $booking->check_in_time) }}" class="w-full border rounded px-3 py-2" required>
        </div>
        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Check-out Date</label>
            <input type="date" name="check_out_date" value="{{ old('check_out_date', $booking->check_out_date->format('Y-m-d')) }}" class="w-full border rounded px-3 py-2" required>
        </div>
        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Check-out Time</label>
            <input type="time" name="check_out_time" value="{{ old('check_out_time', $booking->check_out_time) }}" class="w-full border rounded px-3 py-2" required>
        </div>
        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Status</label>
            <select name="status" class="w-full border rounded px-3 py-2" required>
                <option value="pending" @if(old('status', $booking->status) == 'pending') selected @endif>Pending</option>
                <option value="confirmed" @if(old('status', $booking->status) == 'confirmed') selected @endif>Confirmed</option>
                <option value="cancelled" @if(old('status', $booking->status) == 'cancelled') selected @endif>Cancelled</option>
            </select>
        </div>
        <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded">Update Booking</button>
        <a href="{{ route('admin.bookings.show', $booking) }}" class="ml-4 text-gray-600">Cancel</a>
    </form>
</div>
@endsection 