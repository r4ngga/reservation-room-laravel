@extends('template/main_second')

@section('title','Register')
@section('container')
<!-- register -->
<div id="testimonial" class="testimonial">
    <div class="container">
       <div class="row justify-content-center">

          <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
             <div class="contact">
                <h3>Register</h3>
                @if(session('notify'))
                <div class="alert alert-success my-2" role="alert">
                    {{session('notify')}}
                </div>
                 @endif
                <form method="POST" action="/register" enctype="multipart/form-data">
                    @csrf
                   <div class="row">
                      <div class="col-sm-12">
                         <input class="form-control @error('name') is-invalid @enderror" placeholder="Name" type="text" name="name">
                        @error('name')
                         <div class="invalid-feedback">{{$message}}</div>
                       @enderror
                      </div>
                      <div class="col-sm-12">
                        <input class="form-control @error('email') is-invalid @enderror" placeholder="Email" type="text" name="email">
                      @error('email')
                        <div class="invalid-feedback">{{$message}}</div>
                      @enderror
                     </div>
                      <div class="col-sm-12">
                         <input class="form-control @error('password') is-invalid @enderror" placeholder="Password" type="password" name="password">
                       @error('password')
                         <div class="invalid-feedback">{{$message}}</div>
                       @enderror
                      </div>
                      <div class="col-sm-12">
                        <input class="form-control @error('address') is-invalid @enderror" placeholder="Address" type="text" name="address">
                      @error('address')
                        <div class="invalid-feedback">{{$message}}</div>
                      @enderror
                      </div>
                      <div class="col-sm-12">
                        <input class="form-control @error('phone_number') is-invalid @enderror" placeholder="Phone Number" type="text" name="phone_number">
                      @error('phone_number')
                        <div class="invalid-feedback">{{$message}}</div>
                      @enderror
                      </div>
                      <div class="col-sm-12">
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
                      <div class="col-sm-12">
                         <button type="submit" class="send">Register</button>
                      </div>
                      <div class="col-sm-12">
                          &nbsp;
                     </div>
                      <div class="col-sm-12">
                            <h5>Have account ? let's login here <a href="{{url('/login')}}">Login</a></h5>
                      </div>
                   </div>
                </form>
             </div>
          </div>
       </div>
    </div>
 </div>
@endsection()
