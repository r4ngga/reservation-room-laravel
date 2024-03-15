@extends('template/main_dashboard')

@section('title','Dashboard')
@section('container')
<div class="container mt-4 mb-4">
    <div class="row">
        <div class="col">
            <h2>Dashboard</h2>
        </div>
    </div>
    <div class="row">
        {{-- <div class="col"> --}}
            {{-- <p>USER...logoout here <br>  <a href="{{('/logout')}}"> Logout</a></p> --}}
        {{-- </div> --}}
        <div class="col">
            <div class="card h-70 bg-success">
                <div class="card-body">
                    <h4 style="color:white">Total Free Rooms</h4>
                    <h1 id="room-counts" style="color:white">  </h1>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="card h-70 bg-warning">
                <div class="card-body">
                    <h4 style="color:black">Total Reservation</h4>
                    <h1 id="reservation-count" style="color:white">  </h1>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="card h-70 bg-gray border-lg border-info">
                <div class="card-body" style="background-color: #C0C0C0">
                    <h4 style="color:black">Total Reservation Unpaid</h4>
                    <h1 id="unpaid-count" style="color:black"> 0 </h1>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')

<script type="text/javascript">
    $.ajax({
        type: 'GET',
        url: 'count-room',
        success:function(data){
            document.getElementById('room-counts').innerHTML = data.countroom;
        },
    });

    $.ajax({
        type: 'GET',
        url: 'count-reservation',
        success:function(data){
            document.getElementById('reservation-count').innerHTML = data.countreservation;
        }
    });

    $.ajax({
        type: 'GET',
        url: 'count-unpaid',
        success:function(data){
            document.getElementById('unpaid-count').innerHTML = data.countunpaid;
        }
    });
</script>

@endsection
