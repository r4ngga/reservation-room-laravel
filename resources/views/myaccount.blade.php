@extends('template/main_dashboard')

@section('title','My Account')
@section('container')
<div class="container mt-4 mb-4">
    <div class="row justify-content-center">
        <div class="col">
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">My Account</h5>
                        <h6 class="card-subtitle mb-2 text-muted">Number Registration {{auth()->user()->id_user}}</h6>
                        <p>
                            Your Name Account : {{auth()->user()->name ?? '-'}} <br>
                            Email             : {{auth()->user()->email ?? '-'}} <br>
                            Address           : {{auth()->user()->address ?? '-'}} <br>
                            Number Phone      : {{auth()->user()->phone_number ?? '-'}} <br>
                            Gender            : {{auth()->user()->gender ?? '-'}} <br>
                            @if(auth()->user()->role == "admin")
                            Back to Admin Dashboard <a href="{{('/admindashboard')}}">Here</a>
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
