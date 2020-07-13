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
            <li><a href="/"><i class="fas fa-home"></i>Home</a></li>
            <li><a href="#"><i class="fas fa-building"></i>Space</a></li>
            <li><a href="#"><i class="fas fa-address-card"></i>Insurance</a></li>
            <li><a href="#"><i class="fas fa-car-side"></i>Car Rental</a></li>
            <li><a href="#"><i class="fas fa-user"></i>Clients</a></li>
            <li><a href="#"><i class="fas fa-file-contract"></i>Contracts</a></li>
            <li><a href="#"><i class="fas fa-file-invoice"></i>Invoice</a></li>
            <li><a href="#"><i class="fas fa-money-bill"></i>Payment</a></li>
            <li><a href="#"><i class="fas fa-file-pdf"></i>Reports</a></li>
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

        <a href="/insurance_contract_form" class="btn button_color active" style="    background-color: lightgrey;
    padding: 10px;
    margin-left: -16px;
    margin-bottom: 5px;
    margin-top: 4px;" role="button" aria-pressed="true">New Contract</a>
  <br>

  <div class="row justify-content-center">






      <table class="hover table table-striped table-bordered" id="myTable">
        <thead class="thead-dark">
        <tr>
          <th scope="col" style="color:#3490dc;"><center>S/N</center></th>
            <th scope="col" style="color:#3490dc;"><center>Client Name</center></th>
          <th scope="col" style="color:#3490dc;"><center>Vehicle Reg No</center></th>
          <th scope="col" style="color:#3490dc;"><center>Vehicle Use</center></th>
          <th scope="col" style="color:#3490dc;"><center>Principal</center></th>
          <th scope="col"  style="color:#3490dc;"><center>Insurance Type</center></th>
          <th scope="col"  style="color:#3490dc;"><center>Commission Date</center></th>
          <th scope="col"  style="color:#3490dc;"><center>End Date</center></th>
          <th scope="col"  style="color:#3490dc;"><center>Sum Insured</center></th>
          <th scope="col"  style="color:#3490dc;"><center>Premium</center></th>
            <th scope="col"  style="color:#3490dc;"><center>Actual(Excluding VAT) </center></th>
            <th scope="col"  style="color:#3490dc;"><center>Currency </center></th>
            <th scope="col"  style="color:#3490dc;"><center>Commission </center></th>
            <th scope="col"  style="color:#3490dc;"><center>Receipt No </center></th>
          <th scope="col"  style="color:#3490dc;"><center>Action</center></th>
        </tr>
        </thead>
        <tbody>

        @foreach($insurance_contracts as $var)
          <tr>

            <td class="counterCell text-center"></td>
              <td><center>{{$var->full_name}}</center></td>
            <td><center>{{$var->vehicle_registration_no}}</center></td>
            <td><center>{{$var->vehicle_use}}</center></td>
            <td><center>{{$var->principal}}</center></td>
            <td><center>{{$var->insurance_type}}</center></td>
            <td><center>{{$var->commission_date}}</center></td>
            <td><center>{{$var->end_date}}</center></td>
              <td><center>{{$var->sum_insured}}</center></td>
              <td><center>{{$var->premium}}</center></td>
            <td><center>{{$var->actual_ex_vat}}</center></td>
            <td><center>{{$var->currency}}</center></td>
              <td><center>{{$var->commission}}</center></td>
              <td><center>{{$var->receipt_no}}</center></td>
            <td><center>
                    <a data-toggle="modal" data-target="#terminate{{$var->id}}" role="button" aria-pressed="true"><i class="fa fa-trash" aria-hidden="true" style="font-size:30px; color:red;"></i></a>
                    <a href="/edit_insurance_contract/{{$var->id}}" ><i class="fa fa-edit" style="font-size:30px; color: green;"></i></a>

                    <div class="modal fade" id="terminate{{$var->id}}" role="dialog">

                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                        <b><h5 class="modal-title">Are you sure you want to terminate insurance contract for vehicle with registration number {{$var->vehicle_registration_no}}?</h5></b>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>

                                <div class="modal-body">
                                    <form method="get" action="{{ route('terminate_insurance_contract',$var->id)}}" >
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
@endsection
