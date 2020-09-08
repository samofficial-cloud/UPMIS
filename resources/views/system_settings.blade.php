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
            <li><a href="/contracts_management"><i class="fas fa-file-contract"></i>Contracts</a></li>
            <li><a href="/invoice_management"><i class="fas fa-file-contract"></i>Invoices</a></li>

<li><a href="/payment_management"><i class="fas fa-money-bill"></i>Payment</a></li>
            <li><a href="/reports"><i class="fas fa-file-pdf"></i>Reports</a></li>
@admin
            <li><a href="/system_settings"><i class="fa fa-cog pr-1" aria-hidden="true"></i>System settings</a></li>
          @endadmin
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

          @if (session('error'))
            <div class="alert alert-danger">
              {{ session('error') }}
              <br>
            </div>
          @endif

<p class="mt-1" style="  font-size:30px !important;"> System Settings</p>
          <hr style="margin-bottom: 7px; border-bottom: 1px solid #e5e5e5 !important;">


          <div class="row">



            <div style="    padding-left: 7px; padding-right: 7px;" class="col-xl-4 col-lg-4 col-md-4 mt-2 col-sm-12">
              <a style="width: 100% !important; text-decoration:none;"  href="#" class="hvr-icon-wobble-horizontal">
                <div class="card " style="flex-direction: row; padding: 9%; color:black;">
                  <div  style="padding-right: 22%;"> <h3 >REAL ESTATE</h3>

                  </div>     <div  ><i class="fas fa-building hvr-icon" style="font-size: 50px;" aria-hidden="true"></i></div>

                </div>
              </a>

            </div>


            <div style="    padding-left: 7px; padding-right: 7px;" class="col-xl-4 col-lg-4 col-md-4 mt-2 col-sm-12">
              <a style="width: 100% !important; text-decoration:none;" href="#" class="hvr-icon-wobble-horizontal">
                <div class="card " style="flex-direction: row; padding: 9%; color:black;">
                  <div  style="padding-right: 22%;"> <h3 >INSURANCE</h3>

                  </div>     <div  ><i class="fas fa-address-card hvr-icon" style="font-size: 50px;" aria-hidden="true"></i></div>

                </div>
              </a>

            </div>


            <div style=" padding-left: 7px; padding-right: 7px;" class="col-xl-4 col-lg-4 col-md-4 mt-2 col-sm-12">
              <a style="width: 100% !important; text-decoration:none;" href="#" class="hvr-icon-wobble-horizontal">
                <div class="card " style="flex-direction: row; padding: 9%; color:black;">
                  <div  style="padding-right: 22%;"> <h3 >CAR RENTAL</h3>

                  </div>     <div  ><i class="fas fa-car-side hvr-icon" style="font-size: 50px;" aria-hidden="true"></i></div>

                </div>
              </a>

            </div>


            <div style="    padding-left: 7px; padding-right: 7px;" class="col-xl-4 col-lg-4 col-md-4 mt-2 col-sm-12">
              <a style="width: 100% !important; text-decoration:none;" href="#" class="hvr-icon-wobble-horizontal">
                <div class="card " style="flex-direction: row; padding: 9%; color:black;">
                  <div  style="padding-right: 22%;"> <h3 >CAR RENTAL</h3>

                  </div>     <div  ><i class="fas fa-car-side hvr-icon" style="font-size: 50px;" aria-hidden="true"></i></div>

                </div>
              </a>

            </div>


            <div style="    padding-left: 7px; padding-right: 7px;" class="col-xl-4 col-lg-4 col-md-4 mt-2 col-sm-12">
              <a style="width: 100% !important; text-decoration:none;" href="#" class="hvr-icon-wobble-horizontal">
                <div class="card " style="flex-direction: row; padding: 9%; color:black;">
                  <div  style="padding-right: 22%;"> <h3 >CLIENTS</h3>

                  </div>     <div  ><i class="fas fa-user-tie hvr-icon" style="font-size: 50px;" aria-hidden="true"></i></div>

                </div>
              </a>

            </div>


            <div style="    padding-left: 7px; padding-right: 7px;" class="col-xl-4 col-lg-4 col-md-4 mt-2  col-sm-12">
              <a style="width: 100% !important; text-decoration:none;" href="#" class="hvr-icon-wobble-horizontal">
                <div class="card " style="flex-direction: row; padding: 9%; color:black;">
                  <div  style="padding-right: 22%;"> <h3 >REPORTS</h3>

                  </div>     <div  ><i class="fas fa-file-pdf hvr-icon" style="font-size: 50px;" aria-hidden="true"></i></div>

                </div>
              </a>

            </div>



            <div style="    padding-left: 7px; padding-right: 7px;" class="col-xl-4 col-lg-4 col-md-4 mt-2 col-sm-12">
              <a style="width: 100% !important; text-decoration:none;" href="/user_role_management" class="hvr-icon-wobble-horizontal">
                <div class="card " style="flex-direction: row; padding: 9%; color:black;">
                  <div  > <h3 >USERS AND ROLE MANAGEMENT</h3>

                  </div>     <div  ><i class="fas fa-user-friends hvr-icon" style="font-size: 50px;" aria-hidden="true"></i></div>

                </div>
              </a>

            </div>

          </div>

    </div>
  </div>
</div>
</div>
@endsection

@section('pagescript')




@endsection
