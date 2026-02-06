@extends('layouts.sidebar_layout')

@section('title', 'Active Reservations')
@section('page_title', 'My Current Bookings')

@section('content')
<div class="space-y-6">
    <!-- Feedback Alerts -->
    @if(session('notify'))
    <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-xl shadow-sm animate-fade-in-down">
         <div class="flex items-center">
            <i class="fas fa-check-circle text-green-500 mr-3"></i>
            <p class="text-green-700 font-medium">{{ session('notify') }}</p>
        </div>
    </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
        @if($reservations->count() > 0)
            @foreach ($reservations as $rsv)
            <div class="bg-white rounded-[2.5rem] shadow-sm border border-gray-100 overflow-hidden hover:shadow-xl transition-all duration-300 flex flex-col">
                <div class="p-8 flex-1">
                    <div class="flex items-center justify-between mb-6">
                        <span class="text-[10px] font-black bg-indigo-50 text-indigo-600 px-3 py-1 rounded-full tracking-normal">#{{ $rsv->code_reservation }}</span>
                        <div class="flex items-center space-x-1">
                            <div class="w-2 h-2 rounded-full bg-amber-400 animate-pulse"></div>
                            <span class="text-[10px] font-black text-amber-600 uppercase tracking-widest">Awaiting Payment</span>
                        </div>
                    </div>

                    <h3 class="text-xl font-black text-gray-800 tracking-tighter mb-4">{{ $rsv->name }}</h3>

                    <div class="space-y-3">
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-gray-400 font-bold uppercase tracking-widest text-[10px]">Room Number</span>
                            <span class="text-gray-800 font-black">#{{ $rsv->number_room }}</span>
                        </div>
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-gray-400 font-bold uppercase tracking-widest text-[10px]">Stay Period</span>
                            <span class="text-gray-800 font-bold">{{ \Carbon\Carbon::parse($rsv->time_booking)->format('d M Y') }}</span>
                        </div>
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-gray-400 font-bold uppercase tracking-widest text-[10px]">Duration</span>
                            <span class="text-gray-800 font-black">{{ $rsv->time_spend }} Nights</span>
                        </div>
                        <div class="pt-4 border-t border-gray-50 flex items-center justify-between">
                            <span class="text-xs font-black text-gray-400 uppercase tracking-[0.2em]">Total Bill</span>
                            <span class="text-xl font-black text-indigo-600 tracking-tighter">Rp {{ number_format($rsv->payment, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

                <div class="p-4 bg-gray-50 border-t border-gray-100">
                    <a href="/userdashboard/{{$rsv->code_reservation}}" class="block w-full py-4 bg-indigo-600 text-white text-center font-black rounded-2xl text-[10px] uppercase tracking-[0.2em] hover:bg-indigo-700 hover:shadow-lg hover:shadow-indigo-100 transition-all">
                        Complete Payment Now
                    </a>
                </div>
            </div>
            @endforeach
        @else
            <div class="col-span-full py-20 bg-white rounded-[3rem] border border-gray-100 border-dashed flex flex-col items-center justify-center space-y-4">
                <div class="w-20 h-20 bg-gray-50 text-gray-200 rounded-full flex items-center justify-center text-4xl">
                    <i class="fas fa-calendar-alt"></i>
                </div>
                <div class="text-center">
                    <p class="text-gray-800 font-black tracking-tighter text-lg">No Active Reservations</p>
                    <p class="text-gray-400 text-sm max-w-xs mt-1">You don't have any pending bookings. Ready to plan your next stay?</p>
                </div>
                <a href="{{('/roomsdashboard')}}" class="px-8 py-3 bg-indigo-600 text-white rounded-xl text-xs font-black uppercase tracking-widest hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-100">
                    Browse Rooms
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
