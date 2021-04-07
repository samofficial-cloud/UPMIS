@extends('layouts.app')

@section('style')
<style type="text/css">
  div.dataTables_filter{
    padding-left:878px;
    padding-bottom:20px;
  }

  div.dataTables_length label {
    font-weight: normal;
    text-align: left;
    white-space: nowrap;
    display: inline-block;
  }

  div.dataTables_length select {
    height:25px;
    width:10px;
    font-size: 70%;
  }
  table.dataTable {
    font-family:"Nunito", sans-serif;
    font-size: 15px;



  }
  table.dataTable.no-footer {
    border-bottom: 0px solid #111;
  }

  hr {
    margin-top: 0rem;
    margin-bottom: 2rem;
    border: 0;
    border-bottom: 2px solid #505559;
  }
  .form-inline .form-control {
    width: 100%;
  }

  .form-wrapper{
    width: 100%
  }

  .form-inline label {
    justify-content: left;
  }
}
</style>

@endsection
@section('content')
<div class="wrapper">
  <?php $a=1; $b=1; $c=1; $d=1;?>
<div class="sidebar">
        <ul style="list-style-type:none;">

            <?php
            $category=DB::table('general_settings')->where('user_roles',Auth::user()->role)->value('category');
            ?>

            @if($category=='All')
           <li class="active_nav_item"><a href="/"><i class="fas fa-home active"></i>Home</a></li>
          @elseif($category=='Insurance only')
          <li><a href="{{ route('home2') }}"><i class="fas fa-home active"></i>Home</a></li>
          @elseif($category=='Real Estate only')
          <li><a href="{{ route('home4') }}"><i class="fas fa-home active"></i>Home</a></li>
          @elseif($category=='Research Flats only')
          <li><a href="{{ route('home6') }}"><i class="fas fa-home active"></i>Home</a></li>
           @endif
          @if(($category=='CPTU only') && (Auth::user()->role!='Vote Holder') && (Auth::user()->role!='Accountant-Cost Centre'))
          <li><a href="{{ route('home3') }}"><i class="fas fa-home active"></i>Home</a></li>
          @endif
          @if(($category=='CPTU only') && (Auth::user()->role=='Vote Holder') && (Auth::user()->role!='Accountant-Cost Centre'))
          <li><a href="{{ route('home5') }}"><i class="fas fa-home active"></i>Home</a></li>
          @endif
          @if(($category=='CPTU only') && (Auth::user()->role!='Vote Holder') && (Auth::user()->role=='Accountant-Cost Centre'))
            <li><a href="{{ route('home5') }}"><i class="fas fa-home active"></i>Home</a></li>
          @endif



                @if((Auth::user()->role!='Vote Holder')&&(Auth::user()->role!='Accountant-Cost Centre'))

                <li><a href="/businesses"><i class="fa fa-building" aria-hidden="true"></i> Businesses</a></li>
                <li><a href={{ route('research_flats') }}><i class="fa fa-building" aria-hidden="true"></i> Research Flats</a></li>
                @else
                @endif


    @if((Auth::user()->role!='Vote Holder')&&(Auth::user()->role!='Accountant-Cost Centre'))

            <li><a href="/clients"><i class="fas fa-user"></i>Clients</a></li>
    @endif
            <li><a href="/contracts_management"><i class="fas fa-file-contract"></i>Contracts</a></li>
            <li><a href="/invoice_management"><i class="fas fa-file-contract"></i>Invoices</a></li>

<li><a href="/payment_management"><i class="fas fa-money-bill"></i>Payments</a></li>
 @if((Auth::user()->role!='Vote Holder')&&(Auth::user()->role!='Accountant-Cost Centre'))
            <li><a href="/reports"><i class="fas fa-file-pdf"></i>Reports</a></li>
  @endif
                @admin
                <li><a href="/user_role_management"><i class="fas fa-user-friends hvr-icon" aria-hidden="true"></i>Manage Users</a></li>
                <li><a href="/system_settings"><i class="fa fa-cog pr-1" aria-hidden="true"></i>System settings</a></li>
                @endadmin
        </ul>
    </div>
<div class="main_content">
  <?php $i = 1?>
  <div class="container" style="max-width: 100%;">
    <br>
     @if ($message = Session::get('errors'))
          <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <p>{{$message}}</p>
          </div>
        @endif

      @if ($message = Session::get('success'))
      <div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <p>{{$message}}</p>
      </div>
    @endif
    <br>
    <a title="Add New Room" data-toggle="modal" data-target="#addroom" class="btn btn-success button_color active" style="
    padding: 10px;
    margin-bottom: 5px;
    margin-top: 4px;" role="button" aria-pressed="true">Add Room</a>

    <div class="modal fade" id="addroom" role="dialog">

        <div class="modal-dialog" role="document">
          <div class="modal-content">
              <div class="modal-header">
                <b><h5 class="modal-title">Fill the form below to add new room</h5></b>

                <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                 <div class="modal-body">
                  <form method="post" action="{{ route('addflat') }}">
                      {{csrf_field()}}

                    <div class="form-group">
                      <div class="form-wrapper">
                        <label for="room_no">Room No.<span style="color: red;">*</span></label>
                        <input type="text" id="room_no" name="room_no" class="form-control" required="" >
                      </div>
                    </div>

                    <div class="form-group">
                      <div class="form-wrapper">
                        <label for="category">Category<span style="color: red;">*</span></label>
                          <select class="form-control" required="" id="category" name="category" required="">
                              <option value=""disabled selected hidden>Select Category</option>
                              <option value="Shared Room">Shared Room</option>
                              <option value="Single Room">Single Room</option>
                              <option value="Suit Room">Suit Room</option>
                          </select>
                      </div>
                    </div>

                    <div class="form-group">
                      <div class="form-wrapper">
                        <label for="currency">Currency<span style="color: red;">*</span></label>
                          <select class="form-control" required="" id="currency" name="currency" required="">
                              <option value=""disabled selected hidden>Select Currency</option>
                              <option value="TZS">TZS</option>
                              <option value="USD">USD</option>
                          </select>
                      </div>
                    </div>

                    <div class="form-group">
                        <div class="form-wrapper">
                            <label for="charge_workers">Charging price for workers<span style="color: red;">*</span></label>
                              <input type="text" id="charge_workers" name="charge_workers" class="form-control" required="" onkeypress="if((this.value.length<15)&&((event.charCode >= 48 && event.charCode <= 57) || (event.charCode==46))){return true} else return false;">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="form-wrapper">
                            <label for="charge_students">Charging price for students<span style="color: red;">*</span></label>
                              <input type="text" id="charge_students" name="charge_students" class="form-control" required="" onkeypress="if((this.value.length<15)&&((event.charCode >= 48 && event.charCode <= 57) || (event.charCode==46))){return true} else return false;">
                        </div>
                    </div>


                    <div align="right">
                      <button class="btn btn-primary" type="submit">Save</button>
                      <button class="btn btn-danger" type="button" class="close" data-dismiss="modal">Cancel</button>
                    </div>

                  </form>
                 </div>
        </div>
      </div>
    </div>


    @if(count($rooms)!=0)
    <br><br>
     <table class="hover table table-striped table-bordered" id="myTable">
        <thead class="thead-dark">
          <tr>
            <th scope="col" style="color:#fff; width: 5%;"><center>S/N</center></th>
            <th scope="col" style="color:#fff;"><center>Room No.</center></th>
            <th scope="col" style="color:#fff;"><center>Category</center></th>
            <th scope="col" style="color:#fff;"><center>Currency</center></th>
            <th scope="col" style="color:#fff; width: 20%;"><center>Charging price for workers</center></th>
            <th scope="col" style="color:#fff;width: 20%;"><center>Charging price for students</center></th>
            <th scope="col" style="color:#fff;"><center>Action</center></th>
          </tr>
        </thead>
      <tbody>
        @foreach($rooms as $room)
          <tr>
            <td style="text-align: center;">{{$i}}.</td>
            <td>{{$room->room_no}}</td>
            <td>{{$room->category}}</td>
            <td><center>{{$room->currency}}</center></td>
            <td style="text-align: right;">{{number_format($room->charge_workers)}}</td>
            <td style="text-align: right;">{{number_format($room->charge_students)}}</td>
            <td>
              <a title="Edit Room Details" data-toggle="modal" data-target="#editroom{{$room->id}}" role="button" aria-pressed="true"><i class="fa fa-edit" style="font-size:20px; color: green; cursor: pointer;"></i></a>
              <div class="modal fade" id="editroom{{$room->id}}" role="dialog">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                        <b><h5 class="modal-title">Fill the form below to edit room details</h5></b>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                 <div class="modal-body">
                  <form method="post" action="{{ route('editflat') }}">
                    {{csrf_field()}}
                    <div class="form-group">
                      <div class="form-wrapper">
                        <label for="room_no{{$room->id}}">Room No.<span style="color: red;">*</span></label>
                        <input type="text" id="room_no{{$room->id}}" name="room_no" class="form-control" required="" value="{{$room->room_no}}">
                      </div>
                    </div>
                    <br>
                    <div class="form-group">
                      <div class="form-wrapper">
                        <label for="category{{$room->id}}">Category<span style="color: red;">*</span></label>
                          <select class="form-control" required="" id="category{{$room->id}}" name="category" required="">
                              <option value="{{$room->category}}">{{$room->category}}</option>
                              @if($room->category!='Shared Room')
                                <option value="Shared Room">Shared Room</option>
                              @endif
                              @if($room->category!='Single Room')
                                <option value="Single Room">Single Room</option>
                              @endif
                              @if($room->category!='Suit Room')
                                <option value="Suit Room">Suit Room</option>
                              @endif
                          </select>
                      </div>
                    </div>
                    <br>
                    <div class="form-group">
                      <div class="form-wrapper">
                        <label for="currency{{$room->id}}">Currency<span style="color: red;">*</span></label>
                          <select class="form-control" required="" id="currency{{$room->id}}" name="currency" required="">
                              <option value="{{$room->currency}}">{{$room->currency}}</option>
                                @if($room->currency!='TZS')
                                  <option value="TZS">TZS</option>
                                @endif
                                @if($room->currency!='USD')
                                  <option value="USD">USD</option>
                                @endif
                          </select>
                      </div>
                    </div>
                    <br>
                    <div class="form-group">
                        <div class="form-wrapper">
                            <label for="charge_workers{{$room->id}}">Charging price for workers<span style="color: red;">*</span></label>
                              <input type="text" id="charge_workers{{$room->id}}" name="charge_workers" class="form-control" required="" value="{{$room->charge_workers}}" onkeypress="if((this.value.length<15)&&((event.charCode >= 48 && event.charCode <= 57) || (event.charCode==46))){return true} else return false;">
                        </div>
                    </div>
                    <br>
                    <div class="form-group">
                        <div class="form-wrapper">
                            <label for="charge_students{{$room->id}}">Charging price for students<span style="color: red;">*</span></label>
                              <input type="text" id="charge_students{{$room->id}}" name="charge_students" class="form-control" required="" value="{{$room->charge_students}}" onkeypress="if((this.value.length<15)&&((event.charCode >= 48 && event.charCode <= 57) || (event.charCode==46))){return true} else return false;">
                        </div>
                    </div>
                    <br>
                    <input type="text" name="room_id" value="{{$room->id}}" hidden="">
                    <div align="right">
                      <button class="btn btn-primary" type="submit">Save</button>
                      <button class="btn btn-danger" type="button" class="close" data-dismiss="modal">Cancel</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
               <a title="Delete this room" data-toggle="modal" data-target="#Deleteroom{{$room->id}}" role="button" aria-pressed="true"><i class="fa fa-trash" aria-hidden="true" style="font-size:20px; color:red; cursor: pointer;"></i></a>

        <div class="modal fade" id="Deleteroom{{$room->id}}" role="dialog">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <b><h5 class="modal-title" style="color: red;"><b>WARNING</b></h5></b>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>

           <div class="modal-body">
            <p style="font-size: 20px;">Are you sure you want to delete {{$room->room_no}}?</p>
            <br>
            <div align="right">
                <a class="btn btn-info" href="{{route('deleteflat',$room->id)}}">Proceed</a>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            </div>

</div>
</div>
</div>
</div>
            </td>
          </tr>
          <?php $i = $i + 1; ?>
          @endforeach
      </tbody>
  </table>
  @else
    <br><br>
    <p style="font-size: 18px;">No room has been added yet.</p>
  @endif



</div>
  

</div>
</div>
@endsection

@section('pagescript')
<script type="text/javascript">
  $(document).ready(function(){
    var table = $('#myTable').DataTable({
        dom: '<"top"fl><"top"<"pull-right">>rt<"bottom"pi>'
    });
  });
</script>
@endsection