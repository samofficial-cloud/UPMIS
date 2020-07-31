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
    font-family: "Nunito", sans-serif;
    font-size: 15px;



  }
  table.dataTable.no-footer {
    border-bottom: 0px solid #111;
  }

  hr {
    margin-top: 0rem;
    margin-bottom: 2rem;
    border: 0;
    border: 2px solid #505559;
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
</style>

@endsection

@section('content')
<div class="wrapper">
<div class="sidebar">
        <ul style="list-style-type:none;">

            <li><a href="/"><i class="fas fa-home active"></i>Home</a></li>

            <li><a href="/Space"><i class="fas fa-building"></i>Space</a></li>
            <li><a href="/insurance"><i class="fas fa-address-card"></i>Insurance</a></li>
            <li><a href="/car"><i class="fas fa-car-side"></i>Car Rental</a></li>
            <li><a href="/clients"><i class="fas fa-user"></i>Clients</a></li>
            <div class="dropdown">
  <li class="dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
   <i class="fas fa-file-contract"></i> Contracts
  </li>
  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
    <a class="dropdown-item" href="/contracts/car_rental">Car Rental</a>
    <a class="dropdown-item" href="/insurance_contracts_management">Insurance</a>
    <a class="dropdown-item" href="/space_contracts_management">Space</a>
  </div>
</div>
<div class="dropdown">
  <li class="dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    <i class="fas fa-file-contract"></i> Invoices
  </li>
  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
    <a class="dropdown-item" href="/invoice_management">Space</a>
    <a class="dropdown-item" href="/car_rental_invoice_management">Car Rental</a>
    <a class="dropdown-item" href="/insurance_invoice_management">Insurance</a>
  </div>
</div>
<li><a href="/payment_management"><i class="fas fa-money-bill"></i>Payment</a></li>
            <li><a href="/reports"><i class="fas fa-file-pdf"></i>Reports</a></li>
        </ul>
    </div>

    <div class="main_content">
      <div class="container " style="max-width: 1308px;">
        @if ($message = Session::get('success'))
          <div class="alert alert-success row col-xs-12" style="margin-left: -13px;
    margin-bottom: -1px;
    margin-top: 4px;">
            <p>{{$message}}</p>
          </div>
        @endif

        <a data-toggle="modal" data-target="#space" class="btn button_color active" style="    background-color: lightgrey;
    padding: 10px;
    margin-left: -2px;
    margin-bottom: 5px;
    margin-top: 4px;" role="button" aria-pressed="true">Add New Space</a>
  <br>

  <div class="">
      <div class="modal fade" id="space" role="dialog">

              <div class="modal-dialog" role="document">
          <div class="modal-content">
              <div class="modal-header">
                <b><h5 class="modal-title">Add New Renting Space</h5></b>

                <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                 <div class="modal-body">

                   <form method="post" action="{{ route('add_space')}}"  id="form1" >
                     {{csrf_field()}}
                     <div class="form-group">
                       <div class="form-wrapper">
                         <label for="course_name"  ><strong>Space Id <span style="color: red;">*</span> </strong></label>
                         <input type="text" class="form-control" id="course_name" name="space_id" value="" Required autocomplete="off">
                       </div>
                     </div>
                     <br>

                     <div class="form-group">
                       <div class="form-wrapper">
                         <label for="space_type"  ><strong>Type</strong></label>
                         <select id="space_type" class="form-control" name="space_type" >

                           <option value="Mall-shop" id="Option" >Mall-shop</option>
                           <option value="Villa" id="Option">Villa</option>
                           <option value="Office block" id="Option">Office block</option>
                           <option value="Cafeteria" id="Option">Cafeteria</option>
                           <option value="Stationery" id="Option">Stationery</option>
                         </select>
                       </div>
                     </div>
                     <br>

                     <div class="form-group">
                       <div class="form-wrapper">
                         <label for="space_location"  ><strong>Location</strong></label>
                         <select class="form-control" id="space_location" name="space_location" >
                           <option value="Mlimani City" id="Option" >Mlimani City</option>
                           <option value="UDSM Main Campus" id="Option">UDSM Main Campus</option>
                         </select>
                       </div>
                     </div>
                     <br>
                     <div class="form-group">
                       <div class="form-wrapper">
                         <label for="course_name"  ><strong>Size (SQM) <span style="color: red;"></span></strong></label>
                         <input type="number" min="1" class="form-control" id="course_name" name="space_size" value=""  autocomplete="off">
                       </div>
                     </div>
                     <br>

                     <div class="form-group">
                       <div class="form-wrapper">
                         <label for="rent_price_guide_checkbox" style="display: inline-block;"><strong>Rent Price Guide</strong></label>
                         <input type="checkbox"  style="display: inline-block;" value="rent_price_guide_selected" id="rent_price_guide_checkbox" name="rent_price_guide_checkbox" autocomplete="off">
                         <div  id="rent_price_guide_div" style="display: none;" class="form-group row">

                         <div class="col-4 inline_block form-wrapper">
                           <label  for="rent_price_guide_from" class=" col-form-label">From:</label>
                           <div class="">
                             <input type="number" min="1" class="form-control" id="rent_price_guide_from" name="rent_price_guide_from" value=""  autocomplete="off">
                           </div>
                         </div>

                         <div class="col-4 inline_block form-wrapper">
                           <label  for="rent_price_guide_to" class=" col-form-label">To:</label>
                           <div  class="">
                             <input type="number" min="1" class="form-control" id="rent_price_guide_to" name="rent_price_guide_to" value=""  autocomplete="off">
                           </div>
                         </div>


                         <div class="col-3 inline_block form-wrapper">
                           <label  for="rent_price_guide_currency" class="col-form-label">Currency:</label>
                           <div  class="">
                             <select id="rent_price_guide_currency" class="form-control" name="rent_price_guide_currency" >
                               <option value=""></option>
                               <option value="TZS" >TZS</option>
                               <option value="USD" >USD</option>
                             </select>
                           </div>

                         </div>

                         </div>




                       </div>
                     </div>


                     <div align="right">
                       <button class="btn btn-primary" type="submit">Submit</button>
                       <button class="btn btn-danger" type="button" class="close" data-dismiss="modal">Cancel</button>
                     </div>
                   </form>









      </div>
      </div>
      </div>


    </div>





      <table class="hover table table-striped table-bordered" id="myTable">
        <thead class="thead-dark">
        <tr>
          <th scope="col" style="color:#3490dc;"><center>S/N</center></th>
          <th scope="col" style="color:#3490dc;"><center>Space Id</center></th>
          <th scope="col" style="color:#3490dc;"><center>Type</center></th>
          <th scope="col"  style="color:#3490dc;"><center>Location</center></th>
          <th scope="col"  style="color:#3490dc;"><center>Size (SQM)</center></th>
          <th scope="col"  style="color:#3490dc;"><center>Rent Price Guide</center></th>
          <th scope="col"  style="color:#3490dc;"><center>Action</center></th>
        </tr>
        </thead>
        <tbody>

        @foreach($spaces as $var)
          <tr>

            <td class="counterCell text-center"></td>
            <td><center>{{$var->space_id}}</center></td>
            <td><center>{{$var->space_type}}</center></td>
            <td><center>{{$var->location}}</center></td>

            <td><center>  @if($var->size==null)
                  N/A
                @else
                  {{$var->size}}
                            @endif

              </center></td>
            <td><center>

                @if($var->rent_price_guide_from==null)
                  N/A
                @else
                  {{$var->rent_price_guide_from}} - {{$var->rent_price_guide_to}} {{$var->rent_price_guide_currency}}
                @endif

                </center></td>
            <td>


              <a data-toggle="modal" data-target="#edit_space{{$var->id}}" onclick="trigger_click({{$var->id}});" role="button" aria-pressed="true" name="editC"><i class="fa fa-edit" style="font-size:30px; color: green;"></i></a>

                <a data-toggle="modal" data-target="#deactivate{{$var->id}}" role="button" aria-pressed="true"><i class="fa fa-trash" aria-hidden="true" style="font-size:30px; color:red;"></i></a>
                <div class="modal fade" id="edit_space{{$var->id}}" role="dialog">

                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <b><h5 class="modal-title">Edit Renting Space Information</h5></b>

                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                      </div>

                      <div class="modal-body">
                        <form method="post" action="{{ route('edit_space',$var->id)}}"  id="form1" >
                          {{csrf_field()}}
                          <div class="form-group">
                            <div class="form-wrapper">
                              <label for="course_name"  ><strong>Space Id <span style="color: red;">*</span> </strong></label>
                              <input type="text" class="form-control" id="course_name" name="space_id" value="{{$var->space_id}}" Required autocomplete="off">
                            </div>
                          </div>
                          <br>

                          <div class="form-group">
                            <div class="form-wrapper">
                              <label for="space_type"  ><strong>Type</strong></label>
                              <select id="space_type" class="form-control" name="space_type" >

                                <option value=" {{$var->space_type}}" id="Option" >{{$var->space_type}}</option>
                                <option value="Mall-shop" id="Option" >Mall-shop</option>
                                <option value="Villa" id="Option">Villa</option>
                                <option value="Office block" id="Option">Office block</option>
                                <option value="Cafeteria" id="Option">Cafeteria</option>
                                <option value="Stationery" id="Option">Stationery</option>
                              </select>
                            </div>
                          </div>
                          <br>

                          <div class="form-group">
                            <div class="form-wrapper">
                              <label for="space_location"  ><strong>Location</strong></label>
                              <select class="form-control" id="space_location" name="space_location" >
                                <option value="{{$var->location}}" id="Option" >{{$var->location}}</option>
                                <option value="Mlimani City" id="Option" >Mlimani City</option>
                                <option value="UDSM Main Campus" id="Option">UDSM Main Campus</option>
                              </select>
                            </div>
                          </div>
                          <br>
                          <div class="form-group">
                            <div class="form-wrapper">
                              <label for="course_name"  ><strong>Size (SQM) <span style="color: red;"></span></strong></label>
                              <input type="number" min="1" class="form-control" id="course_name" name="space_size" value="{{$var->size}}"  autocomplete="off">
                            </div>
                          </div>
                          <br>


                          <div class="form-group">
                            <div class="form-wrapper">
                              <label for="rent_price_guide_checkbox_edit" style="display: inline-block;"><strong>Rent Price Guide</strong></label>
                              @if($var->rent_price_guide_checkbox==0)
                              <input type="checkbox"  style="display: inline-block;" onclick="checkbox({{$var->id}});"  id="rent_price_guide_checkbox_edit_zero{{$var->id}}" name="rent_price_guide_checkbox" value="rent_price_guide_selected_edit"  autocomplete="off">
                              @else
                                <input type="checkbox" checked style="display: inline-block;"  onclick="checkbox({{$var->id}});" id="rent_price_guide_checkbox_edit_one{{$var->id}}" name="rent_price_guide_checkbox"  value="rent_price_guide_selected_edit"  autocomplete="off">
                              @endif
                              <div  id="rent_price_guide_div_edit{{$var->id}}" style="display: none;" class="form-group row">

                                <div class="col-4 inline_block form-wrapper">
                                  <label  for="rent_price_guide_from" class=" col-form-label">From:</label>
                                  <div class="">
                                    <input type="number" min="1" class="form-control" id="rent_price_guide_from_edit{{$var->id}}" name="rent_price_guide_from" value="{{$var->rent_price_guide_from}}"  autocomplete="off">
                                  </div>
                                </div>

                                <div class="col-4 inline_block  form-wrapper">
                                  <label  for="rent_price_guide_to" class=" col-form-label">To:</label>
                                  <div  class="">
                                    <input type="number" min="1" class="form-control" id="rent_price_guide_to_edit{{$var->id}}" name="rent_price_guide_to" value="{{$var->rent_price_guide_to}}"  autocomplete="off">
                                  </div>
                                </div>


                                <div class="col-3 inline_block  form-wrapper">
                                  <label  for="rent_price_guide_currency" class="col-form-label">Currency:</label>
                                  <div  class="">
                                    <select id="rent_price_guide_currency_edit{{$var->id}}" class="form-control" name="rent_price_guide_currency" >
                                      <option value="" ></option>
                                      <option value="TZS" >TZS</option>
                                      <option value="USD" >USD</option>
                                      <option value="{{$var->rent_price_guide_currency}}" selected>{{$var->rent_price_guide_currency}}</option>
                                    </select>
                                  </div>

                                </div>

                              </div>




                            </div>
                          </div>

                          <div align="right">
                            <button class="btn btn-primary" type="submit">Submit</button>
                            <button class="btn btn-danger" type="button" class="close" data-dismiss="modal">Cancel</button>
                          </div>
                        </form>


                      </div>
                    </div>
                  </div>


                </div>



                <div class="modal fade" id="deactivate{{$var->id}}" role="dialog">

                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <b><h5 class="modal-title">Are you sure you want to delete the space with space id {{$var->space_id}}?</h5></b>

                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                      </div>

                      <div class="modal-body">
                        <form method="get" action="{{ route('delete_space',$var->id)}}" >
                          {{csrf_field()}}



                          <div align="right">
                            <button class="btn btn-primary" type="submit" id="newdata">Yes</button>
                            <button class="btn btn-danger" type="button" class="close" data-dismiss="modal">No</button>
                          </div>


                        </form>
                      </div>
                    </div>
                  </div>


                </div>



            </td>
          </tr>
        @endforeach





        </tbody>
      </table>

      </div>
    </div>
  </div>
</div>
</div>
@endsection

@section('pagescript')
<script>




  $("#rent_price_guide_checkbox").trigger('change');

  $('#rent_price_guide_checkbox').change(function(){

      if( $('#rent_price_guide_checkbox').prop('checked') ){

        document.getElementById("rent_price_guide_div").style.display = "block";

      } else {
        document.getElementById("rent_price_guide_div").style.display = "none";

        var input_from = document.getElementById("rent_price_guide_from");
        input_from.value = "";

        var input_to = document.getElementById("rent_price_guide_to");
        input_to.value = "";

      }


  });







  function checkbox(id) {
    //for edit case checkbox not selected
    $("#rent_price_guide_checkbox_edit_zero"+id).trigger('change');

    $('#rent_price_guide_checkbox_edit_zero'+id).change(function () {

      if ($('#rent_price_guide_checkbox_edit_zero'+id).prop('checked')) {
        document.getElementById("rent_price_guide_div_edit"+id).style.display = "block";

      } else {
        document.getElementById("rent_price_guide_div_edit"+id).style.display = "none";

        var input_from = document.getElementById("rent_price_guide_from_edit"+id);
        input_from.value = "";

        var input_to = document.getElementById("rent_price_guide_to_edit"+id);
        input_to.value = "";

        var input_currency_edit = document.getElementById("rent_price_guide_currency_edit"+id);
        input_currency_edit.value = "";



      }


    });

    //for edit case checkbox selected
    $("#rent_price_guide_checkbox_edit_one"+id).trigger('change');

    $('#rent_price_guide_checkbox_edit_one'+id).change(function () {

      if ($('#rent_price_guide_checkbox_edit_one'+id).prop('checked')) {
        document.getElementById("rent_price_guide_div_edit"+id).style.display = "block";


      } else {
        document.getElementById("rent_price_guide_div_edit"+id).style.display = "none";

        var input_from = document.getElementById("rent_price_guide_from_edit"+id);
        input_from.value = "";

        var input_to = document.getElementById("rent_price_guide_to_edit"+id);
        input_to.value = "";

        var input_currency_edit = document.getElementById("rent_price_guide_currency_edit"+id);
        input_currency_edit.value = "";


      }


    });

  }
</script>


<script type="text/javascript">
  var table = $('#myTable').DataTable( {
    dom: '<"top"fl>rt<"bottom"pi>'
  } );

</script>


@endsection
