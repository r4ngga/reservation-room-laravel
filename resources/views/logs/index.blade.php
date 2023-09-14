@extends('template/main_dashboard')

@section('title','Logs')

@section('style')
<style>
    .card-total{
        position: absolute;
        /* right: 100%; */
        left: 65%;
        background: #D0D0D0;
        color: black;
        size: 5em;
        width: 100%;
        height: 100%;
        max-width: 10em;
        text-align: center;
        justify-content: space-around;
        /* padding-top: 1px; */
    }

    .mini-img-room{
        max-width: 100px;
        width: 100%;
        max-height: 100px;
        height: 100%;
    }

    .position-col{
        right: 100%;
    }
</style>
@endsection

@section('container')
<div class="container mt-2 mb-2">
    {{-- <a href="{{('/rooms/addroom')}}" class="btn btn-primary mb-2">Add a New Room</a> --}}
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
                <th scope="col">Log Id</th>
                <th scope="col">Action</th>
                <th scope="col">Role</th>
                <th scope="col">Description</th>
                <th scope="col">Log Time</th>
                {{-- <th scope="col">Image Room</th> --}}
                <th scope="col">Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach($logs as $log)
              <tr>
                <td scope="row">{{$log->id ?? ''}}</td>
                <td>{{$log->action ?? ''}}</td>
                <td>{{$log->role ?? ''}}</td>
                <td>{{$log->description ?? ''}}</td>
                <td>{{$log->log_time ?? ''}}</td>

                <td>
                    <a href="{{$log->id}}/#ShowDetailLog" class="btn btn-success" data-toggle="modal" data-target="#ShowDetailLog{{$log->id}}">Detail</a>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
       </div>
    </div>
</div>

{{-- detail room --}}

<div class="modal fade" id="ShowDetailLog" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Detail Log</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="container">
                <div class="row">
                    <div class="col">Log Id :  </div>
                    <div class="col"> <p id="l-id"></p> </div>
                </div>
                <div class="row">
                    <div class="col">Action : </div>
                    <div class="col"> <p id="l-action"></p> </div>
                </div>
                <div class="row">
                    <div class="col">Description : </div>
                    <div class="col"> <p id="l-description"></p> </div>
                </div>
                <div class="row">
                    <div class="col">Log Time : </div>
                    <div class="col"> <p id="l-time"></p> </div>
                </div>
                <div class="row">
                    <div class="col">Data Old : </div>
                    <div class="col"> <p id="l-dataold"></p> </div>
                </div>
                <div class="row">
                    <div class="col">Data New : </div>
                    <div class="col"> <p id="l-datanew"></p> </div>
                </div>

            </div>
          {{-- <p>Number Rooms : {{$rm->number_room}} <br>
             Facility     : {{$rm->facility}} <br>
             Class        : {{$rm->class}} <br>
             Capacity     : {{$rm->capacity}} <br>
             Price        : {{$rm->price}} <br>
             Status       : {{$rm->status}}
          </p> --}}
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
</div>

{{-- detail room --}}


@endsection

@section('scripts')
<script>

    function fetchroom()
    {
        $.ajax({
            type: 'GET',
            url: '',
            processdata: false,
            success: function(data)
            {
                console.log(data);
            }
        });
    }

    function fetchShowRoom(id)
    {
        $.ajax({
            type: 'GET',
            url: '/fetchlogs/'+id,
            processdata: false,
            // type: 'JSON',
            success:function(data){
                console.log(data);
                //
            }
        });
    }
</script>
@endsection
