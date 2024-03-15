@extends('template/main_dashboard')

@section('title','Your History')
@section('container')
<div class="testimonial" id="testimonial">
<div class="container mt-4 mb-4">
     <h3>My History Order</h3>
    <div class="row">
        @if(session('notify'))
        <div class="alert alert-success my-2" role="alert">
            {{session('notify')}}
        </div>
        @endif
    </div>
    <div class="row">
        <div class="col">
            <div class="card mb-1">
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Name Guest</th>
                                <th scope="col">Code Reservation</th>
                                <th scope="col">Time Booking</th>
                                <th scope="col">Room Number</th>
                                <th scope="col">Status Payment</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($reservations->count() > 0)
                            @foreach ($reservations as $rsv)
                            <tr>
                                <td>{{$rsv->name}}</td>
                                <td>{{$rsv->code_reservation}}</td>
                                <td>{{$rsv->time_booking}}</td>
                                <td>{{$rsv->number_room}}</td>
                                <td>{{$rsv->status_payment}}</td>
                            </tr>
                            @endforeach
                            @else
                            <p>You don't have any reservation room, please booking room first  </p>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
