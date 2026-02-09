@extends('layouts.sidebar_layout')

@section('title', 'Your History')
@section('page_title', 'Transaction History')

@section('content')
<div class="space-y-8">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <h2 class="text-2xl font-black text-gray-800 tracking-tight">My History Order</h2>
            <p class="text-gray-500 text-sm mt-1">Review your past and current room reservations.</p>
        </div>
    </div>

    @if(session('notify'))
    <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-xl shadow-sm animate-fade-in-down">
        <div class="flex items-center">
            <i class="fas fa-check-circle text-green-500 mr-3"></i>
            <p class="text-green-700 font-medium">{{ session('notify') }}</p>
        </div>
    </div>
    @endif

    <div class="bg-white rounded-[2rem] border border-gray-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-100">
                        <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-gray-400">Code</th>
                        <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-gray-400">Room</th>
                        <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-gray-400">Booking Date</th>
                        <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-gray-400">Total Payment</th>
                        <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-gray-400">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse ($reservations as $rsv)
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-6 py-4">
                            <span class="text-sm font-bold text-gray-800">#{{ $rsv->code_reservation }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-indigo-50 flex items-center justify-center text-indigo-600">
                                    <i class="fas fa-bed"></i>
                                </div>
                                <span class="text-sm font-bold text-gray-700">Room {{ $rsv->number_room }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">
                            {{ \Carbon\Carbon::parse($rsv->time_booking)->format('d M Y') }}
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-sm font-black text-indigo-600">Rp {{ number_format($rsv->payment, 0, ',', '.') }}</span>
                        </td>
                        <td class="px-6 py-4">
                            @if($rsv->status_payment == 'paid')
                                <span class="px-3 py-1.5 rounded-xl text-[10px] font-black uppercase tracking-widest bg-green-100 text-green-700">
                                    Paid
                                </span>
                            @else
                                <span class="px-3 py-1.5 rounded-xl text-[10px] font-black uppercase tracking-widest bg-amber-100 text-amber-700">
                                    Unpaid
                                </span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-20 text-center">
                            <div class="w-16 h-16 bg-gray-50 rounded-2xl flex items-center justify-center text-gray-300 mx-auto mb-4">
                                <i class="fas fa-history text-2xl"></i>
                            </div>
                            <h3 class="text-lg font-bold text-gray-800">No history found</h3>
                            <p class="text-gray-500 text-sm">You haven't made any reservations yet.</p>
                            <a href="{{ route('rooms') }}" class="inline-flex items-center gap-2 mt-6 px-6 py-3 bg-indigo-600 text-white font-bold rounded-2xl hover:bg-indigo-700 transition-all text-[10px] uppercase tracking-widest">
                                <i class="fas fa-plus"></i>
                                Book Now
                            </a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

