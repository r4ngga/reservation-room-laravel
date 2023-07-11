@extends('template/main_dashboard')

@section('title','Admin Dashboard')
@section('container')
<div class="container mt-4 mb-4">
    <div class="row">
        <div class="col">
            <div class="card h-70 bg-success">
                <div class="card-body">
                    <h4 style="color:white">Total Users</h4>
                    <h1 style="color:white"> {{$userCount}} </h1>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card h-70 bg-warning">
                <div class="card-body">
                    <h4>Total Rooms</h4>
                    <h1> {{$rooms}} </h1>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card h-70 bg-info">
                <div class="card-body">
                    <h4 style="color:white">Total Reservation</h4>
                    <h1 style="color:white"> {{$reservations}} </h1>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
