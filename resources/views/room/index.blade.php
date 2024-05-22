@extends('template/main_dashboard')

@section('title','Room Data')

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
<div class="container py-5 mt-2 mb-2">
    {{-- <a href="{{('/rooms/addroom')}}" class="btn btn-primary mb-2">Add a New Room</a> --}}
    <a href="{{('/rooms/addroom')}}" class="btn btn-primary mb-2">Add a New Room</a>
    <div class="row pb-4">
       <div class="col">
        {{-- @if(session('notify'))
            <div class="alert alert-success my-2" role="alert">
                {{session('notify')}}
            </div>
         @endif --}}
         <div id="aler-success" class="alert alert-success my-2" role="alert" style="display: none">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close" style="color: black">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <table class="table table-bordered border-1 mb-2">
            <thead>
              <tr>
                <th scope="col">Room Number</th>
                <th scope="col">Class</th>
                <th scope="col">Capacity</th>
                <th scope="col">Status</th>
                {{-- <th scope="col">Image Room</th> --}}
                <th scope="col">Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach($rooms as $rm)
              <tr>
                <td scope="row">{{$rm->number_room ?? ''}}</td>
                <td>{{$rm->class ?? ''}}</td>
                <td>{{$rm->capacity ?? ''}}</td>
                <td>{{$rm->status ?? ''}}</td>

                <td>
                    <a onclick="fetchShowRoom({{$rm->number_room ?? ''}})" href="javascript:void(0)" data-toggle="modal" data-target="#ShowDetailRoom" class="btn btn-success" data-toggle="modal" data-target="#ShowDetailRoom{{$rm->number_room}}">Detail</a>
                    <a onclick="fetchEdit({{$rm->number_room ?? ''}} )" href="#" data-toggle="modal" data-target="#editRoom" class="btn btn-info">Change</a>
                    <a href="#" class="btn btn-danger" data-toggle="modal"  data-target="#DeleteRoom{{$rm->number_room}}">Delete</a>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
       </div>
    </div>
</div>

{{-- detail room --}}
{{-- @foreach($rooms as $rm) --}}
<div class="modal fade" id="ShowDetailRoom" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Detail Room</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="container">
                <div class="row">
                    <div class="col">Number Room :  </div>
                    <div class="col"> <p id="r-number"></p> </div>
                </div>
                <div class="row">
                    <div class="col">Facility : </div>
                    <div class="col"> <p id="r-facility"></p> </div>
                </div>
                <div class="row">
                    <div class="col">Class : </div>
                    <div class="col"> <p id="r-class"></p> </div>
                </div>
                <div class="row">
                    <div class="col">Capacity : </div>
                    <div class="col"> <p id="r-capacity"></p> </div>
                </div>
                <div class="row">
                    <div class="col">Price : </div>
                    <div class="col"> <p id="r-price"></p> </div>
                </div>
                <div class="row">
                    <div class="col">Status : </div>
                    <div class="col"> <p id="r-status"></p> </div>
                </div>
                <div class="row">
                    <div class="col">Image Room : </div>
                    <div class="col"> <img id="r-img" class="mini-img-room" src="" alt=""> </div>
                </div>
                <div class="row">
                    <div class="col">Created at: </div>
                    <div class="col"> <p id="r-created"></p> </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
</div>
{{-- @endforeach --}}
{{-- detail room --}}

{{-- delete room --}}
<div class="modal fade" id="DeleteRoom" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Delete Room</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="" method="POST">
              @method('delete')
              @csrf
              <input type="hidden" name="id_room" id="id-room">
              <p>Are you sure delete data room with number {{$rm->number_room}}  ? <br></p>
              <button type="submit" id="btn-delete-room" class="btn btn-danger">Delete</button>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
</div>
{{-- delete room --}}

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
              <input type="hidden" id="id-room" value="">

              <div class="form-group">
                <label for="facility">Facility</label>
                <input type="text" class="form-control" name="facility" id="facility-room" style="color: black">
              </div>
              <div class="form-group">
                <label for="cls">Class</label>
                <select aria-label="label for the select" name="class" class="nice-select" id="class-room" style="display:block; width: 100%;color: black; padding: .375rem .75rem; font-size: 1rem; line-height: 1.5; background-color: #fff; background-clip: padding-box; margin-bottom: 30px; transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;">
                    <option value="" selected>Please Select</option>
                    <option value="1">VIP</option>
                    <option value="2">Premium</option>
                    <option value="3">Regular</option>
                </select>
              </div>
              <div class="form-group">
                <label for="capacity">Capacity</label>
                <input type="text" class="form-control" name="capacity" id="capacity-room" style="color: black">
              </div>
              <div class="form-group">
                <label for="price">Price</label>
                <input type="text" class="form-control" name="price" id="price-room" style="color: black">
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
<script>
    function getEdtRoom(id, fac, cls, cap, prc, status){
        const room_id = id;
        const room_facility = fac;
        const room_class = cls;
        const room_capacity = cap;
        const room_price = prc;
        const room_status = status;

        console.log(room_id, room_capacity, room_facility, room_class, room_price, room_status);
        document.getElementById('id-room').value = room_id;
        document.getElementById('capacity-room').value = room_capacity;
        document.getElementById('facility-room').value = room_facility;
        // document.getElementById('class-room').value =
        document.getElementById('price-room').value = room_price;

        const selectedclass = document.querySelector('#class-room');
        const selectedOptclass = Array.from(selectedclass.selectedOptclass);
        const optionSelected = selectedOptclass.find(item => item.text === cls);
        optionSelected.selected = true;

    }

    const previewImage = (event) => { //untuk preview image ketika edit
        /**
       * Get the selected files.
       */
      const imageFiles = event.target.files;
      /**
       * Count the number of files selected.
       */
      const imageFilesLength = imageFiles.length;
      /**
       * If at least one image is selected, then proceed to display the preview.
       */
      /**
       * If at least one image is selected, then proceed to display the preview.
       */
      if (imageFilesLength > 0) {
          /**
           * Get the image path.
           */
          const imageSrc = URL.createObjectURL(imageFiles[0]);
          /**
           * Select the image preview element.
           */
          const imagePreviewElement = document.querySelector("#img-rm");
          /**
           * Assign the path to the image preview element.
           */
          imagePreviewElement.src = imageSrc;
          /**
           * Show the element by changing the display value to "block".
           */
          imagePreviewElement.style.display = "block";
      }
    };

    function fetchEdit(id)
    {
        $.ajax({
            type: 'GET',
            url: '/fetchedit/'+id,
            processdata: false,
            // type: 'JSON',
            success:function(data){
                console.log(data);

                let selectedClass = document.getElementById('class-room');
                for(let i=0; i < selectedClass.length; i++)
                {
                    if(data.class == selectedClass.options[i].value){
                        selectedClass.options[i].selected = true;
                        // selecte.leaveCode[i].selected = true;
                    }
                }
                // document.getElementById('id-book').value = data.id_book;
                document.getElementById('id-room').value = data.number_room;
                document.getElementById('capacity-room').value = data.capacity;
                document.getElementById('facility-room').value = data.facility;
                document.getElementById('price-room').value = data.price;
                document.getElementById('image_room').value = '';

                document.getElementById('img-rm').src = data.image_room;

            }
        });
    }

   /* function fetchroom()
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
    }*/

    function fetchShowRoom(id)
    {
        $.ajax({
            type: 'GET',
            url: '/rooms/'+id,
            processdata: false,
            success:function(data){
                console.log(data);
                document.getElementById('r-number').innerHTML = data.number_room;
                document.getElementById('r-facility').innerHTML = data.facility;
                document.getElementById('r-class').innerHTML = data.class;
                document.getElementById('r-capacity').innerHTML = data.capacity;
                document.getElementById('r-price').innerHTML = data.price;
                document.getElementById('r-status').innerHTML = data.status;
                document.getElementById('r-img').src = data.image_room;
                document.getElementById('r-created').innerHTML = data.created_at;
                //
            }
        });
    }

    $("#btn-edtroom").click(function(e) {
        e.preventDefault();

        let room_id = $('#id-room').val();
        let room_facility = $('#facility-room').val();
        let room_class = $('#class-room').val();
        let room_capacity = $('#capacity-room').val();
        let room_price = $('#price-room').val();
        let room_img = $('#image_room').val();

        let form_edit =  new FormData($("#form-edtrm")[0]);

        console.log(room_id, room_facility, room_class, room_capacity, room_price, room_img);

        $.ajax({
            type: 'POST',
            enctype: 'multipart/form-data',
            url: '/room/update/'+room_id ,
            headers: {
                'X-CSRF-Token': '{{ csrf_token() }}',
            },
            dataType: 'json',
            processdata: false,
            contentType: false,
            data: form_edit,
            success: function(data){
                $('#editRoom').modal('hide');
                $("#aler-success").css("display", "block");
            }
        });
    });

    $("#btn-delete-room").click(function(e) {

        e.preventDefault();

        let idrm = $("#id-room").val();
        $.ajax({
            type: 'DELETE',
            enctype: 'multipart/form-data',
            url: '/rooms/'
        });
    });
</script>
@endsection
