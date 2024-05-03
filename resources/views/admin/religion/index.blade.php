@extends('template/main_dashboard')

@section('title','Religion Data')

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
              <div id="aler-success" class="alert alert-success my-2" role="alert" style="display: none">
                 <button type="button" class="close" data-dismiss="alert" aria-label="Close" style="color: black">
                     <span aria-hidden="true">&times;</span>
                 </button>
             </div>
             <table class="table table-bordered border-1 mb-2">
                 <thead>
                   <tr>
                     <th scope="col">#</th>
                     <th scope="col">Name</th>
                     <th scope="col">Description</th>
                     <th scope="col">Status</th>
                     <th scope="col">Action</th>
                   </tr>
                 </thead>
                 <tbody>
                   @foreach($religions as $key => $rg)
                   <tr>
                     <td scope="row">{{$key ?? ''}}</td>
                     <td>{{$rg->name ?? ''}}</td>
                     <td>{{$rg->description ?? ''}}</td>
                     <td>{{$rg->status ?? ''}}</td>

                     <td>
                         <a onclick="fetchEdit({{$rm->id ?? ''}}, {{ $rm->name ?? '' }}, {{ $rm->description ?? '' }} )" href="#" data-toggle="modal" data-name="{{$rg->name}}" data-description="{{$rg->description ?? ''}}" data-target="#editReligion" class="btn btn-info">Change</a>
                         <a href="{{$rm->number_room}}/#DeleteRoom" class="btn btn-danger" data-toggle="modal"  data-target="#DeleteRoom{{$rm->number_room}}">Delete</a>
                     </td>
                   </tr>
                   @endforeach
                 </tbody>
               </table>
            </div>
         </div>
    </div>
 </div>

 <div class="modal fade" id="editReligion" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Edit a Data Religion</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="" id="form-edtrlg" method="POST" enctype="multipart/form-data">
              {{-- @method('delete') --}}
              @csrf
              <input type="hidden" id="id-religion" value="">

              <div class="form-group">
                <label for="namereligion">Name Religion</label>
                <input type="text" class="form-control" name="name" id="name-religion" style="color: black">
              </div>

              <div class="form-group">
                <label for="description">Description</label>
                <input type="text" class="form-control" name="description" id="description-religion" style="color: black">
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

<div class="modal" id="delRlg" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Delete a Data Religion</h5>
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
                    <button id="btn-delete-rlg" class="btn btn-danger">Delete</button>
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

    function fetchEdit(id, name, description)
    {
        //let namereligion = name;
        //let description = description;

        //document.getElementById('name-religion').value = namereligion;
        //document.getElementById('description-religion').value = description;
    }

    ("#btn-delete-rlg").click( function() {
        let idrlg = '';
    });


</script>

@endsection
