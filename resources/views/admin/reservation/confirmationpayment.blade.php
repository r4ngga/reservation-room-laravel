@extends('layouts.sidebar_layout')

@section('title', 'Confirmation Reservation')
@section('page_title', 'Payment Verification')

@section('content')
<div class="space-y-6">
    <!-- Header Summary -->
    <div class="bg-white p-8 rounded-[2rem] border border-gray-100 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <h2 class="text-2xl font-black text-gray-800 tracking-tighter">Confirmation Payment Guest</h2>
            <p class="text-sm text-gray-400 mt-1">Verify and approve incoming reservation payments.</p>
        </div>
        <div class="flex items-center space-x-2">
            <span class="px-4 py-2 bg-indigo-50 text-indigo-700 rounded-xl text-xs font-black uppercase tracking-widest border border-indigo-100">
                Pending: {{ $reservations->where('status_payment', 0)->count() }}
            </span>
            <span class="px-4 py-2 bg-green-50 text-green-700 rounded-xl text-xs font-black uppercase tracking-widest border border-green-100">
                Verified: {{ $reservations->where('status_payment', '!=', 0)->count() }}
            </span>
        </div>
    </div>

    <!-- Feedback Alerts -->
    @if(session('notify'))
    <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-xl shadow-sm animate-fade-in-down">
         <div class="flex items-center">
            <i class="fas fa-check-circle text-green-500 mr-3"></i>
            <p class="text-green-700 font-medium">{{ session('notify') }}</p>
        </div>
    </div>
    @endif

    <!-- Reservations Table -->
    <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-100">
                        <th class="px-8 py-5 text-xs font-bold text-gray-400 uppercase tracking-widest">Ref. Code</th>
                        <th class="px-8 py-5 text-xs font-bold text-gray-400 uppercase tracking-widest">Room</th>
                        <th class="px-8 py-5 text-xs font-bold text-gray-400 uppercase tracking-widest">Guest Detail</th>
                        <th class="px-8 py-5 text-xs font-bold text-gray-400 uppercase tracking-widest text-right">Total Amount</th>
                        <th class="px-8 py-5 text-xs font-bold text-gray-400 uppercase tracking-widest text-center">Status</th>
                        <th class="px-8 py-5 text-xs font-bold text-gray-400 uppercase tracking-widest text-center">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50 tracking-tighter">
                    @foreach ($reservations as $rsv)
                    <tr class="hover:bg-gray-50/50 transition-colors group">
                        <td class="px-8 py-5">
                            <span class="text-[10px] font-black bg-gray-100 text-gray-500 px-2 py-0.5 rounded tracking-normal">#{{ $rsv->code_reservation }}</span>
                        </td>
                        <td class="px-8 py-5">
                            <div class="flex flex-col">
                                <span class="text-gray-800 font-black">Room {{ $rsv->number_room }}</span>
                                <span class="text-[10px] text-indigo-500 font-bold uppercase tracking-widest">{{ $rsv->class }}</span>
                            </div>
                        </td>
                        <td class="px-8 py-5">
                            <div class="flex flex-col">
                                <span class="text-gray-800 font-bold">{{ $rsv->name }}</span>
                                <span class="text-[10px] text-gray-400 font-medium">{{ \Carbon\Carbon::parse($rsv->time_booking)->format('d M Y') }}</span>
                            </div>
                        </td>
                        <td class="px-8 py-5 text-right font-mono text-gray-800 font-bold">
                            Rp {{ number_format($rsv->payment, 0, ',', '.') }}
                        </td>
                        <td class="px-8 py-5 text-center">
                            @if($rsv->status_payment == 0 || $rsv->status_payment == "0")
                            <span class="px-3 py-1 bg-amber-100 text-amber-700 rounded-full text-[10px] font-black uppercase tracking-widest">Awaiting Verification</span>
                            @else
                            <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-[10px] font-black uppercase tracking-widest">Approved</span>
                            @endif
                        </td>
                        <td class="px-8 py-5">
                            <div class="flex items-center justify-center space-x-2">
                                @if($rsv->status_payment == 0 || $rsv->status_payment == "0")
                                <button onclick="showConfirmation({{ $rsv->number_reservation }}, '{{ $rsv->code_reservation }}', {{ $rsv->number_room }}, '{{ $rsv->status_payment }}')" 
                                        data-toggle="modal" data-target="#ShowConfirmation" 
                                        class="px-4 py-2 bg-indigo-600 text-white rounded-xl text-xs font-bold hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-100 uppercase tracking-widest">
                                    Approve
                                </button>
                                <button data-toggle="modal" data-target="#ShowImgCheck" 
                                        class="p-2 text-gray-400 bg-gray-50 rounded-xl hover:bg-gray-200 transition-all">
                                    <i class="fas fa-image"></i>
                                </button>
                                @else
                                <div class="w-8 h-8 rounded-full bg-green-50 text-green-500 flex items-center justify-center">
                                    <i class="fas fa-check-circle"></i>
                                </div>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Approval -->
<div class="modal fade" id="ShowConfirmation" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content overflow-hidden border-none shadow-2xl rounded-[2rem]">
            <div class="p-10 text-center">
                <div class="w-20 h-20 bg-indigo-100 text-indigo-600 rounded-full flex items-center justify-center text-3xl mx-auto mb-6 transition-transform hover:scale-110">
                    <i class="fas fa-file-invoice-dollar"></i>
                </div>
                <h3 class="text-2xl font-black text-gray-800 mb-2 tracking-tighter">Approve Payment?</h3>
                <p class="text-gray-500 mb-8 px-6 text-sm">Has this guest settled their bill or provided valid proof of transfer? This will mark the reservation as <span class="text-indigo-600 font-bold">Confirmed</span>.</p>
                
                <form action="/confirmpaymentroom" method="POST" class="flex flex-col sm:flex-row gap-3">
                    @csrf
                    <input type="hidden" name="number_reservation" id="number_reservation">
                    <input type="hidden" name="code_reservation" id="code_reservation">
                    <input type="hidden" name="number_room" id="number_room">
                    <input type="hidden" name="status_payment" id="status_payment">
                    
                    <button type="button" data-dismiss="modal" class="w-full py-3.5 bg-gray-50 text-gray-500 font-bold rounded-2xl hover:bg-gray-100 transition-all uppercase tracking-widest text-[10px]">Review Later</button>
                    <button type="submit" class="w-full py-3.5 bg-indigo-600 text-white font-black rounded-2xl hover:bg-indigo-700 transition-all shadow-xl shadow-indigo-100 uppercase tracking-widest text-[10px]">Approve Now</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Image Modal -->
<div class="modal fade" id="ShowImgCheck" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content overflow-hidden border-none shadow-2xl rounded-[2rem] bg-gray-900">
            <div class="p-6 flex items-center justify-between text-white border-b border-white/10">
                <h5 class="text-sm font-black uppercase tracking-widest">Transfer Proof Verification</h5>
                <button type="button" class="text-white/50 hover:text-white transition-colors" data-dismiss="modal">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="p-4 flex items-center justify-center bg-gray-950 min-h-[300px]">
                <img src="" alt="Proof of Payment" id="imgcheck" class="max-w-full h-auto rounded-lg shadow-2xl border border-white/5">
            </div>
            <div class="p-6 bg-gray-900 text-center">
                <p class="text-[10px] text-gray-400 italic">Please cross-reference this proof with your internal banking records.</p>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script type="text/javascript">
  function showConfirmation(number_reservation, code_reservation, number_room, status_payment) {
    document.getElementById('number_reservation').value = number_reservation;
    document.getElementById('code_reservation').value = code_reservation;
    document.getElementById('number_room').value = number_room;
    document.getElementById('status_payment').value = status_payment;
  }
</script>
@endsection
