@extends('layouts.sidebar_layout')

@section('title', 'Book Event')

@section('page_title', 'Book an Event')

@section('content')
<div class="max-w-4xl mx-auto" x-data="{
    price: {{ $event->price ?? 0 }},
    promotionDiscount: 0,
    get total() {
        return this.price - this.promotionDiscount;
    },
    formatPrice(val) {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0
        }).format(val);
    }
}">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Event Information -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow-md p-8">
                <div class="mb-6">
                    <span class="px-3 py-1 bg-indigo-100 text-indigo-700 rounded-full text-xs font-semibold">
                        <i class="fas fa-star mr-1"></i>Event
                    </span>
                </div>

                <h2 class="text-3xl font-bold text-gray-800 mb-4">{{ $event->name }}</h2>

                <div class="prose text-gray-600 mb-6">
                    <p>{{ $event->description }}</p>
                </div>

                <div class="space-y-3 mb-6">
                    @if($event->start_date)
                    <div class="flex items-center">
                        <div class="w-32 flex items-center text-gray-600">
                            <i class="fas fa-play-circle w-5 text-indigo-500 mr-2"></i>
                            <span class="font-semibold">Start Date</span>
                        </div>
                        <span class="text-gray-800">{{ \Carbon\Carbon::parse($event->start_date)->format('d M Y - H:i') }}</span>
                    </div>
                    @endif

                    @if($event->end_date)
                    <div class="flex items-center">
                        <div class="w-32 flex items-center text-gray-600">
                            <i class="fas fa-stop-circle w-5 text-indigo-500 mr-2"></i>
                            <span class="font-semibold">End Date</span>
                        </div>
                        <span class="text-gray-800">{{ \Carbon\Carbon::parse($event->end_date)->format('d M Y - H:i') }}</span>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Booking Form -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-xl shadow-md p-6 sticky top-6">
                <h3 class="text-xl font-bold text-gray-800 mb-6">Complete Your Booking</h3>

                <form action="{{ route('event.book.submit') }}" method="POST">
                    @csrf

                    <input type="hidden" name="event_id" value="{{ $event->id }}">
                    <input type="hidden" name="payment" value="{{ $event->price ?? 0 }}">

                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Booking Code</label>
                            <input type="text"
                                   name="code_booking"
                                   value="EVT-{{ $set_value }}-{{ $random_string }}"
                                   readonly
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-gray-50 text-gray-600 font-mono">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Your Name</label>
                            <input type="text"
                                   value="{{ auth()->user()->name }}"
                                   readonly
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-gray-50 text-gray-600">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Event Price</label>
                            <div class="text-2xl font-bold text-indigo-600" x-text="formatPrice(price)"></div>
                        </div>

                        @if($promotions->count() > 0)
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Apply Promotion</label>
                            <select class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                    @change="promotionDiscount = $event.target.value ? parseFloat($event.target.value) : 0">
                                <option value="">Select a promotion</option>
                                @foreach($promotions as $promo)
                                <option value="{{ $promo->price ?? 0 }}">{{ $promo->name }} - Rp {{ number_format($promo->price ?? 0, 0, ',', '.') }}</option>
                                @endforeach
                            </select>
                        </div>
                        @endif

                        <div class="border-t pt-4">
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-gray-600">Subtotal</span>
                                <span class="font-semibold" x-text="formatPrice(price)"></span>
                            </div>

                            @if($promotions->count() > 0)
                            <div class="flex justify-between items-center mb-2" x-show="promotionDiscount > 0">
                                <span class="text-gray-600">Discount</span>
                                <span class="font-semibold text-green-600" x-text="'-' + formatPrice(promotionDiscount)"></span>
                            </div>
                            @endif

                            <div class="flex justify-between items-center text-lg">
                                <span class="font-bold text-gray-800">Total</span>
                                <span class="font-bold text-indigo-600" x-text="formatPrice(total)"></span>
                            </div>
                        </div>

                        <button type="submit"
                                class="w-full bg-indigo-600 text-white py-3 rounded-lg font-semibold hover:bg-indigo-700 transition-colors duration-200">
                            <i class="fas fa-check mr-2"></i>Confirm Booking
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
