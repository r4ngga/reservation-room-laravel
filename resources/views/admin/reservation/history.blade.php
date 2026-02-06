@extends('layouts.sidebar_layout')

@section('title', 'Reservation History')
@section('page_title', 'My Billing Archives')

@section('content')
<div class="space-y-6">
    <!-- Header Hero -->
    <div class="bg-indigo-700 p-10 rounded-[2.5rem] text-white relative overflow-hidden shadow-xl">
        <div class="relative z-10">
            <h2 class="text-3xl font-black tracking-tighter mb-2">My History Order</h2>
            <p class="text-indigo-100 text-sm max-w-md">Track all your past transactions and stay periods in one centralized archive.</p>
        </div>
        <!-- Decorative elements -->
        <div class="absolute -right-10 -bottom-10 w-48 h-48 bg-indigo-600 rounded-full opacity-50 blur-2xl"></div>
        <div class="absolute right-10 top-10 w-24 h-24 bg-indigo-500 rounded-full opacity-30 blur-xl"></div>
    </div>

    @if(session('notify'))
    <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-xl shadow-sm animate-fade-in-down">
         <div class="flex items-center">
            <i class="fas fa-check-circle text-green-500 mr-3"></i>
            <p class="text-green-700 font-medium">{{ session('notify') }}</p>
        </div>
    </div>
    @endif

    <!-- History Table -->
    <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 overflow-hidden">
        @if($reservations->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-100">
                        <th class="px-8 py-5 text-xs font-bold text-gray-400 uppercase tracking-widest text-center">Reference</th>
                        <th class="px-8 py-5 text-xs font-bold text-gray-400 uppercase tracking-widest">Stay Period</th>
                        <th class="px-8 py-5 text-xs font-bold text-gray-400 uppercase tracking-widest text-center">Room No.</th>
                        <th class="px-8 py-5 text-xs font-bold text-gray-400 uppercase tracking-widest text-right">Settled Amount</th>
                        <th class="px-8 py-5 text-xs font-bold text-gray-400 uppercase tracking-widest text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50 tracking-tighter">
                    @foreach ($reservations as $rsv)
                    <tr class="hover:bg-gray-50/50 transition-colors group">
                        <td class="px-8 py-5 text-center">
                            <span class="text-[10px] font-black bg-indigo-50 text-indigo-600 px-3 py-1 rounded-full tracking-normal">#{{ $rsv->code_reservation }}</span>
                        </td>
                        <td class="px-8 py-5">
                            <div class="flex flex-col">
                                <span class="text-gray-800 font-bold">{{ $rsv->name }}</span>
                                <span class="text-xs text-gray-400">{{ \Carbon\Carbon::parse($rsv->time_booking)->format('d F Y') }}</span>
                            </div>
                        </td>
                        <td class="px-8 py-5 text-center">
                            <span class="text-sm font-black text-gray-700">#{{ $rsv->number_room }}</span>
                        </td>
                        <td class="px-8 py-5 text-right font-mono text-gray-800 font-bold">
                            Rp {{ number_format($rsv->payment, 0, ',', '.') }}
                        </td>
                        <td class="px-8 py-5 text-center">
                            @if($rsv->status_payment != '0' && $rsv->status_payment != 'unpaid')
                            <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-[10px] font-black uppercase tracking-widest">Verified Payment</span>
                            @else
                            <span class="px-3 py-1 bg-amber-100 text-amber-700 rounded-full text-[10px] font-black uppercase tracking-widest">Processing</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="py-20 flex flex-col items-center justify-center space-y-4">
            <div class="w-20 h-20 bg-gray-50 text-gray-200 rounded-full flex items-center justify-center text-4xl">
                <i class="fas fa-receipt"></i>
            </div>
            <p class="text-gray-400 font-bold tracking-tighter">No reservations found in your archive.</p>
            <a href="/roomsdashboard" class="px-6 py-2 bg-indigo-600 text-white rounded-xl text-xs font-black uppercase tracking-widest hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-100">
                Start Booking Now
            </a>
        </div>
        @endif
    </div>
</div>
@endsection
