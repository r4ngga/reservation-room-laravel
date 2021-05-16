@extends('template/main_dashboard')

@section('title','Change Password')
@section('container')
<div class="container mt-4 mb-4">
    <div class="row">
        <h2>Change Password</h2>
    </div>

    <div class="row justify-content-center">
        <div class="col">
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <form action="/changepassword" method="POST">
                            @csrf
                            <div class="form-group" hidden>
                                <input type="text" class="form-control" id="id_user" name="id_user" value="{{auth()->user()->id_user}}">
                            </div>
                            <div class="form-group">
                                <label for="password">New Password</label>
                                <input type="password" class="form-control" id="password" name="password" value="">
                            </div>
                            <div class="form-group">
                                <label for="repeatpassword">Repeat Password</label>
                                <input type="password" class="form-control" id="repeat_password" name="repeat_password" value="">
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary mr-2">Save Changes</button>
                                <a href="{{('/setting')}}" class="btn btn-warning"> Back</a>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
