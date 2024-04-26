@extends('template/main_dashboard')

@section('title','User Data')
@section('container')
<div class="container mt-2 mb-2">
    <a href="{{('/rooms/addroom')}}" class="btn btn-primary mb-2">Add a New User</a>
    <div class="row">
       <div class="col">
        @if(session('notify'))
            <div class="alert alert-success my-2" role="alert">
                {{session('notify')}}
            </div>
         @endif

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
          <h5 class="modal-title">Detail Users</h5>
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

<div class="modal fade" id="editRoom" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Edit a Room</h5>
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
                <label for="nameusr">Name</label>
                <input type="text" class="form-control" name="name" id="name-usr" style="color: black">
              </div>
              <div class="form-group">
                <label for="facility">Facility</label>
                <input type="text" class="form-control" name="facility" id="facility-room" style="color: black">
              </div>
              <div class="form-group">
                <label for="gender">Gender</label>
                <select aria-label="label for the select" name="gender" class="nice-select" id="class-room" style="display:block; width: 100%;color: black; padding: .375rem .75rem; font-size: 1rem; line-height: 1.5; background-color: #fff; background-clip: padding-box; margin-bottom: 30px; transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;">
                    <option value="" selected>Please Select</option>
                    <option value="1">Man</option>
                    <option value="2">Woman</option>
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
                 <label for="img-rm">Image Room</label>
                 <input type="file" name="image_room" id="image_room" onchange="previewImage(event);">
                 <img src="" id="img-rm" class="mini-img-room" alt="" style="margin-top: 2px; margin-bottom: 4px;">
              </div>

              <button type="submit" id="btn-edtroom" class="btn btn-primary">Update</button>
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
</script>
@endsection
