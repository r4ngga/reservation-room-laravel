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
                {{-- <form action="/roomsdashboard" method="POST" class="mt-2 mb-3"> --}}
                    {{-- <form action="#" method="POST" class="mt-2 mb-3"> --}}
                    {{-- @csrf --}}
                    <select class="" id="search" name="search">
                        <option selected>Please Select</option>
                        <option value="cost_low_to_high">Price Low to High</option>
                        <option value="cost_high_to_low">Price High to Low</option>
                        <option value="free">Status : Free</option>
                    </select>
                    <button class="btn btn-sm btn-primary">Search</button>
                {{-- </form> --}}
            </div>
       </div>
       <div class="row justify-content-center">
           <div class="col" style="color: white;">
                {{ $information ?? '' }}
           </div>
       </div>
       <div class="row">
        @php $list = ['Free', 'Full', 'Booked']; @endphp
           @foreach ($rooms as $rm)
                <div class="col-md-3 mt-2">
                    <div class="card h-100">
                        <div class="card-body">
                            <img @if ($rm->image_room)
                            src="/images/{{$rm->image_room}}"
                            alt="{{$rm->image_room}}"
                            @else
                            src="/images/default.jpeg"
                            alt="images-room"
                            @endif  class="card-img-top img-fluid"  style="height:auto;
                            width:auto;
                            max-width:200px;
                            max-height: 200px;">
                            <h4>Room Number {{$rm->number_room}}</h4>
                            <p>
                                Facility : {{$rm->facility ?? '-'}} <br>
                                Capacity : {{$rm->capacity ?? '-'}} <br>
                                Price    : {{$rm->price ?? '-'}} <br>
                                Status   : {{ $list[$rm->status] }} <br>
                                @if($rm->status == 1 || $rm->status == 2)
                                <button class="btn btn-outline-dark" disabled="disabled">Can't order this room</button>
                                @else
                                {{-- <a href="/bookingrooms/{{$rm->number_room}}" class="btn btn-success">Booking</a> --}}
                                <a href="#" class="btn btn-success">Booking</a>
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
