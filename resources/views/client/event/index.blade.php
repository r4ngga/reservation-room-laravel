@extends('layouts.sidebar_layout')

@section('title', 'Events')

@section('page_title', 'Available Events')

@section('content')
<div class="mb-6">
    <div class="bg-gradient-to-r from-indigo-500 to-purple-600 rounded-2xl p-8 text-white shadow-lg">
        <h2 class="text-3xl font-bold mb-2">Discover Amazing Events</h2>
        <p class="text-indigo-100">Book exclusive events and create memorable experiences</p>
    </div>
</div>

@if(session('notify'))
<div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded">
    <div class="flex">
        <div class="flex-shrink-0">
            <i class="fas fa-check-circle text-green-500"></i>
        </div>
        <div class="ml-3">
            <p class="text-sm text-green-700">{{ session('notify') }}</p>
        </div>
    </div>
</div>
@endif

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @forelse($events as $event)
    <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition-shadow duration-300">
        <div class="h-48 bg-gradient-to-br from-indigo-400 to-purple-500 flex items-center justify-center">
            <i class="fas fa-calendar-star text-white text-6xl opacity-50"></i>
        </div>

        <div class="p-6">
            <div class="flex items-center justify-between mb-2">
                <span class="px-3 py-1 bg-indigo-100 text-indigo-700 rounded-full text-xs font-semibold">
                    <i class="fas fa-star mr-1"></i>Event
                </span>
                <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-semibold">
                    Available
                </span>
            </div>

            <h3 class="text-xl font-bold text-gray-800 mb-2">{{ $event->name }}</h3>
            <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ Str::limit($event->description, 100) }}</p>

            <div class="space-y-2 mb-4">
                @if($event->start_date)
                <div class="flex items-center text-sm text-gray-600">
                    <i class="fas fa-play-circle w-5 text-indigo-500"></i>
                    <span>Start: {{ \Carbon\Carbon::parse($event->start_date)->format('d M Y') }}</span>
                </div>
                @endif

                @if($event->end_date)
                <div class="flex items-center text-sm text-gray-600">
                    <i class="fas fa-stop-circle w-5 text-indigo-500"></i>
                    <span>End: {{ \Carbon\Carbon::parse($event->end_date)->format('d M Y') }}</span>
                </div>
                @endif
            </div>

            <a href="{{ route('event.booking', $event->id) }}"
               class="block w-full bg-indigo-600 text-white text-center py-3 rounded-lg font-semibold hover:bg-indigo-700 transition-colors duration-200">
                <i class="fas fa-ticket-alt mr-2"></i>Book Now
            </a>
        </div>
    </div>
    @empty
    <div class="col-span-full">
        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="fas fa-exclamation-triangle text-yellow-400"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-yellow-700">
                        No events available at the moment. Check back later!
                    </p>
                </div>
            </div>
        </div>
    </div>
    @endforelse
</div>
@endsection
