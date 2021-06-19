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
                <form action="/roomsdashboard" method="POST" class="mt-2 mb-3">
                    @csrf
                    <select class="" id="search" name="search">
                        <option selected>Please Select</option>
                        <option value="cost_low_to_high">Price Low to High</option>
                        <option value="cost_high_to_low">Price High to Low</option>
                        <option value="free">Status : Free</option>
                    </select>
                    <button class="btn btn-sm btn-primary">Search</button>
                </form>
            </div>
       </div>
       <div class="row justify-content-center">
           <div class="col" style="color: white;">
                {{ $information ?? '' }}
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
