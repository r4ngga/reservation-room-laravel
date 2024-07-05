@extends('template/main_dashboard')

@section('title','Confirmation Reservation Room')
@section('container')
<div >
    <div class="container mt-4 mb-4">
        <div class="row">
            @if(session('notify'))
                <div class="alert alert-success my-2" role="alert">
                    {{session('notify')}}
                </div>
             @endif
        </div>
        <div class="row">
            <div class="col">
                <h4>Confirmation Payment Guest</h4>
                <table class="table">
                    <thead>
                        <tr>
                        <th scope="col">Code Reservation</th>
                        <th scope="col">Room Number</th>
                        <th scope="col">Name Guest</th>
                        <th scope="col">Class</th>
                        <th scope="col">Time Booking</th>
                        <th scope="col">Price</th>
                        <th scope="col">Status Payment</th>
                        <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($reservations as $rsv)
                            <tr>
                                <td>{{$rsv->code_reservation ?? ''}}</td>
                                <td>{{$rsv->number_room ?? ''}}</td>
                                <td>{{$rsv->name ?? ''}}</td>
                                <td>{{$rsv->class ?? ''}}</td>
                                <td>{{$rsv->time_booking ?? ''}}</td>
                                <td>{{$rsv->payment ?? ''}}</td>
                                <td>{{$rsv->status_payment ?? ''}}</td>
                                <td>
                                    @if($rsv->status_payment == 0 || $rsv->status_payment == "0")
                                    <a href="#ShowConfirmation" onclick="showConfirmation({{$rsv->number_reservation ?? ''}}, {{$rsv->code_reservation ?? ''}}, {{$rsv->number_room ?? ''}}, {{$rsv->status_payment ?? ''}})" data-toggle="modal" data-target="#ShowConfirmation" class="btn btn-success">Confirmation</a>
                                    @else
                                    Payment has valid
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- @foreach($reservations as $rsv) --}}
<div class="modal fade" id="ShowConfirmation" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Confirmation Payment</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <p>
                This guest pay bill when check in ? <br>

              </p>
              <form action="/confirmpaymentroom" method="POST">
                  @csrf
                  <div class="form-group" hidden>
                    <label for="numberreservation">Number Reservation</label>
                    <input type="text" class="form-control" name="number_reservation" id="number_reservation" value="">
                  </div>
                  <div class="form-group" hidden>
                    <label for="codereservation">Code Reservation</label>
                    <input type="text" class="form-control" name="code_reservation" id="code_reservation" value="">
                  </div>
                  <div class="form-group" hidden>
                     <label for="numberroom">Room Number</label>
                     <input type="text" class="form-control" name="number_room" id="number_room" value="">
                  </div>
                  <div class="form-group" hidden>
                    <label for="statuspayment">Status Payment</label>
                    <input type="text" class="form-control" name="status_payment" id="status_payment" value="">
                  </div>
                  <div class="form-group">

                  </div>
                  <div class="form-group">
                    <button type="submit" id="btn-confrm-pymnt" class="btn btn-success">Yes</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                  </div>
              </form>
            </div>
            {{-- <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div> --}}
        </div>
    </div>
</div>
{{-- @endforeach --}}

@endsection

@section('scripts')
<script type="text/javascript">
  function showConfirmation(number_reservation, code_reservation, number_room, status_payment)
  {
    let number_rsv = number_reservation;
    let code_rsv = code_reservation;
    let number_rm = number_room;
    let status_pymnt = status_payment;
    console.log(number_rsv, code_rsv, number_rm, status_pymnt);
    document.getElementById('number_reservation').value = number_rsv;
    document.getElementById('code_reservation').value = code_rsv;
    document.getElementById('number_room').value = number_rm;
    document.getElementById('status_payment').value = status_pymnt;
  }
</script>

@endsection
