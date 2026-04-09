@extends('layouts.sidebar_layout')

@section('title', 'Promotion Payment')

@section('page_title', 'Complete Promotion Payment')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <div class="bg-gradient-to-r from-green-500 to-teal-600 p-6">
            <h2 class="text-2xl font-bold text-white">Payment Details</h2>
            <p class="text-green-100">Complete your promotion purchase payment</p>
        </div>

        <div class="p-6">
            <div class="space-y-4 mb-6">
                <div class="flex justify-between">
                    <span class="text-gray-600">Purchase Code</span>
                    <span class="font-mono font-semibold text-green-600">#{{ $purchase->code_purchase }}</span>
                </div>

                <div class="flex justify-between">
                    <span class="text-gray-600">Promotion Name</span>
                    <span class="font-semibold text-gray-800">{{ $purchase->promotion_name }}</span>
                </div>

                <div class="flex justify-between">
                    <span class="text-gray-600">Customer</span>
                    <span class="font-semibold text-gray-800">{{ $purchase->name }}</span>
                </div>

                <div class="border-t pt-4">
                    <div class="flex justify-between items-center">
                        <span class="text-lg font-bold text-gray-800">Total Payment</span>
                        <span class="text-2xl font-bold text-green-600">Rp {{ number_format($purchase->payment, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            <form action="{{ route('promotion.payment.confirm') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <input type="hidden" name="purchase_id" value="{{ $purchase->id }}">

                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-upload mr-2"></i>Upload Transfer Proof
                    </label>
                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-green-500 transition-colors">
                        <input type="file" name="photo_transfer" accept="image/*" class="hidden" id="photo_transfer">
                        <label for="photo_transfer" class="cursor-pointer">
                            <i class="fas fa-cloud-upload-alt text-gray-400 text-4xl mb-2"></i>
                            <p class="text-sm text-gray-600">Click to upload or drag and drop</p>
                            <p class="text-xs text-gray-400 mt-1">PNG, JPG, GIF up to 10MB</p>
                        </label>
                    </div>
                    @error('photo_transfer')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit"
                        class="w-full bg-green-600 text-white py-4 rounded-lg font-semibold hover:bg-green-700 transition-colors duration-200">
                    <i class="fas fa-check mr-2"></i>Confirm Payment
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
