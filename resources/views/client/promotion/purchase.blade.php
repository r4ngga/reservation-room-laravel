@extends('layouts.sidebar_layout')

@section('title', 'Purchase Promotion')

@section('page_title', 'Purchase a Promotion')

@section('content')
<div class="max-w-4xl mx-auto" x-data="{
    price: {{ $promotion->price ?? 0 }},
    formatPrice(val) {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0
        }).format(val);
    }
}">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Promotion Information -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow-md p-8">
                <div class="mb-6">
                    <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-semibold">
                        <i class="fas fa-percent mr-1"></i>Promotion
                    </span>
                </div>

                <h2 class="text-3xl font-bold text-gray-800 mb-4">{{ $promotion->name }}</h2>

                <div class="prose text-gray-600 mb-6">
                    <p>{{ $promotion->description }}</p>
                </div>

                <div class="space-y-3">
                    @if($promotion->start_date)
                    <div class="flex items-center">
                        <div class="w-32 flex items-center text-gray-600">
                            <i class="fas fa-calendar-alt w-5 text-green-500 mr-2"></i>
                            <span class="font-semibold">Valid From</span>
                        </div>
                        <span class="text-gray-800">{{ \Carbon\Carbon::parse($promotion->start_date)->format('d M Y') }}</span>
                    </div>
                    @endif

                    @if($promotion->end_date)
                    <div class="flex items-center">
                        <div class="w-32 flex items-center text-gray-600">
                            <i class="fas fa-calendar-check w-5 text-green-500 mr-2"></i>
                            <span class="font-semibold">Valid Until</span>
                        </div>
                        <span class="text-gray-800">{{ \Carbon\Carbon::parse($promotion->end_date)->format('d M Y') }}</span>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Purchase Form -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-xl shadow-md p-6 sticky top-6">
                <h3 class="text-xl font-bold text-gray-800 mb-6">Complete Your Purchase</h3>

                <form action="{{ route('promotion.purchase.submit') }}" method="POST">
                    @csrf

                    <input type="hidden" name="promotion_id" value="{{ $promotion->id }}">
                    <input type="hidden" name="payment" value="{{ $promotion->price ?? 0 }}">

                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Purchase Code</label>
                            <input type="text"
                                   name="code_purchase"
                                   value="PRM-{{ $set_value }}-{{ $random_string }}"
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
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Promotion Price</label>
                            <div class="text-2xl font-bold text-green-600" x-text="formatPrice(price)"></div>
                        </div>

                        <div class="border-t pt-4">
                            <div class="flex justify-between items-center text-lg">
                                <span class="font-bold text-gray-800">Total</span>
                                <span class="font-bold text-green-600" x-text="formatPrice(price)"></span>
                            </div>
                        </div>

                        <button type="submit"
                                class="w-full bg-green-600 text-white py-3 rounded-lg font-semibold hover:bg-green-700 transition-colors duration-200">
                            <i class="fas fa-shopping-cart mr-2"></i>Purchase Promotion
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
