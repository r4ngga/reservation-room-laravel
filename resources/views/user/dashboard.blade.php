@extends('template/main_dashboard')

@section('title','User Dashboard')
@section('container')
<div class="container mt-4 mb-4">
    <div class="row">
        <div class="col">
            <p>USER...logoout here <br>  <a href="{{('/logout')}}"> Logout</a></p>
        </div>
        <div class="col">
            <div class="card h-70 bg-success">
                <div class="card-body">
                    <h4 style="color:white">Total Free Rooms</h4>
                    <h1 id="user-counts" style="color:white">  </h1>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="card h-70 bg-success">
                <div class="card-body">
                    <h4 style="color:white">Total Reservation</h4>
                    <h1 id="user-count" style="color:white">  </h1>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="card h-70 bg-success">
                <div class="card-body">
                    <h4 style="color:white">Total Reservation Unpaid</h4>
                    <h1 id="user-count" style="color:white">  </h1>
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
        url: 'count-users',
        success:function(data){
            document.getElementById('user-counts').innerHTML = data;
        },
    });
</script>

@endsection
