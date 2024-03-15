@extends('template/main_dashboard')

@section('title','Your Reservation Room')
@section('container')
<div class="testimonial" id="testimonial">
<div class="container mt-4 mb-4">
     <h3>Dashboard</h3>
     <div class="row">
        @if(session('notify'))
        <div class="alert alert-success my-2" role="alert">
            {{session('notify')}}
        </div>
        @endif
     </div>
    <div class="row">
        <div class="col">
            @if($reservations->count() > 0)
            @foreach ($reservations as $rsv)
            <div class="card mb-1">
                <div class="card-body">
                    <p>
                        Number Reservation :  {{$rsv->number_reservation}} <br>
                        Name Guest         : {{$rsv->name}} <br>
                        Code Reservation   : {{$rsv->code_reservation}} <br>
                        Time Booking       :  {{$rsv->time_booking}} <br>
                        Room Number        :  {{$rsv->number_room}} <br>
                        Payment            :  {{$rsv->payment}} <br>
                        Status Payment     : {{$rsv->status_payment}} <br>
                        How Much Spend     : {{$rsv->time_spend}} <br>
                        <br>
                        Complete Payment Here --> <a href="/userdashboard/{{$rsv->code_reservation}}" class="btn btn-primary">Here</a>
                    </p>
                </div>
            </div>
            @endforeach
            @else
            <div class="card">
                <div class="card-body">
                    <p>You don't have any reservation room, please booking room first -> <a href="{{('/roomsdashboard')}}">Here</a>  </p>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
</div>
@endsection
