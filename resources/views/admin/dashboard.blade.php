@extends('template/main_dashboard')

@section('title','Admin Dashboard')
@section('container')
<div class="container mt-4 mb-4">
    <div class="row">
        <div class="col">
            <div class="card h-70 bg-success">
                <div class="card-body">
                    <h4 style="color:white">Total Users</h4>
                    <h1 id="user-count" style="color:white">  </h1>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card h-70 bg-warning">
                <div class="card-body">
                    <h4>Total Rooms</h4>
                    <h1 id="room-count"> </h1>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card h-70 bg-info">
                <div class="card-body">
                    <h4 style="color:white">Total Reservation</h4>
                    <h1 id="reservation-count" style="color:white">  </h1>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script type="text/javascript">

    // async function fetchCountUser() {
    // const response = await fetch('/count-users/');
    // // waits until the request completes...
    // console.log(response);
    // }

    // fetchCountUser();

    $.ajax({
        type: 'GET',
        url: 'count-users',
        success:function(data){
            document.getElementById('user-count').innerHTML = data;
        },
    });

    $.ajax({
        type: 'GET',
        url: 'count-rooms',
        success:function(data){
            document.getElementById('room-count').innerHTML = data;
        },
    });

    $.ajax({
        type: 'GET',
        url: 'count-reservations',
        success:function(data){
            document.getElementById('reservation-count').innerHTML = data;
        }
    });

</script>
@endsection
