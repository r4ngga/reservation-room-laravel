@extends('template/main_dashboard')

@section('title','User Data')
@section('container')
<div class="container mt-2 mb-2">
    <a href="#"  data-toggle="modal" data-target="#insert-user" class="btn btn-primary mb-2">Add a New User</a>
    <div class="row">
       <div class="col">
        @if(session('notify'))
            <div class="alert alert-success my-2" role="alert">
                {{session('notify')}}
            </div>
         @endif

         <div id="ntf-success" class="alert alert-success my-2" role="alert" style="display: none">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close" style="color: black">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
         <div id="succes-del-usr" class="alert alert-success my-2" role="alert" style="display: none">
            Success delete a user
        </div>
        <table class="table">
            <thead>
              <tr>
                <th scope="col">Id User</th>
                <th scope="col">Name</th>
                <th scope="col">Address</th>
                <th scope="col">Phone Number</th>
                <th scope="col">Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach($users as $usr)
              {{-- @if($usr->role=="user") --}}
              <tr>
                <th scope="row">{{$usr->id_user}}</th>
                <th>{{$usr->name}}</th>
                <th>{{$usr->address}}</th>
                <th>{{$usr->phone_number}}</th>
                <th>
                    <a href="#" onclick="fetchShowUser({{ $usr->id_user ?? 0}})" data-toggle="modal" data-target="#detailUsers" class="btn btn-success">Detail</a>
                    <a href="#" data-toggle="modal" data-id="{{ $usr->id_user ??  0}}" data-target="#delUsers" class="btn btn-danger">Delete</a>
                </th>
              </tr>
              {{-- @endif --}}
              @endforeach
            </tbody>
          </table>
       </div>
    </div>
</div>

<div class="modal" id="detailUsers" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Detail Users</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="container">
            <div class="row">
                <div class="col"> Id : </div>
                <div class="col"> <p id="u-id"></p> </div>
            </div>
            <div class="row">
                <div class="col"> Name : </div>
                <div class="col"> <p id="u-name"></p> </div>
            </div>
            <div class="row">
                <div class="col"> Email : </div>
                <div class="col"> <p id="u-email"></p> </div>
            </div>
            <div class="row">
                <div class="col"> Address : </div>
                <div class="col"> <p id="u-adrs"></p> </div>
            </div>
            <div class="row">
                <div class="col"> Phone Number : </div>
                <div class="col"> <p id="u-phone"></p> </div>
            </div>
            <div class="row">
                <div class="col"> Gender : </div>
                <div class="col"> <p id="u-gender"></p> </div>
            </div>
            <div class="row">
                <div class="col"> Role : </div>
                <div class="col"> <p id="u-role"></p> </div>
            </div>
            <div class="row">
                <div class="col">Religion</div>
                <div class="col"> <p id="u-religion"></p> </div>
            </div>
            <div class="row">
                <div class="col"> Created At : </div>
                <div class="col"> <p id="u-created"></p> </div>
            </div>
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>


<div class="modal" id="delUsers" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Delete Data User</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="container">
              <div class="row">
                <div class="col">
                 <form action="" id="" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id_users" id="id-users">
                    <input type="hidden" name="" id="token" value="{{ csrf_token() }}">
                    <button id="btn-delete-usr" class="btn btn-danger">Delete</button>
                 </form>
                </div>
              </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
</div>

<div class="modal fade" id="insert-user" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Insert a new user</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body m-2">
          <form action="{{ route('users.store') }}" method="POST">
              @csrf
              {{-- @method('delete') --}}
              {{-- <div class="form-group">
                          <label for="pages">Are you sure delete? Please Type "Delete" or "delete" </label>
                          <input type="text" class="form-control" id="validation" name="validation" placeholder="Type here">
              </div> --}}
              <div class="form-group">
                  <label for="name">Name</label> <span style="color: red;">*</span>
                  <input type="text" class="form-control py-1" id="name" name="name" placeholder="Type Name Here" required>
              </div>
              <div class="form-group">
                  <label for="email">Email</label> <span style="color: red;">*</span>
                  <input type="text" name="email" id="add-email" class="form-control py-1" placeholder="Email Here" required>
                  <span id="msg-email" class="text-sm text-gray-600 one-number" style="display: none;">
                      <i class="fas fa-circle" aria-hidden="true"></i>
                      &nbsp;<p id="response-email"></p>
                  </span>
              </div>
              <div class="form-group">
                  <label for="phonenumber">Phone Number</label> <span style="color: red;">*</span>
                  <input type="number" name="phone_number" id="add_phone_number" class="form-control py-1" placeholder="Phone Number Here" required>
                  <span id="msg-phone" class="text-sm text-gray-600 one-number" style="display: none;">
                      <i class="fas fa-circle" aria-hidden="true"></i>
                      &nbsp;<p id="response-phone"></p>
                  </span>
              </div>
              <div class="form-group">
                  <label for="adress">Address</label> <span style="color: red;">*</span>
                  <input type="text" name="address" id="address" class="form-control py-1" placeholder="Type Address Here" required>
              </div>
              <div class="form-group">
                <label for="rlgion">Religion</label>
                <select name="religion_id" id="religion-id" class="nice-select"  style="display:block; width: 100%;color: black; padding: .375rem .75rem; font-size: 1rem; line-height: 1.5; background-color: #fff; background-clip: padding-box; margin-bottom: 30px; transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;">
                  <option value="">Select Religion</option>
                  @foreach ($religions as $rlg )
                      <option value="{{ $rlg->id ?? '' }}">{{ $rlg->name ??''}}</option>
                  @endforeach
                </select>
              </div>
              <div class="form-group">
                  <label for="gender">Gender</label> <span style="color: red;">*</span>
                  <select aria-label="label for the select" name="gender" class="nice-select" id="gender-usr" style="display:block; width: 100%;color: black; padding: .375rem .75rem; font-size: 1rem; line-height: 1.5; background-color: #fff; background-clip: padding-box; margin-bottom: 30px; transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;">
                    <option value="" selected>Please Select</option>
                    <option value="1">Man</option>
                    <option value="2">Woman</option>
                  </select>
                  {{-- <div class="form-check">
                      <input type="radio" id="man" name="add_gender" value="man" class="form-check-input" required>
                      <label for="man">Man</label>
                    </div>
                    <div class="form-check">
                      <input type="radio" id="woman" name="add_gender" value="woman" class="form-check-input">
                      <label  for="woman">Woman</label>
                    </div> --}}
              </div>
              <div class="form-group">
                  <label for="password">Password</label> <span style="color: red;">*</span>
                  <input type="password" name="password" id="password" class="form-control py-1">
              </div>
              {{-- <div class="form-group">
                  <label for="label">Password dapat dikosongi apabila, tidak diubah</label>
              </div> --}}
              <button id="button-submit" type="submit"  class="btn btn-primary" >Confirm</button>
          </form>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="edituser" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Edit a User</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="" id="form-edtrm" method="POST" enctype="multipart/form-data">
              {{-- @method('delete') --}}
              @csrf
              <input type="hidden" id="id-usr" value="">

              <div class="form-group">
                <label for="nameusr">Name</label> <span style="color: red;">*</span>
                <input type="text" class="form-control" name="name" id="name-usr" style="color: black">
              </div>
              <div class="form-group">
                <label for="emailusr">Email</label> <span style="color: red;">*</span>
                <input type="text" class="form-control" name="email" id="email-usr" style="color: black">
              </div>
              <div class="form-group">
                <label for="gender">Gender</label> <span style="color: red;">*</span>
                <select aria-label="label for the select" name="gender" class="nice-select" id="gender-usr" style="display:block; width: 100%;color: black; padding: .375rem .75rem; font-size: 1rem; line-height: 1.5; background-color: #fff; background-clip: padding-box; margin-bottom: 30px; transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;">
                    <option value="" selected>Please Select</option>
                    <option value="1">Man</option>
                    <option value="2">Woman</option>
                </select>
              </div>
              <div class="form-group">
                <label for="lblregligion">Releigion</label>
                <select aria-label="label for the select" name="religions_id" class="nice-select" id="religions-usr" style="display:block; width: 100%;color: black; padding: .375rem .75rem; font-size: 1rem; line-height: 1.5; background-color: #fff; background-clip: padding-box; margin-bottom: 30px; transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;">
                    <option value="" selected>Please Select Religion</option>
                    @foreach ($religions as $rlg)
                        <option value="{{ $rlg->id }}" >{{ $rlg->name ?? ''}}</option>
                    @endforeach
                </select>
              </div>
              <div class="form-group">
                <label for="address">Address</label>
                <input type="text" class="form-control" name="address" id="address-usr" style="color: black">
              </div>
              <div class="form-group">
                <label for="numberphone">Number Phone</label>
                <input type="text" class="form-control" name="number_phone" id="numberphone-usr" style="color: black">
              </div>
              <div class="form-group">
                <label for="textpassword">Password</label>
                <input type="password" class="form-control" name="password" id="password-usr" style="color: black">
              </div>
              <div class="form-group">
                <p>Password dapat dikosongi apabila tidak diganti</p>
              </div>


              <button type="submit" id="btn-edtusr" class="btn btn-primary">Update</button>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
</div>

@endsection

@section('scripts')
<script type="text/javascript">

    function fetchShowUser(id){
        let url = '';
        $.ajax({
            type: 'GET',
            url: '/users/' + id,
            processdata: false,
            contentType: false,
            success:function(data){
                console.log(data);
                document.getElementById('u-id').innerHTML = data.id;
                document.getElementById('u-name').innerHTML = data.name;
                document.getElementById('u-email').innerHTML = data.email;
                document.getElementById('u-adrs').innerHTML = data.address;
                document.getElementById('u-phone').innerHTML = data.phone_number;
                document.getElementById('u-gender').innerHTML = data.gender;
                document.getElementById('u-role').innerHTML = data.role;
                document.getElementById('u-created').innerHTML = data.created_at;
                document.getElementById('u-religion').innerHTML = data.religion;
            }
        });
    }

    function fetchEdit(id)
    {
        $.ajax({
            type: 'GET',
            url: '/fetchedit-user/' + id,
            processdata: false,
            success:function(data){
                console.log(data);

                let selectedClass = document.getElementById('religions-usr');
                for(let i=0; i < selectedClass.length; i++)
                {
                    if(data.religions_id == selectedClass.options[i].value){
                        selectedClass.options[i].selected = true;
                        // selecte.leaveCode[i].selected = true;
                    }
                }
                document.getElementById('id-usr').value = data.id_user;
                document.getElementById('name-usr').value = data.name;
                document.getElementById('email-usr').value = data.email;
                document.getElementById('address-usr').value = data.address;
                document.getElementById('numberphone-usr').value = data.phone_number;
                // document.
            }
        });
    }

    $("#btn-delete-usr").click( function() {
        let idusr = $(this).data("id");
        let token = document.getElementById('token').val();

        $.ajax({
            type: 'POST',
            url: `users/delete/` + idusr,
            dataType: 'JSON',
            processdata: true,
            contentType: false,
            success:function(data){
                console.log(data);
                $('#delUsers').modal('hide');
                $('#succes-del-usr').css("display", "block");
            }
        });

    });


    function deleteUser(id)
    {
        $.ajax({
            type: 'POST',
            url: '',
            processdata: true,
            contentType: false,
            success:function(data){
                console.log(data);
            }
        });
    }

    $("#btn-edtusr").click(function(e) {
        e.preventDefault();

        let user_id = $('#id-usr').val();
        let user_nm = $('#name-usr').val();
        let user_email = $('#email-usr').val();
        let user_gender = $('#gender-usr').val();
        let user_address = $('#address-usr').val();
        let user_phone = $('#numberphone-usr').val();
        let user_pass = $('#password-usr').val();

        console.log(user_id, user_nm, user_email, user_gender, user_address, user_phone);

        $.ajax({
            type: 'POST',
            url: 'users/update/'+user_id,
            dataType: 'json',
            processdata: false,
            contentType: false,
            data: {
                _token:"{{ csrf_token() }}",
                id_user: user_id,
                name: user_nm,
                email: user_email,
                gender: user_gender,
                address: user_address,
                phone_number: user_phone,
                password: user_pass,
            },
            success: function(data){
                $('#edituser').modal('hide');
                $('#ntf-success').css("display", "block");
                $("#ntf-success").append(data.data);
                fetchuser();
            }
        });
    });

    function fetchuser()
    {
        $.ajax({
            type: 'GET',
            url: '{{ route('users.fetch-index') }}',
            processdata: false,
            success: function(dt)
            {
                console.log(dt);
            }
        });
    }
</script>
@endsection
