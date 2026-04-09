@extends('layouts.sidebar_layout')

@section('title', 'Unpaid Reservations')

@section('page_title', 'Pending Room Payments')

@section('content')
<div class="space-y-8">
    <div class="bg-gradient-to-r from-amber-400 to-orange-500 rounded-2xl p-8 text-white shadow-lg">
        <h2 class="text-3xl font-bold mb-2">Pending Payments</h2>
        <p class="text-amber-100">Complete your room reservation payments to confirm your booking</p>
    </div>

    @if(session('notify'))
    <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-xl shadow-sm">
        <div class="flex items-center">
            <i class="fas fa-check-circle text-green-500 mr-3"></i>
            <p class="text-green-700 font-medium">{{ session('notify') }}</p>
        </div>
    </div>
    @endif

    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <div class="p-6 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-800">Unpaid Room Reservations</h3>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-gray-400">Reservation Code</th>
                        <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-gray-400">Guest Name</th>
                        <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-gray-400">Room</th>
                        <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-gray-400">Booking Date</th>
                        <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-gray-400">Duration</th>
                        <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-gray-400">Payment</th>
                        <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-gray-400">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse ($reservations as $rsv)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="font-mono text-sm text-indigo-600 font-semibold">#{{ $rsv->code_reservation }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm font-semibold text-gray-900">{{ $rsv->name }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-indigo-50 flex items-center justify-center text-indigo-600">
                                    <i class="fas fa-bed"></i>
                                </div>
                                <span class="text-sm font-bold text-gray-700">{{ $rsv->number_room }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-600">
                                {{ \Carbon\Carbon::parse($rsv->time_booking)->format('d M Y') }}
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="text-sm text-gray-600">{{ $rsv->time_spend }} Hour(s)</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="text-sm font-black text-indigo-600">Rp {{ number_format($rsv->payment, 0, ',', '.') }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <a href="{{ route('paidreservation', $rsv->id) }}"
                               class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-xl text-sm font-semibold hover:bg-indigo-700 transition-colors">
                                <i class="fas fa-credit-card mr-2"></i>Pay Now
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-20 text-center">
                            <div class="flex flex-col items-center">
                                <div class="w-16 h-16 bg-green-50 rounded-2xl flex items-center justify-center text-green-300 mx-auto mb-4">
                                    <i class="fas fa-check-circle text-2xl"></i>
                                </div>
                                <p class="text-gray-800 font-bold">No pending payments</p>
                                <p class="text-gray-500 text-sm mt-1">All your room reservations are paid!</p>
                                <a href="{{ route('rooms') }}" class="inline-flex items-center gap-2 mt-4 px-6 py-3 bg-indigo-600 text-white font-bold rounded-2xl hover:bg-indigo-700 transition-all text-[10px] uppercase tracking-widest">
                                    <i class="fas fa-plus"></i>
                                    Book a Room
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
