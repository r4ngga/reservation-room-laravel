@extends('layouts.sidebar_layout')

@section('title', 'Dashboard')
@section('page_title', 'My Reservation Dashboard')

@section('content')
<div class="space-y-8">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Free Rooms -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <div class="w-12 h-12 bg-green-100 text-green-600 rounded-xl flex items-center justify-center text-xl">
                    <i class="fas fa-door-open"></i>
                </div>
                <div>
                    <h3 class="text-2xl font-bold text-gray-800">{{ $roomsCount }}</h3>
                    <p class="text-sm text-gray-500">Available Rooms</p>
                </div>
            </div>
            <a href="{{ route('rooms') }}" class="w-10 h-10 bg-gray-50 text-gray-400 rounded-full flex items-center justify-center hover:bg-green-600 hover:text-white transition-all">
                <i class="fas fa-plus"></i>
            </a>
        </div>

        <!-- My Reservations -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <div class="w-12 h-12 bg-indigo-100 text-indigo-600 rounded-xl flex items-center justify-center text-xl">
                    <i class="fas fa-book-bookmark"></i>
                </div>
                <div>
                    <h3 class="text-2xl font-bold text-gray-800">{{ $reservationsCount }}</h3>
                    <p class="text-sm text-gray-500">My Reservations</p>
                </div>
            </div>
            <div class="w-10 h-10 bg-gray-50 text-gray-400 rounded-full flex items-center justify-center">
                <i class="fas fa-list"></i>
            </div>
        </div>

        <!-- Unpaid -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <div class="w-12 h-12 bg-amber-100 text-amber-600 rounded-xl flex items-center justify-center text-xl">
                    <i class="fas fa-receipt"></i>
                </div>
                <div>
                    <h3 class="text-2xl font-bold text-gray-800">{{ $unpaidCount }}</h3>
                    <p class="text-sm text-gray-500">Unpaid Bills</p>
                </div>
            </div>
            <div class="w-10 h-10 bg-gray-50 text-gray-400 rounded-full flex items-center justify-center">
                <i class="fas fa-clock"></i>
            </div>
        </div>
    </div>

    <!-- Quick Actions / Information -->
    <div class="bg-indigo-700 p-10 rounded-[2rem] text-white overflow-hidden relative shadow-xl">
        <div class="relative z-10 md:w-2/3">
            <h2 class="text-3xl font-bold mb-4">Welcome back, {{ auth()->user()->name }}!</h2>
            <p class="text-indigo-100 mb-6 text-lg">Need a place to stay? Browse our exclusively curated rooms and book your next stay in seconds.</p>
            <a href="{{ route('rooms') }}" class="inline-flex items-center px-6 py-3 bg-white text-indigo-700 font-bold rounded-xl hover:bg-indigo-50 transition-all shadow-lg">
                Explore Rooms <i class="fas fa-arrow-right ml-2 lg:ml-2"></i>
            </a>
        </div>
        
        <!-- Abstract Decoration -->
        <div class="absolute -right-20 -bottom-20 w-80 h-80 bg-indigo-600 rounded-full opacity-50"></div>
        <div class="absolute -right-10 -top-10 w-40 h-40 bg-indigo-500 rounded-full opacity-30"></div>
    </div>
</div>
@endsection
