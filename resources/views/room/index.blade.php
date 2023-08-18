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
<div class="container mt-2 mb-2">
    {{-- <a href="{{('/rooms/addroom')}}" class="btn btn-primary mb-2">Add a New Room</a> --}}
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
                {{-- <th scope="col">Image Room</th> --}}
                <th scope="col">Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach($rooms as $rm)
              <tr>
                <td scope="row">{{$rm->number_room}}</td>
                <td>{{$rm->class}}</td>
                <td>{{$rm->capacity}}</td>
                <td>{{$rm->status}}</td>
                {{-- <th>
                    @if($rm->image_room == null)
                    image room not found
                    @else
                    <img src="/images/{{$rm->image_room}}" alt="" width="55" height="55">
                    @endif
                </th> --}}
                <td>
                    <a href="{{$rm->number_room}}/#ShowDetailRoom" class="btn btn-success" data-toggle="modal" data-target="#ShowDetailRoom{{$rm->number_room}}">Detail</a>
                    <a href="/change/{{$rm->number_room}}" class="btn btn-info">Change</a>
                    <a href="{{$rm->number_room}}/#DeleteRoom" class="btn btn-danger" data-toggle="modal"  data-target="#DeleteRoom{{$rm->number_room}}">Delete</a>
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
{{-- @endforeach --}}
{{-- detail room --}}

{{-- delete room --}}
<div class="modal fade" id="DeleteRoom" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Detail Room</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="" method="POST">
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
          <form action="" method="POST" enctype="multipart/form-data">
              {{-- @method('delete') --}}
              @csrf
              <input type="hidden" id="id-room" value="">

              <div class="form-group">
                <label for="facility">Facility</label>
                <input type="text" class="form-control" name="facility" id="facility-room">
              </div>
              <div class="form-group">
                <label for="cls">Class</label>
                <select name="class" class="form-control" id="class-room">
                    <option value="">Please Select</option>
                    <option value="vip">VIP</option>
                    <option value="premium">Premium</option>
                    <option value="reguler">Regular</option>
                </select>
              </div>
              <div class="form-group">
                <label for="capacity">Capacity</label>
                <input type="text" class="form-control" name="capacity" id="capacity-room">
              </div>
              <div class="form-group">
                <label for="price">Price</label>
                <input type="text" class="form-control" name="price" id="price-room">
              </div>

              <div class="form-group">
                 <label for="img-rm">Image Room</label>
                 <input type="file" name="image_room" id="image_room" onchange="previewImage(event);">
                 <img src="" id="img-rm" class="mini-img-room" alt="" style="margin-top: 2px; margin-bottom: 4px;">
              </div>

              <button type="submit" class="btn btn-primary">Insert</button>
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
                // document.getElementById('id-book').value = data.id_book;
                // document.getElementById('name-book').value = data.name_book;
                // document.getElementById('author-book').value = data.author;
                // document.getElementById('isbn-book').value = data.isbn;
                // document.getElementById('publisher-book').value = data.publisher;
                // document.getElementById('timerelease-book').value = data.time_release;
                // document.getElementById('pages-book').value = data.pages_book;
                // document.getElementById('language-book').value = data.language;
                // document.getElementById('img-book').src = data.image_book;
                // document.getElementById('img-book').value = "";

            }
        });
    }

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
            url: '/room/'+id,
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
