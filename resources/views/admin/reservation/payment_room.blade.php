@extends('layouts.sidebar_layout')

@section('title', 'Payment Processing')
@section('page_title', 'Settlement & Verification')

@section('content')
<div class="max-w-4xl mx-auto py-8">
    <div class="bg-white rounded-[3rem] shadow-sm border border-gray-100 overflow-hidden">
        <!-- Billing Header -->
        <div class="bg-indigo-600 p-12 text-white relative overflow-hidden text-center">
            <div class="relative z-10">
                <p class="text-[10px] font-black uppercase tracking-[0.3em] opacity-80 mb-2">Billing Settlement</p>
                <h2 class="text-4xl font-black tracking-tighter mb-4">Your Final Bill</h2>
                <div class="inline-flex items-baseline bg-white/10 backdrop-blur-md px-8 py-4 rounded-[2rem] border border-white/20">
                    <span class="text-xl font-bold mr-2 text-indigo-200">Rp</span>
                    <span class="text-5xl font-black tracking-tighter">{{ number_format($reservation->payment, 0, ',', '.') }}</span>
                </div>
            </div>
            <!-- Decorative blur -->
            <div class="absolute -right-20 -bottom-20 w-80 h-80 bg-indigo-500 rounded-full opacity-30 blur-3xl"></div>
            <div class="absolute -left-10 -top-10 w-40 h-40 bg-indigo-400 rounded-full opacity-20 blur-2xl"></div>
        </div>

        <!-- Form Body -->
        <div class="p-12">
            <div class="flex flex-col md:flex-row gap-12">
                <!-- Left: Instructions -->
                <div class="flex-1 space-y-8">
                    <div>
                        <h4 class="text-lg font-black text-gray-800 tracking-tight mb-2">Instructions</h4>
                        <p class="text-sm text-gray-500 leading-relaxed">To complete your reservation, please upload a clear digital copy of your bank transfer receipt or invoice. Our concierge will verify the transaction within 24 hours.</p>
                    </div>

                    <div class="space-y-4">
                        <div class="flex items-center space-x-4">
                            <div class="w-10 h-10 bg-indigo-50 text-indigo-600 rounded-2xl flex items-center justify-center font-black">1</div>
                            <p class="text-xs font-bold text-gray-600 uppercase tracking-widest leading-tight">Transfer total amount exactly</p>
                        </div>
                        <div class="flex items-center space-x-4">
                            <div class="w-10 h-10 bg-indigo-50 text-indigo-600 rounded-2xl flex items-center justify-center font-black">2</div>
                            <p class="text-xs font-bold text-gray-600 uppercase tracking-widest leading-tight">Capture transfer confirmation</p>
                        </div>
                        <div class="flex items-center space-x-4">
                            <div class="w-10 h-10 bg-indigo-50 text-indigo-600 rounded-2xl flex items-center justify-center font-black">3</div>
                            <p class="text-xs font-bold text-gray-600 uppercase tracking-widest leading-tight">Upload and submit below</p>
                        </div>
                    </div>
                </div>

                <!-- Right: Form -->
                <div class="flex-1">
                    <form action="/paymentroom" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        <div class="space-y-2">
                            <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest pl-2">Evidence of Payment</label>
                            <div class="relative group">
                                <label for="photo_transfer" class="w-full h-40 bg-gray-50 border-2 border-dashed border-gray-200 rounded-[2rem] flex flex-col items-center justify-center cursor-pointer hover:bg-gray-100 hover:border-indigo-300 transition-all group">
                                    <i class="fas fa-cloud-upload-alt text-3xl text-gray-300 group-hover:text-indigo-400 mb-3 transition-colors"></i>
                                    <span class="text-xs font-bold text-gray-400 uppercase tracking-widest group-hover:text-indigo-500">Pick File</span>
                                    <input type="file" id="photo_transfer" name="photo_transfer" class="hidden" onchange="updateFileName(this)">
                                </label>
                                <p id="file-name-display" class="text-[10px] text-indigo-600 font-bold mt-2 text-center"></p>
                            </div>
                        </div>

                        <!-- Hidden metadata -->
                        <input type="hidden" name="number_reservation" value="{{$reservation->number_reservation}}">
                        <input type="hidden" name="number_room" value="{{$reservation->room_id}}">
                        <input type="hidden" name="payment" value="{{$reservation->payment}}">
                        <input type="hidden" name="status_payment" value="paid off">

                        <button type="submit" class="w-full py-5 bg-indigo-600 text-white font-black rounded-2xl hover:bg-indigo-700 transition-all shadow-xl shadow-indigo-100 uppercase tracking-[0.2em] text-[10px]">
                            Submit for Verification
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function updateFileName(input) {
    const display = document.getElementById('file-name-display');
    if (input.files && input.files[0]) {
        display.innerText = 'Selected: ' + input.files[0].name;
    } else {
        display.innerText = '';
    }
}
</script>
@endsection
