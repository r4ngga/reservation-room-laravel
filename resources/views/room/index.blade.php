@extends('template/main_dashboard')

@section('title','Room Data')
@section('container')
<div class="container mt-2 mb-2">
    <a href="{{('/rooms/addroom')}}" class="btn btn-primary mb-2">Add a New Room</a>
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
                <th scope="col">Room Number</th>
                <th scope="col">Class</th>
                <th scope="col">Capacity</th>
                <th scope="col">Status</th>
                <th scope="col">Image Room</th>
                <th scope="col">Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach($rooms as $rm)
              <tr>
                <th scope="row">{{$rm->number_room}}</th>
                <th>{{$rm->class}}</th>
                <th>{{$rm->capacity}}</th>
                <th>{{$rm->status}}</th>
                <th>
                    @if($rm->image_room == null)
                    image room not found
                    @else
                    <img src="/images/{{$rm->image_room}}" alt="" width="55" height="55">
                    @endif
                </th>
                <th>
                    <a href="{{$rm->number_room}}/#ShowDetailRoom" class="btn btn-success" data-toggle="modal" data-target="#ShowDetailRoom{{$rm->number_room}}">Detail</a>
                    <a href="/change/{{$rm->number_room}}" class="btn btn-info">Change</a>
                    <a href="{{$rm->number_room}}/#DeleteRoom" class="btn btn-danger" data-toggle="modal"  data-target="#DeleteRoom{{$rm->number_room}}">Delete</a>
                </th>
              </tr>
              @endforeach
            </tbody>
          </table>
       </div>
    </div>
</div>

@foreach($rooms as $rm)
<div class="modal fade" id="ShowDetailRoom{{$rm->number_room}}" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Detail Room</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p>Number Rooms : {{$rm->number_room}} <br>
             Facility     : {{$rm->facility}} <br>
             Class        : {{$rm->class}} <br>
             Capacity     : {{$rm->capacity}} <br>
             Price        : {{$rm->price}} <br>
             Status       : {{$rm->status}}
          </p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
</div>
@endforeach

@foreach($rooms as $rm)
<div class="modal fade" id="DeleteRoom{{$rm->number_room}}" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Detail Room</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="/rooms/{{$rm->number_room}}" method="POST">
              @method('delete')
              @csrf
              <p>Are you sure delete data room with number {{$rm->number_room}}  ? <br></p>
              <button type="submit" class="btn btn-danger">Delete</button>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
</div>
@endforeach

@endsection
