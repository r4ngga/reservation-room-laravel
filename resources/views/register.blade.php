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
                <form method="POST" action="{{ route('regist') }}" enctype="multipart/form-data">
                    @csrf
                   <div class="row">
                      <div class="col-sm-12">
                         <input class="form-control @error('name') is-invalid @enderror" placeholder="Name" type="text" name="name">
                        @error('name')
                         <div class="invalid-feedback">{{$message}}</div>
                       @enderror
                      </div>
                      <div class="col-sm-12">
                        <input class="form-control @error('email') is-invalid @enderror" placeholder="Email" type="text" name="email" id="regis_email">
                      @error('email')
                        <div class="invalid-feedback">{{$message}}</div>
                      @enderror
                      <span id="email-msg" class="text-sm text-gray-600 one-number" style="display: none;">
                        <p id="response-email"></p>
                      </span>
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
                        <input class="form-control @error('phone_number') is-invalid @enderror" placeholder="Phone Number" type="text" id="regis_phone_number" name="phone_number">
                        <span id="nomer-wa" class="text-sm text-gray-600 " style="display: none;">
                            &nbsp;<p id="response"></p>
                        </span>
                      @error('phone_number')
                        <div class="invalid-feedback">{{$message}}</div>
                      @enderror
                      </div>
                      <div class="col-sm-12">
                        <div class="custom-control custom-radio">
                            <input type="radio" id="man" name="gender" value="1" class="custom-control-input @error('gender') is-invalid @enderror">
                            <label class="custom-control-label" for="man">Man</label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input type="radio" id="woman" name="gender" value="2" class="custom-control-input @error('gender') is-invalid @enderror">
                            <label class="custom-control-label" for="woman">Woman</label>
                            @error('gender')
                            <div class="invalid-feedback">{{$message}}</div>
                            @enderror
                        </div>
                      </div>
                      <div class="col-sm-12">
                        <select class="form-control @error('religion_id') is-invalid @enderror" name="religion_id" id="religionid">
                            <option value="">Please Select Religion</option>
                            @if (!count($religions) == 0)

                                @foreach ($religions as $religion)
                                <option value="{{ $religion->id }}">{{ $religion->name ?? '' }}</option>
                                @endforeach

                            @endif
                            {{-- <option value=""></option> --}}
                        </select>
                        <input class="form-control @error('phone_number') is-invalid @enderror" placeholder="Phone Number" type="text" id="religion_id" name="religion_id">
                        @error('religion_id')
                            <div class="invalid-feedback">{{$message}}</div>
                        @enderror
                      </div>
                      <div class="col-sm-12">
                         <button type="submit" class="send" style="border-radius: 5px;">Register</button>
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

@section('scripts')
<script>
    const regist_phone_number = document.querySelector('#regis_phone_number');

    regist_phone_number.addEventListener("blur", (event) => {
        event.preventDefault();

        let number ;
        let url;

        url = "{{ route('validation-phone') }}";
        number = regist_phone_number.value;

        $.ajax({
            type: 'POST',
            data: {number:number, _token:'{{ csrf_token() }}'},
            url: url,
            success: function(e){
                if(e.status != true){
                    document.getElementById('nomer-wa').style.display = 'block';
                    document.getElementById('nomer-wa').style.color = '#e90f10';
                    const responseMessage = document.getElementById("response");
                    responseMessage.textContent = e.message;
                }else{
                    document.getElementById('nomer-wa').style.display = 'none';
                    document.getElementById('nomer-wa').style.color = '#e90f10';
                    const responseMessage = document.getElementById("response");
                    responseMessage.textContent = e.message;
                }

            },
        });

    });

    const regis_email = document.querySelector('#regis_email');

    regis_email.addEventListener("blur", (event) => {
        event.preventDefault();

        let email;
        let url_email ;

        url_email = "{{ route('validation-email') }}";
        email = regis_email.value;

        $.ajax({
            type: 'POST',
            data: {email:email, _token:'{{ csrf_token() }}'},
            url:url_email,
            success: function(e){
                  if(e.status == true){
                      document.getElementById('email-msg').style.display = 'none';
                      document.getElementById('email-msg').style.color = '#02b502';
                      const responseMessage = document.getElementById('response-email');
                      responseMessage.textContent = e.message;
                  }else{
                      document.getElementById('email-msg').style.display = 'block';
                      document.getElementById('email-msg').style.color = '#e90f10';
                      const responseMessage = document.getElementById('response-email');
                      responseMessage.textContent = e.message;
                  }
            },
        });
    });
</script>
@endsection
