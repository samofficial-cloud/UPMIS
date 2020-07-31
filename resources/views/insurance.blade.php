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

        <a data-toggle="modal" data-target="#add_insurance" class="btn button_color active" style="    background-color: lightgrey;
    padding: 10px;
    margin-left: -2px;
    margin-bottom: 5px;
    margin-top: 4px;" role="button" aria-pressed="true">New Insurance</a>
  <br>

  <div class="">
    <div class="modal fade" id="add_insurance" role="dialog">

      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <b><h5 class="modal-title">New Insurance Informantion</h5></b>

            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>

          <div class="modal-body">
            <form method="post" action="{{ route('add_insurance')}}"  id="form1" >
              {{csrf_field()}}
              <div class="form-group">
                <div class="form-wrapper">
                  <label for="insurance_company"  ><strong>Insurance Company <span style="color: red;">*</span> </strong></label>
                  <input type="text" class="form-control" id="insurance_company" name="insurance_company" value="" Required autocomplete="off">
                </div>
              </div>
              <br>

              <div class="form-group">
                <div class="form-wrapper">
                  <label for="insurance_type"  ><strong>Insurance Type</strong></label>
                  <select id="insurance_type" class="form-control" name="insurance_type" >
                    <option value="THIRD PARTY" id="Option" >THIRD PARTY</option>
                    <option value="THIRD PARTY" id="Option" >COMPREHENSIVE</option>

                  </select>
                </div>
              </div>
              <br>

              <div class="form-group">
                <div class="form-wrapper">
                  <label for="price"  ><strong>Price</strong></label>
                  <input type="number" min="1" class="form-control" id="price" name="price" value="" required  autocomplete="off">
                </div>
              </div>
              <br>
              <div class="form-group">
                <div class="form-wrapper">
                  <label for="commission"  ><strong>Commission<span style="color: red;"></span></strong></label>
                  <input type="number" min="1" class="form-control" id="commission" name="commission" value="" required autocomplete="off">
                </div>
              </div>
              <br>




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
          <th scope="col" style="color:#3490dc;"><center>Insurance Company</center></th>
          <th scope="col" style="color:#3490dc;"><center>Insurance Type</center></th>
          <th scope="col"  style="color:#3490dc;"><center>Price (TZS)</center></th>
          <th scope="col"  style="color:#3490dc;"><center>Commission (TZS)</center></th>
          <th scope="col"  style="color:#3490dc;"><center>Action</center></th>
        </tr>
        </thead>
        <tbody>

        @foreach($insurance as $var)
          <tr>

            <td class="counterCell text-center"></td>
            <td><center>{{$var->insurance_company}}</center></td>
            <td><center>{{$var->insurance_type}}</center></td>
            <td><center>{{$var->price}}</center></td>
            <td><center>{{$var->commission}}</center></td>
            <td><center><a data-toggle="modal" data-target="#edit_insurance{{$var->id}}" role="button" aria-pressed="true" name="editC"><i class="fa fa-edit" style="font-size:30px; color: green;"></i></a>

                <a data-toggle="modal" data-target="#deactivate{{$var->id}}" role="button" aria-pressed="true"><i class="fa fa-trash" aria-hidden="true" style="font-size:30px; color:red;"></i></a>
                <div class="modal fade" id="edit_insurance{{$var->id}}" role="dialog">

                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <b><h5 class="modal-title">Edit Insurance Informantion</h5></b>

                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                      </div>

                      <div class="modal-body">
                        <form method="post" action="{{ route('edit_insurance',$var->id)}}"  id="form1" >
                          {{csrf_field()}}
                          <div class="form-group">
                            <div class="form-wrapper">
                              <label for="insurance_company"  ><strong>Insurance Company <span style="color: red;">*</span> </strong></label>
                              <input type="text" class="form-control" id="insurance_company" name="insurance_company" value="{{$var->insurance_company}}" Required autocomplete="off">
                            </div>
                          </div>
                          <br>

                          <div class="form-group">
                            <div class="form-wrapper">
                              <label for="insurance_type"  ><strong>Insurance Type</strong></label>
                              <select id="insurance_type" class="form-control" name="insurance_type" >
                                <option value="THIRD PARTY" id="Option" >THIRD PARTY</option>
                                <option value="THIRD PARTY" id="Option" >COMPREHENSIVE</option>
                                <option value=" {{$var->insurance_type}}" id="Option" selected >{{$var->insurance_type}}</option>
                              </select>
                            </div>
                          </div>
                          <br>

                          <div class="form-group">
                            <div class="form-wrapper">
                              <label for="price"  ><strong>Price</strong></label>
                              <input type="number" min="1" class="form-control" id="price" name="price" value="{{$var->price}}" required  autocomplete="off">
                            </div>
                          </div>
                          <br>
                          <div class="form-group">
                            <div class="form-wrapper">
                              <label for="commission"  ><strong>Commission<span style="color: red;"></span></strong></label>
                              <input type="number" min="1" class="form-control" id="commission" name="commission" value="{{$var->commission}}" required autocomplete="off">
                            </div>
                          </div>
                          <br>




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
                        <b><h5 class="modal-title">Are you sure you want to deactivate {{$var->insurance_company}}'s {{$var->insurance_type}} insurance?</h5></b>

                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                      </div>

                      <div class="modal-body">
                        <form method="get" action="{{ route('deactivate_insurance',$var->id)}}" >
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


              </center>
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


<script type="text/javascript">
  var table = $('#myTable').DataTable( {
    dom: '<"top"fl>rt<"bottom"pi>'
  } );

</script>
@endsection
