@extends('layouts.sidebar_layout')

@section('title', 'Promotions')

@section('page_title', 'Available Promotions')

@section('content')
<div class="mb-6">
    <div class="bg-gradient-to-r from-green-500 to-teal-600 rounded-2xl p-8 text-white shadow-lg">
        <h2 class="text-3xl font-bold mb-2">Special Promotions</h2>
        <p class="text-green-100">Grab amazing deals and discounts for your bookings</p>
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
    @forelse($promotions as $promotion)
    <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition-shadow duration-300">
        <div class="h-48 bg-gradient-to-br from-green-400 to-teal-500 flex items-center justify-center">
            <i class="fas fa-tags text-white text-6xl opacity-50"></i>
        </div>

        <div class="p-6">
            <div class="flex items-center justify-between mb-2">
                <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-semibold">
                    <i class="fas fa-percent mr-1"></i>Promotion
                </span>
                <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-semibold">
                    Active
                </span>
            </div>

            <h3 class="text-xl font-bold text-gray-800 mb-2">{{ $promotion->name }}</h3>
            <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ Str::limit($promotion->description, 100) }}</p>

            <div class="space-y-2 mb-4">
                @if($promotion->start_date)
                <div class="flex items-center text-sm text-gray-600">
                    <i class="fas fa-calendar-alt w-5 text-green-500"></i>
                    <span>Valid from: {{ \Carbon\Carbon::parse($promotion->start_date)->format('d M Y') }}</span>
                </div>
                @endif

                @if($promotion->end_date)
                <div class="flex items-center text-sm text-gray-600">
                    <i class="fas fa-calendar-check w-5 text-green-500"></i>
                    <span>Until: {{ \Carbon\Carbon::parse($promotion->end_date)->format('d M Y') }}</span>
                </div>
                @endif
            </div>

            <a href="{{ route('promotion.purchase', $promotion->id) }}"
               class="block w-full bg-green-600 text-white text-center py-3 rounded-lg font-semibold hover:bg-green-700 transition-colors duration-200">
                <i class="fas fa-shopping-cart mr-2"></i>Purchase Now
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
                        No promotions available at the moment. Check back later!
                    </p>
                </div>
            </div>
        </div>
    </div>
    @endforelse
</div>
@endsection
