@extends('template/main_dashboard')

@section('title','Setting')
@section('container')
<div class="container mt-4 mb-4">
    <div class="row">
        <h2>Setting Account</h2>
    </div>
    <div class="row mb-2">
        <a href="{{('/changepassword')}}" class="badge badge-primary">change password</a>
    </div>
    <div class="row justify-content-center">
        <div class="col">
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <form action="/setting" method="POST">
                            @csrf
                            <div class="form-group" hidden>
                                <input type="text" class="form-control" id="id_user" name="id_user" value="{{auth()->user()->id_user}}">
                            </div>
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{auth()->user()->name}}">
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" name="email" value="{{auth()->user()->email}}">
                            </div>
                            <div class="form-group">
                                <label for="address">Address</label>
                                <input type="text" class="form-control" id="address" name="address" value="{{auth()->user()->address}}">
                            </div>
                            <div class="form-group">
                                <label for="number_phone">Number Phone </label>
                                <input type="text" class="form-control" id="phone_number" name="phone_number" value="{{auth()->user()->phone_number}}">
                            </div>
                            <div class="form-group">
                                <label for="gender">Gender</label>
                                <div class="custom-control custom-radio">
                                    <input type="radio" id="man" name="gender" value="man" class="custom-control-input @error('gender') is-invalid @enderror">
                                    <label class="custom-control-label" for="man">Man</label>
                                </div>
                                <div class="custom-control custom-radio">
                                        <input type="radio" id="woman" name="gender" value="woman" class="custom-control-input @error('gender') is-invalid @enderror">
                                            <label class="custom-control-label" for="woman">Woman</label>
                                            @error('gender')
                                            <div class="invalid-feedback">{{$message}}</div>
                                            @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="rlgion">Religion</label>
                                <select name="religion_id" id="religion_id" class="form-control">
                                    <option value="">Select Religion</option>
                                    @foreach ($religions as $religion)
                                    <option value="{{ $religion->id ?? '' }}" @if ($getUser->religions_id == $religion->id) selected @endif >{{ $religion->name ?? '' }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Save Changes</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
