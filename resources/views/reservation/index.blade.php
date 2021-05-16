@extends('template/main_dashboard')

@section('title','Select Room')
@section('container')

<div id="testimonial" class="testimonial">
    <div class="container">
        <div class="row justify-content-center">
            @if(session('notify'))
            <div class="alert alert-success my-2" role="alert">
                {{session('notify')}}
            </div>
            @endif
        </div>
       <div class="row justify-content-center">
            <div class="col">
                <h2>Select Room For Your Holiday</h2>
                <div class="dropdown mb-3 ">
                    <button class="btn btn-testimonial dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown">
                        Filter
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="#">Price Low to High</a>
                        <a class="dropdown-item" href="#">Price High to Low</a>
                        <a class="dropdown-item" href="#">Class</a>
                    </div>
                </div>
            </div>
       </div>
       <div class="row">
           @foreach ($rooms as $rm)
                <div class="col-md-3 mt-2">
                    <div class="card h-100">
                        <div class="card-body">
                            <img src="/images/{{$rm->image_room}}" class="card-img-top img-fluid" alt="{{$rm->image_room}}" style="height:auto;
                            width:auto;
                            max-width:200px;
                            max-height: 200px;">
                            <h4>Room Number {{$rm->number_room}}</h4>
                            <p>
                                Facility : {{$rm->facility}} <br>
                                Capacity : {{$rm->capacity}} <br>
                                Price    : {{$rm->price}} <br>
                                Status   : {{$rm->status}} <br>
                                @if($rm->status == 'full')
                                <button class="btn btn-outline-dark" disabled="disabled">Can't order this room</button>
                                @else
                                <a href="/bookingrooms/{{$rm->number_room}}" class="btn btn-success">Booking</a>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
           @endforeach
       </div>
    </div>
 </div>

@endsection
