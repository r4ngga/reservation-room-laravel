@extends('layouts.sidebar_layout')

@section('title', 'Event Payment')

@section('page_title', 'Complete Event Payment')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <div class="bg-gradient-to-r from-indigo-500 to-purple-600 p-6">
            <h2 class="text-2xl font-bold text-white">Payment Details</h2>
            <p class="text-indigo-100">Complete your event booking payment</p>
        </div>

        <div class="p-6">
            <div class="space-y-4 mb-6">
                <div class="flex justify-between">
                    <span class="text-gray-600">Booking Code</span>
                    <span class="font-mono font-semibold text-indigo-600">#{{ $booking->code_booking }}</span>
                </div>

                <div class="flex justify-between">
                    <span class="text-gray-600">Event Name</span>
                    <span class="font-semibold text-gray-800">{{ $booking->event_name }}</span>
                </div>

                <div class="flex justify-between">
                    <span class="text-gray-600">Customer</span>
                    <span class="font-semibold text-gray-800">{{ $booking->name }}</span>
                </div>

                <div class="border-t pt-4">
                    <div class="flex justify-between items-center">
                        <span class="text-lg font-bold text-gray-800">Total Payment</span>
                        <span class="text-2xl font-bold text-indigo-600">Rp {{ number_format($booking->payment, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            <form action="{{ route('event.payment.confirm') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <input type="hidden" name="booking_id" value="{{ $booking->id }}">

                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-upload mr-2"></i>Upload Transfer Proof
                    </label>
                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-indigo-500 transition-colors">
                        <input type="file" name="photo_transfer" accept="image/*" class="hidden" id="photo_transfer">
                        <label for="photo_transfer" class="cursor-pointer">
                            <i class="fas fa-cloud-upload-alt text-gray-400 text-4xl mb-2"></i>
                            <p class="text-sm text-gray-600">Click to upload or drag and drop</p>
                            <p class="text-xs text-gray-400 mt-1">PNG, JPG, GIF up to 10MB</p>
                        </label>
                    </div>
                    @error('photo_transfer')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit"
                        class="w-full bg-indigo-600 text-white py-4 rounded-lg font-semibold hover:bg-indigo-700 transition-colors duration-200">
                    <i class="fas fa-check mr-2"></i>Confirm Payment
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
