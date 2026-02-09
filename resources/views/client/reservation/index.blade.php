@extends('layouts.sidebar_layout')

@section('title', 'Select Room')
@section('page_title', 'Available Rooms')

@section('style')
<style>
    [x-cloak] { display: none !important; }
</style>
@endsection

@section('content')
<div x-data="{ search: '' }" class="space-y-8" x-cloak>
    <!-- Header/Filter Section -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <h2 class="text-2xl font-black text-gray-800 tracking-tight">Select Room For Your Holiday</h2>
            <p class="text-gray-500 text-sm mt-1">Find the perfect room that fits your needs.</p>
        </div>

        <div class="flex flex-col sm:flex-row items-center gap-3 w-full md:w-auto">
            <form action="{{ route('rooms') }}" method="GET" class="flex items-center gap-2 w-full sm:w-auto">
                <div class="relative flex-1 sm:w-64">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
                        <i class="fas fa-filter text-xs"></i>
                    </span>
                    <select name="search" class="w-full pl-10 pr-8 py-3 bg-white border border-gray-200 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all shadow-sm appearance-none text-sm font-medium text-gray-700 cursor-pointer">
                        <option value="">All Statuses</option>
                        <option value="cost_low_to_high" {{ request('search') == 'cost_low_to_high' ? 'selected' : '' }}>Price: Low to High</option>
                        <option value="cost_high_to_low" {{ request('search') == 'cost_high_to_low' ? 'selected' : '' }}>Price: High to Low</option>
                        <option value="free" {{ request('search') == 'free' ? 'selected' : '' }}>Status: Free</option>
                    </select>
                    <span class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none">
                        <i class="fas fa-chevron-down text-[10px]"></i>
                    </span>
                </div>
                <button type="submit" class="px-6 py-3 bg-indigo-600 text-white font-bold rounded-2xl hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-100 flex items-center gap-2">
                    <i class="fas fa-search text-xs"></i>
                    <span>Search</span>
                </button>
            </form>
        </div>
    </div>

    @if(session('notify'))
    <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-xl shadow-sm animate-fade-in-down">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <i class="fas fa-check-circle text-green-500 mr-3"></i>
                <p class="text-green-700 font-medium">{{ session('notify') }}</p>
            </div>
            <button type="button" @click="$el.parentElement.remove()" class="text-green-500 hover:text-green-700">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>
    @endif

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @php 
            $statusLabels = [
                0 => ['label' => 'Free', 'class' => 'bg-green-100 text-green-700'],
                1 => ['label' => 'Full', 'class' => 'bg-red-100 text-red-700'],
                2 => ['label' => 'Booked', 'class' => 'bg-amber-100 text-amber-700'],
            ];
        @endphp
        
        @forelse ($rooms as $rm)
            <div class="group bg-white rounded-[2rem] border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 overflow-hidden flex flex-col">
                <!-- Image Container -->
                <div class="relative aspect-[4/3] overflow-hidden bg-gray-100">
                    <img @if ($rm->image_room)
                        src="/images/{{$rm->image_room}}"
                        alt="Room {{$rm->number_room}}"
                    @else
                        src="/images/default.jpeg"
                        alt="Default Room Image"
                    @endif class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                    
                    <div class="absolute top-4 right-4">
                        <span class="px-3 py-1.5 rounded-xl text-[10px] font-black uppercase tracking-widest shadow-sm {{ $statusLabels[$rm->status]['class'] }}">
                            {{ $statusLabels[$rm->status]['label'] }}
                        </span>
                    </div>

                    <div class="absolute bottom-4 left-4">
                        <div class="bg-white/90 backdrop-blur-sm px-4 py-2 rounded-2xl shadow-sm">
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest leading-none">Price per day</p>
                            <p class="text-lg font-black text-indigo-600">Rp {{ number_format($rm->price, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Content -->
                <div class="p-6 flex-1 flex flex-col">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-xl font-bold text-gray-800">Room {{ $rm->number_room }}</h3>
                        <div class="flex items-center text-amber-400 text-xs">
                            <i class="fas fa-star mr-1"></i>
                            <span class="font-bold text-gray-600">New</span>
                        </div>
                    </div>

                    <div class="space-y-3 mb-6 flex-1">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-gray-50 flex items-center justify-center text-gray-400 group-hover:bg-indigo-50 group-hover:text-indigo-500 transition-colors">
                                <i class="fas fa-wifi text-xs"></i>
                            </div>
                            <span class="text-sm text-gray-600">{{ $rm->facility ?? 'Standard Facilities' }}</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-gray-50 flex items-center justify-center text-gray-400 group-hover:bg-indigo-50 group-hover:text-indigo-500 transition-colors">
                                <i class="fas fa-user-friends text-xs"></i>
                            </div>
                            <span class="text-sm text-gray-600">{{ $rm->capacity ?? '2' }} People</span>
                        </div>
                    </div>

                    @if($rm->status == 1 || $rm->status == 2)
                        <button disabled class="w-full py-4 bg-gray-100 text-gray-400 font-bold rounded-2xl cursor-not-allowed uppercase tracking-widest text-[10px] flex items-center justify-center gap-2">
                            <i class="fas fa-lock"></i>
                            Currently Unavailable
                        </button>
                    @else
                        <a href="{{ url('/bookingrooms/'.$rm->number_room) }}" class="w-full py-4 bg-indigo-600 text-white font-bold rounded-2xl hover:bg-indigo-700 hover:shadow-lg hover:shadow-indigo-100 transition-all text-center uppercase tracking-widest text-[10px] flex items-center justify-center gap-2">
                            <i class="fas fa-calendar-alt"></i>
                            Book This Room
                        </a>
                    @endif
                </div>
            </div>
        @empty
            <div class="col-span-full py-20 text-center">
                <div class="w-20 h-20 bg-gray-100 rounded-3xl flex items-center justify-center text-3xl text-gray-400 mx-auto mb-4">
                    <i class="fas fa-search"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-800">No rooms found</h3>
                <p class="text-gray-500">Try adjusting your filters to find what you're looking for.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection
