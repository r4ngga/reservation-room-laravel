@extends('template/main_dashboard')

@section('title','Payment Room')
@section('container')
<div class="container mt-4 mb-4">
    <div class="row">
        <div class="col">
            <h2>Your Bill</h2>
            <div class="card">
                <div class="card-body">
                    <p>
                        Price Payment : {{$reservation->payment}} <br>
                        Status Payment: {{$reservation->status_payment}} <br>
                        Are you sure pay for this transaction ?
                        <br>
                    </p>
                    {{-- <form action="/paymentroom" method="POST" enctype="multipart/form-data"> --}}
                    <form action="{{ route('paymentroom')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="numberreservation">Upload Your Invoice Transaction Bank</label> <span style="color: red;"> *</span>
                            <input type="file"  id="photo_transfer" name="photo_transfer" >
                        </div>
                        <div class="form-group" hidden>
                            <label for="numberreservation">Number Reservation</label>
                            <input type="text" class="form-control" id="number_reservation" name="number_reservation" value="{{$reservation->number_reservation}}">
                        </div>
                        <div class="form-group" hidden>
                            <label for="statuspayment">Room Number</label>
                            <input type="text" class="form-control" id="number_room" name="number_room" value="{{$reservation->room_id}}">
                        </div>
                        <div class="form-group" hidden>
                            <label for="spayment">Price Payment</label>
                            <input type="text" class="form-control" id="payment" name="payment" value="{{$reservation->payment}}">
                        </div>
                        <div class="form-group" hidden>
                            <label for="statuspayment">Status Payment</label>
                            <input type="text" class="form-control" id="status_payment" name="status_payment" value="">
                        </div>
                        <div class="form-group">
                            <button class="btn btn-success">Process</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
