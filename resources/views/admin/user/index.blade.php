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
        <table class="table">
            <thead>
              <tr>
                <th scope="col">Id User</th>
                <th scope="col">Name</th>
                <th scope="col">Address</th>
                <th scope="col">Phone Number</th>
                {{-- <th scope="col">Gender</th> --}}
                {{-- <th scope="col">Role</th> --}}
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
                {{-- <th>{{$usr->gender}}</th> --}}
                {{-- <th>{{$usr->role}}</th> --}}
                <th>
                    <a href="" class="btn btn-success">Detail</a>
                    <a href="" class="btn btn-danger">Delete</a>
                </th>
              </tr>
              {{-- @endif --}}
              @endforeach
            </tbody>
          </table>
       </div>
    </div>
</div>

<div class="modal" id="" tabindex="-1">
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
        </div>
        <p>Modal body text goes here.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>

@endsection

@section('scripts')
<script type="text/javascript">

    function fetchShowUser(){
        let url = '';
        $.ajax({
            type: 'GET',
            url: '',
            processdata: false,
            contentType: false,
            success:function(data){
                console.log(data);
            }
        });
    }
</script>
@endsection
