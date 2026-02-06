@extends('layouts.sidebar_layout')

@section('title', 'Booking Room')
@section('page_title', 'Secure Booking')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
    <!-- Room Summary Card -->
    <div class="lg:col-span-4 space-y-6">
        <div class="bg-white rounded-[2.5rem] shadow-sm border border-gray-100 overflow-hidden sticky top-8">
            <div class="relative h-64">
                <img src="@if($room->image_room)/images/{{$room->image_room}}@else/images/default.jpeg@endif" 
                     class="w-full h-full object-cover" 
                     alt="Room #{{ $room->number_room }}">
                <div class="absolute inset-0 bg-gradient-to-t from-gray-900/60 to-transparent"></div>
                <div class="absolute bottom-6 left-6 text-white">
                    <p class="text-[10px] font-black uppercase tracking-[0.2em] opacity-80 mb-1">Reservation for</p>
                    <h3 class="text-2xl font-black tracking-tighter">Room #{{ $room->number_room }}</h3>
                </div>
            </div>
            
            <div class="p-8 space-y-6">
                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-gray-50 p-4 rounded-2xl border border-gray-100/50">
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Capacity</p>
                        <p class="text-sm font-black text-gray-800">{{ $room->capacity }} Persons</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-2xl border border-gray-100/50">
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Room Class</p>
                        <p class="text-sm font-black text-indigo-600 uppercase">{{ $room->class }}</p>
                    </div>
                </div>

                <div class="space-y-4">
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest pl-1">Included Facilities</p>
                    <div class="flex flex-wrap gap-2">
                        @foreach(explode(',', $room->facility) as $feat)
                        <span class="px-3 py-1.5 bg-indigo-50 text-indigo-700 rounded-xl text-xs font-bold border border-indigo-100/50">
                            {{ trim($feat) }}
                        </span>
                        @endforeach
                    </div>
                </div>

                <div class="pt-6 border-t border-gray-50">
                    <div class="flex items-center justify-between">
                        <p class="text-sm font-bold text-gray-500">Base Price</p>
                        <p class="text-xl font-black text-gray-800 tracking-tighter">Rp {{ number_format($room->price, 0, ',', '.') }}</p>
                    </div>
                    <p class="text-[10px] text-gray-400 italic mt-1 text-right">*Price charged per stay period calculated later.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Booking Form Card -->
    <div class="lg:col-span-8">
        <div class="bg-white rounded-[2.5rem] shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-10 py-8 border-b border-gray-50 flex items-center justify-between">
                <div>
                    <h3 class="text-2xl font-black text-gray-800 tracking-tighter">Booking Parameters</h3>
                    <p class="text-sm text-gray-400 mt-1">Please provide accurate details for your reservation.</p>
                </div>
                <div class="w-12 h-12 bg-indigo-600 text-white rounded-2xl flex items-center justify-center text-xl shadow-lg shadow-indigo-100">
                    <i class="fas fa-file-signature"></i>
                </div>
            </div>

            <form action="/bookingrooms" method="POST" class="p-10 space-y-8">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Read-only metadata -->
                    <div class="space-y-2">
                        <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest pl-1">Reservation Reference</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-indigo-500">
                                <i class="fas fa-hashtag"></i>
                            </span>
                            <input type="text" name="code_reservation" value="{{$set_value}}" readonly class="w-full pl-10 pr-5 py-4 bg-gray-50 border border-gray-100 rounded-[1.25rem] text-sm font-bold text-gray-800 outline-none cursor-not-allowed">
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest pl-1">Validated Guest Identity</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-indigo-500">
                                <i class="fas fa-user-shield"></i>
                            </span>
                            <input type="text" value="{{auth()->user()->name}}" readonly class="w-full pl-10 pr-5 py-4 bg-gray-50 border border-gray-100 rounded-[1.25rem] text-sm font-bold text-gray-800 outline-none cursor-not-allowed">
                            <input type="hidden" name="id_user" value="{{auth()->user()->id_user}}">
                            <input type="hidden" name="name" value="{{auth()->user()->name}}">
                            <input type="hidden" name="number_room" value="{{$room->number_room}}">
                        </div>
                    </div>

                    <!-- Input fields -->
                    <div class="space-y-2">
                        <label class="text-[10px] font-bold text-indigo-600 uppercase tracking-widest pl-1">Target Check-in Date</label>
                        <div class="relative group">
                            <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-400 group-focus-within:text-indigo-500 transition-colors">
                                <i class="fas fa-calendar-day"></i>
                            </span>
                            <input type="date" name="time_booking" id="time_booking" required class="w-full pl-10 pr-5 py-4 bg-white border border-gray-200 rounded-[1.25rem] text-sm font-bold text-gray-800 outline-none focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all shadow-sm">
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-bold text-indigo-600 uppercase tracking-widest pl-1">Duration of Stay (Nights)</label>
                        <div class="relative group">
                            <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-400 group-focus-within:text-indigo-500 transition-colors">
                                <i class="fas fa-clock"></i>
                            </span>
                            <input type="number" name="time_spend" id="time_spend" onkeyup="countpayment()" min="1" required placeholder="e.g. 3" class="w-full pl-10 pr-5 py-4 bg-white border border-gray-200 rounded-[1.25rem] text-sm font-bold text-gray-800 outline-none focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all shadow-sm">
                        </div>
                    </div>

                    <div class="md:col-span-2 pt-6 border-t border-gray-50">
                        <div class="bg-indigo-900 rounded-[2rem] p-8 text-white relative overflow-hidden">
                            <!-- Abstract decoration -->
                            <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-indigo-800/50 rounded-full blur-2xl"></div>
                            
                            <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                                <div>
                                    <p class="text-[10px] font-black uppercase tracking-[0.2em] text-indigo-300 mb-1">Estimated Grand Total</p>
                                    <div class="flex items-baseline">
                                        <span class="text-xl font-bold text-indigo-200 mr-2">Rp</span>
                                        <input type="text" id="display_payment" value="0" readonly class="bg-transparent text-4xl font-black tracking-tighter outline-none w-full">
                                        <input type="hidden" id="price" value="{{$room->price}}">
                                        <input type="hidden" name="payment" id="payment_val">
                                    </div>
                                </div>
                                
                                <div class="flex items-center gap-4">
                                    <a href="/roomsdashboard" class="px-6 py-4 bg-white/10 text-white font-bold rounded-2xl hover:bg-white/20 transition-all text-xs uppercase tracking-widest">
                                        Cancel
                                    </a>
                                    <button type="submit" class="px-10 py-4 bg-white text-indigo-900 font-black rounded-2xl hover:bg-indigo-50 transition-all shadow-xl shadow-indigo-950/20 text-xs uppercase tracking-[0.2em]">
                                        Confirm Booking
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
function countpayment(){
    var price = parseInt(document.getElementById("price").value) || 0;
    var stay = parseInt(document.getElementById("time_spend").value) || 0;
    
    var total = price * stay;
    
    document.getElementById("display_payment").value = total.toLocaleString('id-ID');
    document.getElementById("payment_val").value = total;
}
</script>
@endsection
