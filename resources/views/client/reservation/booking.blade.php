@extends('template/main_dashboard')

@section('title','Booking Room')
@section('container')

<div id="testimonial" class="testimonial">
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <img src="/images/{{$room->image_room}}" class="card-img-top" alt="{{$room->image_room}}" style="height:auto;
                        width:auto;
                        max-width:200px;
                        max-height: 200px;">
                        <h3>Booking Room Number {{$room->number_room}}</h3>
                        <p>
                          Facility : {{$room->facility}} <br>
                          Capacity : {{$room->capacity}} <br>
                          Class    : {{$room->class}} <br>
                          Price    : {{$room->price}} <br>
                          <br>
                        </p>
                        <form action="/bookingrooms" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="codereservation">Code Random Reservation</label>
                                <input type="text" class="form-control" id="code_reservation" name="code_reservation" value="{{$set_value ?? ''}}" readonly>
                            </div>
                            <div class="form-group">
                                <label for="numberroom">Number Room</label>
                                <input type="text" class="form-control" id="number_room" name="number_room" value="{{$room->number_room ?? ''}}" readonly>
                            </div>
                            <div class="form-group">
                                <label for="idguest">ID User</label>
                                <input type="text" class="form-control" id="id_user" name="id_user" value="{{auth()->user()->id_user ?? ''}}" readonly>
                            </div>
                            <div class="form-group">
                                <label for="nameguest">Name Guest</label>
                                <input type="text" class="form-control" id="name_guest" name="name" value="{{auth()->user()->name ?? ''}}">
                            </div>
                            <div class="form-group">
                                <label for="datebooking">Date Booking</label>
                                <input type="date" class="form-control" id="time_booking" name="time_booking">
                            </div>
                            <div class="form-group">
                                <label for="checkin_time">Check-in Time</label>
                                <input type="time" class="form-control @error('checkin_time') is-invalid @enderror" id="checkin_time" name="checkin_time" min="13:00" value="{{ old('checkin_time') }}" required>
                                <small class="text-muted">Minimum check-in time is 1:00 PM (13:00)</small>
                                @error('checkin_time')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="checkout_time">Checkout Time</label>
                                <input type="time" class="form-control @error('checkout_time') is-invalid @enderror" id="checkout_time" name="checkout_time" max="12:00" value="{{ old('checkout_time') }}" required>
                                <small class="text-muted">Maximum checkout time is 12:00 Noon</small>
                                @error('checkout_time')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="timespend">Time Spend</label>
                                <input type="text" class="form-control" id="price" name="price" value=" {{$room->price}}" hidden>
                                <input type="text" class="form-control" id="time_spend" name="time_spend" onkeyup="countpayment()">
                            </div>
                            <div class="form-group">
                                <label for="Use Promotion">Promotion</label>
                                {{-- <input type="text" name="" id=""> --}}
                                <select name="promotion_id" id="promotion_id">
                                    <option value="">Pilih Promotion</option>
                                    @foreach ($promotions as $promotion)
                                        <option value="{{ $promotion->id ?? '' }}">{{$promotion->name ?? ''}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="payment">Payment (Time Spend x Price)</label>
                                <input type="text" class="form-control" id="payment" name="payment" onkeyup="countpayment()">
                            </div>
                            <div class="form-group">
                                <button class="btn btn-primary">Booking</button>
                                <a href="/roomsdashboard" class="btn btn-warning">Back</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

function countpayment(){
    var pricevalue = parseInt(document.getElementById("price").value);
    var timespendvalue = parseInt(document.getElementById("time_spend").value);

    var paymentroom = parseInt(document.getElementById("payment").value);

    paymentroom = pricevalue * timespendvalue;
    parseInt(document.getElementById("payment").value = paymentroom);
}

</script>

@endsection
