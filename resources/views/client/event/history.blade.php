@extends('layouts.sidebar_layout')

@section('title', 'Event History')

@section('page_title', 'My Event Bookings')

@section('content')
<div class="mb-6">
    <div class="bg-gradient-to-r from-indigo-500 to-purple-600 rounded-2xl p-8 text-white shadow-lg">
        <h2 class="text-3xl font-bold mb-2">Event Booking History</h2>
        <p class="text-indigo-100">Track all your event bookings and payments</p>
    </div>
</div>

<div class="bg-white rounded-xl shadow-md overflow-hidden">
    <div class="p-6 border-b border-gray-200">
        <h3 class="text-lg font-semibold text-gray-800">All Event Bookings</h3>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Booking Code</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Event Name</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Date</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Payment</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($bookings as $booking)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="font-mono text-sm text-indigo-600 font-semibold">#{{ $booking->code_booking }}</span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm font-semibold text-gray-900">{{ $booking->event_name }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-600">
                            {{ \Carbon\Carbon::parse($booking->created_at)->format('d M Y') }}
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-semibold text-gray-900">
                            Rp {{ number_format($booking->payment, 0, ',', '.') }}
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($booking->status_payment == 'paid')
                        <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-semibold">
                            <i class="fas fa-check-circle mr-1"></i>Paid
                        </span>
                        @else
                        <span class="px-3 py-1 bg-amber-100 text-amber-700 rounded-full text-xs font-semibold">
                            <i class="fas fa-clock mr-1"></i>Unpaid
                        </span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center">
                        <div class="flex flex-col items-center">
                            <i class="fas fa-calendar-times text-gray-300 text-5xl mb-4"></i>
                            <p class="text-gray-500 font-semibold">No event bookings found</p>
                            <p class="text-gray-400 text-sm mt-1">Start by booking your first event!</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
