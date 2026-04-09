@extends('layouts.sidebar_layout')

@section('title', 'Payment Room')
@section('page_title', 'Room Payment')

@section('content')
<div class="space-y-8">
    <div class="bg-gradient-to-r from-indigo-500 to-purple-600 rounded-2xl p-8 text-white shadow-lg">
        <h2 class="text-3xl font-bold mb-2">Complete Your Payment</h2>
        <p class="text-indigo-100">Upload your bank transfer proof to confirm the booking</p>
    </div>

    @if(session('notify'))
    <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-xl shadow-sm">
        <div class="flex items-center">
            <i class="fas fa-check-circle text-green-500 mr-3"></i>
            <p class="text-green-700 font-medium">{{ session('notify') }}</p>
        </div>
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Bill Summary -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-2xl shadow-md overflow-hidden">
                <div class="bg-gray-50 px-6 py-4 border-b border-gray-100">
                    <h3 class="text-lg font-bold text-gray-800">Bill Summary</h3>
                </div>
                <div class="p-6 space-y-4">
                    @foreach($reservation as $rsv)
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-500">Reservation Code</span>
                        <span class="text-sm font-bold text-gray-800">#{{ $rsv->code_reservation ?? $rsv->code }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-500">Room Number</span>
                        <span class="text-sm font-bold text-gray-800">{{ $rsv->number_room }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-500">Room Class</span>
                        <span class="text-sm font-bold text-gray-800">{{ $rsv->class_room }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-500">Duration</span>
                        <span class="text-sm font-bold text-gray-800">{{ $rsv->time_spend }} Hour(s)</span>
                    </div>
                    <hr class="border-gray-100">
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-500">Status</span>
                        <span class="px-3 py-1 rounded-xl text-[10px] font-black uppercase tracking-widest bg-amber-100 text-amber-700">
                            {{ $rsv->status_payment }}
                        </span>
                    </div>
                    <div class="bg-indigo-50 rounded-xl p-4 mt-4">
                        <p class="text-xs text-indigo-500 font-semibold uppercase tracking-widest mb-1">Total Payment</p>
                        <p class="text-2xl font-black text-indigo-600">Rp {{ number_format($rsv->payment, 0, ',', '.') }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Payment Form -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl shadow-md overflow-hidden">
                <div class="bg-gray-50 px-6 py-4 border-b border-gray-100">
                    <h3 class="text-lg font-bold text-gray-800">Upload Transfer Proof</h3>
                </div>
                <div class="p-6">
                    <form action="{{ route('paymentroom') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="space-y-6">
                            <!-- Transfer Proof Upload -->
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">
                                    Bank Transfer Invoice
                                    <span class="text-red-500">*</span>
                                </label>
                                <div class="border-2 border-dashed border-gray-300 rounded-xl p-8 text-center hover:border-indigo-400 transition-colors cursor-pointer" onclick="document.getElementById('photo_transfer').click()">
                                    <div id="upload-preview">
                                        <i class="fas fa-cloud-upload-alt text-4xl text-gray-300 mb-3"></i>
                                        <p class="text-sm text-gray-500">Click to upload or drag your transfer proof</p>
                                        <p class="text-xs text-gray-400 mt-1">Supported: JPEG, PNG, JPG, GIF, SVG</p>
                                    </div>
                                    <input type="file" id="photo_transfer" name="photo_transfer" class="hidden"
                                           accept="image/*"
                                           onchange="document.getElementById('upload-preview').innerHTML = '<i class=\'fas fa-check-circle text-4xl text-green-400 mb-3\'></i><p class=\'text-sm text-green-600 font-semibold\'>' + this.files[0].name + '</p>'">
                                </div>
                                @error('photo_transfer')
                                <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Hidden Fields -->
                            @foreach($reservation as $rsv)
                            <input type="hidden" name="number_reservation" value="{{ $rsv->number_reservation }}">
                            <input type="hidden" name="number_room" value="{{ $rsv->number_room }}">
                            <input type="hidden" name="payment" value="{{ $rsv->payment }}">
                            <input type="hidden" name="status_payment" value="paid">
                            @endforeach

                            <!-- Submit -->
                            <div class="flex justify-end">
                                <button type="submit" class="inline-flex items-center px-8 py-3 bg-indigo-600 text-white font-bold rounded-xl hover:bg-indigo-700 transition-colors shadow-lg shadow-indigo-200">
                                    <i class="fas fa-paper-plane mr-2"></i>
                                    Submit Payment
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
