@extends('template/main_dashboard')

@section('title','Promotion Data')

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
                     <th scope="col">Enable</th>
                     <th scope="col">Start Date</th>
                     <th scope="col">End Date</th>
                     <th scope="col">Action</th>
                   </tr>
                 </thead>
                 <tbody>
                   @foreach($promotions as $key => $pr)
                   <tr>
                     <td scope="row">{{$key ?? ''}}</td>
                     <td>{{$pr->name ?? ''}}</td>
                     <td>{{$pr->enable ?? ''}}</td>
                     <td>{{$pr->start_date ?? ''}}</td>
                     <td>{{$pr->end_date ?? '' }}</td>

                     <td>
                         <a href="#" onclick="fetchEditPromot({{$pr->id ?? ''}}, {{ $pr->name ?? '' }}, {{ $pr->description ?? '' }}, {{ $pr->start_date ?? ''}}, {{ $pr->end_date ?? ''}} )" href="#" data-toggle="modal" data-name="{{$pr->name}}" data-description="{{$pr->description ?? ''}}" data-target="#editPromotion" class="btn btn-info">Change</a>
                         <a href="#" onclick="deletePromot({{$rg->id}})" class="btn btn-danger" data-toggle="modal" data-target="#delPrmt">Delete</a>
                     </td>
                   </tr>
                   @endforeach
                 </tbody>
               </table>
            </div>
         </div>
    </div>
 </div>

 <div class="modal fade" id="ShowDetailPromotion" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Detail Promotion</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="container">
                <div class="row">
                    <div class="col">Name Promotion :  </div>
                    <div class="col"> <p id="p-name"></p> </div>
                </div>
                <div class="row">
                    <div class="col">Description : </div>
                    <div class="col"> <p id="p-description"></p> </div>
                </div>
                <div class="row">
                    <div class="col">Enable : </div>
                    <div class="col"> <p id="p-enable"></p> </div>
                </div>
                <div class="row">
                    <div class="col">Status : </div>
                    <div class="col"> <p id="p-status"></p> </div>
                </div>
                <div class="row">
                    <div class="col">Price : </div>
                    <div class="col"> <p id="p-price"></p> </div>
                </div>

                <div class="row">
                    <div class="col">Start Promot : </div>
                    <div class="col"> <p id="p-start-price"></p> </div>
                </div>
                <div class="row">
                    <div class="col">End Promot : </div>
                    <div class="col"> <p id="p-end-price"></p> </div>
                </div>
                <div class="row">
                    <div class="col">Created at: </div>
                    <div class="col"> <p id="p-created"></p> </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
</div>

 <div class="modal fade" id="editPromotion" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Edit a Data Promotion</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="" id="form-edtprmt" method="POST" enctype="multipart/form-data">
              {{-- @method('delete') --}}
              @csrf
              <input type="hidden" id="id-promotion" value="">

              <div class="form-group">
                <label for="namepromotion">Name Promotion</label>
                <input type="text" class="form-control" name="name" id="name-promotion" style="color: black">
              </div>

              <div class="form-group">
                <label for="description">Description</label>
                <input type="text" class="form-control" name="description" id="description-promotion" style="color: black">
              </div>

              <div class="form-group">
                <label for="enablepromotion">Toggle Promotion</label>
                <select name="" id="">
                    <option value="">Enable</option>
                    <option value="">Disable</option>
                </select>
              </div>

              <div class="form-group">
                 <label for="pricepromotion">Price</label>
                 <input type="text" name="price" class="form-control" id="price-promotion" style="color: black">
              </div>

              <div class="form-group">
                <label for="startdatepromot">Start Date Promotion</label>
                <input type="date" name="start_date" id="start-promotion">
              </div>

              <div class="form-group">
                <label for="enddatepromot">End Date Promotion</label>
                <input type="date" name="end_date" id="end-promotion">
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

<div class="modal" id="delPrmt" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Delete a Data Promotion</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="container">
              <div class="row">
                <div class="col">
                 <form action="" id="" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id_promotion" id="id-promotion">
                    <input type="hidden" name="" id="token" value="{{ csrf_token() }}">
                    <button id="btn-delete-prmt" class="btn btn-danger">Delete</button>
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

    function fetchShowPromot(id)
    {
        $.ajax({
            type: 'GET',
            url: '/promotions/'+id,
            processdata: false,
            success:function(data){
                console.log(data);
                document.getElementById('p-name').innerHTML = data.name;
                document.getElementById('p-description').innerHTML = data.description;
                document.getElementById('p-enable').innerHTML = data.enable;
                document.getElementById('p-status').innerHTML = data.status;
                document.getElementById('p-price').innerHTML = data.price;
                document.getElementById('p-start-price').innerHTML = data.start_date;
                document.getElementById('p-end-price').innerHTML = data.end_date;
                document.getElementById('p-created').innerHTML = data.created_at;
            }
        });
    }

    function fetchEditPromot(id, name, description, start_date, end_date)
    {
        let namepromotion = name;
        let description = description;
        let startpromotion = start_date;
        let endpromotion = end_date;

        document.getElementById('name-promotion').value = namepromotion;
        document.getElementById('description-promotion').value = description;
        document.getElementById('start-promotion').value = startpromotion;
        document.getElementById('end-promotion').value = endpromotion;

    }

    ("#btn-delete-prmt").click( function(e) {
        e.preventDefault();

        let idrlg = $('#id-promotion').val();

        $.ajax({
            type: 'DELETE',
            enctype: 'multipart/form-data',
            url: '/promotions/',
        });
        // let namerlg = $
    });


</script>

@endsection
