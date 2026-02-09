@extends('layouts.sidebar_layout')

@section('title', 'Booking Room')
@section('page_title', 'Complete Your Booking')

@section('style')
<style>
    [x-cloak] { display: none !important; }
</style>
@endsection

@section('content')
<div x-data="{ 
    price: {{ $room->price }},
    time_spend: {{ old('time_spend', 1) }},
    promotion_id: '{{ old('promotion_id', '') }}',
    get total() {
        return this.price * (this.time_spend || 0);
    },
    formatPrice(val) {
        return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(val);
    }
}" class="max-w-5xl mx-auto" x-cloak>
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Room Info Card -->
        <div class="lg:col-span-1 space-y-6">
            <div class="bg-white rounded-[2rem] border border-gray-100 shadow-sm overflow-hidden sticky top-8">
                <div class="aspect-[4/3] overflow-hidden">
                    <img @if ($room->image_room)
                        src="/images/{{$room->image_room}}"
                        alt="Room {{$room->number_room}}"
                    @else
                        src="/images/default.jpeg"
                        alt="Default Room Image"
                    @endif class="w-full h-full object-cover">
                </div>
                <div class="p-8">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-xl font-bold text-gray-800">Room {{ $room->number_room }}</h3>
                        <span class="px-3 py-1 bg-indigo-50 text-indigo-600 rounded-xl text-[10px] font-black uppercase tracking-widest">{{ $room->class }}</span>
                    </div>
                    
                    <div class="space-y-4">
                        <div class="flex items-center gap-3 text-sm">
                            <i class="fas fa-layer-group text-gray-400 w-5"></i>
                            <span class="text-gray-600"><span class="font-bold text-gray-800">Facility:</span> {{ $room->facility }}</span>
                        </div>
                        <div class="flex items-center gap-3 text-sm">
                            <i class="fas fa-user-friends text-gray-400 w-5"></i>
                            <span class="text-gray-600"><span class="font-bold text-gray-800">Capacity:</span> {{ $room->capacity }} People</span>
                        </div>
                        <div class="pt-4 border-t border-gray-50 flex items-center justify-between">
                            <span class="text-gray-400 text-xs font-bold uppercase tracking-widest">Rate</span>
                            <span class="text-indigo-600 font-black" x-text="formatPrice(price)"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Booking Form -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-[2rem] border border-gray-100 shadow-sm p-10">
                <div class="flex items-center gap-4 mb-10">
                    <div class="w-12 h-12 bg-indigo-600 text-white rounded-2xl flex items-center justify-center text-xl shadow-lg shadow-indigo-100 italic font-black">R</div>
                    <div>
                        <h4 class="text-xl font-bold text-gray-800 leading-none">Reservation Details</h4>
                        <p class="text-[10px] text-gray-400 mt-1 uppercase tracking-widest font-medium">Please fill in the information below</p>
                    </div>
                </div>

                <form action="/bookingrooms" method="POST" class="space-y-8">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Read-only Info -->
                        <div class="space-y-2">
                            <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest pl-1">Reservation Code</label>
                            <input type="text" name="code_reservation" value="{{$set_value ?? ''}}" readonly class="w-full px-5 py-3 bg-gray-50 border border-gray-100 rounded-2xl text-gray-500 font-mono text-sm outline-none cursor-not-allowed">
                        </div>
                        <div class="space-y-2">
                            <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest pl-1">Room Number</label>
                            <input type="text" name="number_room" value="{{$room->number_room ?? ''}}" readonly class="w-full px-5 py-3 bg-gray-50 border border-gray-100 rounded-2xl text-gray-500 font-bold text-sm outline-none cursor-not-allowed">
                        </div>

                        <!-- Guest Info -->
                        <div class="space-y-2 hidden">
                            <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest pl-1">User ID</label>
                            <input type="text" name="id_user" value="{{auth()->user()->id_user ?? ''}}" readonly class="w-full px-5 py-3 bg-gray-50 border border-gray-100 rounded-2xl text-gray-500 text-sm outline-none">
                        </div>
                        <div class="space-y-2 md:col-span-2">
                            <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest pl-1">Guest Name</label>
                            <div class="relative">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
                                    <i class="fas fa-user text-xs"></i>
                                </span>
                                <input type="text" name="name" value="{{auth()->user()->name ?? ''}}" class="w-full pl-11 pr-5 py-3 bg-white border border-gray-200 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all shadow-sm text-sm font-medium" placeholder="Your Full Name">
                            </div>
                        </div>

                        <!-- Booking Times -->
                        <div class="space-y-2 md:col-span-2">
                            <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest pl-1">Date of Booking</label>
                            <div class="relative">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
                                    <i class="fas fa-calendar-day text-xs"></i>
                                </span>
                                <input type="date" name="time_booking" class="w-full pl-11 pr-5 py-3 bg-white border border-gray-200 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all shadow-sm text-sm font-medium" required>
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest pl-1">Check-in Time</label>
                            <input type="time" name="checkin_time" min="13:00" value="{{ old('checkin_time', '13:00') }}" required class="w-full px-5 py-3 bg-white border border-gray-200 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all shadow-sm text-sm font-medium @error('checkin_time') border-red-500 @enderror">
                            <p class="text-[9px] text-gray-400 ml-1">Min. check-in is 13:00 (1:00 PM)</p>
                            @error('checkin_time')<p class="text-xs text-red-500 mt-1 ml-1">{{ $message }}</p>@enderror
                        </div>
                        <div class="space-y-2">
                            <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest pl-1">Checkout Time</label>
                            <input type="time" name="checkout_time" max="12:00" value="{{ old('checkout_time', '12:00') }}" required class="w-full px-5 py-3 bg-white border border-gray-200 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all shadow-sm text-sm font-medium @error('checkout_time') border-red-500 @enderror">
                            <p class="text-[9px] text-gray-400 ml-1">Max. checkout is 12:00 (12:00 Noon)</p>
                            @error('checkout_time')<p class="text-xs text-red-500 mt-1 ml-1">{{ $message }}</p>@enderror
                        </div>

                        <!-- Duration & Promotion -->
                        <div class="space-y-2">
                            <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest pl-1">Duration (Days)</label>
                            <div class="relative">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
                                    <i class="fas fa-clock text-xs"></i>
                                </span>
                                <input type="number" x-model="time_spend" name="time_spend" min="1" class="w-full pl-11 pr-5 py-3 bg-white border border-gray-200 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all shadow-sm text-sm font-medium" required>
                            </div>
                        </div>
                        <div class="space-y-2">
                            <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest pl-1">Available Promotions</label>
                            <div class="relative">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none">
                                    <i class="fas fa-tag text-xs"></i>
                                </span>
                                <select name="promotion_id" x-model="promotion_id" class="w-full pl-10 pr-8 py-3 bg-white border border-gray-200 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all shadow-sm appearance-none text-sm font-medium text-gray-700 cursor-pointer">
                                    <option value="">No Promotion</option>
                                    @foreach ($promotions as $promotion)
                                        <option value="{{ $promotion->id }}">{{$promotion->name}}</option>
                                    @endforeach
                                </select>
                                <span class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none">
                                    <i class="fas fa-chevron-down text-[10px]"></i>
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Summary -->
                    <div class="bg-gray-50 rounded-3xl p-8 space-y-4">
                        <h5 class="text-xs font-black text-gray-400 uppercase tracking-[0.2em] mb-4">Payment Summary</h5>
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-gray-500">Rate x Duration</span>
                            <span class="text-gray-700 font-bold" x-text="formatPrice(price) + ' x ' + (time_spend || 0)"></span>
                        </div>
                        <div class="pt-4 border-t border-gray-100 flex items-center justify-between">
                            <span class="text-gray-800 font-black">Total Payment</span>
                            <span class="text-2xl font-black text-indigo-600" x-text="formatPrice(total)"></span>
                        </div>
                        <input type="hidden" name="payment" :value="total">
                    </div>

                    <div class="flex flex-col sm:flex-row items-center gap-4 pt-4">
                        <button type="submit" class="w-full sm:flex-1 py-4 bg-indigo-600 text-white font-bold rounded-2xl hover:bg-indigo-700 hover:shadow-xl hover:shadow-indigo-100 transition-all text-center uppercase tracking-widest text-[10px] flex items-center justify-center gap-2">
                            <i class="fas fa-check-circle"></i>
                            Confirm Booking
                        </button>
                        <a href="{{ route('rooms') }}" class="w-full sm:w-auto px-8 py-4 bg-white border border-gray-200 text-gray-600 font-bold rounded-2xl hover:bg-gray-100 transition-all text-center uppercase tracking-widest text-[10px]">
                            Discard
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
