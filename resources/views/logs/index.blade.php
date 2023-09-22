@extends('template/main_dashboard')

@section('title','Logs')

@section('style')
<style>
    .card-total-log{
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

    .mini-img-log{
        max-width: 100px;
        width: 100%;
        max-height: 100px;
        height: 100%;
    }

    .position-col-log{
        right: 100%;
    }
</style>
@endsection

@section('container')
{{-- <div id="service" class="service"> --}}
<div class="container py-5 mt-2 mb-2" style="overflow-y:auto;">
    {{-- <a href="{{('/rooms/addroom')}}" class="btn btn-primary mb-2">Add a New Room</a> --}}
    <div class="row pb-4">
       <div class="col">
        @if(session('notify'))
            <div class="alert alert-success my-2" role="alert">
                {{session('notify')}}
            </div>
         @endif
        <table class="table table-bordered table-sm border-1 mb-2" id="tableLogs">
            <thead>
              <tr>
                <th style="text-align: center;" scope="col">Log Id</th>
                <th style="text-align: center;" scope="col">Command</th>
                <th style="text-align: center;" scope="col">Role</th>
                <th style="text-align: center;" scope="col">Description</th>
                <th style="text-align: center;" scope="col">Log Time</th>
                {{-- <th scope="col">Image Room</th> --}}
                <th style="text-align: center;" scope="col">Action</th>
              </tr>
            </thead>
            <tbody id="bodylogs">
              @foreach($logs as $log)
              <tr>
                <td style="text-align: center;" scope="row">{{$log->id ?? ''}}</td>
                <td style="text-align: center;">{{$log->action ?? ''}}</td>
                <td style="text-align: center;">{{($log->role == 1)? 'admin' : 'user' ?? ''}}</td>
                <td style="text-align: center;">{{$log->description ?? ''}}</td>
                <td style="text-align: center;">{{date('j F Y, h:i', strtotime($log->log_time)) ?? ''}}</td>

                <td style="text-align: center;">
                    <a href="javascript:void(0)" onclick="fetchShowLog({{$log->id ?? ''}})" class="btn btn-success" data-toggle="modal" data-target="#ShowDetailLog">Detail</a>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
       </div>
    </div>
</div>
{{-- </div> --}}
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
                    <div class="col">Name : </div>
                    <div class="col"> <p id="l-nameuser"></p> </div>
                </div>
                <div class="row">
                    <div class="col">User Id : </div>
                    <div class="col"> <p id="l-userid"></p> </div>
                </div>
                <div class="row">
                    <div class="col">Command : </div>
                    <div class="col"> <p id="l-action"></p> </div>
                </div>
                <div class="row">
                    <div class="col">Description : </div>
                    <div class="col"> <p id="l-description"></p> </div>
                </div>
                <div class="row">
                    <div class="col">Role : </div>
                    <div class="col"> <p id="l-role"></p> </div>
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

    function fetchlog()
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

    function fetchShowLog(id)
    {
        $.ajax({
            type: 'GET',
            url: '/fetchlogs/'+id,
            processdata: false,
            // type: 'JSON',
            success:function(data){
                let parsedata = JSON.parse(data);
                console.log(parsedata);
                document.getElementById('l-id').innerHTML = parsedata.id;
                document.getElementById('l-userid').innerHTML = parsedata.user_id;
                document.getElementById('l-action').innerHTML = parsedata.action;
                document.getElementById('l-description').innerHTML = parsedata.description;
                document.getElementById('l-time').innerHTML = parsedata.log_time;
                document.getElementById('l-dataold').innerHTML = parsedata.data_old;
                document.getElementById('l-datanew').innerHTML = parsedata.data_new;
                document.getElementById('l-nameuser').innerHTML = parsedata.name;
                document.getElementById('l-role').innerHTML = parsedata.role;
                // document.getElementById('b-pagesbook').innerHTML = data.pages_book;
            }
        });
    }
</script>
@endsection
