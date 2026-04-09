@extends('layouts.sidebar_layout')

@section('title', 'Unpaid Event Bookings')

@section('page_title', 'Pending Event Payments')

@section('content')
<div class="mb-6">
    <div class="bg-gradient-to-r from-amber-400 to-orange-500 rounded-2xl p-8 text-white shadow-lg">
        <h2 class="text-3xl font-bold mb-2">Pending Payments</h2>
        <p class="text-amber-100">Complete your event booking payments to secure your spot</p>
    </div>
</div>

<div class="bg-white rounded-xl shadow-md overflow-hidden">
    <div class="p-6 border-b border-gray-200">
        <h3 class="text-lg font-semibold text-gray-800">Unpaid Event Bookings</h3>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Booking Code</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Event Name</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Date</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Payment</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Action</th>
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
                        <a href="{{ route('event.payment', $booking->id) }}"
                           class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-lg text-sm font-semibold hover:bg-indigo-700 transition-colors">
                            <i class="fas fa-credit-card mr-2"></i>Pay Now
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center">
                        <div class="flex flex-col items-center">
                            <i class="fas fa-check-circle text-green-300 text-5xl mb-4"></i>
                            <p class="text-gray-500 font-semibold">No pending payments</p>
                            <p class="text-gray-400 text-sm mt-1">All your event bookings are paid!</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
