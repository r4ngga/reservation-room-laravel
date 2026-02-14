@extends('layouts.sidebar_layout')

@section('title', 'Select Room')
@section('page_title', 'Browse & Reserve')

@section('content')
<div class="space-y-8">
    <!-- Search & Filter Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 bg-white p-6 rounded-[2rem] shadow-sm border border-gray-100">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Select Room</h2>
            <p class="text-sm text-gray-500 mt-1">Planning a stay? Find the perfect room for your holiday.</p>
        </div>
        
        <form action="/roomsdashboard" method="POST" class="flex items-center gap-3">
            @csrf
            <div class="relative">
                <select name="search" class="pl-4 pr-10 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none transition-all appearance-none cursor-pointer text-sm font-semibold text-gray-600">
                    <option selected>Filter by...</option>
                    <option value="cost_low_to_high">Price: Low to High</option>
                    <option value="cost_high_to_low">Price: High to Low</option>
                    <option value="free">Status: Available Only</option>
                </select>
                <i class="fas fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none text-xs"></i>
            </div>
            <button type="submit" class="p-2.5 bg-indigo-600 text-white rounded-xl hover:bg-indigo-700 transition-all shadow-md shadow-indigo-100">
                <i class="fas fa-search px-1"></i>
            </button>
        </form>
    </div>

    @if(session('notify'))
    <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-xl shadow-sm animate-fade-in-down">
         <div class="flex items-center">
            <i class="fas fa-check-circle text-green-500 mr-3"></i>
            <p class="text-green-700 font-medium">{{ session('notify') }}</p>
        </div>
    </div>
    @endif

    @if(isset($information))
    <div class="bg-indigo-50 border-l-4 border-indigo-500 p-4 rounded-xl text-indigo-700 text-sm font-medium">
        {{ $information }}
    </div>
    @endif

    <!-- Rooms Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
        @php $status_labels = ['Free', 'Full', 'Booked']; @endphp
        @php $status_colors = ['bg-green-100 text-green-700', 'bg-red-100 text-red-700', 'bg-amber-100 text-amber-700']; @endphp
        @php $class_labels = ['', 'VIP', 'Premium', 'Regular']; @endphp
        @php $class_colors = ['', 'text-indigo-600', 'text-amber-600', 'text-gray-600']; @endphp

        @foreach ($rooms as $rm)
        <div class="group bg-white rounded-[2.5rem] shadow-sm border border-gray-100 overflow-hidden hover:shadow-2xl hover:-translate-y-2 transition-all duration-300">
            <!-- Room Image Container -->
            <div class="relative h-56 overflow-hidden">
                <img src="@if($rm->image_room)/images/{{$rm->image_room}}@else/images/default.jpeg@endif" 
                     class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" 
                     alt="Room #{{ $rm->number_room }}">
                
                <div class="absolute top-4 left-4">
                    <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest shadow-lg {{ $status_colors[$rm->status] ?? 'bg-white text-gray-800' }}">
                        {{ $status_labels[$rm->status] }}
                    </span>
                </div>
                
                <div class="absolute bottom-4 right-4 bg-white/90 backdrop-blur-sm px-4 py-2 rounded-2xl shadow-lg border border-white">
                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-tighter text-right leading-none">Price / Night</p>
                    <p class="text-lg font-black text-indigo-700 tracking-tighter leading-none mt-1">Rp {{ number_format($rm->price, 0, ',', '.') }}</p>
                </div>
            </div>

            <!-- Content Area -->
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <h4 class="text-xl font-black text-gray-800 tracking-tighter">Room #{{ $rm->number_room }}</h4>
                    <span class="text-xs font-bold uppercase tracking-widest {{ $class_colors[$rm->class] ?? '' }}">{{ $class_labels[$rm->class] ?? '' }}</span>
                </div>
                
                <div class="space-y-3 mb-6">
                    <div class="flex items-center text-sm text-gray-500">
                        <div class="w-8 h-8 rounded-lg bg-gray-50 text-gray-400 flex items-center justify-center mr-3 text-xs">
                            <i class="fas fa-users"></i>
                        </div>
                        <span class="font-medium">Capacity: {{ $rm->capacity }} Persons</span>
                    </div>
                    <div class="flex items-start text-sm text-gray-500">
                        <div class="w-8 h-8 rounded-lg bg-gray-50 text-gray-400 flex items-center justify-center mr-3 text-xs mt-0.5">
                            <i class="fas fa-sparkles"></i>
                        </div>
                        <span class="font-medium flex-1">{{ Str::limit($rm->facility ?? 'No facilities specified', 60) }}</span>
                    </div>
                </div>

                @if($rm->status == 1 || $rm->status == 2)
                <button class="w-full py-4 bg-gray-100 text-gray-400 font-black rounded-2xl text-[10px] uppercase tracking-[0.2em] cursor-not-allowed border border-gray-100" disabled>
                    Unavailable
                </button>
                @else
                <a href="/bookingrooms/{{$rm->number_room}}" class="block w-full py-4 bg-indigo-600 text-white text-center font-black rounded-2xl text-[10px] uppercase tracking-[0.2em] hover:bg-indigo-700 hover:shadow-xl hover:shadow-indigo-100 transition-all">
                    Book This Room
                </a>
                @endif
            </div>
        </div>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="mt-12">
        {{ $rooms->links('vendor.pagination.numbered_pagination') }}
    </div>
</div>
@endsection
