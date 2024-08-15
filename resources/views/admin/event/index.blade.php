@extends('template/main_dashboard')

@section('title','Event Data')

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

<div id="testimonial" class="testimonial">
    <div class="container">
        <div class="row pb-4">
            <div class="col">
             {{-- @if(session('notify'))
                 <div class="alert alert-success my-2" role="alert">
                     {{session('notify')}}
                 </div>
              @endif --}}

             <div id="ntf-success" class="alert alert-success my-2" role="alert" style="display: none">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close" style="color: black">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
             <table class="table table-bordered border-1 mb-2">
                 <thead>
                   <tr>
                     <th scope="col">#</th>
                     <th scope="col">Name</th>
                     <th scope="col">Enable</th>
                     <th scope="col">Start Date</th>
                     <th scope="col">End Date</th>
                     <th scope="col">Action</th>
                   </tr>
                 </thead>
                 <tbody>
                   @foreach($events as $key => $ev)
                   <tr>
                     <td scope="row">{{$key ?? ''}}</td>
                     <td>{{$ev->name ?? ''}}</td>
                     <td>{{$ev->enable ?? ''}}</td>
                     <td>{{$ev->start_date ?? ''}}</td>
                     <td>{{$ev->end_date ?? '' }}</td>

                     <td>
                        <a href="#" onclick="fetchShowEvent($ev->id)" class="btn btn-info" data-toggle="modal" data-target="#ShowDetailEvent">Show</a>
                         <a href="#" onclick="fetchEditEvent({{$ev->id ?? ''}}, {{ $ev->name ?? '' }}, {{ $ev->description ?? '' }}, {{ $ev->start_date ?? ''}}, {{ $ev->end_date ?? ''}} )" href="#" data-toggle="modal" data-name="{{$ev->name}}" data-description="{{$ev->description ?? ''}}" data-target="#editEvent" class="btn btn-info">Change</a>
                         <a href="#" onclick="deleteEvent({{$ev->id}})" class="btn btn-danger" data-toggle="modal" data-target="#delEvt">Delete</a>
                     </td>
                   </tr>
                   @endforeach
                 </tbody>
               </table>
            </div>
         </div>
    </div>
 </div>

 <div class="modal fade" id="ShowDetailEvent" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Detail Event</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="container">
                <div class="row">
                    <div class="col">Name Event :  </div>
                    <div class="col"> <p id="e-name"></p> </div>
                </div>
                <div class="row">
                    <div class="col">Description : </div>
                    <div class="col"> <p id="e-description"></p> </div>
                </div>
                <div class="row">
                    <div class="col">Enable : </div>
                    <div class="col"> <p id="e-enable"></p> </div>
                </div>
                <div class="row">
                    <div class="col">Status : </div>
                    <div class="col"> <p id="e-status"></p> </div>
                </div>
                <div class="row">
                    <div class="col">Price : </div>
                    <div class="col"> <p id="e-price"></p> </div>
                </div>

                <div class="row">
                    <div class="col">Start Event : </div>
                    <div class="col"> <p id="e-start-price"></p> </div>
                </div>
                <div class="row">
                    <div class="col">End Event : </div>
                    <div class="col"> <p id="e-end-price"></p> </div>
                </div>
                <div class="row">
                    <div class="col">Created at: </div>
                    <div class="col"> <p id="e-created"></p> </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
</div>

 <div class="modal fade" id="editEvent" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Edit a Data Event</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="" id="form-edtevt" method="POST" enctype="multipart/form-data">
              {{-- @method('delete') --}}
              @csrf
              <input type="hidden" id="id-event" value="">

              <div class="form-group">
                <label for="namevent">Name Event</label>
                <input type="text" class="form-control" name="name" id="name-event" style="color: black">
              </div>

              <div class="form-group">
                <label for="description">Description</label>
                <input type="text" class="form-control" name="description" id="description-event" style="color: black">
              </div>

              <div class="form-group">
                <label for="enableevent">Toggle Event</label>
                <select name="enable" id="enable-event">
                    <option value="1">Enable</option>
                    <option value="0">Disable</option>
                </select>
              </div>

              <div class="form-group">
                 <label for="pricepromotion">Price</label>
                 <input type="text" name="price" class="form-control" id="price-promotion" style="color: black">
              </div>

              <div class="form-group">
                <label for="startdatepromot">Start Date Promotion</label>
                <input type="date" name="start_date" id="start-event">
              </div>

              <div class="form-group">
                <label for="enddatepromot">End Date Promotion</label>
                <input type="date" name="end_date" id="end-event">
              </div>

              <button type="submit" id="btn-edtevnt" class="btn btn-primary">Update</button>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
</div>

<div class="modal" id="delEvt" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Delete a Data Event</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="container">
              <div class="row">
                <div class="col">
                 <form action="" id="" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id_event" id="id-event-del" value="">
                    <input type="hidden" name="" id="token" value="{{ csrf_token() }}">
                    <button id="btn-delete-evnt" class="btn btn-danger">Delete</button>
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

@endsection

@section('scripts')
<script type="text/javascript">

    function fetchShowEvent(id)
    {
        $.ajax({
            type: 'GET',
            url: '/events/'+id,
            processdata: false,
            success:function(data){
                console.log(data);
                document.getElementById('e-name').innerHTML = data.name;
                document.getElementById('e-description').innerHTML = data.description;
                document.getElementById('e-enable').innerHTML = data.enable;
                document.getElementById('e-status').innerHTML = data.status;
                document.getElementById('e-price').innerHTML = data.price;
                document.getElementById('e-start-price').innerHTML = data.start_date;
                document.getElementById('e-end-price').innerHTML = data.end_date;
                document.getElementById('e-created').innerHTML = data.created_at;
            }
        });
    }

    function fetchEditEvent(id, name, description, start_date, end_date)
    {
        let namepromotion = name;
        let description = description;
        let startpromotion = start_date;
        let endpromotion = end_date;

        document.getElementById('id-event').value = id;
        document.getElementById('name-event').value = namepromotion;
        document.getElementById('description-event').value = description;
        document.getElementById('start-event').value = startpromotion;
        document.getElementById('end-event').value = endpromotion;

    }

    function deleteEvent(id)
    {
        document.getElementById('id-event-del').value = id;
    }

    ("#btn-delete-evnt").click( function(e) {
        e.preventDefault();

        let idrlg = $('#id-event-del').val();

        $.ajax({
            type: 'DELETE',
            enctype: 'multipart/form-data',
            url: '/promotions/',
        });
        // let namerlg = $
    });

    $("#btn-edtevnt").click( function (ev) {
        ev.preventDefault();

        let event_id = $('#id-event').val();
        let event_name = $('#name-event').val();
        let event_description = $('#description-event').val();
        let event_enable = $('#enable-event').val();
        let event_start = $('#start-date').val();

        console.log(event_id, event_name, event_description, event_enable, event_start);

        $.ajax({
            type: 'POST',
            url: 'users/update/'+user_id,
            dataType: 'json',
            processdata: false,
            contentType: false,
            data: {
                _token:"{{ csrf_token() }}",
                id: event_id,
                name: event_name,
                description: event_description,
                enable: event_enable,
                start_date: event_start,
            },
            success: function(data){
                $('#editEvent').modal('hide');
                $('#ntf-success').css("display", "block");
                $('#ntf-success').append(data.data);
            }
        });
    });

    function fetchevent(){
        $.ajax({
            type: 'GET',
            url: '{{ route('users.fetch-index') }}',
            processdata: false,
            success: function(data)
            {
                console.log(data);
            }
        });
    }

</script>

@endsection
