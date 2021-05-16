@extends('template/main_second')

@section('title','Login')
@section('container')
<!-- login -->
<div id="testimonial" class="testimonial">
    <div class="container">
       <div class="row justify-content-center">

          <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
             <div class="contact">
                <h3>Login</h3>
                @if(session('notify'))
                <div class="alert alert-success my-2" role="alert">
                    {{session('notify')}}
                </div>
                 @endif
                <form method="POST" action="/login">
                    @csrf
                   <div class="row">
                      <div class="col-sm-12">
                         <input class="contactus" placeholder="Email" type="text" name="email">

                      </div>
                      <div class="col-sm-12">
                         <input class="contactus" placeholder="Password" type="password" name="password">

                      </div>
                      <div class="col-sm-12">
                         <button type="submit" class="send">Login</button>
                      </div>
                      <div class="col-sm-12">
                          &nbsp;
                     </div>
                      <div class="col-sm-12">
                            <h5>Don't have account ? create some account here <a href="{{url('/register')}}">Register</a></h5>
                      </div>
                   </div>
                </form>
             </div>
          </div>
       </div>
    </div>
 </div>
@endsection()
