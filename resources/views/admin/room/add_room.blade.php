@extends('template/main_dashboard')

@section('title','Insert New Room')

@section('style')
<style>
    .mini-img-room{
        max-width: 100px;
        width: 100%;
        max-height: 100px;
        height: 100%;
        margin: 4px;
    }
</style>
@endsection

@section('container')
<div class="container">
    <div class="row">

       <div class="col">
           <h3 class="mt-2">Insert a New Room</h3>
           @if(session('notify'))
           <div class="alert alert-success my-2" role="alert">
               {{session('notify')}}
               <button type="button" class="close" data-dismiss="alert" aria-label="Close" style="color: black">
                   <span aria-hidden="true">&times;</span>
               </button>
           </div>
           @endif
            <div class="card mt-4 mb-3">

                <div class="card-body">
                        <form action="{{ route('rooms.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="nmberrom">Number Room</label>
                                <input type="text" class="form-control py-1" name="number_room" id="number_room">
                            </div>
                            <div class="form-group">
                                <label for="facility">Facility</label>
                                <textarea class="form-control py-1" id="facility" name="facility" rows="2"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="">Class</label><br>

                                <select aria-label="label for the select" class="nice-select" id="" name="class" style="display:block; width: 100%;color: black; padding: .375rem .75rem; font-size: 1rem; line-height: 1.5; background-color: #fff; background-clip: padding-box; margin-bottom: 30px; transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;">
                                    <option selected>Please Select</option>
                                    <option value="1">Vip</option>
                                    <option value="2">Premium</option>
                                    <option value="3">Reguler</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="capacity">Capacity</label>
                                <input type="text" class="form-control rounded-md py-1" id="capacity" name="capacity">
                            </div>
                            <div class="form-group">
                                <label for="price">Price</label>
                                <input type="text" class="form-control py-1" id="price" name="price">
                            </div>
                            <div class="form-group">
                                <label for="image room">Image Room</label>
                                <input type="file" class="form-control-file" id="image_room" name="image_room">

                                <div class="row">
                                    <div class="col">
                                        <img id="img-room" src="" class="mini-img-room" style="display: none;" alt="">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Insert</button>
                            </div>
                        </form>
                </div>
            </div>
       </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    const prevImage = (event) => { //untuk preview image ketika edit
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
          const imagePreviewElement = document.querySelector("#img-room");
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
</script>
@endsection
