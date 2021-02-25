@extends('layouts.app')

@section('style')
<style type="text/css">
  #msform {
    text-align: center;
    position: relative;
    margin-top: 20px
}

#msform fieldset .form-card {
    background: white;
    border: 0 none;
    border-radius: 0px;
    box-shadow: 0 2px 2px 2px rgba(0, 0, 0, 0.2);
    padding: 20px 40px 30px 40px;
    box-sizing: border-box;
    width: 94%;
    margin: 0 3% 20px 3%;
    position: relative
}

#msform fieldset {
    background: white;
    border: 0 none;
    border-radius: 0.5rem;
    box-sizing: border-box;
    width: 100%;
    margin: 0;
    padding-bottom: 20px;
    position: relative
}

#msform fieldset:not(:first-of-type) {
    display: none
}

#msform fieldset .form-card {
    text-align: left;
    color: #9E9E9E
}

#msform input,
#msform textarea {
    padding: 0px 8px 4px 8px;
    border: none;
    border-bottom: 1px solid #ccc;
    border-radius: 0px;
    margin-bottom: 25px;
    margin-top: 2px;
    width: 100%;
    box-sizing: border-box;
    /*font-family: montserrat;*/
    color: #2C3E50;
    font-size: 16px;
    letter-spacing: 1px
}

#msform input[type=checkbox]{
  width: 30%;
  float: left;
  margin-bottom: 0px;
}

#msform input[type=radio]{
  width: 30%;
  float: left;
  margin-bottom: 0px;
}

#msform input:focus,
#msform textarea:focus {
    -moz-box-shadow: none !important;
    -webkit-box-shadow: none !important;
    box-shadow: none !important;
    border: none;
    font-weight: bold;
    border-bottom: 2px solid skyblue;
    outline-width: 0
}

#msform .action-button {
    width: 100px;
    background: skyblue;
    font-weight: bold;
    color: white;
    border: 0 none;
    border-radius: 0px;
    cursor: pointer;
    padding: 10px 5px;
    margin: 10px 5px
}

#msform .action-button:hover,
#msform .action-button:focus {
    box-shadow: 0 0 0 2px white, 0 0 0 3px skyblue
}

select.list-dt {
    border: none;
    outline: 0;
    border-bottom: 1px solid #ccc;
    padding: 2px 5px 3px 5px;
    margin: 2px
}

select.list-dt:focus {
    border-bottom: 2px solid skyblue
}

.card {
    z-index: 0;
    border: none;
    border-radius: 0.5rem;
    position: relative
}

</style>

@endsection

@section('content')
<?php
$current=date('Y');
$year=$current-3;
    use App\hire_rate;
    use App\carRental;
    use App\space;
      $model= hire_rate::select('vehicle_model')->get();
      $sp_industry= DB::table('space_classification')->select('major_industry')->distinct()->orderBy('major_industry','asc')->get();
      $ay=0;
      $spacesids= [];
    ?>
<div class="wrapper">
<div class="sidebar">
        <ul style="list-style-type:none;">

            <?php
            $category=DB::table('general_settings')->where('user_roles',Auth::user()->role)->value('category');
            ?>

            @if($category=='All')
           <li><a href="/"><i class="fas fa-home active"></i>Home</a></li>
          @elseif($category=='Insurance only')
          <li><a href="{{ route('home2') }}"><i class="fas fa-home active"></i>Home</a></li>
          @elseif($category=='Real Estate only')
          <li><a href="{{ route('home4') }}"><i class="fas fa-home active"></i>Home</a></li>
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
                @else
                @endif
    @if((Auth::user()->role!='Vote Holder')&&(Auth::user()->role!='Accountant-Cost Centre'))

            <li><a href="/clients"><i class="fas fa-user"></i>Clients</a></li>
    @endif
            <li><a href="/contracts_management"><i class="fas fa-file-contract"></i>Contracts</a></li>
            <li><a href="/invoice_management"><i class="fas fa-file-contract"></i>Invoices</a></li>

<li><a href="/payment_management"><i class="fas fa-money-bill"></i>Payments</a></li>
 @if((Auth::user()->role!='Vote Holder')&&(Auth::user()->role!='Accountant-Cost Centre'))
            <li class="active_nav_item"><a href="/reports"><i class="fas fa-file-pdf"></i>Reports</a></li>
  @endif
@admin
            <li><a href="/user_role_management"><i class="fas fa-user-friends hvr-icon" aria-hidden="true"></i>Manage Users</a></li>
<li><a href="/system_settings"><i class="fa fa-cog pr-1" aria-hidden="true"></i>System settings</a></li>
          @endadmin
        </ul>
    </div>
<div class="main_content">
<div class="container-fluid" id="grad1">
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
    <div class="row justify-content-center mt-0">
        <div class="col-12 col-sm-9 col-md-7 col-lg-9 text-center p-0 mt-3 mb-2">
            <div class="card px-0 pt-4 pb-0 mt-3 mb-3">
                <h2><strong>Report Generation</strong></h2>
                <div class="row">
                    <div class="col-md-12 mx-0">
                        <form id="msform" method="post" action="#">
                            {{csrf_field()}}

                             <!-- fieldsets -->
                            <fieldset>
                                <div class="form-card">
                          <div class="form-group" id="modulediv">
          <div class="form-wrapper" >
          <label for="module">Module<span style="color: red;">*</span></label>
            <select class="form-control" required="" id="module" name="module">
              <option value="" disabled selected hidden>Select Module</option>
              @if ($category=='CPTU only' OR $category=='All')
              <option value="car">Car Rental Module</option>
              @endif
              <option value="contract">Contracts Module</option>
              @if ($category=='Insurance only' OR $category=='All')
              <option value="insurance">Insurance Module</option>
              @endif
              <option value="invoice">Invoice and Payment Module</option>
              {{-- <option value="payment">Payments Module</option> --}}
              @if ($category=='Research Flats only' OR $category=='All')
              <option value="research_flats">Research Flats</option>
              @endif
              @if ($category=='Real Estate only' OR $category=='All')
              <option value="space">Space Module</option>
              <option value="tenant">Tenants Module</option>
              @endif
              @if ($category=='All')
              <option value="system">System Settings</option>
              @endif

            </select>
        </div>
    </div>

    <div class="form-group" id="spacetypediv" style="display: none;">
          <div class="form-wrapper">
          <label for="major_industry">Select Report Type<span style="color: red;">*</span></label>
          <span id="spacetypemsg"></span>
            <select class="form-control" id="major_industry" name="major_industry">
              <option value=" " disabled selected hidden>Select Report Type</option>
              <option value="list">List of Spaces</option>
              <option value="history">Space History</option>
            </select>
        </div>
    </div>


      <div class="form-group" id="spacefilterdiv" style="display: none;">
        <div class="form-wrapper">
      <label for="space_filter" style=" display: inline-block; white-space: nowrap;">Apply Filter
      <input id="space_filter" type="checkbox" name="space_filter" style="margin-bottom: 15px;" value="true"></label>

      </div>
    </div>


    <div class="form-group" id="space_industrydiv2" style="display: none;">
          <div class="form-wrapper">
      <label for="space_industry2">Major Industry<span style="color: red;">*</span></label>
          <span id="spaceindustrymsg2"></span>
            <select class="form-control" id="space_industry2" name="space_industry2">
              <option value="" disabled selected hidden>Select Major Industry</option>
              @foreach($sp_industry as $var)
              <option value="{{$var->major_industry}}">{{$var->major_industry}}</option>
              @endforeach
            </select>
        </div>
    </div>

    <div class="form-group" id="space_idDiv" style="display: none;">
      <div class="form-wrapper">
      <label for="space_id"  >Space Id<span style="color: red;">*</span></label>
      <span id="spaceidmsg"></span>
     {{-- <input type="text" class="form-control" id="space_id" name="space_id" value="" autocomplete="off"> --}}
       {{-- <select class="form-control" id="space_id" name="space_id">
        <option value="" disabled selected hidden>Select Space</option>
         
       </select> --}}
        <span id="nameListSpaceId"></span>
      </div>
    </div>

    <div class="form-group row" id="spacefilterBydate" style="display: none;">
        <div class="col-3 form-check form-check-inline">
       <input id="space_filter_date" type="checkbox" name="space_filter_date" value="" class="form-check-input">
      <label for="space_filter_date" class="form-check-label">Filter By Date</label>
      </div>
    </div>



    <div class="form-group" id="spacefilterBydiv" style="display: none;">
      <div class="form-wrapper">
                  <label for="Criteria">Filter By</label>
                  <div class="row">
{{--
                    <div class="form-wrapper col-2">
                  <label for="date" style=" display: block;
    white-space: nowrap;">Date
                  <input class="form-check-input" type="radio" name="Selection" id="date" value="date">
                </label>
                 </div> --}}

                  <div class="col-2 form-check form-check-inline" id="spacefilterprize">
                  <input class="form-check-input" type="checkbox" name="space_prize" id="space_prize" value="">
                  <label for="space_prize" class="form-check-label">Price</label>
                  </div>

                 <div class="col-3 form-check form-check-inline">
                  <input class="form-check-input" type="checkbox" name="status" id="Status" value="">
                  <label for="Status" class="form-check-label">Occupation</label>
                  </div>

                <div class="col-3 form-check form-check-inline">
                  <input class="form-check-input" type="checkbox" name="location_filter" id="location_filter" value="">
                  <label for="location_filter" class="form-check-label">Location</label>
                </div>

                <div class="col-3 form-check form-check-inline">
                  <input class="form-check-input" type="checkbox" name="industry_filter" id="industry_filter" value="">
                  <label for="industry_filter" class="form-check-label">Major Industry</label>
                </div>


               </div>
             </div>
           </div>


           <div class="form-group row" id="spacedatediv" style="display: none;">
            <div class="form-wrapper col-6">
              <label for="start_date">From<span style="color: red;">*</span></label>
              <span id="startdatemsg"></span>
              <input type="date" id="start_date" name="start_date" class="form-control" max="<?php echo(date('Y-m-d'))?>">
            </div>
            <div class="form-wrapper col-6">
              <label for="end_date">To<span style="color: red;">*</span></label>
              <span id="enddatemsg"></span>
              <input type="date" id="end_date" name="end_date" class="form-control"  max="<?php echo(date('Y-m-d'))?>">
            </div>
          </div>

          <div class="form-group row" id="spacepricediv" style="display: none;">
            <div class="form-wrapper col-6">
              <label for="min_price">Min Price<span style="color: red;">*</span></label>
              <span id="minpricemsg"></span>
              <input type="number" id="min_price" name="min_price" class="form-control" value="">
            </div>
            <div class="form-wrapper col-6">
              <label for="max_price">Max Price<span style="color: red;">*</span></label>
              <span id="maxpricemsg"></span>
              <input type="number" id="max_price" name="max_price" class="form-control" value="" >
            </div>
          </div>

          <div class="form-group" id="spaceoccupationdiv" style="display: none;">
          <div class="form-wrapper">
          <label for="space_status">Occupation Status<span style="color: red;">*</span></label>
          <span id="spacestatusmsg"></span>
            <select class="form-control" id="space_status" name="space_status">
              <option value="" disabled selected hidden> Select Occupation Status</option>
              <option value="1">Occupied</option>
              <option value="0">Vacant</option>
            </select>
        </div>
    </div>


    <div class="form-group" id="insurancereporttypediv" style="display: none;">
          <div class="form-wrapper">
          <label for="insurance_reporttype">Select Report Type<span style="color: red;">*</span></label>
          <span id="insurancereporttypemsg"></span>
            <select class="form-control" id="insurance_reporttype" name="insurance_reporttype">
              <option value=" " disabled selected hidden>Select Report Type</option>
              <option value="sales">Sales Report</option>
              <option value="principals">List of Principals</option>
              <option value="clients">List of Clients</option>
            </select>
        </div>
    </div>

  <div class="form-group" id="InsurancefilterBydiv" style="display: none;">
      <div class="form-wrapper">
                  <label for="Criteria">Filter By</label>
                  <div class="row">

                  <div class="col-3 form-check form-check-inline">
                  <input class="form-check-input" type="checkbox" name="principal_filter" id="principal_filter" value="">
                  <label for="principal_filter" id="principal_filter" class="form-check-label">Principal</label>
                 </div>



                <div class="col-3 form-check form-check-inline">
                  <input class="form-check-input" type="checkbox" name="insurance_packagefilter" id="insurance_packagefilter"  value="">
                  <label for="insurance_packagefilter" id="insurance_packagefilter" class="form-check-label">Insurance Package</label>
                </div>

                {{-- <div class="col-3 form-check form-check-inline">
                  <input class="form-check-input" type="checkbox" name="insurance_yearfilter" id="insurance_yearfilter"  value="">
                  <label for="insurance_yearfilter" id="insurance_yearfilter" class="form-check-label">Year</label>
                </div> --}}

                <div class="col-3 form-check form-check-inline">
                  <input class="form-check-input" type="checkbox" name="insurance_datefilter" id="insurance_datefilter"  value="">
                  <label for="insurance_datefilter" id="insurance_datefilter" class="form-check-label">Date</label>
                </div>

               </div>
             </div>
           </div>



           <div class="form-group" id="Locationtypediv" style="display: none;">
          <div class="form-wrapper">
          <label for="Locationtype">Location<span style="color: red;">*</span></label>
          <span id="Locationtypemsg"></span>
            <select class="form-control" id="Locationtype" name="Locationtype">
              <option value="" disabled selected hidden>Select Location</option>
             <?php
                $locations=DB::table('space_locations')->select('location')->distinct()->orderBy('location','asc')->get();
              ?>
                @foreach($locations as $location)
                  <option value="{{$location->location}}">{{$location->location}}</option>
                @endforeach
            </select>
        </div>
    </div>


      <div class="form-group" id="space_industrydiv" style="display: none;">
          <div class="form-wrapper">
      <label for="space_industry">Major Industry<span style="color: red;">*</span></label>
          <span id="spaceindustrymsg"></span>
            <select class="form-control" id="space_industry" name="space_industry">
              <option value="" disabled selected hidden>Select Major Industry</option>
              @foreach($sp_industry as $var)
              <option value="{{$var->major_industry}}">{{$var->major_industry}}</option>
              @endforeach
            </select>
        </div>
    </div>

           <div class="form-group" id="principaltypediv" style="display: none;">
          <div class="form-wrapper">
          <label for="principaltype">Select Principal<span style="color: red;">*</span></label>
          <span id="principaltypemsg"></span>
            <select class="form-control" id="principaltype" name="principaltype">
              <option value=" " disabled selected hidden>Select Principal</option>
              <option value="BRITAM">BRITAM</option>
              <option value="ICEA LION">ICEA LION</option>
              <option value="NIC">NIC</option>
            </select>
        </div>
    </div>

    <div class="form-group" id="insurancepackagediv" style="display: none;">
          <div class="form-wrapper">
          <label for="insurance_package">Select Insurance Type<span style="color: red;">*</span></label>
          <span id="insurancepackagemsg"></span>
            <select class="form-control" id="insurance_package" name="insurance_package">
              <option value=" " disabled selected hidden>Select Insurance Package</option>
              <option value="FIDELTY">FIDELTY</option>
              <option value="FIRE">FIRE</option>
              <option value="INSURANCE OF MONEY">INSURANCE OF MONEY</option>
              <option value="MARINE HULL">MARINE HULL</option>
              <option value="MOTOR">MOTOR</option>
              <option value="PROFFESIONAL INDEMNITY">PROFFESIONAL INDEMNITY</option>
              <option value="PUBLIC LIABILITY">PUBLIC LIABILITY</option>
            </select>
        </div>
    </div>

    <div class="form-group" id="InsurancefilterBytype" style="display: none;">
            <div class="form-wrapper">
              <label for="Criteria">Filter By</label>
              <div class="row">
           <div class="col-3 form-check form-check-inline">
                  <input class="form-check-input" type="checkbox" name="insurance_typefilter" id="insurance_typefilter"  value="">
                  <label for="insurance_typefilter" id="insurance_typefilter" class="form-check-label">Insurance Type</label>
                </div>
              </div>
            </div>
          </div>

    <div class="form-group" id="insurancetypediv" style="display: none;">
          <div class="form-wrapper">
          <label for="insurance_type">Select Insurance Type<span style="color: red;">*</span></label>
          <span id="insurancetypemsg"></span>
            <select class="form-control" id="insurance_type" name="insurance_type">
              <option value=" " disabled selected hidden>Select Insurance Type</option>
              <option value="COMPREHENSIVE">COMPREHENSIVE</option>
              <option value="THIRD PARTY">THIRD PARTY</option>
            </select>
        </div>
    </div>

    <div class="form-group" id="insuranceyeardiv" style="display: none;">
      <div class="form-wrapper">
                  <label for="insurance_year">Year Category</label>
                  <span id="insuranceyearmsg"></span>
                  <div class="row">

                  <div class="col-3 form-check-inline">
                    <input class="form-check-input" type="radio" name="insurance_year" id="ins_start_year" value="start" checked="">
                  <label for="ins_start_year" class="form-check-label">Commission Year</label>
                 </div>

                 <div class="col-3 form-check-inline">
                  <input class="form-check-input" type="radio" name="insurance_year" id="ins_end_year" value="end" >
                  <label for="ins_end_year" class="form-check-label">Expiry Year</label>
                </div>
              </div>
            </div>
          </div>

          <div class="form-group" id="udiayeardiv" style="display: none;">
          <div class="form-wrapper">
          <label for="udiayeardiv">Select Year<span style="color: red;">*</span></label>
          <span id="udiayearmsg"></span>
            <select class="form-control" id="udia_year" name="udia_year">
            <option value=" " disabled selected hidden>Select Year</option>
            @for($x=0;$x<=5; $x++)
              <option value="{{$year + $x}}">{{$year + $x}}</option>
              @endfor
            </select>
        </div>
    </div>

 <div class="form-group row" id="insurancedatediv" style="display: none;">
    <div class="form-wrapper col-6">
        <label for="insurance_start_date">From<span style="color: red;">*</span></label>
        <span id="insurance_start_datemsg"></span>
        <input type="date" id="insurance_start_date" name="insurance_start_date" class="form-control" max="<?php echo(date('Y-m-d'))?>">
      </div>

    <div class="form-wrapper col-6">
      <label for="insurance_end_date">To<span style="color: red;">*</span></label>
      <span id="insurance_end_datemsg"></span>
      <input type="date" id="insurance_end_date" name="insurance_end_date" class="form-control" max="<?php echo(date('Y-m-d'))?>">
    </div>
  </div>

    <div class="form-group" id="tenanttypediv" style="display: none;">
          <div class="form-wrapper">
          <label for="tenant_type">Select Report Type<span style="color: red;">*</span></label>
          <span id="tenanttypemsg"></span>
            <select class="form-control" id="tenant_type" name="tenant_type">
              <option value=" " disabled selected hidden>Select Report Type</option>
              <option value="list">List of Tenants</option>
              <option value="invoice">Tenants Invoice</option>
              <option value="schedule">Tenancy Schedule</option>
            </select>
        </div>
    </div>

    <div class="form-group" id="TenantfilterBydiv" style="display: none;">
      <div class="form-wrapper">
                  <label for="Criteria">Filter By</label>
                  <div class="row">

                  <div class="col-3 form-check form-check-inline">
                  <input class="form-check-input" type="checkbox" name="business_filter" id="business_filter" value="">
                  <label for="business_filter" class="form-check-label">Business Type</label>
                 </div>

                 <div class="col-3 form-check form-check-inline">
                   <input class="form-check-input" type="checkbox" name="contract_filter" id="contract_filter" value="">
                  <label for="contract_filter" class="form-check-label">Contract Status</label>
                </div>

                <div class="col-3 form-check form-check-inline">
                   <input class="form-check-input" type="checkbox" name="payment_filter" id="payment_filter" value="">
                  <label for="payment_filter" class="form-check-label">Payment Status</label>
                </div>
               </div>
             </div>
           </div>


           <div class="form-group" id="businesstypediv" style="display: none;">
          <div class="form-wrapper">
          <label for="business_type">Select Business Type<span style="color: red;">*</span></label>
          <span id="businesstypemsg"></span>
            <select class="form-control" id="business_type" name="business_type">
              <option value=" " disabled selected hidden>Select Business Type</option>
              <?php
              $major_industries=DB::table('space_classification')->select('major_industry')->distinct()->orderBy('major_industry','asc')->get();
              ?>
              @foreach($major_industries as $var)
              <option value="{{$var->major_industry}}">{{$var->major_industry}}</option>
              @endforeach
              {{-- <option value="Cafeteria">CAFETERIA</option>
              <option value="Mall-Shop">MALL SHOP</option>
              <option value="Office block">OFFICE BLOCK</option>
              <option value="Stationery">STATIONERY</option>
              <option value="Villa">VILLA</option> --}}
            </select>
        </div>
    </div>

    <div class="form-group" id="contractstatusdiv" style="display: none;">
          <div class="form-wrapper">
          <label for="contract_status">Select Contract Status<span style="color: red;">*</span></label>
          <span id="contractstatusmsg"></span>
            <select class="form-control" id="contract_status" name="contract_status">
              <option value=" " disabled selected hidden>Select Contract Status</option>
              <option value="1">Active</option>
              <option value="0">Expired</option>
              <option value="-1">Terminated</option>
            </select>
        </div>
    </div>

    <div class="form-group" id="paymentstatusdiv" style="display: none;">
          <div class="form-wrapper">
          <label for="payment_status">Select Payment Status<span style="color: red;">*</span></label>
          <span id="paymentstatusmsg"></span>
            <select class="form-control" id="payment_status" name="payment_status">
              <option value=" " disabled selected hidden>Select Payment Status</option>
              <option value="Paid">Paid</option>
              <option value="Partially Paid">Partially Paid</option>
              <option value="Not paid">Not Paid</option>
            </select>
        </div>
    </div>

    <div class="form-group" id="TenantInvoiceCriteriadiv" style="display: none;">
      <div class="form-wrapper">
                  <label for="Criteria">Criteria<span style="color: red;">*</span></label>
                  <span id="t_invoiceCriteriamsg"></span>
                  <div class="row">

                  <div class="col-3 form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="t_invoiceCriteria" id="space_rent" value="rent" checked="">
                  <label for="space_rent" class="form-check-label">Space Rent</label>

                 </div>

                 <div class="col-3 form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="t_invoiceCriteria" id="electricity_bill" value="electricity" >
                  <label for="electricity_bill" class="form-check-label">Electricity Bill</label>
                </div>

                <div class="col-3 form-check form-check-inline">
                   <input class="form-check-input" type="radio" name="t_invoiceCriteria" id="water_bill" value="water">
                  <label for="water_bill" class="form-check-label">Water Bill</label>
                </div>
               </div>
             </div>
           </div>

           <div class="form-group row" id="t_invoicedurationdiv" style="display: none;">
            <div class="form-wrapper col-6">
              <label for="t_Invoice_start_date">From<span style="color: red;">*</span></label>
              <span id="t_Invoice_startdatemsg"></span>
              <input type="date" id="t_Invoice_start_date" name="t_Invoice_start_date" class="form-control" max="<?php echo(date('Y-m-d'))?>">
            </div>
            <div class="form-wrapper col-6">
              <label for="t_Invoice_end_date">To<span style="color: red;">*</span></label>
              <span id="t_invoice_enddatemsg"></span>
              <input type="date" id="t_invoice_end_date" name="t_invoice_end_date" class="form-control" max="<?php echo(date('Y-m-d'))?>">
            </div>
          </div>

          <div class="form-group" id="TenantInvoicefilterBydiv" style="display: none;">
      <div class="form-wrapper">
                  <label for="Criteria">Filter By</label>
                  <div class="row">

                <div class="col-3 form-check form-check-inline">
                  <input class="form-check-input" type="checkbox" name="t_invoice_payment_filter" id="t_invoice_payment_filter" value="">
                  <label for="t_invoice_payment_filter" class="form-check-label">Payment Status</label>
                </div>
               </div>
             </div>
           </div>

            <div class="form-group" id="tInvoicepaymentstatusdiv" style="display: none;">
          <div class="form-wrapper">
          <label for="t_invoicepayment_status">Select Payment Status<span style="color: red;">*</span></label>
          <span id="t_invoicepaymentstatusmsg"></span>
            <select class="form-control" id="t_invoicepayment_status" name="t_invoicepayment_status">
              <option value=" " disabled selected hidden>Select Payment Status</option>
              <option value="Paid">Paid</option>
              <option value="Partially Paid">Partially Paid</option>
              <option value="Not paid">Not Paid</option>
            </select>
        </div>
    </div>

    <div class="form-group row" id="tenancysheduleduration" style="display: none;">
      <div class="form-wrapper col-4">
              <label for="tenancy_year">Year<span style="color: red;">*</span></label>
              <span id="tenancyyearmsg"></span>
              <select class="form-control" id="tenancy_year" name="tenancy_year">
                <option value=" " disabled selected hidden>Select Year</option>
                @for($x=0;$x<=5; $x++)
                  <option value="{{$year + $x}}">{{$year + $x}}</option>
                @endfor
              </select>
        </div>

        <div class="form-wrapper col-4">
              <label for="tenancy_end">Duration<span style="color: red;">*</span></label>
              <span id="tenancyendmsg"></span>
              <select class="form-control" id="tenancy_end" name="tenancy_end">
                <option value=" " disabled selected hidden>Select Duration</option>
                  @for($ay=1;$ay<=5; $ay++)
                  <option value="{{$ay}}">{{$ay}} Months</option>
                @endfor
              </select>

        </div>

        <div class="form-wrapper col-4">
              <label for="tenancy_start">From<span style="color: red;">*</span></label>
              <span id="tenancystartmsg"></span>
              <select class="form-control" id="tenancy_start" name="tenancy_start">
                <option value=" " disabled selected hidden>Select Start Month</option>
                @for($x=1;$x<=12; $x++)
                  <option value="{{$x}}">{{DateTime::createFromFormat('!m', $x)->format('F')}}</option>
                @endfor
              </select>
        </div>
   </div>


    <div class="form-group" id="tenancyfilterBydiv" style="display: none;">
        <div class="form-wrapper">
          <label for="Criteria">Filter By</label>

              <div class="row">
                  <div class="col-3 form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="tenancy_business_filter" id="tenancy_business_filter" value="">
                    <label for="tenancy_business_filter" class="form-check-label">Business Type</label>
                  </div>

                 <div class="col-3 form-check form-check-inline">
                   <input class="form-check-input" type="checkbox" name="tenancy_location_filter" id="tenancy_location_filter" value="">
                  <label for="tenancy_location_filter" class="form-check-label">Location</label>
                </div>
            </div>
       </div>
     </div>

     <div class="form-group" id="tenancy_businessdiv" style="display: none;">
        <div class="form-wrapper">
          <label for="tenancy_business">Select Business Type<span style="color: red;">*</span></label>
          <span id="tenancybusinessmsg"></span>
            <select class="form-control" id="tenancy_business" name="tenancy_business">
                <option value=" " disabled selected hidden>Select Business Type</option>
                <?php
                $major_industries=DB::table('space_classification')->select('major_industry')->distinct()->orderBy('major_industry','asc')->get();
                ?>
                @foreach($major_industries as $var)
                  <option value="{{$var->major_industry}}">{{$var->major_industry}}</option>
                @endforeach
            </select>
        </div>
    </div>


    <div class="form-group" id="tenancy_locationdiv" style="display: none;">
          <div class="form-wrapper">
          <label for="tenancy_location">Location<span style="color: red;">*</span></label>
          <span id="tenancylocationmsg"></span>
            <select class="form-control" id="tenancy_location" name="tenancy_location">
              <option value=" " disabled selected hidden>Select Location</option>
              <?php
                $locations=DB::table('space_locations')->select('location')->distinct()->orderBy('location','asc')->get();
              ?>
                @foreach($locations as $location)
                  <option value="{{$location->location}}">{{$location->location}}</option>
                @endforeach
            </select>
        </div>
    </div>



    <div class="form-group" id="cartypediv" style="display: none;">
          <div class="form-wrapper">
          <label for="car_type">Select Report Type<span style="color: red;">*</span></label>
          <span id="cartypemsg"></span>
            <select class="form-control" id="car_type" name="car_type">
              <option value=" " disabled selected hidden>Select Report Type</option>
              {{-- <option value="car history">List of Car Rental History</option> --}}
              
              <option value="clients">List of Clients</option>
              <option value="cars">List of Rental Cars</option>
              <option value="history">Car Rental History</option>
              <option value="revenue">Revenue Report From CPTU Vehicles</option>
              <option value="operational">Revenue Report For Service, Repairs and Fuel For Motor Vehicles</option>
            </select>
        </div>
    </div>

    {{-- <div class="form-group" id="vehicleregdiv" style="display: none;">
          <div class="form-wrapper">
            <label for="vehicle_reg">Vehicle Reg. No<span style="color: red;">*</span></label>
            <span id="vehicleregmsg"></span>
            <input type="text" id="vehicle_reg" name="vehicle_reg" class="form-control" autocomplete="off">
            <span id="nameList"></span>
          </div>
        </div> --}}

        <div class="form-group" id="vehicleregdiv" style="display: none;">
          <div class="form-wrapper">
            <label for="vehicle_reg">Vehicle Reg. No<span style="color: red;">*</span></label>
            <span id="vehicleregmsg"></span>
            <select id="vehicle_reg" name="vehicle_reg" class="form-control">
              <option value=""disabled selected hidden>Select Vehicle</option>
              <?php
                $vehicles =carRental::where('flag',1)->get();
              ?>
              @foreach($vehicles as $vehicle)
                <option value="{{$vehicle->vehicle_reg_no}}">{{$vehicle->vehicle_reg_no}} - {{$vehicle->vehicle_model}}</option>
              @endforeach
            </select>
            
          </div>
        </div>


  <div class="form-group" id="carhistoryfilterBydiv" style="display: none;">
      <div class="form-wrapper">
          <label for="Criteria">Filter By</label>
            <div class="row">
                  <div class="col-3 form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="cardate_histfil" id="cardate_histfil" value="">
                  <label class="form-check-label" for="cardate_histfil">Date
                </label>
                 </div>
               </div>
         </div>
       </div>


       <div class="form-group row" id="carhistorydatediv" style="display: none;">
            <div class="form-wrapper col-6">
              <label for="carhistory_start_date">From<span style="color: red;">*</span></label>
              <span id="carhistory_startdatemsg"></span>
              <input type="date" id="carhistory_start_date" name="carhistory_start_date" class="form-control" max="<?php echo(date('Y-m-d'))?>" >
            </div>
            <div class="form-wrapper col-6">
              <label for="carhistory_end_date">To<span style="color: red;">*</span></label>
              <span id="carhistory_enddatemsg"></span>
              <input type="date" id="carhistory_end_date" name="carhistory_end_date" class="form-control" max="<?php echo(date('Y-m-d'))?>" >
            </div>
          </div>


    <div class="form-group" id="carsfilterBydiv" style="display: none;">
      <div class="form-wrapper">
                  <label for="Criteria">Filter By</label>
                  <div class="row">

                  <div class="col-3 form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="carmodel_filter" id="carmodel_filter" value="">
                  <label class="form-check-label" for="carmodel_filter" id="carmodel_filter">Vehicle Model
                </label>
                 </div>

                 <div class="col-3 form-check form-check-inline">
                  <input class="form-check-input" type="checkbox" name="carstatus_filter" id="carstatus_filter" value="">
                  <label class="form-check-label" for="carstatus_filter" id="carstatus_filter">Vehicle Status
                   </label>
                </div>

                <div class="col-3 form-check form-check-inline">
                  <input class="form-check-input" type="checkbox" name="carrange_filter" id="carrange_filter" value="">
                  <label class="form-check-label" for="carrange_filter" id="carrange_filter">Hire Range
                   </label>
                </div>

                <div class="col-2 form-check form-check-inline">
                  <input class="form-check-input" type="checkbox" name="rentstatus_filter" id="rentstatus_filter" value="">
                  <label class="form-check-label" for="rentstatus_filter" id="rentstatus_filter">Rent status
                   </label>
                </div>
               </div>
             </div>
           </div>

           <div class="form-group" id="carmodeldiv" style="display: none;">
          <div class="form-wrapper">
            <label for="model">Vehicle Model<span style="color: red;">*</span></label>
             <span id="modelmsg"></span>
            <select class="form-control" required="" id="model" name="model" required="">
              <option value=""disabled selected hidden>Select Vehicle Model</option>
              @foreach($model as $var)
              <option value="{{$var->vehicle_model}}">{{$var->vehicle_model}}</option>
              @endforeach
            </select>
          </div>
        </div>

        <div class="form-group" id="carstatusdiv" style="display: none;">
          <div class="form-wrapper" >
          <label for="vehicle_status">Vehicle Status<span style="color: red;">*</span></label>
           <span id="vehiclestatusmsg"></span>
            <select class="form-control" required="" id="vehicle_status" name="vehicle_status" required="">
              <option value=""disabled selected hidden>Select Vehicle status</option>
              <option value="Running">Running</option>
              <option value="Minor Repair">Minor Repair</option>
              <option value="Grounded">Grounded</option>
            </select>

        </div>
    </div>

    <div class="form-group row" id="carrangediv" style="display: none;">
            <div class="form-wrapper col-6">
              <label for="carmin_price">Min Price<span style="color: red;">*</span></label>
              <span id="carminpricemsg"></span>
              <input type="number" id="carmin_price" name="carmin_price" class="form-control" value="">
            </div>
            <div class="form-wrapper col-6">
              <label for="carmax_price">Max Price<span style="color: red;">*</span></label>
              <span id="carmaxpricemsg"></span>
              <input type="number" id="carmax_price" name="carmax_price" class="form-control" value="" >
            </div>
          </div>

    <div class="form-group" id="rentstatusdiv" style="display: none;">
          <div class="form-wrapper" >
          <label for="rent_status">Rent Status<span style="color: red;">*</span></label>
           <span id="rentstatusmsg"></span>
            <select class="form-control" required="" id="rent_status" name="rent_status" required="">
              <option value=""disabled selected hidden>Select Rent Status</option>
              <option value="Rented">Rented</option>
              <option value="Available">Available</option>
            </select>

        </div>
    </div>

      <div class="form-group" id="carclientfilterBydiv" style="display: none;">
      <div class="form-wrapper">
                  <label for="Criteria">Filter By</label>
                  <div class="row">

                  <div class="col-3 form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="clientcostcentre_filter" id="clientcostcentre_filter" value="">
                  <label class="form-check-label" for="clientcostcentre_filter" id="clientcostcentre_filter">Cost Centre
                </label>
                 </div>

                 <div class="col-3 form-check form-check-inline">
                  <input class="form-check-input" type="checkbox" name="clientcontract_filter" id="clientcontract_filter" value="">
                  <label class="form-check-label" for="clientcontract_filter" id="clientcontract_filter">Contract Status
                   </label>
                </div>

                 <div class="col-2 form-check form-check-inline">
                  <input class="form-check-input" type="checkbox" name="clientdate_filter" id="clientdate_filter" value="">
                  <label class="form-check-label" for="clientdate_filter" id="clientdate_filter">Date
                   </label>
                </div>

                <div class="col-3 form-check form-check-inline">
                  <input class="form-check-input" type="checkbox" name="clientpayment_filter" id="clientpayment_filter" value="">
                  <label class="form-check-label" for="clientpayment_filter" id="clientpayment_filter">Payment Status
                   </label>
                </div>
               </div>
             </div>
           </div>

           <div class="form-group" id="clientcostcentrediv" style="display: none;">
          <div class="form-wrapper">
            <label for="clientcostcentre">Cost Centre Id<span style="color: red;">*</span></label>
            <span id="clientcostcentremsg"></span>
           {{--  <input type="text" id="clientcostcentre" name="clientcostcentre" class="form-control" autocomplete="off" onkeypress="if((this.value.length<15)&&((event.charCode >= 48 && event.charCode <= 57) || (event.charCode==46))){return true} else return false;"> --}}
            <select type="text" id="clientcostcentre" name="clientcostcentre" class="form-control">
              <option value="" disabled selected hidden> </option>
                <?php $cost_centres = DB::table('cost_centres')->orderBy('costcentre_id','asc')->get(); ?>
                  @foreach($cost_centres as $cost_centre)
                    <option value="{{$cost_centre->costcentre_id}}">{{$cost_centre->costcentre_id}}-{{$cost_centre->costcentre}}
              </option>
                  @endforeach
            </select>

            {{-- <span id="costcentres"></span> --}}
          </div>
        </div>

        <div class="form-group" id="clientcontractdiv" style="display: none;">
      <div class="form-wrapper">
                  <label for="clientcontract">Contract Status</label>
                  <span id="clientcontractmsg"></span>
                  <div class="row">

                  <div class="col-3 form-check-inline">
                    <input class="form-check-input" type="radio" name="clientcontract" id="clientcontract_active" value="Active" checked="">
                  <label for="clientcontract_active" class="form-check-label">Active Contracts</label>
                 </div>

                 <div class="col-3 form-check-inline">
                  <input class="form-check-input" type="radio" name="clientcontract" id="clientcontract_inactive" value="Inactive" >
                  <label for="clientcontract_inactive" class="form-check-label">Inactive Contracts</label>
                </div>
              </div>
            </div>
          </div>

        <div class="form-group row" id="clientdatediv" style="display: none;">
            <div class="form-wrapper col-6">
              <label for="client_start_date">From<span style="color: red;">*</span></label>
              <span id="client_startdatemsg"></span>
              <input type="date" id="client_start_date" name="client_start_date" class="form-control" >
            </div>
            <div class="form-wrapper col-6">
              <label for="client_end_date">To<span style="color: red;">*</span></label>
              <span id="client_enddatemsg"></span>
              <input type="date" id="client_end_date" name="client_end_date" class="form-control" >
            </div>
          </div>

          <div class="form-group" id="clientpaymentdiv" style="display: none;">
      <div class="form-wrapper">
                  <label for="clientpayment">Payment Status</label>
                  <span id="clientpaymentmsg"></span>
                  <div class="row">

                  <div class="col-3 form-check-inline">
                    <input class="form-check-input" type="radio" name="clientpayment" id="clientpayment_paid" value="Paid" checked="">
                  <label for="clientpayment_paid" class="form-check-label">Paid</label>
                 </div>

                 <div class="col-3 form-check-inline">
                  <input class="form-check-input" type="radio" name="clientpayment" id="clientpayment_partial" value="Partially Paid" >
                  <label for="clientpayment_partial" class="form-check-label">Partially paid</label>
                </div>

                 <div class="col-3 form-check-inline">
                  <input class="form-check-input" type="radio" name="clientpayment" id="clientpayment_unpaid" value="Not paid" >
                  <label for="clientpayment_unpaid" class="form-check-label">Not Paid</label>
                </div>
              </div>
            </div>
          </div>

     <div class="form-group" id="carrevenuefilterBydiv" style="display: none;">
      <div class="form-wrapper">
                  <label for="Criteria">Filter By</label>
                  <div class="row">

                  <div class="col-3 form-check form-check-inline">
                  <input class="form-check-input" type="checkbox" name="carrevenuedate_filter" id="carrevenuedate_filter" value="">
                  <label class="form-check-label" for="carrevenuedate_filter">Date
                   </label>
                </div>

                  <div class="col-3 form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="carrevenuemodel_filter" id="carrevenuemodel_filter" value="">
                  <label class="form-check-label" for="carrevenuemodel_filter">Vehicle Model
                </label>
                 </div>

                 <div class="col-4 form-check form-check-inline">
                  <input class="form-check-input" type="checkbox" name="carrevenuereg_filter" id="carrevenuereg_filter" value="">
                  <label class="form-check-label" for="carrevenuereg_filter">Vehicle Registration No.
                   </label>
                </div>
               </div>
             </div>
           </div>

           <div class="form-group row" id="carrevenuedatediv" style="display: none;">
            <div class="form-wrapper col-6">
              <label for="carrevenue_start_date">From<span style="color: red;">*</span></label>
              <span id="carrevenue_startdatemsg"></span>
              <input type="date" id="carrevenue_start_date" name="carrevenue_start_date" class="form-control" max="<?php echo(date('Y-m-d'))?>" >
            </div>
            <div class="form-wrapper col-6">
              <label for="carrevenue_end_date">To<span style="color: red;">*</span></label>
              <span id="carrevenue_enddatemsg"></span>
              <input type="date" id="carrevenue_end_date" name="carrevenue_end_date" class="form-control" max="<?php echo(date('Y-m-d'))?>" >
            </div>
          </div>

           <div class="form-group" id="carrevenuemodeldiv" style="display: none;">
          <div class="form-wrapper">
            <label for="carrevenuemodel">Vehicle Model<span style="color: red;">*</span></label>
             <span id="carrevenuemodelmsg"></span>
            <select class="form-control" id="carrevenuemodel" name="carrevenuemodel">
              <option value=""disabled selected hidden>Select Vehicle Model</option>
              @foreach($model as $var)
              <option value="{{$var->vehicle_model}}">{{$var->vehicle_model}}</option>
              @endforeach
            </select>
          </div>
        </div>

        <div class="form-group" id="carrevenueregdiv" style="display: none;">
          <div class="form-wrapper">
            <label for="carrevenuereg">Vehicle Reg. No<span style="color: red;">*</span></label>
            <span id="carrevenueregmsg"></span>
            {{-- <input type="text" id="carrevenuereg" name="carrevenuereg" class="form-control" autocomplete="off"> --}}
            <select class="form-control"  id="carrevenuereg" name="carrevenuereg">
              <option value=""disabled selected hidden>Select Vehicle Registration</option>
              <?php $vehicles= DB::table('car_rentals')->orderBy('vehicle_reg_no','asc')->get(); ?>
                @foreach($vehicles as $var)
                  <option value="{{$var->vehicle_reg_no}}">{{$var->vehicle_reg_no}} - {{$var->vehicle_model}}</option>
                @endforeach
            </select>
            {{-- <span id="carrevenuenameList"></span> --}}
          </div>
        </div>

     <div class="form-group row" id="rent_durationdiv" style="display: none;">
            <div class="form-wrapper col-6">
              <label for="rent_start_date">From<span style="color: red;">*</span></label>
              <span id="rent_startdatemsg"></span>
              <input type="date" id="rent_start_date" name="rent_start_date" class="form-control" max="<?php echo(date('Y-m-d'))?>">
            </div>
            <div class="form-wrapper col-6">
              <label for="rent_end_date">To<span style="color: red;">*</span></label>
              <span id="rent_enddatemsg"></span>
              <input type="date" id="rent_end_date" name="rent_end_date" class="form-control" max="<?php echo(date('Y-m-d'))?>">
            </div>
          </div>

    <div class="form-group row" id="revenue_durationdiv" style="display: none;">
            <div class="form-wrapper col-6">
              <label for="rev_start_date">From<span style="color: red;">*</span></label>
              <span id="rev_startdatemsg"></span>
              <input type="date" id="rev_start_date" name="rev_start_date" class="form-control" max="<?php echo(date('Y-m-d'))?>">
            </div>
            <div class="form-wrapper col-6">
              <label for="rev_end_date">To<span style="color: red;">*</span></label>
              <span id="rev_enddatemsg"></span>
              <input type="date" id="rev_end_date" name="rev_end_date" class="form-control" max="<?php echo(date('Y-m-d'))?>">
            </div>
          </div>

    <div class="form-group" id="contracttypediv" style="display: none;">
          <div class="form-wrapper">
          <label for="contract_type">Select Report Type<span style="color: red;">*</span></label>
          <span id="contracttypemsg"></span>
            <select class="form-control" id="contract_type" name="contract_type">
              <option value=" " disabled selected hidden>Select Report Type</option>
              <option value="list">List of Contracts</option>
            </select>
        </div>
    </div>

    <div class="form-group" id="contractbusinesstypediv" style="display: none;">
          <div class="form-wrapper">
          <label for="contractbusiness_type">Select Business Type<span style="color: red;">*</span></label>
          <span id="contractbusinesstypemsg"></span>
            <select class="form-control" id="contractbusiness_type" name="contractbusiness_type">
              <option value=" " disabled selected hidden>Select Business Type</option>
               @if ($category=='Real Estate only' OR $category=='All')
              <option value="Space">SPACE</option>
              @endif
              @if($category=='Insurance only' OR $category=='All')
              <option value="Insurance">INSURANCE</option>
              @endif
              @if ($category=='CPTU only' OR $category=='All')
              <option value="Car Rental">CAR RENTAL</option>
              @endif
            </select>
        </div>
    </div>

      <div class="form-group" id="ContractfilterBydiv" style="display: none;">
      <div class="form-wrapper">
                  <label for="Criteria">Filter By</label>
                  <div class="row">

                 {{--  <div class="form-wrapper col-3">
                  <label for="client_filter" style=" display: block;
    white-space: nowrap;">Client Type
                  <input class="form-check-input" type="checkbox" name="client_filter" id="client_filter" value="">
                </label>
                 </div> --}}


                 <div class="col-3 form-check form-check-inline">
                  <input class="form-check-input" type="checkbox" name="Con_client_filter" id="Con_client_filter" value="">
                  <label class="form-check-label" id="Con_client_filter" for="Con_client_filter">Client Name</label>
                 </div>

                 <div class="col-3 form-check form-check-inline">
                   <input class="form-check-input" type="checkbox" name="Con_payment_filter" id="Con_payment_filter" value="">
                  <label class="form-check-label" id="Con_payment_filter" for="Con_payment_filter">Contract Status</label>
                </div>

                 <div class="col-3 form-check form-check-inline">
                  <input class="form-check-input" type="checkbox" name="Con_year_filter" id="Con_year_filter" value="">
                  <label class="form-check-label" id="Con_year_filter" for="Con_year_filter">Lease Year</label>
                </div>

               </div>
             </div>
           </div>

           <div class="form-group" id="clienttypediv" style="display: none;">
          <div class="form-wrapper">
          <label for="client_type">Select Client Type<span style="color: red;">*</span></label>
          <span id="clienttypemsg"></span>
            <select class="form-control" id="client_type" name="client_type">
              <option value=" " disabled selected hidden>Select Client Type</option>
              <option value="Individual">Individual</option>
              <option value="Company">Company</option>
            </select>
        </div>
    </div>

     <div class="form-group" id="Con_clientnamediv" style="display: none;">
          <div class="form-wrapper">
            <label for="Con_clientname">Client Name<span style="color: red;">*</span></label>
            <span id="Conclientnamemsg"></span>
            {{-- <input type="text" id="Con_clientname" name="Con_clientname" class="form-control" autocomplete="off"> --}}
            <select class="form-control" id="Con_clientname" name="Con_clientname">
              <option value=" " disabled selected hidden>Select Client Type</option>
            </select>
            <span id="ConnameList"></span>
          </div>
        </div>

        <div class="form-group" id="Conpaymentstatusdiv" style="display: none;">
          <div class="form-wrapper">
          <label for="Con_payment_status">Select Contract Status<span style="color: red;">*</span></label>
          <span id="Conpaymentstatusmsg"></span>
            <select class="form-control" id="Con_payment_status" name="Con_payment_status">
              <option value=" " disabled selected hidden>Select Contract Status</option>
              <option value="Active">Active</option>
              <option value="Expired">Expired</option>
            </select>
        </div>
    </div>

    <div class="form-group" id="Conyearcategorydiv" style="display: none;">
      <div class="form-wrapper">
                  <label for="Conyearcategory">Lease Year Category</label>
                  <span id="Conyearcategorymsg"></span>
                  <div class="row">

                  <div class="col-3 form-check-inline">
                    <input class="form-check-input" type="radio" name="Conyearcategory" id="Con_start_year" value="start" checked="">
                  <label for="Con_start_year" class="form-check-label">Lease Start</label>
                 </div>

                 <div class="col-3 form-check-inline">
                  <input class="form-check-input" type="radio" name="Conyearcategory" id="Con_end_year" value="end" >
                  <label for="Con_end_year" class="form-check-label">Lease End</label>
                </div>
              </div>
            </div>
          </div>

    <div class="form-group" id="Conyeardiv" style="display: none;">
          <div class="form-wrapper">
          <label for="Con_year">Select Year<span style="color: red;">*</span></label>
          <span id="Conyearmsg"></span>
            <select class="form-control" id="Con_year" name="Con_year">
            <option value=" " disabled selected hidden>Select Year</option>
            @for($x=0;$x<=5; $x++)
              <option value="{{$year + $x}}">{{$year + $x}}</option>
              @endfor
            </select>
        </div>
    </div>

    <div class="form-group" id="invoicetypediv" style="display: none;">
          <div class="form-wrapper">
          <label for="invoice_type">Select Report Type<span style="color: red;">*</span></label>
          <span id="invoicetypemsg"></span>
            <select class="form-control" id="invoice_type" name="invoice_type">
              <option value=" " disabled selected hidden>Select Report Type</option>
              <option value="list">List of Invoices</option>
              <option value="summary">Revenue and Debt summary</option>
            </select>
        </div>
    </div>

    <div class="form-group" id="Inbusinesstypediv" style="display: none;">
          <div class="form-wrapper">
          <label for="Inbusiness_type">Select Business Type<span style="color: red;">*</span></label>
          <span id="Inbusinesstypemsg"></span>
            <select class="form-control" id="Inbusiness_type" name="Inbusiness_type">
              <option value=" " disabled selected hidden>Select Business Type</option>
              @if ($category=='CPTU only' OR $category=='All')
                <option value="Car Rental">Car Rental</option>
              @endif
              @if($category=='Insurance only' OR $category=='All')
                <option value="Insurance">Insurance</option>
              @endif
              @if ($category=='Real Estate only' OR $category=='All')
                <option value="Space">Real Estate</option>
              @endif
            </select>
        </div>
    </div>

    <div class="form-group" id="summarybiztypediv" style="display: none;">
          <div class="form-wrapper">
          <label for="summarybiz">Select Business Type<span style="color: red;">*</span></label>
          <span id="summarybiztypemsg"></span>
            <select class="form-control" id="summarybiztype" name="summarybiztype">
              <option value=" " disabled selected hidden>Select Business Type</option>
              @if ($category=='CPTU only' OR $category=='All')
                <option value="Car Rental">Car Rental</option>
              @endif
              @if($category=='Insurance only' OR $category=='All')
                <option value="Insurance">Insurance</option>
              @endif
              @if ($category=='Real Estate only' OR $category=='All')
                <option value="Space">Real Estate</option>
              @endif
               @if ($category=='All')
                <option value="All">All Businesses</option>
              @endif
            </select>
        </div>
    </div>



     <div class="form-group" id="summaryspacecriteriadiv" style="display: none;">
      <div class="form-wrapper">
                  <label for="summarycriteria2">Criteria<span style="color: red;">*</span></label>
                  <span id="summarycriteriamsg"></span>
                  <div class="row">

                  <div class="form-wrapper col-3">
                  <label for="summary_space" style=" display: block;
    white-space: nowrap;">Space Rent
                  <input class="form-check-input" type="radio" name="summary_criteria" id="summary_space" value="space" checked="">
                </label>
                 </div>

                 <div class="form-wrapper col-3">
                  <label for="summary_electricity" style=" display: block;
    white-space: nowrap;">Electricity Bill
                   <input class="form-check-input" type="radio" name="summary_criteria" id="summary_electricity" value="electricity" >
                   </label>
                </div>

                <div class="form-wrapper col-3">
                  <label for="summary_water" style=" display: block;
    white-space: nowrap;">Water Bill
                   <input class="form-check-input" type="radio" name="summary_criteria" id="summary_water" value="water">
                   </label>
                </div>
               </div>
             </div>
     </div>


              <div class="form-group" id="summaryshowcriteriadiv" style="display: none;">
      <div class="form-wrapper">
                  <label for="summaryshowcriteria2">Show By<span style="color: red;">*</span></label>
                  <span id="summaryshowcriteriamsg"></span>
                  <div class="row">

                  <div class="form-wrapper col-3">
                  <label for="summary_clients" style=" display: block;
    white-space: nowrap;">Clients
                  <input class="form-check-input" type="radio" name="summary_show" id="summary_clients" value="clients" checked="">
                </label>
                 </div>

                 <div class="form-wrapper col-3">
                  <label for="summary_industry" style=" display: block;
    white-space: nowrap;">Major Industry
                   <input class="form-check-input" type="radio" name="summary_show" id="summary_industry" value="industry" >
                   </label>
                </div>
               </div>
             </div>
           </div>


       <div class="form-group" id="summaryspacefilterBydiv" style="display: none;">
        <div class="form-wrapper">
          <label for="summaryspacefilterBy">Filter By</label>

              <div class="row">
                  <div class="col-3 form-check form-check-inline" id="summary_business_filter_div">
                    <input class="form-check-input" type="checkbox" name="summary_business_filter" id="summary_business_filter" value="">
                    <label for="summary_business_filter" class="form-check-label">Business Type</label>
                  </div>

                 <div class="col-3 form-check form-check-inline" id="summary_location_filter_div">
                   <input class="form-check-input" type="checkbox" name="summary_location_filter" id="summary_location_filter" value="">
                  <label for="summary_location_filter" class="form-check-label">Location</label>
                </div>

                <div class="col-3 form-check form-check-inline">
                   <input class="form-check-input" type="checkbox" name="summary_year_filter" id="summary_year_filter" value="">
                  <label for="summary_year_filter" class="form-check-label">Date</label>
                </div>
            </div>
       </div>
     </div>

      <div class="form-group" id="summaryspacefilterBydiv2" style="display: none;">
        <div class="form-wrapper">
          <label for="summaryspacefilterBy">Filter By</label>
              <div class="row">
                <div class="col-3 form-check form-check-inline">
                   <input class="form-check-input" type="checkbox" name="summary_year_filter2" id="summary_year_filter2" value="">
                  <label for="summary_year_filter2" class="form-check-label">Date</label>
                </div>
            </div>
       </div>
     </div>

     <div class="form-group row" id="summary_yeardiv2" style="display: none;">
        <div class="form-wrapper col-6">
          <label for="summary2_start_date">From<span style="color: red;">*</span></label>
          <span id="summary2_startdatemsg"></span>
          <input type="date" id="summary2_start_date" name="summary2_start_date" class="form-control" max="<?php echo(date('Y-m-d'))?>">
        </div>

        <div class="form-wrapper col-6">
          <label for="summary2_end_date">To<span style="color: red;">*</span></label>
          <span id="summary2_enddatemsg"></span>
          <input type="date" id="summary2_end_date" name="summary2_end_date" class="form-control"  max="<?php echo(date('Y-m-d'))?>">
        </div>

    </div>

     <div class="form-group" id="summary_businessdiv" style="display: none;">
        <div class="form-wrapper">
          <label for="summary_business">Select Business Type<span style="color: red;">*</span></label>
          <span id="summarybusinessmsg"></span>
            <select class="form-control" id="summary_business" name="summary_business">
                <option value=" " disabled selected hidden>Select Business Type</option>
                <?php
                $major_industries=DB::table('space_classification')->select('major_industry')->distinct()->orderBy('major_industry','asc')->get();
                ?>
                @foreach($major_industries as $var)
                  <option value="{{$var->major_industry}}">{{$var->major_industry}}</option>
                @endforeach
            </select>
        </div>
    </div>


    <div class="form-group" id="summary_locationdiv" style="display: none;">
          <div class="form-wrapper">
          <label for="summary_location">Location<span style="color: red;">*</span></label>
          <span id="summarylocationmsg"></span>
            <select class="form-control" id="summary_location" name="summary_location">
              <option value=" " disabled selected hidden>Select Location</option>
              <?php
                $locations=DB::table('space_locations')->select('location')->distinct()->orderBy('location','asc')->get();
              ?>
                @foreach($locations as $location)
                  <option value="{{$location->location}}">{{$location->location}}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="form-group row" id="summary_yeardiv" style="display: none;">
        <div class="form-wrapper col-6">
          <label for="summary_start_date">From<span style="color: red;">*</span></label>
          <span id="summary_startdatemsg"></span>
          <input type="date" id="summary_start_date" name="summary_start_date" class="form-control" max="<?php echo(date('Y-m-d'))?>">
        </div>

        <div class="form-wrapper col-6">
          <label for="summary_end_date">To<span style="color: red;">*</span></label>
          <span id="summary_enddatemsg"></span>
          <input type="date" id="summary_end_date" name="summary_end_date" class="form-control"  max="<?php echo(date('Y-m-d'))?>">
        </div>
    </div>

    <div class="form-group" id="InSpaceCriteriadiv" style="display: none;">
      <div class="form-wrapper">
                  <label for="InCriteria">Invoice Criteria</label>
                  <span id="InspaceCriteriamsg"></span>
                  <div class="row">

                 <div class="col-3 form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="In_SpaceCriteria" id="space_rent2" value="rent" checked="">
                  <label for="space_rent2" class="form-check-label">Space Rent</label>
                </div>

                 <div class="col-3 form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="In_SpaceCriteria" id="electricity_bill2" value="electricity" >
                  <label for="electricity_bill2" class="form-check-label">Electricity Bill</label>
                </div>

                <div class="col-3 form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="In_SpaceCriteria" id="water_bill2" value="water" >
                  <label for="water_bill2" class="form-check-label">Water Bill</label>
                </div>

               </div>
             </div>
           </div>

    <div class="form-group" id="InvoicefilterBydiv" style="display: none;">
      <div class="form-wrapper">
                  <label for="Criteria">Filter By</label>
                  <div class="row">

                  <div class="col-3 form-check form-check-inline">
                  <input class="form-check-input" type="checkbox" name="In_client_filter" id="In_client_filter" value="">
                  <label for="In_client_filter" class="form-check-label">Client Name</label>
                 </div>

                 <div class="col-3 form-check form-check-inline">
                   <input class="form-check-input" type="checkbox" name="In_payment_filter" id="In_payment_filter" value="">
                  <label for="In_payment_filter" class="form-check-label">Payment Status</label>
                </div>

                 <div class="col-3 form-check form-check-inline">
                  <input class="form-check-input" type="checkbox" name="In_year_filter" id="In_year_filter" value="">
                  <label for="In_year_filter" class="form-check-label">Year</label>
                </div>

               </div>
             </div>
           </div>



         <div class="form-group" id="In_clientnamediv" style="display: none;">
          <div class="form-wrapper">
            <label for="In_clientname">Client Name<span style="color: red;">*</span></label>
            <span id="Inclientnamemsg"></span>
           {{--  <input type="text" id="In_clientname" name="In_clientname" class="form-control" autocomplete="off"> --}}
            <select class="form-control" id="In_clientname" name="In_clientname">
              <option value=" " disabled selected hidden>Select Client</option>
            </select>
            {{-- <span id="nameListClient"></span> --}}
          </div>
        </div>

        <div class="form-group" id="Inpaymentstatusdiv" style="display: none;">
          <div class="form-wrapper">
          <label for="In_payment_status">Select Payment Status<span style="color: red;">*</span></label>
          <span id="Inpaymentstatusmsg"></span>
            <select class="form-control" id="In_payment_status" name="In_payment_status">
              <option value=" " disabled selected hidden>Select Payment Status</option>
              <option value="Paid">Paid</option>
              <option value="Partially Paid">Partially Paid</option>
              <option value="Not paid">Not Paid</option>
            </select>
        </div>
    </div>

    <div class="form-group" id="Inyeardiv" style="display: none;">
          <div class="form-wrapper">
          <label for="In_year">Select Payment Year<span style="color: red;">*</span></label>
          <span id="Inyearmsg"></span>
            <select class="form-control" id="In_year" name="In_year">
            <option value=" " disabled selected hidden>Select Year</option>
            @for($x=0;$x<=5; $x++)
              <option value="{{$year + $x}}">{{$year + $x}}</option>
              @endfor
            </select>
        </div>
    </div>

    <div class="form-group" id="systemtypediv" style="display: none;">
          <div class="form-wrapper">
          <label for="system_type">Select Report Type<span style="color: red;">*</span></label>
          <span id="systemtypemsg"></span>
            <select class="form-control" id="system_type" name="system_type">
              <option value=" " disabled selected hidden>Select Report Type</option>
              <option value="user">List of System User</option>
            </select>
        </div>
    </div>

    <div class="form-group" id="systemfilterBydiv" style="display: none;">
      <div class="form-wrapper">
                  <label for="Criteria">Filter By</label>
                  <div class="row">

                  <div class="col-3 form-check form-check-inline">
                  <input class="form-check-input" type="checkbox" name="system_status_filter" id="system_status_filter" value="">
                  <label for="system_status_filter" class="form-check-label">User Status</label>
                 </div>
               </div>
             </div>
     </div>

     <div class="form-group" id="systemstatusdiv" style="display: none;">
      <div class="form-wrapper">
                  <label for="system_status">User Status</label>
                  <span id="systemstatusmsg"></span>
                  <div class="row">

                  <div class="col-3 form-check-inline">
                    <input class="form-check-input" type="radio" name="system_status" id="system_status_active" value="active" checked="">
                  <label for="system_status_active" class="form-check-label">Active Users</label>
                 </div>

                 <div class="col-3 form-check-inline">
                  <input class="form-check-input" type="radio" name="system_status" id="system_status_inactive" value="inactive" >
                  <label for="system_status_inactive" class="form-check-label">Inactive Users</label>
                </div>
              </div>
            </div>
          </div>


   <div class="form-group" id="flatsreporttypediv" style="display: none;">
      <div class="form-wrapper">
        <label for="flats_reporttype">Select Report Type<span style="color: red;">*</span></label>
          <span id="flatsreporttypemsg"></span>
            <select class="form-control" id="flats_reporttype" name="flats_reporttype">
              <option value=" " disabled selected hidden>Select Report Type</option>
              <option value="rooms">Research Flats Rooms</option>
              <option value="contracts">Research Flats Contracts</option>
              {{-- <option value="clients">List of Clients</option> --}}
            </select>
        </div>
    </div>


    <div class="form-group" id="flatsrooms_filterBydiv" style="display: none;">
      <div class="form-wrapper">
                  <label for="Criteria">Filter By</label>
                  <div class="row">

                  <div class="col-3 form-check form-check-inline">
                  <input class="form-check-input" type="checkbox" name="room_category_filter" id="room_category_filter" value="">
                  <label for="room_category_filter" class="form-check-label">Room Category</label>
                 </div>
               </div>
             </div>
     </div>

     <div class="form-group" id="room_categoryDiv" style="display: none;">
      <div class="form-wrapper">
        <label for="room_category">Select Room Category<span style="color: red;">*</span></label>
          <span id="roomcategorymsg"></span>
            <select class="form-control" id="room_category" name="room_category">
              <option value="" disabled selected hidden>Select Room Category</option>
              <option value="Single Room">Single Room</option>
              <option value="Shared Room">Shared Room</option>
              <option value="Suit Room">Suit Room</option>
            </select>
        </div>
    </div>

    <div class="form-group" id="flatscontracts_filterBydiv" style="display: none;">
      <div class="form-wrapper">
                  <label for="Criteria">Filter By</label>
                  <div class="row">

                  <div class="col-3 form-check form-check-inline">
                  <input class="form-check-input" type="checkbox" name="flats_payment_filter" id="flats_payment_filter" value="">
                  <label for="flats_payment_filter" class="form-check-label">Payment Status</label>
                 </div>

                 <div class="col-3 form-check form-check-inline">
                  <input class="form-check-input" type="checkbox" name="flats_status_filter" id="flats_status_filter" value="">
                  <label for="flats_status_filter" class="form-check-label">Contract Status</label>
                 </div>

               </div>
             </div>
     </div>


      <div class="form-group" id="flats_paymentDiv" style="display: none;">
          <div class="form-wrapper">
          <label for="flats_payment">Select Payment Status<span style="color: red;">*</span></label>
          <span id="flatspaymentmsg"></span>
            <select class="form-control" id="flats_payment" name="flats_payment">
              <option value="" disabled selected hidden>Select Payment Status</option>
              <option value="Paid">Paid</option>
              <option value="Partially Paid">Partially Paid</option>
              <option value="Not paid">Not Paid</option>
            </select>
        </div>
    </div>


    <div class="form-group" id="flats_statusdiv" style="display: none;">
          <div class="form-wrapper">
          <label for="flats_status">Select Contract Status<span style="color: red;">*</span></label>
          <span id="flats_statusmsg"></span>
            <select class="form-control" id="flats_status" name="flats_status">
              <option value="" disabled selected hidden>Select Contract Status</option>
              <option value="Active">Active</option>
              <option value="Expired">Expired</option>
            </select>
        </div>
    </div>  


  </div>
  <div>
  <button class="btn btn-primary" type="submit" id="submitbutton">Generate</button>
  <button class="btn btn-danger" type="button" onclick="history.back()">Back</button>
     </div>
</fieldset>
</form>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
@endsection


@section('pagescript')
<script>
function myFunction() {
  var strt=document.getElementById('tenancy_start').value;
  if(strt!=""){
   <?php echo $ay = 5; ?>;
  }
}
</script>
<script type="text/javascript">
  $(document).ready(function(){
    var az,bz,cz;
   $("#module").click(function(){
     var query = $(this).val();
     if(query=='space'){
      $('#spacetypediv').show();
       $('#insurancereporttypediv').hide();
       $('#InsurancefilterBydiv').hide();
       $('#InsurancefilterBytype').hide();
       $('#principaltypediv').hide();
       $('#insurancepackagediv').hide();
       $('#insuranceyeardiv').hide();
       $('#insurancedatediv').hide();
       $('#udiayeardiv').hide();
       $('#insurancetypediv').hide();
       $('#tenancysheduleduration').hide();
       $('#TenantfilterBydiv').hide();
       $('#businesstypediv').hide();
       $('#contractstatusdiv').hide();
       $('#paymentstatusdiv').hide();
       $("input[name='principal_filter']:checked").prop("checked", false);
       $("input[name='insurance_typefilter']:checked").prop("checked", false);
       $("input[name='business_filter']:checked").prop("checked", false);
       $("input[name='contract_filter']:checked").prop("checked", false);
       $("input[name='payment_filter']:checked").prop("checked", false);
       $('#TenantInvoiceCriteriadiv').hide();
       $('#t_invoicedurationdiv').hide();
       $('#TenantInvoicefilterBydiv').hide();
       $('#tInvoicepaymentstatusdiv').hide();
       $("input[name='t_invoice_payment_filter']:checked").prop("checked", false);
       $('#t_Invoice_start_date').val('');
       $('#t_invoice_end_date').val('');
       $('#t_invoicepayment_status').val(' ');
       $('#insurance_reporttype').val(" ");
       $('#principaltype').val(" ");
       $('#insurance_type').val(" ");
       $('#tenant_type').val(" ");
       $('#business_type').val(" ");
       $('#contract_status').val(" ");
       $('#payment_status').val(" ");
       $('#cartypediv').hide();
       $('#carsfilterBydiv').hide();
       $('#carclientfilterBydiv').hide();
       $('#carrevenuefilterBydiv').hide();
       $('#carrevenuemodeldiv').hide();
   $('#carmodeldiv').hide();
    $('#carstatusdiv').hide();
    $('#carrangediv').hide();
    $('#rentstatusdiv').hide();
    $('#vehicleregdiv').hide();
    $('#rent_durationdiv').hide();
    $('#vehicle_reg').val("");
    $('#rent_start_date').val("");
    $('#rent_end_date').val("");
    $('#model').val("");
    $('#vehicle_status').val("");
    $('#carmin_price').val("");
    $('#carmax_price').val("");
    $('#rent_status').val("");
    $('#clientcostcentrediv').hide();
    $('#clientcontractdiv').hide();
    $('#clientdatediv').hide();
    $('#clientpaymentdiv').hide();
    $('#carhistoryfilterBydiv').hide();
    $('#clientcostcentre').val("");
    $('#client_start_date').val("");
    $('#client_end_date').val("");
    $('#carhistorydatediv').hide();
    $('#carhistory_start_date').val("");
    $('#carhistory_end_date').val("");
  $("input[name='cardate_histfil']:checked").prop("checked", false);
   $("input[name='carmodel_filter']:checked").prop("checked", false);
     $("input[name='carstatus_filter']:checked").prop("checked", false);
      $("input[name='carrange_filter']:checked").prop("checked", false);
       $("input[name='rentstatus_filter']:checked").prop("checked", false);
        $("input[name='clientcostcentre_filter']:checked").prop("checked", false);
        $("input[name='clientcontract_filter']:checked").prop("checked", false);
        $("input[name='clientdate_filter']:checked").prop("checked", false);
        $("input[name='clientpayment_filter']:checked").prop("checked", false);
       $('#revenue_durationdiv').hide();
       $('#car_type').val(" ");
       $('#tenanttypediv').hide();
       $('#contracttypediv').hide();
       $('#contractbusinesstypediv').hide();
       $('#ContractfilterBydiv').hide();
       $('#clienttypediv').hide();
       $("input[name='client_filter']:checked").prop("checked", false);
       $('#contract_type').val(" ");
       $('#contractbusiness_type').val(" ");
       $('#client_type').val(" ");
       $('#invoicetypediv').hide();
       $('#InvoicefilterBydiv').hide();
       $('#Inbusinesstypediv').hide();
       $('#In_clientnamediv').hide();
       $('#Inpaymentstatusdiv').hide();
       $('#Inyeardiv').hide();
       $('#InSpaceCriteriadiv').hide();
       $('#invoice_type').val(" ");
       $('#Inbusiness_type').val(" ");
       $('#In_clientname').val("");
       $('#In_payment_status').val(" ");
       $('#In_year').val(" ");
       $("input[name='In_client_filter']:checked").prop("checked", false);
       $("input[name='In_payment_filter']:checked").prop("checked", false);
       $("input[name='In_year_filter']:checked").prop("checked", false);
    $('#contractbusinesstypediv').hide();
    $('#contractbusiness_type').val();
    $('#ContractfilterBydiv').hide();
    $('#Con_clientnamediv').hide();
    $('#Con_clientname').val("");
    $('#Conpaymentstatusdiv').hide();
    $('#Con_payment_status').val(" ");
    $('#Conyeardiv').hide();
    $('#Con_year').val(" ");
    $('#Conyearcategorydiv').hide();
    $("input[name='Con_client_filter']:checked").prop("checked", false);
    $("input[name='Con_payment_filter']:checked").prop("checked", false);
    $("input[name='Con_year_filter']:checked").prop("checked", false);
    $('#systemtypediv').hide();
    $('#systemfilterBydiv').hide();
    $('#systemstatusdiv').hide();
    $('#system_type').val(" ");
    $('#tenancyfilterBydiv').hide();
    $('#tenancy_businessdiv').hide();
  $('#tenancy_locationdiv').hide();
  $('#tenancy_business').val(" ");
    $('#tenancy_location').val(" ");
  $("input[name='tenancy_business_filter']:checked").prop("checked", false);
  $("input[name='tenancy_location_filter']:checked").prop("checked", false);
    $("input[name='system_status_filter']:checked").prop("checked", false);
    $('#summaryspacefilterBydiv').hide();
    $('#summaryspacefilterBydiv2').hide();
      $('#summaryshowcriteriadiv').hide();
      $('#summaryspacecriteriadiv').hide();
      $('#summary_businessdiv').hide();
      $('#summary_locationdiv').hide();
      $('#summary_yeardiv').hide();
      $('#summary_start_date').val("");
      $('#summary_end_date').val("");
      $('#summarybiztypediv').hide();
      $('#summarybiztype').val(" ");
      $('#summary_business').val(" ");
      $('#summary_location').val(" ");
      $("#summary_business_filter:checked").prop("checked", false);
      $("#summary_location_filter:checked").prop("checked", false);
      $("#summary_year_filter:checked").prop("checked", false);
      $("#summary_year_filter2:checked").prop("checked", false);
      $('#flatsreporttypediv').hide();
      $('#flatsrooms_filterBydiv').hide();
      $('#room_categoryDiv').hide();
      $('#flatscontracts_filterBydiv').hide();
      $('#flats_paymentDiv').hide();
      $('#flats_statusdiv').hide();
     }

     else if(query=='insurance'){
       $('#spacetypediv').hide();
       $('#spacefilterdiv').hide();
       $('#space_industrydiv2').hide();
       $('#space_idDiv').hide();
       $('#spacefilterBydate').hide();
       $('#spacefilterBydiv').hide();
       $('#spacedatediv').hide();
       $('#spacepricediv').hide();
       $('#Locationtypediv').hide();
       $('#space_industrydiv').hide();
       $('#spaceoccupationdiv').hide();
       $('#TenantfilterBydiv').hide();
       $('#tenancysheduleduration').hide();
       $('#businesstypediv').hide();
       $('#contractstatusdiv').hide();
       $('#paymentstatusdiv').hide();
       $('#major_industry').val(" ");
       $('#space_id').val(" ");
       $('#start_date').val(" ");
       $('#end_date').val(" ");
       $('#min_price').val(" ");
       $('#max_price').val(" ");
       $('#space_status').val("");
       $('#Locationtype').val("");
       $("input[name='space_filter_date']:checked").prop("checked", false);
       $("input[name='space_prize']:checked").prop("checked", false);
       $("input[name='location_filter']:checked").prop("checked", false);
       $("input[name='industry_filter']:checked").prop("checked", false);
       $("input[name='status']:checked").prop("checked", false);
       $("input[name='business_filter']:checked").prop("checked", false);
       $("input[name='contract_filter']:checked").prop("checked", false);
       $("input[name='payment_filter']:checked").prop("checked", false);
       $('#TenantInvoiceCriteriadiv').hide();
       $('#t_invoicedurationdiv').hide();
       $('#TenantInvoicefilterBydiv').hide();
       $('#tInvoicepaymentstatusdiv').hide();
       $("input[name='t_invoice_payment_filter']:checked").prop("checked", false);
       $('#t_Invoice_start_date').val('');
       $('#t_invoice_end_date').val('');
       $('#t_invoicepayment_status').val(' ');
       $('#business_type').val(" ");
       $('#contract_status').val(" ");
       $('#payment_status').val(" ");
       $('#tenant_type').val(" ");
       $('#cartypediv').hide();
       $('#carsfilterBydiv').hide();
       $('#carclientfilterBydiv').hide();
       $('#carrevenuefilterBydiv').hide();
       $('#carrevenuemodeldiv').hide();
   $('#carmodeldiv').hide();
    $('#carstatusdiv').hide();
    $('#carrangediv').hide();
    $('#rentstatusdiv').hide();
    $('#vehicleregdiv').hide();
    $('#rent_durationdiv').hide();
    $('#vehicle_reg').val("");
    $('#rent_start_date').val("");
    $('#rent_end_date').val("");
    $('#model').val("");
    $('#vehicle_status').val("");
    $('#carmin_price').val("");
    $('#carmax_price').val("");
    $('#rent_status').val("");
    $('#clientcostcentrediv').hide();
    $('#clientcontractdiv').hide();
    $('#clientdatediv').hide();
    $('#clientpaymentdiv').hide();
    $('#carhistoryfilterBydiv').hide();
    $('#clientcostcentre').val("");
    $('#client_start_date').val("");
    $('#client_end_date').val("");
    $('#carhistorydatediv').hide();
    $('#carhistory_start_date').val("");
    $('#carhistory_end_date').val("");
  $("input[name='cardate_histfil']:checked").prop("checked", false);
   $("input[name='carmodel_filter']:checked").prop("checked", false);
     $("input[name='carstatus_filter']:checked").prop("checked", false);
      $("input[name='carrange_filter']:checked").prop("checked", false);
       $("input[name='rentstatus_filter']:checked").prop("checked", false);
       $("input[name='clientcostcentre_filter']:checked").prop("checked", false);
        $("input[name='clientcontract_filter']:checked").prop("checked", false);
        $("input[name='clientdate_filter']:checked").prop("checked", false);
        $("input[name='clientpayment_filter']:checked").prop("checked", false);
       $('#revenue_durationdiv').hide();
       $('#car_type').val(" ");
      $('#insurancereporttypediv').show();
      $('#tenanttypediv').hide();
      $('#contracttypediv').hide();
       $('#contractbusinesstypediv').hide();
       $('#ContractfilterBydiv').hide();
       $('#clienttypediv').hide();
       $("input[name='client_filter']:checked").prop("checked", false);
       $('#contract_type').val(" ");
       $('#contractbusiness_type').val(" ");
       $('#client_type').val(" ");
       $('#invoicetypediv').hide();
       $('#InvoicefilterBydiv').hide();
       $('#Inbusinesstypediv').hide();
       $('#In_clientnamediv').hide();
       $('#Inpaymentstatusdiv').hide();
       $('#Inyeardiv').hide();
       $('#InSpaceCriteriadiv').hide();
       $('#invoice_type').val(" ");
       $('#Inbusiness_type').val(" ");
       $('#In_clientname').val("");
       $('#In_payment_status').val(" ");
       $('#In_year').val(" ");
       $("input[name='In_client_filter']:checked").prop("checked", false);
       $("input[name='In_payment_filter']:checked").prop("checked", false);
       $("input[name='In_year_filter']:checked").prop("checked", false);
       $('#contractbusinesstypediv').hide();
    $('#contractbusiness_type').val();
    $('#ContractfilterBydiv').hide();
    $('#Con_clientnamediv').hide();
    $('#Con_clientname').val("");
    $('#Conpaymentstatusdiv').hide();
    $('#Con_payment_status').val(" ");
    $('#Conyeardiv').hide();
    $('#Con_year').val(" ");
    $('#Conyearcategorydiv').hide();
    $("input[name='Con_client_filter']:checked").prop("checked", false);
    $("input[name='Con_payment_filter']:checked").prop("checked", false);
    $("input[name='Con_year_filter']:checked").prop("checked", false);
    $('#systemtypediv').hide();
    $('#systemfilterBydiv').hide();
    $('#systemstatusdiv').hide();
    $('#system_type').val(" ");
    $('#tenancy_businessdiv').hide();
  $('#tenancy_locationdiv').hide();
  $('#tenancyfilterBydiv').hide();
  $('#tenancy_business').val(" ");
    $('#tenancy_location').val(" ");
  $("input[name='tenancy_business_filter']:checked").prop("checked", false);
  $("input[name='tenancy_location_filter']:checked").prop("checked", false);
    $("input[name='system_status_filter']:checked").prop("checked", false);
    $('#summaryspacefilterBydiv').hide();
    $('#summaryspacefilterBydiv2').hide();
      $('#summaryshowcriteriadiv').hide();
      $('#summaryspacecriteriadiv').hide();
      $('#summary_businessdiv').hide();
      $('#summary_locationdiv').hide();
      $('#summarybiztypediv').hide();
      $('#summary_yeardiv').hide();
     $('#summary_start_date').val("");
      $('#summary_end_date').val("");
      $('#summarybiztype').val(" ");
      $('#summary_business').val(" ");
      $('#summary_location').val(" ");
      $("#summary_business_filter:checked").prop("checked", false);
      $("#summary_location_filter:checked").prop("checked", false);
      $("#summary_year_filter:checked").prop("checked", false);
      $("#summary_year_filter2:checked").prop("checked", false);
      $('#flatsreporttypediv').hide();
      $('#flatsrooms_filterBydiv').hide();
      $('#room_categoryDiv').hide();
      $('#flatscontracts_filterBydiv').hide();
      $('#flats_paymentDiv').hide();
      $('#flats_statusdiv').hide();
     }
     else if(query=='tenant'){
       $('#tenanttypediv').show();
       $('#spacetypediv').hide();
       $('#spacefilterdiv').hide();
       $('#space_industrydiv2').hide();
       $('#space_idDiv').hide();
       $('#spacefilterBydate').hide();
       $('#spacefilterBydiv').hide();
       $('#spacedatediv').hide();
       $('#spacepricediv').hide();
       $('#Locationtypediv').hide();
       $('#space_industrydiv').hide();
       $('#spaceoccupationdiv').hide();
       $('#insurancereporttypediv').hide();
       $('#InsurancefilterBydiv').hide();
       $('#InsurancefilterBytype').hide();
       $('#principaltypediv').hide();
       $('#insurancetypediv').hide();
       $('#insurancepackagediv').hide();
       $('#insuranceyeardiv').hide();
       $('#insurancedatediv').hide();
       $('#udiayeardiv').hide();
       $('#major_industry').val(" ");
       $('#space_id').val(" ");
       $('#start_date').val(" ");
       $('#end_date').val(" ");
       $('#min_price').val(" ");
       $('#max_price').val(" ");
       $('#space_status').val("");
       $('#Locationtype').val("");
       $("input[name='space_filter_date']:checked").prop("checked", false);
       $("input[name='space_prize']:checked").prop("checked", false);
       $("input[name='location_filter']:checked").prop("checked", false);
       $("input[name='industry_filter']:checked").prop("checked", false);
       $("input[name='status']:checked").prop("checked", false);
       $('#insurancereporttypediv').hide();
       $('#InsurancefilterBydiv').hide();
       $('#principaltypediv').hide();
       $('#insurancetypediv').hide();
       $('#cartypediv').hide();
       $('#car_type').val(" ");
       $('#carsfilterBydiv').hide();
       $('#carclientfilterBydiv').hide();
       $('#carrevenuefilterBydiv').hide();
       $('#carrevenuemodeldiv').hide();
   $('#carmodeldiv').hide();
    $('#carstatusdiv').hide();
    $('#carrangediv').hide();
    $('#rentstatusdiv').hide();
    $('#vehicleregdiv').hide();
    $('#rent_durationdiv').hide();
    $('#vehicle_reg').val("");
    $('#rent_start_date').val("");
    $('#rent_end_date').val("");
    $('#model').val("");
    $('#vehicle_status').val("");
    $('#carmin_price').val("");
    $('#carmax_price').val("");
    $('#rent_status').val("");
    $('#clientcostcentrediv').hide();
    $('#clientcontractdiv').hide();
    $('#clientdatediv').hide();
    $('#clientpaymentdiv').hide();
    $('#carhistoryfilterBydiv').hide();
    $('#clientcostcentre').val("");
    $('#client_start_date').val("");
    $('#client_end_date').val("");
    $('#carhistorydatediv').hide();
    $('#carhistory_start_date').val("");
    $('#carhistory_end_date').val("");
  $("input[name='cardate_histfil']:checked").prop("checked", false);
   $("input[name='carmodel_filter']:checked").prop("checked", false);
     $("input[name='carstatus_filter']:checked").prop("checked", false);
      $("input[name='carrange_filter']:checked").prop("checked", false);
       $("input[name='rentstatus_filter']:checked").prop("checked", false);
       $("input[name='clientcostcentre_filter']:checked").prop("checked", false);
        $("input[name='clientcontract_filter']:checked").prop("checked", false);
        $("input[name='clientdate_filter']:checked").prop("checked", false);
        $("input[name='clientpayment_filter']:checked").prop("checked", false);

       $("input[name='principal_filter']:checked").prop("checked", false);
       $("input[name='insurance_typefilter']:checked").prop("checked", false);
       $('#insurance_reporttype').val(" ");
       $('#principaltype').val(" ");
       $('#insurance_type').val(" ");
       $('#contracttypediv').hide();
       $('#contractbusinesstypediv').hide();
       $('#ContractfilterBydiv').hide();
       $('#clienttypediv').hide();
       $("input[name='client_filter']:checked").prop("checked", false);
       $('#contract_type').val(" ");
       $('#contractbusiness_type').val(" ");
       $('#client_type').val(" ");
       $('#revenue_durationdiv').hide();
       $('#invoicetypediv').hide();
       $('#InvoicefilterBydiv').hide();
       $('#Inbusinesstypediv').hide();
       $('#In_clientnamediv').hide();
       $('#Inpaymentstatusdiv').hide();
       $('#Inyeardiv').hide();
       $('#InSpaceCriteriadiv').hide();
       $('#invoice_type').val(" ");
       $('#Inbusiness_type').val(" ");
       $('#In_clientname').val("");
       $('#In_payment_status').val(" ");
       $('#In_year').val(" ");
       $("input[name='In_client_filter']:checked").prop("checked", false);
       $("input[name='In_payment_filter']:checked").prop("checked", false);
       $("input[name='In_year_filter']:checked").prop("checked", false);
       $('#contractbusinesstypediv').hide();
    $('#contractbusiness_type').val();
    $('#ContractfilterBydiv').hide();
    $('#Con_clientnamediv').hide();
    $('#Con_clientname').val("");
    $('#Conpaymentstatusdiv').hide();
    $('#Con_payment_status').val(" ");
    $('#Conyeardiv').hide();
    $('#Con_year').val(" ");
    $('#Conyearcategorydiv').hide();
    $("input[name='Con_client_filter']:checked").prop("checked", false);
    $("input[name='Con_payment_filter']:checked").prop("checked", false);
    $("input[name='Con_year_filter']:checked").prop("checked", false);
    $('#systemtypediv').hide();
    $('#systemfilterBydiv').hide();
    $('#systemstatusdiv').hide();
    $('#system_type').val(" ");
    $("input[name='system_status_filter']:checked").prop("checked", false);
    $('#summaryspacefilterBydiv').hide();
    $('#summaryspacefilterBydiv2').hide();
      $('#summaryshowcriteriadiv').hide();
      $('#summaryspacecriteriadiv').hide();
      $('#summary_businessdiv').hide();
      $('#summary_locationdiv').hide();
      $('#summary_yeardiv').hide();
      $('#summary_start_date').val("");
      $('#summary_end_date').val("");
      $('#summarybiztypediv').hide();
      $('#summarybiztype').val(" ");
      $('#summary_business').val(" ");
      $('#summary_location').val(" ");
      $("#summary_business_filter:checked").prop("checked", false);
      $("#summary_location_filter:checked").prop("checked", false);
      $("#summary_year_filter:checked").prop("checked", false);
      $("#summary_year_filter2:checked").prop("checked", false);
      $('#flatsreporttypediv').hide();
      $('#flatsrooms_filterBydiv').hide();
      $('#room_categoryDiv').hide();
      $('#flatscontracts_filterBydiv').hide();
      $('#flats_paymentDiv').hide();
      $('#flats_statusdiv').hide();
     }
     else if(query=='car'){
      $('#insurancereporttypediv').hide();
       $('#InsurancefilterBydiv').hide();
       $('#InsurancefilterBytype').hide();
       $('#principaltypediv').hide();
       $('#insurancetypediv').hide();
       $('#insurancepackagediv').hide();
       $('#insuranceyeardiv').hide();
       $('#insurancedatediv').hide();
       $('#udiayeardiv').hide();
      $('#cartypediv').show();
       $('#spacetypediv').hide();
       $('#spacefilterdiv').hide();
       $('#space_industrydiv2').hide();
       $('#space_idDiv').hide();
       $('#spacefilterBydate').hide();
       $('#spacefilterBydiv').hide();
       $('#spacedatediv').hide();
       $('#spacepricediv').hide();
       $('#Locationtypediv').hide();
       $('#space_industrydiv').hide();
       $('#spaceoccupationdiv').hide();
       $('#TenantfilterBydiv').hide();
       $('#tenancysheduleduration').hide();
       $('#businesstypediv').hide();
       $('#contractstatusdiv').hide();
       $('#paymentstatusdiv').hide();
       $('#tenanttypediv').hide();
       $('#major_industry').val(" ");
       $('#space_id').val(" ");
       $('#start_date').val(" ");
       $('#end_date').val(" ");
       $('#min_price').val(" ");
       $('#max_price').val(" ");
       $('#space_status').val("");
       $('#Locationtype').val("");
       $('#insurance_reporttype').val(" ");
       $('#principaltype').val(" ");
       $('#insurance_type').val(" ");
       $('#business_type').val(" ");
       $('#contract_status').val(" ");
       $('#payment_status').val(" ");
       $('#tenant_type').val(" ");
       $("input[name='space_filter_date']:checked").prop("checked", false);
       $("input[name='space_prize']:checked").prop("checked", false);
       $("input[name='location_filter']:checked").prop("checked", false);
       $("input[name='industry_filter']:checked").prop("checked", false);
       $("input[name='status']:checked").prop("checked", false);
       $("input[name='business_filter']:checked").prop("checked", false);
       $("input[name='contract_filter']:checked").prop("checked", false);
       $("input[name='payment_filter']:checked").prop("checked", false);
       $("input[name='principal_filter']:checked").prop("checked", false);
       $("input[name='insurance_typefilter']:checked").prop("checked", false);
       $('#TenantInvoiceCriteriadiv').hide();
       $('#t_invoicedurationdiv').hide();
       $('#TenantInvoicefilterBydiv').hide();
       $('#tInvoicepaymentstatusdiv').hide();
       $("input[name='t_invoice_payment_filter']:checked").prop("checked", false);
      $('#t_Invoice_start_date').val('');
      $('#t_invoice_end_date').val('');
       $('#t_invoicepayment_status').val(' ');
       $('#contracttypediv').hide();
       $('#contractbusinesstypediv').hide();
       $('#ContractfilterBydiv').hide();
       $('#clienttypediv').hide();
       $("input[name='client_filter']:checked").prop("checked", false);
       $('#contract_type').val(" ");
       $('#contractbusiness_type').val(" ");
       $('#client_type').val(" ");
       $('#invoicetypediv').hide();
       $('#InvoicefilterBydiv').hide();
       $('#Inbusinesstypediv').hide();
       $('#In_clientnamediv').hide();
       $('#Inpaymentstatusdiv').hide();
       $('#Inyeardiv').hide();
       $('#InSpaceCriteriadiv').hide();
       $('#invoice_type').val(" ");
       $('#Inbusiness_type').val(" ");
       $('#In_clientname').val("");
       $('#In_payment_status').val(" ");
       $('#In_year').val(" ");
       $("input[name='In_client_filter']:checked").prop("checked", false);
       $("input[name='In_payment_filter']:checked").prop("checked", false);
       $("input[name='In_year_filter']:checked").prop("checked", false);
       $('#contractbusinesstypediv').hide();
    $('#contractbusiness_type').val();
    $('#ContractfilterBydiv').hide();
    $('#Con_clientnamediv').hide();
    $('#Con_clientname').val("");
    $('#Conpaymentstatusdiv').hide();
    $('#Con_payment_status').val(" ");
    $('#Conyeardiv').hide();
    $('#Con_year').val(" ");
    $('#Conyearcategorydiv').hide();
    $("input[name='Con_client_filter']:checked").prop("checked", false);
    $("input[name='Con_payment_filter']:checked").prop("checked", false);
    $("input[name='Con_year_filter']:checked").prop("checked", false);
    $('#systemtypediv').hide();
    $('#systemfilterBydiv').hide();
    $('#systemstatusdiv').hide();
    $('#system_type').val(" ");
    $('#tenancy_businessdiv').hide();
    $('#tenancy_locationdiv').hide();
    $('#tenancyfilterBydiv').hide();
    $('#tenancy_business').val(" ");
    $('#tenancy_location').val(" ");
    $("input[name='tenancy_business_filter']:checked").prop("checked", false);
    $("input[name='tenancy_location_filter']:checked").prop("checked", false);
    $("input[name='system_status_filter']:checked").prop("checked", false);
    $('#summaryspacefilterBydiv').hide();
    $('#summaryspacefilterBydiv2').hide();
      $('#summaryshowcriteriadiv').hide();
      $('#summaryspacecriteriadiv').hide();
      $('#summary_businessdiv').hide();
      $('#summary_locationdiv').hide();
      $('#summarybiztypediv').hide();
      $('#summary_yeardiv').hide();
      $('#summary_start_date').val("");
      $('#summary_end_date').val("");
      $('#summarybiztype').val(" ");
      $('#summary_business').val(" ");
      $('#summary_location').val(" ");
      $("#summary_business_filter:checked").prop("checked", false);
      $("#summary_location_filter:checked").prop("checked", false);
      $("#summary_year_filter:checked").prop("checked", false);
      $("#summary_year_filter2:checked").prop("checked", false);
      $('#flatsreporttypediv').hide();
      $('#flatsrooms_filterBydiv').hide();
      $('#room_categoryDiv').hide();
      $('#flatscontracts_filterBydiv').hide();
      $('#flats_paymentDiv').hide();
      $('#flats_statusdiv').hide();
     }

     else if(query=='contract'){
      $('#contracttypediv').show();
      $('#insurancereporttypediv').hide();
       $('#InsurancefilterBydiv').hide();
       $('#InsurancefilterBytype').hide();
       $('#principaltypediv').hide();
       $('#insurancetypediv').hide();
       $('#insurancepackagediv').hide();
       $('#insuranceyeardiv').hide();
       $('#insurancedatediv').hide();
       $('#udiayeardiv').hide();
       $('#TenantfilterBydiv').hide();
       $('#tenancysheduleduration').hide();
       $('#businesstypediv').hide();
       $('#contractstatusdiv').hide();
       $('#paymentstatusdiv').hide();
       $("input[name='principal_filter']:checked").prop("checked", false);
       $("input[name='insurance_typefilter']:checked").prop("checked", false);
       $("input[name='business_filter']:checked").prop("checked", false);
       $("input[name='contract_filter']:checked").prop("checked", false);
       $("input[name='payment_filter']:checked").prop("checked", false);
       $('#TenantInvoiceCriteriadiv').hide();
       $('#t_invoicedurationdiv').hide();
       $('#TenantInvoicefilterBydiv').hide();
      $('#tInvoicepaymentstatusdiv').hide();
      $("input[name='t_invoice_payment_filter']:checked").prop("checked", false);
  $('#t_Invoice_start_date').val('');
  $('#t_invoice_end_date').val('');
  $('#t_invoicepayment_status').val(' ');
       $('#insurance_reporttype').val(" ");
       $('#principaltype').val(" ");
       $('#insurance_type').val(" ");
       $('#tenant_type').val(" ");
       $('#business_type').val(" ");
       $('#contract_status').val(" ");
       $('#payment_status').val(" ");
       $('#cartypediv').hide();
       $('#car_type').val(" ");
       $('#carsfilterBydiv').hide();
       $('#carclientfilterBydiv').hide();
       $('#carrevenuefilterBydiv').hide();
       $('#carrevenuemodeldiv').hide();
   $('#carmodeldiv').hide();
    $('#carstatusdiv').hide();
    $('#carrangediv').hide();
    $('#rentstatusdiv').hide();
    $('#vehicleregdiv').hide();
    $('#rent_durationdiv').hide();
    $('#vehicle_reg').val("");
    $('#rent_start_date').val("");
    $('#rent_end_date').val("");
    $('#model').val("");
    $('#vehicle_status').val("");
    $('#carmin_price').val("");
    $('#carmax_price').val("");
    $('#rent_status').val("");
    $('#clientcostcentrediv').hide();
    $('#clientcontractdiv').hide();
    $('#clientdatediv').hide();
    $('#clientpaymentdiv').hide();
    $('#carhistoryfilterBydiv').hide();
    $('#clientcostcentre').val("");
    $('#client_start_date').val("");
    $('#client_end_date').val("");
    $('#carhistorydatediv').hide();
    $('#carhistory_start_date').val("");
    $('#carhistory_end_date').val("");
  $("input[name='cardate_histfil']:checked").prop("checked", false);
   $("input[name='carmodel_filter']:checked").prop("checked", false);
     $("input[name='carstatus_filter']:checked").prop("checked", false);
      $("input[name='carrange_filter']:checked").prop("checked", false);
       $("input[name='rentstatus_filter']:checked").prop("checked", false);
       $("input[name='clientcostcentre_filter']:checked").prop("checked", false);
        $("input[name='clientcontract_filter']:checked").prop("checked", false);
        $("input[name='clientdate_filter']:checked").prop("checked", false);
        $("input[name='clientpayment_filter']:checked").prop("checked", false);
       $('#tenanttypediv').hide();
       $('#spacetypediv').hide();
       $('#spacefilterdiv').hide();
       $('#space_industrydiv2').hide();
       $('#space_idDiv').hide();
       $('#spacefilterBydate').hide();
       $('#spacefilterBydiv').hide();
       $('#spacedatediv').hide();
       $('#spacepricediv').hide();
       $('#Locationtypediv').hide();
       $('#space_industrydiv').hide();
       $('#spaceoccupationdiv').hide();
       $('#major_industry').val(" ");
       $('#space_id').val(" ");
       $('#start_date').val(" ");
       $('#end_date').val(" ");
       $('#min_price').val(" ");
       $('#max_price').val(" ");
       $('#space_status').val("");
       $('#Locationtype').val("");
       $('#revenue_durationdiv').hide();
       $("input[name='space_filter_date']:checked").prop("checked", false);
       $("input[name='space_prize']:checked").prop("checked", false);
       $("input[name='location_filter']:checked").prop("checked", false);
       $("input[name='industry_filter']:checked").prop("checked", false);
       $('#invoicetypediv').hide();
       $('#InvoicefilterBydiv').hide();
       $('#Inbusinesstypediv').hide();
       $('#In_clientnamediv').hide();
       $('#Inpaymentstatusdiv').hide();
       $('#Inyeardiv').hide();
       $('#InSpaceCriteriadiv').hide();
       $('#invoice_type').val(" ");
       $('#Inbusiness_type').val(" ");
       $('#In_clientname').val("");
       $('#In_payment_status').val(" ");
       $('#In_year').val(" ");
       $("input[name='In_client_filter']:checked").prop("checked", false);
       $("input[name='In_payment_filter']:checked").prop("checked", false);
       $("input[name='In_year_filter']:checked").prop("checked", false);
       $('#systemtypediv').hide();
        $('#systemfilterBydiv').hide();
      $('#systemstatusdiv').hide();
      $('#system_type').val(" ");
      $('#tenancy_businessdiv').hide();
      $('#tenancy_locationdiv').hide();
      $('#tenancyfilterBydiv').hide();
      $('#tenancy_business').val(" ");
      $('#tenancy_location').val(" ");
      $("input[name='tenancy_business_filter']:checked").prop("checked", false);
      $("input[name='tenancy_location_filter']:checked").prop("checked", false);
    $("input[name='system_status_filter']:checked").prop("checked", false);
    $('#summaryspacefilterBydiv').hide();
    $('#summaryspacefilterBydiv2').hide();
      $('#summaryshowcriteriadiv').hide();
      $('#summaryspacecriteriadiv').hide();
      $('#summary_businessdiv').hide();
      $('#summary_locationdiv').hide();
      $('#summarybiztypediv').hide();
      $('#summary_yeardiv').hide();
      $('#summary_start_date').val("");
      $('#summary_end_date').val("");
      $('#summarybiztype').val(" ");
      $('#summary_business').val(" ");
      $('#summary_location').val(" ");
      $("#summary_business_filter:checked").prop("checked", false);
      $("#summary_location_filter:checked").prop("checked", false);
      $("#summary_year_filter:checked").prop("checked", false);
      $("#summary_year_filter2:checked").prop("checked", false);
      $('#flatsreporttypediv').hide();
      $('#flatsrooms_filterBydiv').hide();
      $('#room_categoryDiv').hide();
      $('#flatscontracts_filterBydiv').hide();
      $('#flats_paymentDiv').hide();
      $('#flats_statusdiv').hide();
     }
     else if(query=='invoice'){
      $('#invoicetypediv').show();
      $('#contracttypediv').hide();
      $('#insurancereporttypediv').hide();
       $('#InsurancefilterBydiv').hide();
       $('#InsurancefilterBytype').hide();
       $('#principaltypediv').hide();
       $('#insurancetypediv').hide();
       $('#insurancepackagediv').hide();
       $('#insuranceyeardiv').hide();
       $('#insurancedatediv').hide();
       $('#udiayeardiv').hide();
       $('#TenantfilterBydiv').hide();
       $('#tenancysheduleduration').hide();
       $('#businesstypediv').hide();
       $('#contractstatusdiv').hide();
       $('#paymentstatusdiv').hide();
       $("input[name='principal_filter']:checked").prop("checked", false);
       $("input[name='insurance_typefilter']:checked").prop("checked", false);
       $("input[name='business_filter']:checked").prop("checked", false);
       $("input[name='contract_filter']:checked").prop("checked", false);
       $("input[name='payment_filter']:checked").prop("checked", false);
       $('#TenantInvoiceCriteriadiv').hide();
       $('#t_invoicedurationdiv').hide();
       $('#TenantInvoicefilterBydiv').hide();
      $('#tInvoicepaymentstatusdiv').hide();
      $("input[name='t_invoice_payment_filter']:checked").prop("checked", false);
  $('#t_Invoice_start_date').val('');
  $('#t_invoice_end_date').val('');
  $('#t_invoicepayment_status').val(' ');
       $('#insurance_reporttype').val(" ");
       $('#principaltype').val(" ");
       $('#insurance_type').val(" ");
       $('#tenant_type').val(" ");
       $('#business_type').val(" ");
       $('#contract_status').val(" ");
       $('#payment_status').val(" ");
       $('#cartypediv').hide();
       $('#car_type').val(" ");
       $('#carsfilterBydiv').hide();
       $('#carclientfilterBydiv').hide();
       $('#carrevenuefilterBydiv').hide();
       $('#carrevenuemodeldiv').hide();
   $('#carmodeldiv').hide();
    $('#carstatusdiv').hide();
    $('#carrangediv').hide();
    $('#rentstatusdiv').hide();
    $('#vehicleregdiv').hide();
    $('#rent_durationdiv').hide();
    $('#vehicle_reg').val("");
    $('#rent_start_date').val("");
    $('#rent_end_date').val("");
    $('#model').val("");
    $('#vehicle_status').val("");
    $('#carmin_price').val("");
    $('#carmax_price').val("");
    $('#rent_status').val("");
    $('#clientcostcentrediv').hide();
    $('#clientcontractdiv').hide();
    $('#clientdatediv').hide();
    $('#clientpaymentdiv').hide();
    $('#carhistoryfilterBydiv').hide();
    $('#clientcostcentre').val("");
    $('#client_start_date').val("");
    $('#client_end_date').val("");
    $('#carhistorydatediv').hide();
    $('#carhistory_start_date').val("");
    $('#carhistory_end_date').val("");
  $("input[name='cardate_histfil']:checked").prop("checked", false);
   $("input[name='carmodel_filter']:checked").prop("checked", false);
     $("input[name='carstatus_filter']:checked").prop("checked", false);
      $("input[name='carrange_filter']:checked").prop("checked", false);
       $("input[name='rentstatus_filter']:checked").prop("checked", false);
       $("input[name='clientcostcentre_filter']:checked").prop("checked", false);
        $("input[name='clientcontract_filter']:checked").prop("checked", false);
        $("input[name='clientdate_filter']:checked").prop("checked", false);
        $("input[name='clientpayment_filter']:checked").prop("checked", false);
       $('#tenanttypediv').hide();
       $('#spacetypediv').hide();
       $('#spacefilterdiv').hide();
       $('#space_industrydiv2').hide();
       $('#space_idDiv').hide();
       $('#spacefilterBydate').hide();
       $('#spacefilterBydiv').hide();
       $('#spacedatediv').hide();
       $('#spacepricediv').hide();
       $('#Locationtypediv').hide();
       $('#space_industrydiv').hide();
       $('#spaceoccupationdiv').hide();
       $('#space_type').val(" ");
       $('#space_id').val(" ");
       $('#start_date').val(" ");
       $('#end_date').val(" ");
       $('#min_price').val(" ");
       $('#max_price').val(" ");
       $('#space_status').val("");
       $('#Locationtype').val("");
       $('#revenue_durationdiv').hide();
       $("input[name='space_filter_date']:checked").prop("checked", false);
       $("input[name='space_prize']:checked").prop("checked", false);
       $("input[name='location_filter']:checked").prop("checked", false);
       $("input[name='industry_filter']:checked").prop("checked", false);
       $('#contractbusinesstypediv').hide();
    $('#contractbusiness_type').val();
    $('#ContractfilterBydiv').hide();
    $('#Con_clientnamediv').hide();
    $('#Con_clientname').val("");
    $('#Conpaymentstatusdiv').hide();
    $('#Con_payment_status').val(" ");
    $('#Conyeardiv').hide();
    $('#Con_year').val(" ");
    $('#Conyearcategorydiv').hide();
    $("input[name='Con_client_filter']:checked").prop("checked", false);
    $("input[name='Con_payment_filter']:checked").prop("checked", false);
    $("input[name='Con_year_filter']:checked").prop("checked", false);
    $('#systemtypediv').hide();
    $('#systemfilterBydiv').hide();
    $('#systemstatusdiv').hide();
    $('#system_type').val(" ");
    $('#tenancy_businessdiv').hide();
    $('#tenancy_locationdiv').hide();
    $('#tenancyfilterBydiv').hide();
    $('#tenancy_business').val(" ");
    $('#tenancy_location').val(" ");
    $("input[name='tenancy_business_filter']:checked").prop("checked", false);
    $("input[name='tenancy_location_filter']:checked").prop("checked", false);
    $("input[name='system_status_filter']:checked").prop("checked", false);
    $('#flatsreporttypediv').hide();
      $('#flatsrooms_filterBydiv').hide();
      $('#room_categoryDiv').hide();
      $('#flatscontracts_filterBydiv').hide();
      $('#flats_paymentDiv').hide();
      $('#flats_statusdiv').hide();
     }
     else if(query=='system'){
      $('#spacetypediv').hide();
      $('#spacefilterdiv').hide();
      $('#space_industrydiv2').hide();
       $('#space_idDiv').hide();
       $('#spacefilterBydate').hide();
       $('#spacefilterBydiv').hide();
       $('#spacedatediv').hide();
       $('#spacepricediv').hide();
       $('#Locationtypediv').hide();
       $('#space_industrydiv').hide();
       $('#spaceoccupationdiv').hide();
       $('#TenantfilterBydiv').hide();
       $('#tenancysheduleduration').hide();
       $('#businesstypediv').hide();
       $('#contractstatusdiv').hide();
       $('#paymentstatusdiv').hide();
       $('#major_industry').val(" ");
       $('#space_id').val(" ");
       $('#start_date').val(" ");
       $('#end_date').val(" ");
       $('#min_price').val(" ");
       $('#max_price').val(" ");
       $('#space_status').val("");
       $('#Locationtype').val("");
       $("input[name='space_filter_date']:checked").prop("checked", false);
       $("input[name='space_prize']:checked").prop("checked", false);
       $("input[name='location_filter']:checked").prop("checked", false);
       $("input[name='industry_filter']:checked").prop("checked", false);
       $("input[name='status']:checked").prop("checked", false);

       $('#insurancereporttypediv').hide();
       $('#InsurancefilterBydiv').hide();
       $('#InsurancefilterBytype').hide();
       $('#principaltypediv').hide();
       $('#insurancepackagediv').hide();
       $('#insuranceyeardiv').hide();
       $('#insurancedatediv').hide();
       $('#udiayeardiv').hide();
       $('#insurancetypediv').hide();
       $('#TenantfilterBydiv').hide();
       $('#businesstypediv').hide();
       $('#contractstatusdiv').hide();
       $('#paymentstatusdiv').hide();
       $("input[name='principal_filter']:checked").prop("checked", false);
       $("input[name='insurance_typefilter']:checked").prop("checked", false);
       $("input[name='business_filter']:checked").prop("checked", false);
       $("input[name='contract_filter']:checked").prop("checked", false);
       $("input[name='payment_filter']:checked").prop("checked", false);
       $('#TenantInvoiceCriteriadiv').hide();
       $('#t_invoicedurationdiv').hide();
       $('#TenantInvoicefilterBydiv').hide();
       $('#tInvoicepaymentstatusdiv').hide();
       $("input[name='t_invoice_payment_filter']:checked").prop("checked", false);
       $('#t_Invoice_start_date').val('');
       $('#t_invoice_end_date').val('');
       $('#t_invoicepayment_status').val(' ');
       $('#insurance_reporttype').val(" ");
       $('#principaltype').val(" ");
       $('#insurance_type').val(" ");
       $('#tenant_type').val(" ");
       $('#business_type').val(" ");
       $('#contract_status').val(" ");
       $('#payment_status').val(" ");
       $('#cartypediv').hide();
       $('#carsfilterBydiv').hide();
       $('#carclientfilterBydiv').hide();
       $('#carrevenuefilterBydiv').hide();
       $('#carrevenuemodeldiv').hide();
   $('#carmodeldiv').hide();
    $('#carstatusdiv').hide();
    $('#carrangediv').hide();
    $('#rentstatusdiv').hide();
    $('#vehicleregdiv').hide();
    $('#rent_durationdiv').hide();
    $('#vehicle_reg').val("");
    $('#rent_start_date').val("");
    $('#rent_end_date').val("");
    $('#model').val("");
    $('#vehicle_status').val("");
    $('#carmin_price').val("");
    $('#carmax_price').val("");
    $('#rent_status').val("");
    $('#clientcostcentrediv').hide();
    $('#clientcontractdiv').hide();
    $('#clientdatediv').hide();
    $('#clientpaymentdiv').hide();
    $('#carhistoryfilterBydiv').hide();
    $('#clientcostcentre').val("");
    $('#client_start_date').val("");
    $('#client_end_date').val("");
    $('#carhistorydatediv').hide();
    $('#carhistory_start_date').val("");
    $('#carhistory_end_date').val("");
  $("input[name='cardate_histfil']:checked").prop("checked", false);
   $("input[name='carmodel_filter']:checked").prop("checked", false);
     $("input[name='carstatus_filter']:checked").prop("checked", false);
      $("input[name='carrange_filter']:checked").prop("checked", false);
       $("input[name='rentstatus_filter']:checked").prop("checked", false);
        $("input[name='clientcostcentre_filter']:checked").prop("checked", false);
        $("input[name='clientcontract_filter']:checked").prop("checked", false);
        $("input[name='clientdate_filter']:checked").prop("checked", false);
        $("input[name='clientpayment_filter']:checked").prop("checked", false);
       $('#revenue_durationdiv').hide();
       $('#car_type').val(" ");
       $('#tenanttypediv').hide();
       $('#contracttypediv').hide();
       $('#contractbusinesstypediv').hide();
       $('#ContractfilterBydiv').hide();
       $('#clienttypediv').hide();
       $("input[name='client_filter']:checked").prop("checked", false);
       $('#contract_type').val(" ");
       $('#contractbusiness_type').val(" ");
       $('#client_type').val(" ");
       $('#invoicetypediv').hide();
       $('#InvoicefilterBydiv').hide();
       $('#Inbusinesstypediv').hide();
       $('#In_clientnamediv').hide();
       $('#Inpaymentstatusdiv').hide();
       $('#Inyeardiv').hide();
       $('#InSpaceCriteriadiv').hide();
       $('#invoice_type').val(" ");
       $('#Inbusiness_type').val(" ");
       $('#In_clientname').val("");
       $('#In_payment_status').val(" ");
       $('#In_year').val(" ");
       $("input[name='In_client_filter']:checked").prop("checked", false);
       $("input[name='In_payment_filter']:checked").prop("checked", false);
       $("input[name='In_year_filter']:checked").prop("checked", false);
    $('#contractbusinesstypediv').hide();
    $('#contractbusiness_type').val();
    $('#ContractfilterBydiv').hide();
    $('#Con_clientnamediv').hide();
    $('#Con_clientname').val("");
    $('#Conpaymentstatusdiv').hide();
    $('#Con_payment_status').val(" ");
    $('#Conyeardiv').hide();
    $('#Con_year').val(" ");
    $('#Conyearcategorydiv').hide();
    $("input[name='Con_client_filter']:checked").prop("checked", false);
    $("input[name='Con_payment_filter']:checked").prop("checked", false);
    $("input[name='Con_year_filter']:checked").prop("checked", false);
    $('#tenancy_businessdiv').hide();
    $('#tenancy_locationdiv').hide();
    $('#tenancyfilterBydiv').hide();
    $('#tenancy_business').val(" ");
    $('#tenancy_location').val(" ");
    $("input[name='tenancy_business_filter']:checked").prop("checked", false);
    $("input[name='tenancy_location_filter']:checked").prop("checked", false);
    $('#systemtypediv').show();
    $('#summaryspacefilterBydiv').hide();
    $('#summaryspacefilterBydiv2').hide();
      $('#summaryshowcriteriadiv').hide();
      $('#summaryspacecriteriadiv').hide();
      $('#summary_businessdiv').hide();
      $('#summary_locationdiv').hide();
      $('#summarybiztypediv').hide();
      $('#summary_yeardiv').hide();
      $('#summary_start_date').val("");
      $('#summary_end_date').val("");
      $('#summarybiztype').val(" ");
      $('#summary_business').val(" ");
      $('#summary_location').val(" ");
      $("#summary_business_filter:checked").prop("checked", false);
      $("#summary_location_filter:checked").prop("checked", false);
      $("#summary_year_filter:checked").prop("checked", false);
      $("#summary_year_filter:checked").prop("checked", false);
      $('#flatsreporttypediv').hide();
      $('#flatsrooms_filterBydiv').hide();
      $('#room_categoryDiv').hide();
      $('#flatscontracts_filterBydiv').hide();
      $('#flats_paymentDiv').hide();
      $('#flats_statusdiv').hide();
     }

    else if(query=='research_flats'){
      $('#flatsreporttypediv').show();
      $('#spacetypediv').hide();
      $('#spacefilterdiv').hide();
      $('#space_industrydiv2').hide();
       $('#space_idDiv').hide();
       $('#spacefilterBydate').hide();
       $('#spacefilterBydiv').hide();
       $('#spacedatediv').hide();
       $('#spacepricediv').hide();
       $('#Locationtypediv').hide();
       $('#space_industrydiv').hide();
       $('#spaceoccupationdiv').hide();
       $('#TenantfilterBydiv').hide();
       $('#tenancysheduleduration').hide();
       $('#businesstypediv').hide();
       $('#contractstatusdiv').hide();
       $('#paymentstatusdiv').hide();
       $('#major_industry').val(" ");
       $('#space_id').val(" ");
       $('#start_date').val(" ");
       $('#end_date').val(" ");
       $('#min_price').val(" ");
       $('#max_price').val(" ");
       $('#space_status').val("");
       $('#Locationtype').val("");
       $("input[name='space_filter_date']:checked").prop("checked", false);
       $("input[name='space_prize']:checked").prop("checked", false);
       $("input[name='location_filter']:checked").prop("checked", false);
       $("input[name='industry_filter']:checked").prop("checked", false);
       $("input[name='status']:checked").prop("checked", false);

       $('#insurancereporttypediv').hide();
       $('#InsurancefilterBydiv').hide();
       $('#InsurancefilterBytype').hide();
       $('#principaltypediv').hide();
       $('#insurancepackagediv').hide();
       $('#insuranceyeardiv').hide();
       $('#insurancedatediv').hide();
       $('#udiayeardiv').hide();
       $('#insurancetypediv').hide();
       $('#TenantfilterBydiv').hide();
       $('#businesstypediv').hide();
       $('#contractstatusdiv').hide();
       $('#paymentstatusdiv').hide();
       $("input[name='principal_filter']:checked").prop("checked", false);
       $("input[name='insurance_typefilter']:checked").prop("checked", false);
       $("input[name='business_filter']:checked").prop("checked", false);
       $("input[name='contract_filter']:checked").prop("checked", false);
       $("input[name='payment_filter']:checked").prop("checked", false);
       $('#TenantInvoiceCriteriadiv').hide();
       $('#t_invoicedurationdiv').hide();
       $('#TenantInvoicefilterBydiv').hide();
       $('#tInvoicepaymentstatusdiv').hide();
       $("input[name='t_invoice_payment_filter']:checked").prop("checked", false);
       $('#t_Invoice_start_date').val('');
       $('#t_invoice_end_date').val('');
       $('#t_invoicepayment_status').val(' ');
       $('#insurance_reporttype').val(" ");
       $('#principaltype').val(" ");
       $('#insurance_type').val(" ");
       $('#tenant_type').val(" ");
       $('#business_type').val(" ");
       $('#contract_status').val(" ");
       $('#payment_status').val(" ");
       $('#cartypediv').hide();
       $('#carsfilterBydiv').hide();
       $('#carclientfilterBydiv').hide();
       $('#carrevenuefilterBydiv').hide();
       $('#carrevenuemodeldiv').hide();
   $('#carmodeldiv').hide();
    $('#carstatusdiv').hide();
    $('#carrangediv').hide();
    $('#rentstatusdiv').hide();
    $('#vehicleregdiv').hide();
    $('#rent_durationdiv').hide();
    $('#vehicle_reg').val("");
    $('#rent_start_date').val("");
    $('#rent_end_date').val("");
    $('#model').val("");
    $('#vehicle_status').val("");
    $('#carmin_price').val("");
    $('#carmax_price').val("");
    $('#rent_status').val("");
    $('#clientcostcentrediv').hide();
    $('#clientcontractdiv').hide();
    $('#clientdatediv').hide();
    $('#clientpaymentdiv').hide();
    $('#carhistoryfilterBydiv').hide();
    $('#clientcostcentre').val("");
    $('#client_start_date').val("");
    $('#client_end_date').val("");
    $('#carhistorydatediv').hide();
    $('#carhistory_start_date').val("");
    $('#carhistory_end_date').val("");
  $("input[name='cardate_histfil']:checked").prop("checked", false);
   $("input[name='carmodel_filter']:checked").prop("checked", false);
     $("input[name='carstatus_filter']:checked").prop("checked", false);
      $("input[name='carrange_filter']:checked").prop("checked", false);
       $("input[name='rentstatus_filter']:checked").prop("checked", false);
        $("input[name='clientcostcentre_filter']:checked").prop("checked", false);
        $("input[name='clientcontract_filter']:checked").prop("checked", false);
        $("input[name='clientdate_filter']:checked").prop("checked", false);
        $("input[name='clientpayment_filter']:checked").prop("checked", false);
       $('#revenue_durationdiv').hide();
       $('#car_type').val(" ");
       $('#tenanttypediv').hide();
       $('#contracttypediv').hide();
       $('#contractbusinesstypediv').hide();
       $('#ContractfilterBydiv').hide();
       $('#clienttypediv').hide();
       $("input[name='client_filter']:checked").prop("checked", false);
       $('#contract_type').val(" ");
       $('#contractbusiness_type').val(" ");
       $('#client_type').val(" ");
       $('#invoicetypediv').hide();
       $('#InvoicefilterBydiv').hide();
       $('#Inbusinesstypediv').hide();
       $('#In_clientnamediv').hide();
       $('#Inpaymentstatusdiv').hide();
       $('#Inyeardiv').hide();
       $('#InSpaceCriteriadiv').hide();
       $('#invoice_type').val(" ");
       $('#Inbusiness_type').val(" ");
       $('#In_clientname').val("");
       $('#In_payment_status').val(" ");
       $('#In_year').val(" ");
       $("input[name='In_client_filter']:checked").prop("checked", false);
       $("input[name='In_payment_filter']:checked").prop("checked", false);
       $("input[name='In_year_filter']:checked").prop("checked", false);
    $('#contractbusinesstypediv').hide();
    $('#contractbusiness_type').val();
    $('#ContractfilterBydiv').hide();
    $('#Con_clientnamediv').hide();
    $('#Con_clientname').val("");
    $('#Conpaymentstatusdiv').hide();
    $('#Con_payment_status').val(" ");
    $('#Conyeardiv').hide();
    $('#Con_year').val(" ");
    $('#Conyearcategorydiv').hide();
    $("input[name='Con_client_filter']:checked").prop("checked", false);
    $("input[name='Con_payment_filter']:checked").prop("checked", false);
    $("input[name='Con_year_filter']:checked").prop("checked", false);
    $('#tenancy_businessdiv').hide();
    $('#tenancy_locationdiv').hide();
    $('#tenancyfilterBydiv').hide();
    $('#tenancy_business').val(" ");
    $('#tenancy_location').val(" ");
    $("input[name='tenancy_business_filter']:checked").prop("checked", false);
    $("input[name='tenancy_location_filter']:checked").prop("checked", false);
    $('#systemtypediv').show();
    $('#summaryspacefilterBydiv').hide();
    $('#summaryspacefilterBydiv2').hide();
      $('#summaryshowcriteriadiv').hide();
      $('#summaryspacecriteriadiv').hide();
      $('#summary_businessdiv').hide();
      $('#summary_locationdiv').hide();
      $('#summarybiztypediv').hide();
      $('#summary_yeardiv').hide();
      $('#summary_start_date').val("");
      $('#summary_end_date').val("");
      $('#summarybiztype').val(" ");
      $('#summary_business').val(" ");
      $('#summary_location').val(" ");
      $("#summary_business_filter:checked").prop("checked", false);
      $("#summary_location_filter:checked").prop("checked", false);
      $("#summary_year_filter:checked").prop("checked", false);
      $("#summary_year_filter:checked").prop("checked", false);
      $('#systemtypediv').hide();
    $('#systemfilterBydiv').hide();
    $('#systemstatusdiv').hide();
    $('#system_type').val(" ");
     }
    });

    $("#invoice_type").click(function(){
     var query = $(this).val();
     if(query=='list'){
      $('#Inbusinesstypediv').show();
      $('#summarybiztypediv').hide();
      $('#summaryspacefilterBydiv').hide();
      $('#summaryspacefilterBydiv2').hide();
      $('#summaryshowcriteriadiv').hide();
      $('#summaryspacecriteriadiv').hide();
      $('#summary_businessdiv').hide();
      $('#summary_locationdiv').hide();
      $('#summary_yeardiv').hide();
      $('#summary_start_date').val("");
      $('#summary_end_date').val("");
      $('#summarybiztype').val(" ");
      $('#summary_business').val(" ");
      $('#summary_location').val(" ");
      $("#summary_business_filter:checked").prop("checked", false);
      $("#summary_location_filter:checked").prop("checked", false);
      $("#summary_year_filter:checked").prop("checked", false);
      $("#summary_year_filter2:checked").prop("checked", false);
     }
     else if(query=='summary'){
      $('#summarybiztypediv').show();
      $('#InvoicefilterBydiv').hide();
      $('#Inbusinesstypediv').hide();
      $('#In_clientnamediv').hide();
      $('#Inpaymentstatusdiv').hide();
      $('#Inyeardiv').hide();
      $('#Inbusiness_type').val(" ");
      $('#In_clientname').val("");
      $('#In_payment_status').val(" ");
      $('#In_year').val(" ");
      $("#In_client_filter:checked").prop("checked", false);
      $("#In_payment_filter:checked").prop("checked", false);
      $("#In_year_filter:checked").prop("checked", false);
     }
     else{
      $('#InvoicefilterBydiv').hide();
      $('#Inbusinesstypediv').hide();
      $('#summarybiztypediv').hide();
     }
     });

    $('#summarybiztype').click(function(){
      var query470 = $(this).val();
      if(query470=='Space'){
        $('#summaryshowcriteriadiv').show();
        $('#summaryspacecriteriadiv').show();
        $('#summaryspacefilterBydiv2').hide();
        $('#summary_yeardiv2').hide();
        $('#summary2_start_date').val("");
        $('#summary2_end_date').val("");
        $("#summary_year_filter2:checked").prop("checked", false);
        var query472=$('input[name="summary_show"]:checked').val();
        if(query472=='clients'){
          $('#summaryspacefilterBydiv').show();
        }
        else{
          $('#summaryspacefilterBydiv').hide();
        }
      }
      else{
        $('#summaryspacefilterBydiv2').show();
        $('#summary_businessdiv').hide();
        $('#summary_locationdiv').hide();
        $('#summary_yeardiv').hide();
        $('#summary_start_date').val("");
        $('#summary_end_date').val("");
        $('#summary_business').val(" ");
        $('#summary_location').val(" ");
        $('#summaryshowcriteriadiv').hide();
        $('#summaryspacecriteriadiv').hide();
        $('#summaryspacefilterBydiv').hide();
        $("#summary_business_filter:checked").prop("checked", false);
        $("#summary_location_filter:checked").prop("checked", false);
        $("#summary_year_filter:checked").prop("checked", false);
      }

    });

    $("input[name='summary_show']").click(function(){
      var query471=$(this).val();
      if(query471=='clients'){
        $('#summaryspacefilterBydiv').show();
        $('#summary_business_filter_div').show();
        $('#summary_location_filter_div').show();
        // $('#summary_businessdiv').show();
        // $('#summary_locationdiv').show();
      }

      else if(query471=='industry'){
        $('#summary_business_filter_div').hide();
        $('#summary_location_filter_div').hide();
        $('#summary_businessdiv').hide();
        $('#summary_locationdiv').hide();
        $('#summary_business').val(" ");
        $('#summary_location').val(" ");
        $("#summary_business_filter").val("");
        $("#summary_location_filter").val("");
        $("#summary_business_filter:checked").prop("checked", false);
        $("#summary_location_filter:checked").prop("checked", false);
      }

      else{
        $('#summaryspacefilterBydiv').hide();
      }

    });

    $("#summary_business_filter").click(function(){
    if($(this).is(":checked")){
      $(this).val("true");
      $('#summary_businessdiv').show();
    }
    else{
       $(this).val("");
     $('#summary_businessdiv').hide();
      $('#summary_business').val(" ");
    }
    });

    $("#summary_location_filter").click(function(){
    if($(this).is(":checked")){
      $(this).val("true");
      $('#summary_locationdiv').show();
    }
    else{
       $(this).val("");
     $('#summary_locationdiv').hide();
      $('#summary_location').val(" ");
    }
    });

    $("#summary_year_filter").click(function(){
    if($(this).is(":checked")){
      $(this).val("true");
      $('#summary_yeardiv').show();
    }
    else{
       $(this).val("");
     $('#summary_yeardiv').hide();
      $('#summary_start_date').val("");
      $('#summary_end_date').val("");
    }
    });

     $("#summary_year_filter2").click(function(){
    if($(this).is(":checked")){
      $(this).val("true");
      $('#summary_yeardiv2').show();
    }
    else{
       $(this).val("");
     $('#summary_yeardiv2').hide();
      $('#summary2_start_date').val("");
      $('#summary2_end_date').val("");
    }
    });

    $("#Inbusiness_type").click(function(){
      var query=$(this).val();
      $('#In_clientname').val("");
      bz=1;
      if(query!=null){
       $('#InvoicefilterBydiv').show();
       if(query=='Space'){
        $('#InSpaceCriteriadiv').show();
      }
      else{
         $('#InSpaceCriteriadiv').hide();
      }
      }
      else{
        $('#InvoicefilterBydiv').hide();
        $('#InSpaceCriteriadiv').hide();
      }

       });


    $("#In_client_filter").click(function(){
    if($(this).is(":checked")){
      $('#In_clientnamediv').show();
    }
    else{
      $('#In_clientnamediv').hide();
      $('#In_clientname').val('').trigger('change');
    }
    });

    $("#In_payment_filter").click(function(){
    if($(this).is(":checked")){
      $('#Inpaymentstatusdiv').show();
    }
    else{
      $('#Inpaymentstatusdiv').hide();
      $('#In_payment_status').val(" ");
    }
    });

    $("#In_year_filter").click(function(){
    if($(this).is(":checked")){
      $('#Inyeardiv').show();
    }
    else{
      $('#Inyeardiv').hide();
      $('#In_year').val(" ");
    }
    });


    //       $('#In_clientname').keyup(function(e){
    // //e.preventDefault();
    // var queryy=$('#Inbusiness_type').val();
    //     var query = $(this).val();
    //     if(query != ''){
    //      var _token = $('input[name="_token"]').val();
    //      $.ajax({
    //       url:"{ route('autocomplete.client_name') }}",
    //       method:"POST",
    //       data:{query:query, _token:_token,queryy:queryy},
    //       success:function(data){
    //         if(data=='0'){
    //          $('#In_clientname').attr('style','border-bottom:1px solid #f00');
    //          bz = '0';
    //         }
    //         else{
    //           bz ='1';
    //           //$('#message2').hide();
    //           $('#In_clientname').attr('style','border-bottom:1px solid #ced4da');
    //           $('#nameListClient').fadeIn();
    //           $('#nameListClient').html(data);
    //       }
    //     }
    //      });
    //     }
    //     else if(query==''){
    //       bz ='1';
    //           //$('#message2').hide();
    //           $('#In_clientname').attr('style','border-bottom:1px solid #ced4da');
    //     }


    // });

  // $(document).on('click', '#list', function(){
  //  bz ='1';
  //  //$('#message2').hide();
  // $('#In_clientname').attr('style','border-bottom:1px solid #ced4da');

  //       $('#In_clientname').val($(this).text());
  //       $('#nameListClient').fadeOut();

  //       });

  //  $(document).on('click', 'form', function(){
  //    $('#nameListClient').fadeOut();
  //   });


   $('#Con_clientnamesss').keyup(function(e){
    //e.preventDefault();
    var query = $(this).val();
    var queryy=$('#contractbusiness_type').val();
        if(query != ''){
         var _token = $('input[name="_token"]').val();
         $.ajax({
          url:"{{ route('autocomplete.client_name') }}",
          method:"POST",
          data:{query:query, _token:_token,queryy:queryy},
          success:function(data){
            if(data=='0'){
             $('#Con_clientname').attr('style','border-bottom:1px solid #f00');
             cz = '0';
            }
            else{
              cz ='1';
              //$('#message2').hide();
              $('#Con_clientname').attr('style','border-bottom:1px solid #ced4da');
              $('#ConnameList').fadeIn();
              $('#ConnameList').html(data);
          }
        }
         });
        }
        else if(query==''){
          cz ='1';
              //$('#message2').hide();
              $('#Con_clientname').attr('style','border-bottom:1px solid #ced4da');
        }


    });

   $(document).on('click', '#list', function(){
   cz ='1';
   //$('#message2').hide();
  $('#Con_clientname').attr('style','border-bottom:1px solid #ced4da');

        $('#Con_clientname').val($(this).text());
        $('#ConnameList').fadeOut();

        });

   $(document).on('click', 'form', function(){
     $('#ConnameList').fadeOut();
    });

   $("#system_type").click(function(){
    var query=$(this).val();
    if(query=='user'){
      $('#systemfilterBydiv').show();
    }
    else{
      $('#systemfilterBydiv').hide();
    }
    });

   $("#system_status_filter").click(function(){
    if($(this).is(":checked")){
      $('#systemstatusdiv').show();
    }
    else{
      $('#systemstatusdiv').hide();
    }
  });


   $("#major_industry").click(function(){
     var query = $(this).val();
     if(query=='list'){
      $('#space_idDiv').hide();
      $('#space_industrydiv2').hide();
      $('#spacefilterBydiv').show();
      $('#spacefilterBydate').hide();
      $('#spacedatediv').hide();
      $('#start_date').val("");
      $('#end_date').val("");
      $('#space_id').val("");
      $("input[name='space_filter_date']:checked").prop("checked", false);
     }
     else if(query=='history'){
      $('#spacefilterBydate').show();
     // $('#space_idDiv').show();
      $('#space_industrydiv2').show();
      $('#spacefilterBydiv').hide();
      $('#spacepricediv').hide();
      $('#Locationtypediv').hide();
      $('#space_industrydiv').hide();
      $('#spaceoccupationdiv').hide();
      $("input[name='space_filter']:checked").prop("checked", false);
      $("input[name='space_prize']:checked").prop("checked", false);
      $("input[name='location_filter']:checked").prop("checked", false);
      $("input[name='industry_filter']:checked").prop("checked", false);
      $("input[name='status']:checked").prop("checked", false);
      $('#min_price').val("");
      $('#max_price').val("");
      $('#space_status').val("");
      $('#start_date').val("");
      $('#end_date').val("");
     }
     else{
      $('#space_idDiv').hide();
      $('#space_industrydiv2').hide();
      $('#spacefilterBydate').hide();
      $('#spacepricediv').hide();
      $('#Locationtypediv').hide();
      $('#space_industrydiv').hide();
      $('#spaceoccupationdiv').hide();
     }

     });

    $("#space_industry2").click(function(){
      var industry = $(this).val();
      console.log(industry);
      if(industry!=null){
        $('#space_idDiv').show();
        var query = $('#space_industry2').val();
        if(query != ''){
          var _token = $('input[name="_token"]').val();
          $.ajax({
          url:"{{ route('autocomplete.spaces2') }}",
          method:"POST",
          data:{query:query, _token:_token},
          success:function(data){
            $('#nameListSpaceId').fadeIn();
            $('#nameListSpaceId').html(data);
            $("#space_id").select2({
              placeholder: "Select Space Id",
              theme: "bootstrap",
              allowClear: true,
            });
          }
         });
        }
        else if(query==''){
          // a ='1';
          //     //$('#message2').hide();
          //     $('#space_id').attr('style','border:1px solid #ced4da');
        }
      }
      else{
        $('#space_idDiv').hide();
      }

    });

   $("#space_filter").click(function(){
    if($(this).is(":checked")){
      $('#spacefilterBydiv').show();
    }
    else{
      $('#spacefilterBydiv').hide();
      $('#spacepricediv').hide();
      $('#Locationtypediv').hide();
      $('#spaceoccupationdiv').hide();
      $('#spacedatediv').hide();
      $("input[name='space_prize']:checked").prop("checked", false);
      $("input[name='location_filter']:checked").prop("checked", false);
      $("input[name='status']:checked").prop("checked", false);
      $('#min_price').val("");
      $('#max_price').val("");
      $('#space_status').val("");
      $('#start_date').val("");
      $('#end_date').val("");
    }
    });

   $("#space_filter_date").click(function(){
    if($(this).is(":checked")){
      $('#space_filter_date').val("true");
      $('#spacedatediv').show();
    }
    else{
       $('#space_filter_date').val("");
       $('#spacedatediv').hide();
       $('#start_date').val("");
       $('#end_date').val("");
    }

    });

   $("#space_prize").click(function(){
      if($(this).is(":checked")){
      $("#space_prize").val("true");
      $('#spacepricediv').show();
    }
    else{
      $('#spacepricediv').hide();
      $('#min_price').val("");
      $('#max_price').val("");
      $("#space_prize").val("");
    }
    });

   $("#Status").click(function(){
    if($(this).is(":checked")){
       $("#Status").val("true");
      $('#spaceoccupationdiv').show();
    }
    else{
      $("#Status").val("");
      $('#spaceoccupationdiv').hide();
      $('#space_status').val("");
    }

    });

   $("#location_filter").click(function(){
      if($(this).is(":checked")){
      $("#location_filter").val("true");
      $('#Locationtypediv').show();
    }
    else{
      $('#Locationtypediv').hide();
      $('#Locationtype').val("");
      $("#location_filter").val("");
    }
    });

   $("#industry_filter").click(function(){
      if($(this).is(":checked")){
      $("#industry_filter").val("true");
      $('#space_industrydiv').show();
    }
    else{
      $('#space_industrydiv').hide();
      $('#space_industry').val("");
      $("#industry_filter").val("");
    }
    });

   $("#business_filter").click(function(){
    if($(this).is(":checked")){
      $('#businesstypediv').show();
      $("#business_filter").val("true");
    }
    else{
       $('#businesstypediv').hide();
       $('#business_type').val(" ");
       $("#business_filter").val("");
    }

    });

   $("#contract_filter").click(function(){
    if($(this).is(":checked")){
      $('#contractstatusdiv').show();
      $("#contract_filter").val("true");
    }
    else{
      $("#contract_filter").val("");
      $('#contract_status').val(" ");
      $('#contractstatusdiv').hide();
    }

    });

   $("#payment_filter").click(function(){
    if($(this).is(":checked")){
      $('#paymentstatusdiv').show();
      $('#t_invoicedurationdiv').show();
      $("#payment_filter").val("true");
    }
    else{
      $("#payment_filter").val("");
      $('#payment_status').val(" ");
      $('#paymentstatusdiv').hide();
      $('#t_invoicedurationdiv').hide();
      $('#t_Invoice_start_date').val('');
      $('#t_invoice_end_date').val('');
    }
    });

   $("#client_filter").click(function(){
    if($(this).is(":checked")){
      $('#clienttypediv').show();
      $('#client_filter').val("true");
    }
    else{
       $('#clienttypediv').hide();
       $('#client_filter').val(" ");
       $('#client_type').val(" ");
    }

     });


   $('#contract_type').click(function(){
    var query=$(this).val();
    if(query=='list'){
      $('#contractbusinesstypediv').show();
    }
    else{
      $('#contractbusinesstypediv').hide();
      $('#contractbusiness_type').val();
    }
   });

   $('#contractbusiness_type').click(function(){
     var query=$(this).val();
     if(query!=null){
      $('#ContractfilterBydiv').show();
     }
     else{
      $('#ContractfilterBydiv').hide();
     }
   });

   $("#Con_client_filter").click(function(){
    if($(this).is(":checked")){
      $('#Con_clientnamediv').show();
    }
    else{
      $('#Con_clientnamediv').hide();
      $('#Con_clientname').val("");
    }
    });

    $("#Con_payment_filter").click(function(){
    if($(this).is(":checked")){
      $('#Conpaymentstatusdiv').show();
    }
    else{
      $('#Conpaymentstatusdiv').hide();
      $('#Con_payment_status').val(" ");
    }
    });

    $("#Con_year_filter").click(function(){
    if($(this).is(":checked")){
      $('#Conyeardiv').show();
      $('#Conyearcategorydiv').show();
    }
    else{
      $('#Conyeardiv').hide();
      $('#Con_year').val(" ");
      $('#Conyearcategorydiv').hide();
    }
    });




var a;
   // $('#space_id').click(function(e){
   //  e.preventDefault();
        


   //  });

  //  $(document).on('click', '#list', function(){
  //  a ='1';
  //  //$('#message2').hide();
  // $('#space_id').attr('style','border:1px solid #ced4da');

  //       $('#space_id').val($(this).text());
  //       $('#nameListSpaceId').fadeOut();

  //       });

  //  $(document).on('click', 'form', function(){
  //    $('#nameListSpaceId').fadeOut();
  //   });

$("#tenant_type").click(function(){
 var query= $(this).val();
 if(query=='list'){
  $('#TenantfilterBydiv').show();
  $('#tenancysheduleduration').hide();
  $('#tenancyfilterBydiv').hide();
  $('#tenancy_businessdiv').hide();
  $('#tenancy_locationdiv').hide();
  $("input[name='tenancy_business_filter']:checked").prop("checked", false);
  $("input[name='tenancy_location_filter']:checked").prop("checked", false);
  $('#TenantInvoiceCriteriadiv').hide();
  $('#t_invoicedurationdiv').hide();
  $('#TenantInvoicefilterBydiv').hide();
  $('#tInvoicepaymentstatusdiv').hide();
  $("input[name='t_invoice_payment_filter']:checked").prop("checked", false);
  $('#t_Invoice_start_date').val('');
  $('#t_invoice_end_date').val('');
  $('#t_invoicepayment_status').val(' ');
  $('#t_Invoice_startdatemsg').hide();
   $('#t_Invoice_start_date').attr('style','border-bottom:1px solid #ccc');
   $('#t_invoice_enddatemsg').hide();
   $('#t_invoice_end_date').attr('style','border-bottom:1px solid #ccc');
   $('#tenancy_business').val(" ");
  $('#tenancy_location').val(" ");
 }

 else if(query=='invoice'){
  $('#tenancysheduleduration').hide();
  $('#tenancyfilterBydiv').hide();
  $('#tenancy_businessdiv').hide();
  $('#tenancy_locationdiv').hide();
  $('#TenantInvoiceCriteriadiv').show();
  $('#t_invoicedurationdiv').show();
  $('#TenantInvoicefilterBydiv').show();
   $('#TenantfilterBydiv').hide();
   $('#businesstypediv').hide();
   $('#contractstatusdiv').hide();
   $('#paymentstatusdiv').hide();
   $("input[name='business_filter']:checked").prop("checked", false);
   $("input[name='contract_filter']:checked").prop("checked", false);
   $("input[name='payment_filter']:checked").prop("checked", false);
   $("input[name='tenancy_business_filter']:checked").prop("checked", false);
  $("input[name='tenancy_location_filter']:checked").prop("checked", false);
   $('#business_type').val(' ');
   $('#contract_status').val(' ');
   $('#payment_status').val(' ');
   $('#t_Invoice_startdatemsg').hide();
   $('#t_Invoice_start_date').attr('style','border-bottom:1px solid #ccc');
   $('#t_invoice_enddatemsg').hide();
   $('#t_invoice_end_date').attr('style','border-bottom:1px solid #ccc');
   $('#tenancy_business').val(" ");
    $('#tenancy_location').val(" ");
 }

 else if(query=='schedule'){
  $('#tenancysheduleduration').show();
  $('#tenancyfilterBydiv').show();
  $('#TenantInvoiceCriteriadiv').hide();
  $('#t_invoicedurationdiv').hide();
  $('#TenantInvoicefilterBydiv').hide();
  $('#tInvoicepaymentstatusdiv').hide();
  $("input[name='t_invoice_payment_filter']:checked").prop("checked", false);
  $('#t_Invoice_start_date').val('');
  $('#t_invoice_end_date').val('');
  $('#t_invoicepayment_status').val(' ');
  $('#t_Invoice_startdatemsg').hide();
   $('#t_Invoice_start_date').attr('style','border-bottom:1px solid #ccc');
   $('#t_invoice_enddatemsg').hide();
   $('#t_invoice_end_date').attr('style','border-bottom:1px solid #ccc');
   $('#TenantfilterBydiv').hide();
   $('#businesstypediv').hide();
   $('#contractstatusdiv').hide();
   $('#paymentstatusdiv').hide();
   $("input[name='business_filter']:checked").prop("checked", false);
   $("input[name='contract_filter']:checked").prop("checked", false);
   $("input[name='payment_filter']:checked").prop("checked", false);
   $('#business_type').val(' ');
   $('#contract_status').val(' ');
   $('#payment_status').val(' ');
   $('#t_Invoice_startdatemsg').hide();
   $('#t_Invoice_start_date').attr('style','border-bottom:1px solid #ccc');
   $('#t_invoice_enddatemsg').hide();
   $('#t_invoice_end_date').attr('style','border-bottom:1px solid #ccc');
 }
   });

$("#tenancy_business_filter").click(function(){
    if($(this).is(":checked")){
      $('#tenancy_businessdiv').show();
      $('#tenancy_business_filter').val('true');
    }
    else{
      $('#tenancy_business_filter').val('');
      $('#tenancy_businessdiv').hide();
      $('#tenancy_business').val(" ");
    }
});

$("#tenancy_location_filter").click(function(){
    if($(this).is(":checked")){
      $('#tenancy_locationdiv').show();
      $('#tenancy_location_filter').val('true');
    }
    else{
      $('#tenancy_location_filter').val('');
      $('#tenancy_locationdiv').hide();
      $('#tenancy_location').val(" ");
    }
});


$("#t_invoice_payment_filter").click(function(){
    if($(this).is(":checked")){
      $('#tInvoicepaymentstatusdiv').show();
      $('#t_invoice_payment_filter').val('true');
    }
    else{
      $('#t_invoice_payment_filter').val('');
      $('#tInvoicepaymentstatusdiv').hide();
      $('#t_invoicepayment_status').val(" ");
    }
    });

// $('#vehicle_reg').keyup(function(e){
//         console.log(4);

//         e.preventDefault();
//         var query = $(this).val();
//         if(query != ''){
//          var _token = $('input[name="_token"]').val();
//          $.ajax({
//           url:"{ route('autocomplete.fetch') }}",
//           method:"POST",
//           data:{query:query, _token:_token},
//           success:function(data){
//             if(data=='0'){
//              $('#vehicle_reg').attr('style','border:1px solid #f00');
//              az = '0';
//             }
//             else{
//               az ='1';
//               //$('#message2').hide();
//               $('#vehicle_reg').attr('style','border:1px solid #ced4da');
//               $('#nameList').fadeIn();
//               $('#nameList').html(data);
//           }
//         }
//          });
//         }
//         else if(query==''){
//           az ='1';
//               //$('#message2').hide();
//               $('#vehicle_reg').attr('style','border:1px solid #ced4da');
//         }
//      });

// $(document).on('click', '#list', function(){
//    az ='1';
//    //$('#message2').hide();
//   $('#vehicle_reg').attr('style','border:1px solid #ced4da');

//         $('#vehicle_reg').val($(this).text());
//         $('#nameList').fadeOut();

//     });

   // $(document).on('click', 'form', function(){
   //   $('#nameList').fadeOut();
   //  });

$("#car_type").click(function(){
    var query= $(this).val();
 if(query=='revenue'){
  $('#carrevenuefilterBydiv').hide();
   $('#revenue_durationdiv').show();
    $('#carsfilterBydiv').hide();
    $('#carhistoryfilterBydiv').hide();
    $('#carclientfilterBydiv').hide();
     $('#vehicleregdiv').hide();
     $('#carmodeldiv').hide();
    $('#carstatusdiv').hide();
    $('#carrangediv').hide();
    $('#rentstatusdiv').hide();
    $('#clientcostcentrediv').hide();
    $('#clientcontractdiv').hide();
    $('#clientdatediv').hide();
    $('#clientpaymentdiv').hide();
    $('#clientcostcentre').val("");
    $('#client_start_date').val("");
    $('#client_end_date').val("");
    $('#model').val("");
    $('#vehicle_status').val("");
    $('#carmin_price').val("");
    $('#carmax_price').val("");
    $('#rent_status').val("");
    $('#vehicle_reg').val("");
    $('#carhistorydatediv').hide();
    $('#carhistory_start_date').val("");
    $('#carhistory_end_date').val("");
  $("input[name='cardate_histfil']:checked").prop("checked", false);
   $("input[name='carmodel_filter']:checked").prop("checked", false);
     $("input[name='carstatus_filter']:checked").prop("checked", false);
      $("input[name='carrange_filter']:checked").prop("checked", false);
       $("input[name='rentstatus_filter']:checked").prop("checked", false);
       $("input[name='clientcostcentre_filter']:checked").prop("checked", false);
        $("input[name='clientcontract_filter']:checked").prop("checked", false);
        $("input[name='clientdate_filter']:checked").prop("checked", false);
        $("input[name='clientpayment_filter']:checked").prop("checked", false);
    $('#carrevenuedatediv').hide();
     $('#carrevenueregdiv').hide();
     $('#carrevenuemodeldiv').hide();
     $("input[name='carrevenuedate_filter']:checked").prop("checked", false);
   $("input[name='carrevenuemodel_filter']:checked").prop("checked", false);
     $("input[name='carrevenuereg_filter']:checked").prop("checked", false);
 }
 else if(query=='cars'){
  $('#carrevenuefilterBydiv').hide();
  $('#carsfilterBydiv').show();
  $('#carclientfilterBydiv').hide();
  $('#revenue_durationdiv').hide();
  $('#carhistoryfilterBydiv').hide();
   $('#vehicleregdiv').hide();
   $('#rev_start_date').val("");
   $('#rev_end_date').val("");
   $('#vehicle_reg').val("");
   $('#carrevenuedatediv').hide();
   $('#carrevenueregdiv').hide();
   $('#carrevenuemodeldiv').hide();
   $('#clientcostcentrediv').hide();
    $('#clientcontractdiv').hide();
    $('#clientdatediv').hide();
    $('#clientpaymentdiv').hide();
    $('#clientcostcentre').val("");
    $('#client_start_date').val("");
    $('#client_end_date').val("");
    $('#carhistorydatediv').hide();
    $('#carhistory_start_date').val("");
    $('#carhistory_end_date').val("");
  $("input[name='cardate_histfil']:checked").prop("checked", false);
   $("input[name='carrevenuedate_filter']:checked").prop("checked", false);
   $("input[name='carrevenuemodel_filter']:checked").prop("checked", false);
   $("input[name='carrevenuereg_filter']:checked").prop("checked", false);
   $("input[name='clientcostcentre_filter']:checked").prop("checked", false);
  $("input[name='clientcontract_filter']:checked").prop("checked", false);
  $("input[name='clientdate_filter']:checked").prop("checked", false);
  $("input[name='clientpayment_filter']:checked").prop("checked", false);
 }
 else if(query=='history'){
  $('#carrevenuefilterBydiv').hide();
  $('#carsfilterBydiv').hide();
  $('#carclientfilterBydiv').hide();
  $('#revenue_durationdiv').hide();
  $('#carmodeldiv').hide();
    $('#carstatusdiv').hide();
    $('#carrangediv').hide();
    $('#rentstatusdiv').hide();
  $('#vehicleregdiv').show();
  $('#carhistoryfilterBydiv').show();
  $('#model').val("");
    $('#vehicle_status').val("");
    $('#carmin_price').val("");
    $('#carmax_price').val("");
    $('#rent_status').val("");
    $('#rev_start_date').val("");
   $('#rev_end_date').val("");
   $('#carrevenuedatediv').hide();
     $('#carrevenueregdiv').hide();
     $('#carrevenuemodeldiv').hide();
     $('#clientcostcentrediv').hide();
    $('#clientcontractdiv').hide();
    $('#clientdatediv').hide();
    $('#clientpaymentdiv').hide();
    $('#clientcostcentre').val("");
    $('#client_start_date').val("");
    $('#client_end_date').val("");
     $("input[name='carrevenuedate_filter']:checked").prop("checked", false);
    $("input[name='carrevenuemodel_filter']:checked").prop("checked", false);
     $("input[name='carrevenuereg_filter']:checked").prop("checked", false);
   $("input[name='carmodel_filter']:checked").prop("checked", false);
     $("input[name='carstatus_filter']:checked").prop("checked", false);
      $("input[name='carrange_filter']:checked").prop("checked", false);
       $("input[name='rentstatus_filter']:checked").prop("checked", false);
       $("input[name='clientcostcentre_filter']:checked").prop("checked", false);
        $("input[name='clientcontract_filter']:checked").prop("checked", false);
        $("input[name='clientdate_filter']:checked").prop("checked", false);
        $("input[name='clientpayment_filter']:checked").prop("checked", false);
 }
 else if(query=='clients'){
  $('#carrevenuefilterBydiv').hide();
  $('#carclientfilterBydiv').show();
  $('#revenue_durationdiv').hide();
   $('#carsfilterBydiv').hide();
    $('#carhistoryfilterBydiv').hide();
   $('#carmodeldiv').hide();
    $('#carstatusdiv').hide();
    $('#carrangediv').hide();
    $('#rentstatusdiv').hide();
     $('#vehicleregdiv').hide();
     $('#carrevenuedatediv').hide();
     $('#carrevenueregdiv').hide();
     $('#carrevenuemodeldiv').hide();
     $("input[name='carrevenuedate_filter']:checked").prop("checked", false);
     $("input[name='carrevenuemodel_filter']:checked").prop("checked", false);
     $("input[name='carrevenuereg_filter']:checked").prop("checked", false);
    $('#model').val("");
    $('#vehicle_status').val("");
    $('#carmin_price').val("");
    $('#carmax_price').val("");
    $('#rent_status').val("");
    $('#rev_start_date').val("");
   $('#rev_end_date').val("");
   $('#vehicle_reg').val("");
   $('#carhistorydatediv').hide();
    $('#carhistory_start_date').val("");
    $('#carhistory_end_date').val("");
  $("input[name='cardate_histfil']:checked").prop("checked", false);
   $("input[name='carmodel_filter']:checked").prop("checked", false);
    $("input[name='carstatus_filter']:checked").prop("checked", false);
      $("input[name='carrange_filter']:checked").prop("checked", false);
       $("input[name='rentstatus_filter']:checked").prop("checked", false);
 }
 else if(query=='operational'){
   $('#carrevenuefilterBydiv').show();
  $('#revenue_durationdiv').hide();
   $('#carsfilterBydiv').hide();
    $('#carhistoryfilterBydiv').hide();
   $('#carclientfilterBydiv').hide();
   $('#carmodeldiv').hide();
   $('#clientcostcentrediv').hide();
    $('#clientcontractdiv').hide();
    $('#clientdatediv').hide();
    $('#clientpaymentdiv').hide();
    $('#clientcostcentre').val("");
    $('#client_start_date').val("");
    $('#client_end_date').val("");
    $('#carstatusdiv').hide();
    $('#carrangediv').hide();
    $('#rentstatusdiv').hide();
     $('#vehicleregdiv').hide();
    $('#model').val("");
    $('#vehicle_status').val("");
    $('#carmin_price').val("");
    $('#carmax_price').val("");
    $('#rent_status').val("");
    $('#rev_start_date').val("");
   $('#rev_end_date').val("");
   $('#vehicle_reg').val("");
   $('#carhistorydatediv').hide();
    $('#carhistory_start_date').val("");
    $('#carhistory_end_date').val("");
  $("input[name='cardate_histfil']:checked").prop("checked", false);
   $("input[name='carmodel_filter']:checked").prop("checked", false);
     $("input[name='carstatus_filter']:checked").prop("checked", false);
      $("input[name='carrange_filter']:checked").prop("checked", false);
       $("input[name='rentstatus_filter']:checked").prop("checked", false);
       $("input[name='clientcostcentre_filter']:checked").prop("checked", false);
        $("input[name='clientcontract_filter']:checked").prop("checked", false);
        $("input[name='clientdate_filter']:checked").prop("checked", false);
        $("input[name='clientpayment_filter']:checked").prop("checked", false);
 }
 else{
  $('#revenue_durationdiv').hide();
   $('#carsfilterBydiv').hide();
    $('#carhistoryfilterBydiv').hide();
   $('#carclientfilterBydiv').hide();
   $('#carrevenuefilterBydiv').hide();
   $('#carmodeldiv').hide();
    $('#carstatusdiv').hide();
    $('#carrangediv').hide();
    $('#clientcostcentrediv').hide();
    $('#clientcontractdiv').hide();
    $('#clientdatediv').hide();
    $('#clientpaymentdiv').hide();
    $('#clientcostcentre').val("");
    $('#client_start_date').val("");
    $('#client_end_date').val("");
    $('#rentstatusdiv').hide();
     $('#vehicleregdiv').hide();
    $('#model').val("");
    $('#vehicle_status').val("");
    $('#carmin_price').val("");
    $('#carmax_price').val("");
    $('#rent_status').val("");
    $('#rev_start_date').val("");
   $('#rev_end_date').val("");
   $('#vehicle_reg').val("");
   $('#carrevenuedatediv').hide();
     $('#carrevenueregdiv').hide();
     $('#carrevenuemodeldiv').hide();
     $("input[name='carrevenuedate_filter']:checked").prop("checked", false);
     $("input[name='carrevenuemodel_filter']:checked").prop("checked", false);
     $("input[name='carrevenuereg_filter']:checked").prop("checked", false);
   $("input[name='carmodel_filter']:checked").prop("checked", false);
     $("input[name='carstatus_filter']:checked").prop("checked", false);
      $("input[name='carrange_filter']:checked").prop("checked", false);
       $("input[name='rentstatus_filter']:checked").prop("checked", false);
       $("input[name='clientcostcentre_filter']:checked").prop("checked", false);
        $("input[name='clientcontract_filter']:checked").prop("checked", false);
        $("input[name='clientdate_filter']:checked").prop("checked", false);
        $("input[name='clientpayment_filter']:checked").prop("checked", false);
 }
  });

$("#cardate_histfil").click(function(){
    if($(this).is(":checked")){
      $('#carhistorydatediv').show();
      $('#cardate_histfil').val('true');
    }
    else{
    $('#cardate_histfil').val('');
    $('#carhistorydatediv').hide();
    $('#carhistory_start_date').val("");
    $('#carhistory_end_date').val("");
    }
});

$("#carmodel_filter").click(function(){
    if($(this).is(":checked")){
      $('#carmodeldiv').show();
      $('#carmodel_filter').val('true');
    }
    else{
    $('#carmodel_filter').val('');
     $('#carmodeldiv').hide();
      $('#model').val("");
    }
    });

$("#carstatus_filter").click(function(){
    if($(this).is(":checked")){
      $('#carstatusdiv').show();
      $('#carstatus_filter').val('true');
    }
    else{
     $('#carstatus_filter').val('');
     $('#carstatusdiv').hide();
     $('#vehicle_status').val("");
    }
    });

$("#carrange_filter").click(function(){
    if($(this).is(":checked")){
      $('#carrangediv').show();
      $('#carrange_filter').val('true');
    }
    else{
      $('#carrange_filter').val('');
     $('#carrangediv').hide();
     $('#carmin_price').val("");
    $('#carmax_price').val("");
    }
    });

$("#rentstatus_filter").click(function(){
    if($(this).is(":checked")){
      $('#rentstatusdiv').show();
      $('#rent_durationdiv').show();
      $('#rentstatus_filter').val('true');
    }
    else{
     $('#rentstatus_filter').val('');
     $('#rentstatusdiv').hide();
     $('#rent_durationdiv').hide();
     $('#rent_start_date').val("");
     $('#rent_end_date').val("");
     $('#rent_status').val("");
    }
    });

    $("#clientcostcentre_filter").click(function(){
    if($(this).is(":checked")){
      $('#clientcostcentrediv').show();
      $('#clientcostcentre_filter').val('true');
    }
    else{
    $('#clientcostcentre_filter').val('');
    $('#clientcostcentrediv').hide();
    $('#clientcostcentre').val("");
    }
    });

    $("#clientdate_filter").click(function(){
    if($(this).is(":checked")){
      $('#clientdatediv').show();
      $('#clientdate_filter').val('true');
    }
    else{
    $('#clientdate_filter').val('');
    $('#clientdatediv').hide();
    $('#client_start_date').val("");
    $('#client_end_date').val("");
    }
    });

    $("#clientcontract_filter").click(function(){
    if($(this).is(":checked")){
      $('#clientcontractdiv').show();
      $('#clientcontract_filter').val('true');
    }
    else{
    $('#clientcontract_filter').val('');
    $('#clientcontractdiv').hide();
    }
    });

    $("#clientpayment_filter").click(function(){
    if($(this).is(":checked")){
      $('#clientpaymentdiv').show();
      $('#clientpayment_filter').val('true');
    }
    else{
    $('#clientpayment_filter').val('');
    $('#clientpaymentdiv').hide();
    }
    });

    $("#carrevenuedate_filter").click(function(){
    if($(this).is(":checked")){
      $('#carrevenuedatediv').show();
      $('#carrevenuedate_filter').val('true');
    }
    else{
    $('#carrevenuedate_filter').val('');
    $('#carrevenuedatediv').hide();
    $('#carrevenue_start_date').val("");
    $('#carrevenue_end_date').val("");
    }
    });

    $("#carrevenuemodel_filter").click(function(){
    if($(this).is(":checked")){
      $('#carrevenuemodeldiv').show();
      $('#carrevenuemodel_filter').val('true');
    }
    else{
    $('#carrevenuemodel_filter').val('');
    $('#carrevenuemodeldiv').hide();
    $('#carrevenuemodel').val("");
    }
    });

    $("#carrevenuereg_filter").click(function(){
    if($(this).is(":checked")){
      $('#carrevenueregdiv').show();
      $('#carrevenuereg_filter').val('true');
    }
    else{
    $('#carrevenuereg_filter').val('');
    $('#carrevenueregdiv').hide();
    $('#carrevenuereg').val(null);
    }
    });

    // $('#carrevenuereg').keyup(function(e){
    //     e.preventDefault();
    //     var query209 = $(this).val();
    //     if(query209 != ''){
    //      var _token = $('input[name="_token"]').val();
    //      $.ajax({
    //       url:"{ route('autocomplete.fetch') }}",
    //       method:"POST",
    //       data:{query:query209, _token:_token},
    //       success:function(data){
    //         if(data=='0'){
    //          $('#carrevenuereg').attr('style','border-bottom:1px solid #f00');
    //          az1 = '0';
    //         }
    //         else{
    //           az1 ='1';
    //           //$('#message2').hide();
    //           $('#carrevenuereg').attr('style','border-bottom:1px solid #ced4da');
    //           $('#carrevenuenameList').fadeIn();
    //           $('#carrevenuenameList').html(data);
    //       }
    //     }
    //      });
    //     }
    //     else if(query209==''){
    //       az1 ='1';
    //           //$('#message2').hide();
    //           $('#carrevenuereg').attr('style','border-bottom:1px solid #ced4da');
    //     }
    //  });

// $(document).on('click', '#list', function(){
//    az1 ='1';
//    //$('#message2').hide();
//   $('#carrevenuereg').attr('style','border-bottom:1px solid #ced4da');

//         $('#carrevenuereg').val($(this).text());
//         $('#carrevenuenameList').fadeOut();

//     });

//    $(document).on('click', 'form', function(){
//      $('#carrevenuenameList').fadeOut();
//     });

var a100=0;
    //  $('#clientcostcentre').keyup(function(e){
    //   e.preventDefault();
    //     var query = $(this).val();
    //     if(query != ''){
    //      var _token = $('input[name="_token"]').val();
    //      $.ajax({
    //       url:"{{ route('autocomplete.costcentres') }}",
    //       method:"POST",
    //       data:{query:query, _token:_token},
    //       success:function(data){
    //         if(data=='0'){
    //          $('#clientcostcentre').attr('style','border-bottom:1px solid #f00');
    //          a100 = '0';
    //         }
    //         else{
    //           a100 ='1';
    //           //$('#message2').hide();
    //           $('#clientcostcentre').attr('style','border-bottom:1px solid #ced4da');
    //           $('#costcentres').fadeIn();
    //           $('#costcentres').html(data);
    //       }
    //     }
    //      });
    //     }
    //     else if(query==''){
    //       a100 ='1';
    //           //$('#message2').hide();
    //           $('#clientcostcentre').attr('style','border-bottom:1px solid #ced4da');
    //     }


    // });

   //   $(document).on('click', '#list', function(){
   //    a100 ='1';
   //    $('#clientcostcentre').attr('style','border-bottom:1px solid #ced4da');

   //      $('#clientcostcentre').val($(this).text().match(/\d+/g));
   //      //$('#clientcostcentre_name').val($(this).text().match(/[a-zA-Z]+/g));
   //      $('#costcentres').fadeOut();

   //      });

   // $(document).on('click', 'form', function(){
   //   $('#costcentres').fadeOut();
   //  });


   $('#flats_reporttype').click(function(){
      var type = $(this).val();
        if(type=='rooms'){
          $('#flatsrooms_filterBydiv').show();
          $('#flatscontracts_filterBydiv').hide();
          $('#flats_paymentDiv').hide();
          $('#flats_statusdiv').hide();
        }
        else if(type=='contracts'){
          $('#flatscontracts_filterBydiv').show();
          $('#room_categoryDiv').hide();
          $('#flatsrooms_filterBydiv').hide();
        } 
    });


  $("#room_category_filter").click(function(){
    if($(this).is(":checked")){
      $('#room_categoryDiv').show();
    }
    else{
      $('#room_categoryDiv').hide();
      $('#room_category').val("");
    }
  });


  $("#flats_payment_filter").click(function(){
    if($(this).is(":checked")){
      $('#flats_paymentDiv').show();
    }
    else{
      $('#flats_paymentDiv').hide();
      $('#flats_payment').val("");
    }
  });

  $("#flats_status_filter").click(function(){
    if($(this).is(":checked")){
      $('#flats_statusdiv').show();
    }
    else{
      $('#flats_statusdiv').hide();
      $('#flats_status').val("");
    }
  });

   $("#submitbutton").click(function(e){
       e.preventDefault();
       var p1,p2,p3,p4,p5,p6,p7,p8,p9,p10,p11,p12,p13,p14,p15,p16,p17,p18,p19,p20,p21,p22,p23,p24,p25,p26,p27,p28,p29,p30,p31,p32,p33,p34,p35,p36,p490,p491, p50, p51, p52, p53, p54;
       var query = $("#module").val();

       if(query=='space'){
        var query2 = $("#major_industry").val();
        if(query2==null){
          p1=0;
          $('#spacetypemsg').show();
             var message=document.getElementById('spacetypemsg');
             message.style.color='red';
             message.innerHTML="Required";
             $('#major_industry').attr('style','border:1px solid #f00');
        }

        else if(query2=='list'){
          p1=1;
         if($('#space_prize').is(":checked")){
          var query3=$("#min_price").val();
          var query4=$("#max_price").val();
          if(query3==""){
            p2=0;
            $('#minpricemsg').show();
             var message=document.getElementById('minpricemsg');
             message.style.color='red';
             message.innerHTML="Required";
             $('#min_price').attr('style','border-bottom:1px solid #f00');
          }
          else{
            p2=1;
            $('#minpricemsg').hide();
            $('#min_price').attr('style','border-bottom: 1px solid #ccc');
          }

          if(query4==""){
            p3=0;
            $('#maxpricemsg').show();
             var message=document.getElementById('maxpricemsg');
             message.style.color='red';
             message.innerHTML="Required";
             $('#max_price').attr('style','border-bottom:1px solid #f00');
          }
          else{
            p3=1;
            $('#maxpricemsg').hide();
            $('#max_price').attr('style','border-bottom: 1px solid #ccc');
          }

         }
         else{
          p2=1;
          p3=1;
         }

         if($('#Status').is(":checked")){
          var query5=$('#space_status').val();
          console.log(query5);
          if(query5==null){
            p4=0;
             $('#spacestatusmsg').show();
             var message=document.getElementById('spacestatusmsg');
             message.style.color='red';
             message.innerHTML="Required";
             $('#space_status').attr('style','border:1px solid #f00');
          }
          else{
            p4=1;
            $('#spacestatusmsg').hide();
            $('#space_status').attr('style','border: 1px solid #ccc');
          }

         }
         else{
          p4=1;
         }

         if($('#location_filter').is(":checked")){
          var queryA=$('#Locationtype').val();
          if(queryA==null){
            p13=0;
            $('#Locationtypemsg').show();
             var message=document.getElementById('Locationtypemsg');
             message.style.color='red';
             message.innerHTML="Required";
             $('#Locationtype').attr('style','border:1px solid #f00');
          }
          else{
            p13=1;
            $('#Locationtypemsg').hide();
            $('#Locationtype').attr('style','border: 1px solid #ccc');
          }
         }
         else{
          p13=1;
         }


         if($('#industry_filter').is(":checked")){
          var query105=$('#space_industry').val();
          if(query105==null){
            var p105=0;
            $('#spaceindustrymsg').show();
             var message=document.getElementById('spaceindustrymsg');
             message.style.color='red';
             message.innerHTML="Required";
             $('#space_industry').attr('style','border:1px solid #f00');
          }
          else{
            p105=1;
            $('#spaceindustrymsg').hide();
            $('#space_industry').attr('style','border: 1px solid #ccc');
          }
         }
         else{
          p105=1;
         }

         if(p1==1&& p2==1 && p3==1 &&p4==1&&p13==1&&p105==1){
          $.ajaxSetup({
      headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

          var _token = $('input[name="_token"]').val();
          var postData = "module="+ query+ "&major_industry="+ query2+ "&min_price=" + query3 + "&max_price=" +query4 + "&space_status=" +query5+"&space_prize="+$('#space_prize').val()+"&status="+ $('#Status').val()+"&location="+queryA+"&location_status="+$('#location_filter').val()+"&ind_fil="+$('#industry_filter').val()+"&ind="+query105;

            $.ajax({
            url: "{{ route('spacereport1') }}",
            method:"GET",
            data: postData,
            contentType: "application/x-www-form-urlencoded",
            success: function(data) {
                window.location.href = "/reports/space1/pdf?"+postData;
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });

         }
       }
       else if (query2=='history'){
        p1=1;
        var query6=$('#space_id').val();
        
        if(query6==null){
          p5=0;
          $('#spaceidmsg').show();
          var message=document.getElementById('spaceidmsg');
           message.style.color='red';
           message.innerHTML="Required";
           $('#space_id').attr('style','border:1px solid #f00');
        }
        else{
          p5=1;
          $('#spaceidmsg').hide();
          $('#space_id').attr('style','border: 1px solid #ccc');
        }

         if($('#space_filter_date').is(":checked")){
          var query7=$('#start_date').val();
          var query8=$('#end_date').val();
          if(query7==""){
            p6=0;
          $('#startdatemsg').show();
          var message=document.getElementById('startdatemsg');
           message.style.color='red';
           message.innerHTML="Required";
           $('#start_date').attr('style','border-bottom:1px solid #f00');
          }
          else{
            p6=1;
          $('#startdatemsg').hide();
          $('#start_date').attr('style','border-bottom: 1px solid #ccc');
          }

          if(query8==""){
            p7=0;
            $('#enddatemsg').show();
          var message=document.getElementById('enddatemsg');
           message.style.color='red';
           message.innerHTML="Required";
           $('#end_date').attr('style','border-bottom:1px solid #f00');
          }
          else{
            p7=1;
          $('#enddatemsg').hide();
          $('#end_date').attr('style','border-bottom: 1px solid #ccc');
          }
          if(new Date(query8) <= new Date(query7)){
          var queryz=query8;
          query8=query7;
          query7=queryz;
          }

         }
         else{
          p6=1;
          p7=1;
         }
        if(p1==1 && p5==1 && p6==1 && p7==1){
          var _token = $('input[name="_token"]').val();
          var postData1 = "space_id="+ query6+ "&start_date="+ query7+ "&end_date=" + query8 + "&filter_date=" + $('#space_filter_date').val();

            $.ajax({
            url: "{{ route('spacereport1') }}",
            method:"GET",
            data: postData1,
            contentType: "application/x-www-form-urlencoded",
            success: function(data) {
                window.location.href = "/reports/space2/pdf?"+postData1;
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });

        }


       }

       else{
        p1=0;
                $('#spacetypemsg').hide();
                $('#major_industry').attr('style','border: 1px solid #ccc');
        }
    }
    else if(query=='insurance'){
      var query9=$('#insurance_reporttype').val();
      if(query9==null){
        p8=0;
        $('#insurancereporttypemsg').show();
          var message=document.getElementById('insurancereporttypemsg');
           message.style.color='red';
           message.innerHTML="Required";
           $('#insurance_reporttype').attr('style','border:1px solid #f00');
      }
      else if(query9=='sales' || query9=='clients'){
        p8=1;
        $('#insurancereporttypemsg').hide();
        $('#insurance_reporttype').attr('style','border: 1px solid #ccc');
        if($('#principal_filter').is(":checked")){
          var query10=$('#principaltype').val();
          if(query10==null){
            p9=0;
          $('#principaltypemsg').show();
          var message=document.getElementById('principaltypemsg');
           message.style.color='red';
           message.innerHTML="Required";
           $('#principaltype').attr('style','border:1px solid #f00');
          }
          else{
            p9=1;
          $('#principaltypemsg').hide();
          $('#principaltype').attr('style','border: 1px solid #ccc');
          }
        }
        else{
          p9=1;
        }

        if($('#insurance_typefilter').is(":checked")){
          var query11=$('#insurance_type').val();
          if(query11==null){
            p10=0;
          $('#insurancetypemsg').show();
          var message=document.getElementById('insurancetypemsg');
           message.style.color='red';
           message.innerHTML="Required";
           $('#insurance_type').attr('style','border:1px solid #f00');
          }
          else{
            p10=1;
           $('#insurancetypemsg').hide();
          $('#insurance_type').attr('style','border: 1px solid #ccc');
          }
        }
        else{
          p10=1;
        }

        if($('#insurance_packagefilter').is(":checked")){
          var query101=$('#insurance_package').val();
          if(query101==null){
           var p101=0;
          $('#insurancepackagemsg').show();
          var message=document.getElementById('insurancepackagemsg');
           message.style.color='red';
           message.innerHTML="Required";
           $('#insurance_package').attr('style','border:1px solid #f00');
          }
          else{
            p101=1;
           $('#insurancepackagemsg').hide();
          $('#insurance_package').attr('style','border: 1px solid #ccc');
          }
        }
        else{
          p101=1;
        }


        if($('#insurance_yearfilter').is(":checked")){
          var query102=$('input[name="insurance_year"]:checked').val();
          var query103 = $('#udia_year').val();
          if(query103==null){
           var p102=0;
          $('#udiayearmsg').show();
          var message=document.getElementById('udiayearmsg');
           message.style.color='red';
           message.innerHTML="Required";
           $('#udia_year').attr('style','border:1px solid #f00');
          }
          else{
            p102=1;
           $('#udiayearmsg').hide();
            $('#udia_year').attr('style','border: 1px solid #ccc');
          }
        }
        else{
          p102=1;
        }

          if($('#insurance_datefilter').is(":checked")){
          var query102=$('#insurance_start_date').val();
          console.log(query102);
          var query103 = $('#insurance_end_date').val();
              if(query102==""){
               var p102=0;
              $('#insurance_start_datemsg').show();
              var message=document.getElementById('insurance_start_datemsg');
               message.style.color='red';
               message.innerHTML="Required";
               $('#insurance_start_date').attr('style','border-bottom:1px solid #f00');
              }
            else{
              p102=1;
             $('#insurance_start_datemsg').hide();
              $('#insurance_start_date').attr('style','border-bottom: 1px solid #ccc');
            }

            if(query103==""){
               var p102a=0;
              $('#insurance_end_datemsg').show();
              var message=document.getElementById('insurance_end_datemsg');
               message.style.color='red';
               message.innerHTML="Required";
               $('#insurance_end_date').attr('style','border-bottom:1px solid #f00');
              }
            else{
              p102a=1;
             $('#insurance_end_datemsg').hide();
              $('#insurance_end_date').attr('style','border-bottom: 1px solid #ccc');
            }

            if(query102!='' && query103!=''){
              if(query102 > query103){
                var query102a = query102;
                query102 = query103;
                query103 = query102a;
              }
            }
        }
        else{
          p102=1;
          p102a=1;
        }

        if(p8==1 && p9==1 &&p10==1&&p101==1&&p102==1&&p102a==1){
          var _token = $('input[name="_token"]').val();
          var postData2 = "report_type="+ query9+ "&principaltype="+ query10+ "&insurance_type=" + query11 + "&principal_filter=" + $('#principal_filter').val() + "&insurance_typefilter=" + $('#insurance_typefilter').val() +"&package_filter="+$('#insurance_packagefilter').val()+"&package="+query101+"&yr_fil="+$('#insurance_datefilter').val()+"&start="+query102+"&end="+query103;

            $.ajax({
            url: "{{ route('spacereport1') }}",
            method:"GET",
            data: postData2,
            contentType: "application/x-www-form-urlencoded",
            success: function(data) {
                window.location.href = "/reports/insurance/pdf?"+postData2;
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
        }

      }
      else{
        p8=1;
        $('#insurancereporttypemsg').hide();
        $('#insurance_reporttype').attr('style','border: 1px solid #ccc');
        var _token = $('input[name="_token"]').val();
          var postData3 = "report_type="+ query9;

            $.ajax({
            url: "{{ route('spacereport1') }}",
            method:"GET",
            data: postData3,
            contentType: "application/x-www-form-urlencoded",
            success: function(data) {
                window.location.href = "/reports/insurance/pdf?"+postData3;
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
      }
    }
    else if(query=='invoice'){
      var query34=$('#invoice_type').val();
      if(query34=='list'){
        var query35=$('#Inbusiness_type').val();
        if(query35==null){
          p32=0;
          $('#Inbusinesstypemsg').show();
          var message=document.getElementById('Inbusinesstypemsg');
           message.style.color='red';
           message.innerHTML="Required";
           $('#Inbusiness_type').attr('style','border:1px solid #f00');
        }
        else{
          p32=1;
           $('#Inbusinesstypemsg').hide();
           $('#Inbusiness_type').attr('style','border:1px solid #ccc');
        }

       if($('#In_client_filter').is(":checked")){
        $("#In_client_filter").val("true");
        var query36=$('#In_clientname').val();
        if(query36==null){
          p33=0;
           $('#Inclientnamemsg').show();
          var message=document.getElementById('Inclientnamemsg');
           message.style.color='red';
           message.innerHTML="Required";
           $('#In_clientname').attr('style','border-bottom:1px solid #f00');
        }
        else{
         p33=1;
          $('#Inclientnamemsg').hide();
           $('#In_clientname').attr('style','border-bottom:1px solid #ccc');
        }
        // if(bz==0){
        //   p33=0;
        //    $('#Inclientnamemsg').show();
        //   var message=document.getElementById('Inclientnamemsg');
        //    message.style.color='red';
        //    message.innerHTML="This client does not exists in the system";
        //    $('#In_clientname').attr('style','border-bottom:1px solid #f00');
        // }
        // else if(bz==1){
        //    p33=1;
        //   $('#Inclientnamemsg').hide();
        //    $('#In_clientname').attr('style','border-bottom:1px solid #ccc');
        // }
      }
      else{
        p33=1;
      }

      if($('#In_payment_filter').is(":checked")){
        $("#In_payment_filter").val("true");
        var query37=$('#In_payment_status').val();
        if(query37==null){
          p34=0;
           $('#Inpaymentstatusmsg').show();
          var message=document.getElementById('Inpaymentstatusmsg');
           message.style.color='red';
           message.innerHTML="Required";
           $('#In_payment_status').attr('style','border:1px solid #f00');
        }
        else{
         p34=1;
          $('#Inpaymentstatusmsg').hide();
           $('#In_payment_status').attr('style','border:1px solid #ccc');
        }
      }
      else{
        p34=1;
      }
      if($('#In_year_filter').is(":checked")){
        $("#In_year_filter").val("true");
        var query38=$('#In_year').val();
        if(query38==null){
          p35=0;
           $('#Inyearmsg').show();
          var message=document.getElementById('Inyearmsg');
           message.style.color='red';
           message.innerHTML="Required";
           $('#In_year').attr('style','border:1px solid #f00');
        }
        else{
         p35=1;
          $('#Inyearmsg').hide();
           $('#In_year').attr('style','border:1px solid #ccc');
        }
      }
      else{
        p35=1;
      }
      if(p32==1 && p33==1 && p34==1 && p35==1){
          var _token = $('input[name="_token"]').val();
          var postData7 = "report_type="+ query34+ "&b_type="+ query35+ "&c_filter=" + $("#In_client_filter").val() + "&c_name=" + query36 +"&payment_filter="+$('#In_payment_filter').val()+"&payment_status="+query37+"&year_filter="+ $("#In_year_filter").val()+"&year="+query38+"&In_type="+$('input[name="In_SpaceCriteria"]:checked').val();

            $.ajax({
            url: "{{ route('spacereport1') }}",
            method:"GET",
            data: postData7,
            contentType: "application/x-www-form-urlencoded",
            success: function(data) {
                window.location.href = "/reports/invoice/pdf?"+postData7;
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
        }
    }
    else if(query34=='summary'){
      var p480,p481,p482,p483,p484,p485,p4831;
      var query480=$('#summarybiztype').val();
      if(query480==null){
        p480=0;
        $('#summarybiztypemsg').show();
        var message=document.getElementById('summarybiztypemsg');
        message.style.color='red';
        message.innerHTML="Required";
        $('#summarybiztype').attr('style','border:1px solid #f00');
      }
      else{
        p480=1;
        $('#summarybiztypemsg').hide();
        $('#summarybiztype').attr('style','border:1px solid #ccc');
      }

      if($('#summary_business_filter').is(":checked")){
        var query481=$('#summary_business').val();
        if(query481==null){
          p481=0;
          $('#summarybusinessmsg').show();
          var message=document.getElementById('summarybusinessmsg');
           message.style.color='red';
           message.innerHTML="Required";
           $('#summary_business').attr('style','border:1px solid #f00');
        }
        else{
         p481=1;
          $('#summarybusinessmsg').hide();
           $('#summary_business').attr('style','border:1px solid #ccc');
        }
      }
      else{
       p481=1;
      }

      if($('#summary_location_filter').is(":checked")){
        var query482=$('#summary_location').val();
        if(query482==null){
          p482=0;
          $('#summarylocationmsg').show();
          var message=document.getElementById('summarylocationmsg');
           message.style.color='red';
           message.innerHTML="Required";
           $('#summary_location').attr('style','border:1px solid #f00');
        }
        else{
         p482=1;
          $('#summarylocationmsg').hide();
           $('#summary_location').attr('style','border:1px solid #ccc');
        }
      }
      else{
        p482=1;
      }

      if($('#summary_year_filter').is(":checked")){
          var query483 = $('#summary_start_date').val(),
            query4831 = $('#summary_end_date').val();

       
        if(query483==""){
          p483=0;
          $('#summary_startdatemsg').show();
          var message=document.getElementById('summary_startdatemsg');
           message.style.color='red';
           message.innerHTML="Required";
           $('#summary_start_date').attr('style','border-bottom:1px solid #f00');
        }
        else{
         p483=1;
          $('#summary_startdatemsg').hide();
          $('#summary_start_date').attr('style','border-bottom:1px solid #ccc');
        }

        if(query4831==""){
          p4831=0;
          $('#summary_enddatemsg').show();
          var message=document.getElementById('summary_enddatemsg');
           message.style.color='red';
           message.innerHTML="Required";
           $('#summary_end_date').attr('style','border-bottom:1px solid #f00');
        }
        else{
         p4831=1;
          $('#summary_enddatemsg').hide();
          $('#summary_end_date').attr('style','border-bottom:1px solid #ccc');
        }

        if(query483!='' && query4831!=''){
          if(query483 > query4831){
            var query4832 = query483;
            query483 = query4831;
            query4831 = query4832;
          }
        }
      }
      else{
        p483=1;

        p4831 =1; 

      }

      if($('#summary_year_filter2').is(":checked")){
        var query484 = $('#summary2_start_date').val(),
            query485 = $('#summary2_end_date').val();

       
        if(query484==""){
          p484=0;
          $('#summary2_startdatemsg').show();
          var message=document.getElementById('summary2_startdatemsg');
           message.style.color='red';
           message.innerHTML="Required";
           $('#summary2_start_date').attr('style','border-bottom:1px solid #f00');
        }
        else{
         p484=1;
          $('#summary2_startdatemsg').hide();
          $('#summary2_start_date').attr('style','border-bottom:1px solid #ccc');
        }

        if(query485==""){
          p485=0;
          $('#summary2_enddatemsg').show();
          var message=document.getElementById('summary2_enddatemsg');
           message.style.color='red';
           message.innerHTML="Required";
           $('#summary2_end_date').attr('style','border-bottom:1px solid #f00');
        }
        else{
         p485=1;
          $('#summary2_enddatemsg').hide();
          $('#summary2_end_date').attr('style','border-bottom:1px solid #ccc');
        }

        if(query484!='' && query485!=''){
          if(query484 > query485){
            var query486 = query484;
            query484 = query485;
            query485 = query486;
          }
        }
      }
      else{
        p484=1;

        p485=1; 

      }
      if(p480==1 && p481==1 && p482==1&&p483==1 &&p4831==1 &&p484==1&&p485==1){
        var _token = $('input[name="_token"]').val();
          var postData7 = "report_type="+ query34+ "&b_type="+ query480+ "&criteria=" + $("input[name='summary_criteria']:checked").val() + "&show=" + $("input[name='summary_show']:checked").val() +"&bus_fil="+$('#summary_business_filter').val()+"&loc_fil="+$('#summary_location_filter').val()+"&biz="+ query481+ "&loc="+query482+"&yr_fil="+$('#summary_year_filter').val()+"&start="+query483+"&end="+query4831+"&yr2_fil="+$('#summary_year_filter2').val()+"&start2="+query484+"&end2="+query485;

            $.ajax({
            url: "{{ route('spacereport1') }}",
            method:"GET",
            data: postData7,
            contentType: "application/x-www-form-urlencoded",
            success: function(data) {
                window.location.href = "/reports/invoice/debt_summary?"+postData7;
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
      }
    }
  }

    else if(query=='system'){
      var p400,p401,p402;
      var query400=$('#system_type').val();
      if(query400==null){
        p400=0;
         $('#systemtypemsg').show();
          var message=document.getElementById('systemtypemsg');
           message.style.color='red';
           message.innerHTML="Required";
           $('#system_type').attr('style','border:1px solid #f00');
      }
      else if(query400=='user'){
        p400=1;
        $('#systemtypemsg').hide();
        $('#system_type').attr('style','border: 1px solid #ccc');

        if($('#system_status_filter').is(":checked")){
          $("#system_status_filter").val("true");
        }

      }
      if(p400==1){
          var _token = $('input[name="_token"]').val();
          var postData400 = "report_type="+ query400+ "&st_fil="+$('#system_status_filter').val()+ "&user=" +$('input[name=system_status]:checked').val() ;

            $.ajax({
            url: "{{ route('spacereport1') }}",
            method:"GET",
            data: postData4,
            contentType: "application/x-www-form-urlencoded",
            success: function(data) {
                window.location.href = "/reports/system/user/pdf?"+postData400;
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
      }
    }

    else if(query=='research_flats'){
        var query50 = $('#flats_reporttype').val();
        if(query50==null){
          p51 = 0;
          $('#flatsreporttypemsg').show();
          var message=document.getElementById('flatsreporttypemsg');
           message.style.color='red';
           message.innerHTML="Required";
           $('#flats_reporttype').attr('style','border:1px solid #f00');
        }

        else if(query50=='rooms'){
          p51 = 1; p53=1; p54=1;
          $('#flatsreporttypemsg').hide();
          $('#flats_reporttype').attr('style','border: 1px solid #ccc');


          if($('#room_category_filter').is(":checked")){
            $("#room_category_filter").val("true");
            var query51=$('#room_category').val();

            if(query51==null){
              p52 = 0;
              $('#roomcategorymsg').show();
              var message=document.getElementById('roomcategorymsg');
               message.style.color='red';
               message.innerHTML="Required";
              $('#room_category').attr('style','border:1px solid #f00');
            }

            else{
              p52 = 1;
              $('#roomcategorymsg').hide();
              $('#room_category').attr('style','border:1px solid #ccc');
            }
          }
          else{
            p52 = 1;
            $("#room_category_filter").val("");
            $('#roomcategorymsg').hide();
            $('#room_category').attr('style','border:1px solid #ccc');
          }

        }
        else if(query50=='contracts'){
          p51 = 1; p52=1; 
          $('#flatsreporttypemsg').hide();
          $('#flats_reporttype').attr('style','border: 1px solid #ccc');


          if($('#flats_payment_filter').is(":checked")){
            $("#flats_payment_filter").val("true");
            var query52=$('#flats_payment').val();
            if(query52==null){
              p53 = 0;
              $('#flatspaymentmsg').show();
              var message=document.getElementById('flatspaymentmsg');
               message.style.color='red';
               message.innerHTML="Required";
              $('#flats_payment').attr('style','border:1px solid #f00');
            }

            else{
              p53 = 1;
              $('#flatspaymentmsg').hide();
              $('#flats_payment').attr('style','border:1px solid #ccc');
            }
          }

          else{
            p53 = 1;
            $("#flats_payment_filter").val("");
            $('#flatspaymentmsg').hide();
            $('#flats_payment').attr('style','border:1px solid #ccc');
          }


          if($('#flats_status_filter').is(":checked")){
            $("#flats_status_filter").val("true");
            var query53=$('#flats_status').val();

            if(query53==null){
              p54 = 0;
              $('#flats_statusmsg').show();
              var message=document.getElementById('flats_statusmsg');
               message.style.color='red';
               message.innerHTML="Required";
              $('#flats_status').attr('style','border:1px solid #f00');
            }

            else{
              p54 = 1;
              $('#flats_statusmsg').hide();
              $('#flats_status').attr('style','border:1px solid #ccc');
            }
          }
          else{
            p54 = 1;
            $("#flats_status_filter").val("");
            $('#flats_statusmsg').hide();
            $('#flats_status').attr('style','border:1px solid #ccc');
          }
        }

        if(p51==1 && p52==1 && p53==1 && p54==1){
          var _token = $('input[name="_token"]').val();
          var postData51 = "report_type="+ query50+ "&room_fil="+$('#room_category_filter').val()+ "&room="+ query51 + "&pay_fil="+$('#flats_payment_filter').val()+"&pay="+query52+"&stat_fil="+$('#flats_status_filter').val()+"&status="+query53;

            $.ajax({
            url: "{{ route('spacereport1') }}",
            method:"GET",
            data: postData4,
            contentType: "application/x-www-form-urlencoded",
            success: function(data) {
                window.location.href = "/reports/research_flats/pdf?"+postData51;
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
        }
    }


    else if(query=='tenant'){
      var query12=$('#tenant_type').val();

      if(query12==null){
        p14=0;
         $('#tenanttypemsg').show();
          var message=document.getElementById('tenanttypemsg');
           message.style.color='red';
           message.innerHTML="Required";
           $('#tenant_type').attr('style','border:1px solid #f00');
      }
      else if(query12=='invoice'){
        p14=1;
        $('#tenanttypemsg').hide();
        $('#tenant_type').attr('style','border: 1px solid #ccc');
        var query20=$('input[name=t_invoiceCriteria]:checked').val();
        if(query20==null){
          p15=0;
          $('#t_invoiceCriteriamsg').show();
          var message=document.getElementById('t_invoiceCriteriamsg');
           message.style.color='red';
           message.innerHTML="Required";
        }
        else{
          p15=1;
          $('#t_invoiceCriteriamsg').hide();
        }

        var query21=$('#t_Invoice_start_date').val();
        var query22=$('#t_invoice_end_date').val();
        if(query21==''){
          p16=0;
          $('#t_Invoice_startdatemsg').show();
          var message=document.getElementById('t_Invoice_startdatemsg');
           message.style.color='red';
           message.innerHTML="Required";
           $('#t_Invoice_start_date').attr('style','border-bottom:1px solid #f00');
        }
        else{
          p16=1;
         $('#t_Invoice_startdatemsg').hide();
         $('#t_Invoice_start_date').attr('style','border-bottom:1px solid #ccc');
        }
        if(query22==''){
          p17=0;
          $('#t_invoice_enddatemsg').show();
          var message=document.getElementById('t_invoice_enddatemsg');
           message.style.color='red';
           message.innerHTML="Required";
           $('#t_invoice_end_date').attr('style','border-bottom:1px solid #f00');
        }
        else{
          p17=1;
         $('#t_invoice_enddatemsg').hide();
         $('#t_invoice_end_date').attr('style','border-bottom:1px solid #ccc');
        }
        if(new Date(query22) <= new Date(query21)){
        var query23=query22;
        query22=query21;
        query21=query23;
      }

      if($('#t_invoice_payment_filter').is(":checked")){
        $("#t_invoice_payment_filter").val("true");
        var query24=$('#t_invoicepayment_status').val();
        if(query24==null){
          p22=0;
          $('#t_invoicepaymentstatusmsg').show();
          var message=document.getElementById('t_invoicepaymentstatusmsg');
           message.style.color='red';
           message.innerHTML="Required";
        $('#t_invoicepayment_status').attr('style','border:1px solid #f00');
        }
        else{
          p22=1;
          $('#t_invoicepaymentstatusmsg').hide();
           $('#t_invoicepayment_status').attr('style','border:1px solid #ccc');
        }
      }
      else{
        p22=1;
        $("#t_invoice_payment_filter").val("");
        $('#t_invoicepaymentstatusmsg').hide();
        $('#t_invoicepayment_status').attr('style','border:1px solid #ccc');
      }

      if(p14==1 && p15==1 && p16==1 && p17==1 && p22==1){
          var _token = $('input[name="_token"]').val();
          var postData4 = "report_type="+ query12+ "&criteria="+ query20+ "&start_date=" + query21 + "&end_date=" + query22 +"&payment_filter="+$('#t_invoice_payment_filter').val()+"&payment_status="+query24;

            $.ajax({
            url: "{{ route('spacereport1') }}",
            method:"GET",
            data: postData4,
            contentType: "application/x-www-form-urlencoded",
            success: function(data) {
                window.location.href = "/reports/tenant/pdf?"+postData4;
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
        }

      }

      else if(query12=='schedule'){
        var p450,p451,p452,p453,p454,p455;
        var query450=$('#tenancy_year').val(),
            query451=$('#tenancy_end').val(),
            query452=$('#tenancy_start').val();

            if(query450==null){
              p450=0;
              $('#tenancyyearmsg').show();
              var message=document.getElementById('tenancyyearmsg');
              message.style.color='red';
              message.innerHTML="Required";
              $('#tenancy_year').attr('style','border:1px solid #f00');
            }
            else{
              p450=1;
              $('#tenancyyearmsg').hide();
              $('#tenancy_year').attr('style','border: 1px solid #ccc');
            }

            if(query451==null){
              p451=0;
              $('#tenancyendmsg').show();
              var message=document.getElementById('tenancyendmsg');
              message.style.color='red';
              message.innerHTML="Required";
              $('#tenancy_end').attr('style','border:1px solid #f00');
            }
            else{
              p451=1;
              $('#tenancyendmsg').hide();
              $('#tenancy_end').attr('style','border: 1px solid #ccc');
            }

            if(query452==null){
              p452=0;
              $('#tenancystartmsg').show();
              var message=document.getElementById('tenancystartmsg');
              message.style.color='red';
              message.innerHTML="Required";
              $('#tenancy_start').attr('style','border:1px solid #f00');
            }
            else{
              p452=1;
              $('#tenancystartmsg').hide();
              $('#tenancy_start').attr('style','border: 1px solid #ccc');
            }

            if($('#tenancy_business_filter').is(":checked")){
              var query453=$('#tenancy_business').val();

              if(query453==null){
                p453=0;
                $('#tenancybusinessmsg').show();
                var message=document.getElementById('tenancybusinessmsg');
                message.style.color='red';
                message.innerHTML="Required";
                $('#tenancy_business').attr('style','border:1px solid #f00');
              }
              else{
                p453=1;
                $('#tenancybusinessmsg').hide();
                $('#tenancy_business').attr('style','border:1px solid #ccc');
              }
            }
            else{
              p453=1;
              $('#tenancybusinessmsg').hide();
              $('#tenancy_business').attr('style','border:1px solid #ccc');
            }


            if($('#tenancy_location_filter').is(":checked")){
              var query454=$('#tenancy_location').val();

              if(query454==null){
                p454=0;
                $('#tenancylocationmsg').show();
                var message=document.getElementById('tenancylocationmsg');
                message.style.color='red';
                message.innerHTML="Required";
                $('#tenancy_location').attr('style','border:1px solid #f00');
              }
              else{
                p454=1;
                $('#tenancylocationmsg').hide();
                $('#tenancy_location').attr('style','border:1px solid #ccc');
              }
            }
            else{
              p454=1;
              $('#tenancylocationmsg').hide();
              $('#tenancy_location').attr('style','border:1px solid #ccc');
            }

            if(p450==1 && p451==1 && p452==1 && p453==1 && p454==1){
              var _token = $('input[name="_token"]').val();
              var postData450 = "report_type="+ query12+ "&year="+ query450+ "&start=" + query452 + "&duration=" + query451 + "&b_fil="+$('#tenancy_business_filter').val()+"&b_type="+query453+"&l_fil="+$('#tenancy_location_filter').val()+"&loc="+query454;

              $.ajax({
              url: "{{ route('spacereport1') }}",
              method:"GET",
              data: postData450,
              contentType: "application/x-www-form-urlencoded",
              success: function(data) {
                window.location.href = "/reports/tenancy/pdf?"+postData450;
              },
              error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
            }

      }
      else if(query12=='list'){
            p14=1;
           $('#tenanttypemsg').hide();
          $('#tenant_type').attr('style','border: 1px solid #ccc');
          if($('#business_filter').is(":checked")){
          var query13 =$('#business_type').val();
          if(query13==null){
            p15=0;
          $('#businesstypemsg').show();
          var message=document.getElementById('businesstypemsg');
           message.style.color='red';
           message.innerHTML="Required";
           $('#business_type').attr('style','border:1px solid #f00');
          }
          else{
            p15=1;
           $('#businesstypemsg').hide();
          $('#business_type').attr('style','border: 1px solid #ccc');
          }
        }
        else{
          p15=1;
          $('#businesstypemsg').hide();
          $('#business_type').attr('style','border: 1px solid #ccc');
        }
         if($('#contract_filter').is(":checked")){
          var query14 =$('#contract_status').val();
          if(query14==null){
            p16=0;
          $('#contractstatusmsg').show();
          var message=document.getElementById('contractstatusmsg');
           message.style.color='red';
           message.innerHTML="Required";
           $('#contract_status').attr('style','border:1px solid #f00');
          }
          else{
            p16=1;
           $('#contractstatusmsg').hide();
          $('#contract_status').attr('style','border: 1px solid #ccc');
          }
        }
        else{
          p16=1;
          $('#contractstatusmsg').hide();
          $('#contract_status').attr('style','border: 1px solid #ccc');
        }
        if($('#payment_filter').is(":checked")){
          var query15 =$('#payment_status').val();
          if(query15==null){
            p17=0;
          $('#paymentstatusmsg').show();
          var message=document.getElementById('paymentstatusmsg');
           message.style.color='red';
           message.innerHTML="Required";
           $('#payment_status').attr('style','border:1px solid #f00');
          }
          else{
            p17=1;
           $('#paymentstatusmsg').hide();
          $('#payment_status').attr('style','border: 1px solid #ccc');
          }
        var query21=$('#t_Invoice_start_date').val();
        var query22=$('#t_invoice_end_date').val();
        if(query21==''){
          p23=0;
          $('#t_Invoice_startdatemsg').show();
          var message=document.getElementById('t_Invoice_startdatemsg');
           message.style.color='red';
           message.innerHTML="Required";
           $('#t_Invoice_start_date').attr('style','border-bottom:1px solid #f00');
        }
        else{
          p23=1;
         $('#t_Invoice_startdatemsg').hide();
         $('#t_Invoice_start_date').attr('style','border-bottom:1px solid #ccc');
        }
        if(query22==''){
          p24=0;
          $('#t_invoice_enddatemsg').show();
          var message=document.getElementById('t_invoice_enddatemsg');
           message.style.color='red';
           message.innerHTML="Required";
           $('#t_invoice_end_date').attr('style','border-bottom:1px solid #f00');
        }
        else{
          p24=1;
         $('#t_invoice_enddatemsg').hide();
         $('#t_invoice_end_date').attr('style','border-bottom:1px solid #ccc');
        }
        if(new Date(query22) <= new Date(query21)){
        var query23=query22;
        query22=query21;
        query21=query23;
      }
        }
        else{
          p17=1;p23=1;p24=1;
          $('#paymentstatusmsg').hide();
          $('#payment_status').attr('style','border: 1px solid #ccc');
        }

        if(p14==1 && p15==1 && p16==1 && p17==1 && p23==1 && p24==1){
           var _token = $('input[name="_token"]').val();
          var postData4 = "report_type="+ query12+ "&business_filter="+ $('#business_filter').val()+ "&business_type=" + query13 + "&contract_filter=" + $('#contract_filter').val() + "&contract_status=" + query14 +"&payment_filter="+$('#payment_filter').val()+"&payment_status="+query15+"&start_date=" +query21+ "&end_date="+query22;

            $.ajax({
            url: "{{ route('spacereport1') }}",
            method:"GET",
            data: postData4,
            contentType: "application/x-www-form-urlencoded",
            success: function(data) {
                window.location.href = "/reports/tenant/pdf?"+postData4;
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
        }
          }

    }

    else if(query=='car'){
      var query16=$('#car_type').val();
      if(query16==null){
        p18=0;
         $('#cartypemsg').show();
          var message=document.getElementById('cartypemsg');
           message.style.color='red';
           message.innerHTML="Required";
           $('#car_type').attr('style','border:1px solid #f00');
      }
      else if(query16=='operational'){
        var p300, p301, p302, p304;
        if($('#carrevenuemodel_filter').is(":checked")){
          var query300=$('#carrevenuemodel').val();
          console.log(query300);
          if(query300==null){
            p300=0;
          $('#carrevenuemodelmsg').show();
          var message=document.getElementById('carrevenuemodelmsg');
           message.style.color='red';
           message.innerHTML="Required";
           $('#carrevenuemodel').attr('style','border:1px solid #f00');
          }
          else{
            p300=1;
          $('#carrevenuemodelmsg').hide();
          $('#carrevenuemodel').attr('style','border:1px solid #ccc');
        }
        }
        else{
          p300=1;
        }

        if($('#carrevenuereg_filter').is(":checked")){
          var query301=$('#carrevenuereg').val();
          if(query301==null){
            p301=0;
          $('#carrevenueregmsg').show();
          var message=document.getElementById('carrevenueregmsg');
           message.style.color='red';
           message.innerHTML="Required";
           $('#carrevenuereg').attr('style','border-bottom:1px solid #f00');
          }
          else{
            p301=1;
          $('#carrevenueregmsg').hide();
          $('#carrevenuereg').attr('style','border-bottom:1px solid #ccc');
        }
        }
        else{
          p301=1;
        }

        if($('#carrevenuedate_filter').is(":checked")){
          var query302=$('#carrevenue_start_date').val();
          var query303=$('#carrevenue_end_date').val();
          if(query302==""){
            p302=0;
          $('#carrevenue_startdatemsg').show();
          var message=document.getElementById('carrevenue_startdatemsg');
           message.style.color='red';
           message.innerHTML="Required";
           $('#carrevenue_start_date').attr('style','border-bottom:1px solid #f00');
          }
          else{
            p302=1;
          $('#carrevenue_startdatemsg').hide();
          $('#carrevenue_start_date').attr('style','border-bottom:1px solid #ccc');
        }
        if(query303==""){
            p303=0;
          $('#carrevenue_enddatemsg').show();
          var message=document.getElementById('carrevenue_enddatemsg');
           message.style.color='red';
           message.innerHTML="Required";
           $('#carrevenue_end_date').attr('style','border-bottom:1px solid #f00');
          }
          else{
            p303=1;
          $('#carrevenue_enddatemsg').hide();
          $('#carrevenue_end_date').attr('style','border-bottom:1px solid #ccc');
        }

        if(query302!="" && query303!=""){
          if(query302>query303){
            var query304=query302;
              query302=query303;
              query303=query304;
          }
        }
      }
        else{
          p302=1;
          p303=1;
        }

        if(p300==1 && p301==1 && p302==1 && p303==1){
          var _token = $('input[name="_token"]').val();
          var postData5 = "report_type="+ query16+"&date_fil="+$('#carrevenuedate_filter').val()+"&model_fil="+$('#carrevenuemodel_filter').val()+"&reg_fil="+$('#carrevenuereg_filter').val()+"&start="+query302+"&end="+query303+"&model="+query300+"&reg="+query301;
            $.ajax({
            url: "{{ route('spacereport1') }}",
            method:"GET",
            data: postData5,
            contentType: "application/x-www-form-urlencoded",
            success: function(data) {
                window.location.href = "/reports/car_rental2/pdf?"+postData5;
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
        }
      }
      else if(query16=='revenue'){
        var rev_start=$('#rev_start_date').val();
        var rev_end=$('#rev_end_date').val();
        console.log(rev_start);
        if(rev_start==''){
           var message=document.getElementById('rev_startdatemsg');
           message.style.color='red';
           message.innerHTML="Required";
           $('#rev_start_date').attr('style','border-bottom:1px solid #f00');
        }
        if(rev_end==''){
          var message=document.getElementById('rev_enddatemsg');
           message.style.color='red';
           message.innerHTML="Required";
           $('#rev_end_date').attr('style','border-bottom:1px solid #f00');
        }
        else{
           $('#rev_enddatemsg').hide();
           $('#rev_startdatemsg').hide();
        $('#rev_start_date').attr('style','border-bottom: 1px solid #ccc');
        $('#rev_end_date').attr('style','border-bottom: 1px solid #ccc');
        if(new Date(rev_end) <= new Date(rev_start)){
        var rev_end2=rev_end;
        rev_end=rev_start;
        rev_start=rev_end2;
      }

        var _token = $('input[name="_token"]').val();
          var postData5 = "report_type="+ query16;

            $.ajax({
            url: "{{ route('spacereport1') }}",
            method:"GET",
            data: postData5,
            contentType: "application/x-www-form-urlencoded",
            success: function(data) {
                window.location.href = "/reports/car_rental/pdf?"+postData5+"&start_date="+rev_start+"&end_date="+rev_end;
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
        }
      }
      else if(query16=='history'){
        var reg=$('#vehicle_reg').val();
        console.log(reg);
        //  if(az=="0"){
        //   var message=document.getElementById('vehicleregmsg');
        //    message.style.color='red';
        //    message.innerHTML="This Vehicle does not exists";
        //    $('#vehicle_reg').attr('style','border-bottom:1px solid #f00');
        // }
        if(reg==null){
          az=0;
          var message=document.getElementById('vehicleregmsg');
           message.style.color='red';
           message.innerHTML="Required";
           $('#vehicle_reg').attr('style','border:1px solid #f00');
        }
        else{
          az=1;
          $('#vehicleregmsg').hide();
          $('#vehicle_reg').attr('style','border-bottom:1px solid #ccc');
        }
         if($('#cardate_histfil').is(":checked")){
          var query490 =$('#carhistory_start_date').val(),
              query491 =$('#carhistory_end_date').val();

              if(query490==''){
                p490 =0;
                $('#carhistory_startdatemsg').show();
              var message=document.getElementById('carhistory_startdatemsg');
              message.style.color='red';
              message.innerHTML="Required";
              $('#carhistory_start_date').attr('style','border-bottom:1px solid #f00'); 
              }
              else{
                p490=1;
                $('#carhistory_startdatemsg').hide();
                $('#carhistory_start_date').attr('style','border-bottom:1px solid #ccc');
              }
              if(query491==''){
                p491=0;
                $('#carhistory_enddatemsg').show();
                var message=document.getElementById('carhistory_enddatemsg');
                message.style.color='red';
                message.innerHTML="Required";
                $('#carhistory_end_date').attr('style','border-bottom:1px solid #f00'); 
              }
              else{
                p491=1;
                $('#carhistory_enddatemsg').hide();
                 $('#carhistory_end_date').attr('style','border-bottom:1px solid #ccc'); 
              }
              if(query490!='' && query491!=''){
                if(query490>query491){
                var query492 = query490;
                    query490 = query491;
                    query491 = query492;
                }
              }
              

         }
         else{
          p490=1;
          p491=1;
         }
        if(az=='1' && reg!="" &&p490=='1' && p491=='1'){
          $('#vehicleregmsg').hide();
        $('#vehicle_reg').attr('style','border-bottom: 1px solid #ccc');
         var _token = $('input[name="_token"]').val();
          var postData5 = "report_type="+ query16+"&reg="+reg+"&start="+query490+"&end="+query491+"&date_fil="+$('#cardate_histfil').val();

            $.ajax({
            url: "{{ route('spacereport1') }}",
            method:"GET",
            data: postData5,
            contentType: "application/x-www-form-urlencoded",
            success: function(data) {
                window.location.href = "/reports/car_rental3/pdf?"+postData5;
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
        }
      }

      else if(query16=='clients'){
        var p200,p201,p202,p203,p204,p205;

        if($('#clientcostcentre_filter').is(":checked")){
          var query200=$('#clientcostcentre').val();
          if(query200==null){
            p200=0;
          $('#clientcostcentremsg').show();
          var message=document.getElementById('clientcostcentremsg');
           message.style.color='red';
           message.innerHTML="Required";
           $('#clientcostcentre').attr('style','border:1px solid #f00');
          }
          else{
            p200=1;
          $('#clientcostcentremsg').hide();
          $('#clientcostcentre').attr('style','border:1px solid #ccc');
        }
        }
        else{
          p200=1;
        }

         if($('#clientdate_filter').is(":checked")){
          var query201=$('#client_start_date').val(),
              query202=$('#client_end_date').val();
              if(query201==''){
                p201=0;
                $('#client_startdatemsg').show();
                var message=document.getElementById('client_startdatemsg');
                message.style.color='red';
                message.innerHTML="Required";
                $('#client_start_date').attr('style','border-bottom:1px solid #f00');
              }
              else{
                p201=1;
              }
              if(query202==''){
                p202=0;
                $('#client_enddatemsg').show();
                var message=document.getElementById('client_enddatemsg');
                message.style.color='red';
                message.innerHTML="Required";
                $('#client_end_date').attr('style','border-bottom:1px solid #f00');
              }
              else{
                p202=1;
              }
              if(query201!='' && query202!=''){
                if(query201>query202){
                var query203 = query201;
                    query201 = query202;
                    query202 = query203;
                }
              }


         }
         else{
          p201=1;
          p202=1;
         }
         if(p200==1 && p201==1 && p202==1){
          var _token = $('input[name="_token"]').val();
          var postData50 = "report_type="+ query16+"&centre="+query200+"&cont="+$('input[name="clientcontract"]:checked').val()+"&start="+query201+"&end="+query202+"&pay="+$('input[name="clientpayment"]:checked').val()+"&centre_fil="+$('#clientcostcentre_filter').val()+"&cont_fil="+$('#clientcontract_filter').val()+"&date_fil="+$('#clientdate_filter').val()+"&pay_fil="+$('#clientpayment_filter').val();

            $.ajax({
            url: "{{ route('spacereport1') }}",
            method:"GET",
            data: postData5,
            contentType: "application/x-www-form-urlencoded",
            success: function(data) {
                window.location.href = "/reports/car_rental/pdf?"+postData50;
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
         }
      }
      else if(query16=='cars'){
        if($('#carmodel_filter').is(":checked")){
          var query25=$('#model').val();
          if(query25==null){
            p25=0;
            $('#modelmsg').show();
          var message=document.getElementById('modelmsg');
           message.style.color='red';
           message.innerHTML="Required";
           $('#model').attr('style','border:1px solid #f00');
          }
           else{
            p25=1;
          $('#modelmsg').hide();
          $('#model').attr('style','border:1px solid #ccc');
        }
        }
        else{
          p25=1;
        }


        if($('#carstatus_filter').is(":checked")){
          var query26=$('#vehicle_status').val();
          if(query26==null){
            p26=0;
            $('#vehiclestatusmsg').show();
          var message=document.getElementById('vehiclestatusmsg');
           message.style.color='red';
           message.innerHTML="Required";
           $('#vehicle_status').attr('style','border:1px solid #f00');
          }
          else{
            p26=1;
          $('#vehiclestatusmsg').hide();
          $('#vehicle_status').attr('style','border:1px solid #ccc');
        }
        }
        else{
          p26=1;
        }

        if($('#carrange_filter').is(":checked")){
          var query27=$('#carmin_price').val();
          var query28=$('#carmax_price').val();
          if(query27==""){
            p27=0;
            $('#carminpricemsg').show();
          var message=document.getElementById('carminpricemsg');
           message.style.color='red';
           message.innerHTML="Required";
           $('#carmin_price').attr('style','border-bottom:1px solid #f00');
          }
          else{
            p27=1;
          $('#carminpricemsg').hide();
          $('#carmin_price').attr('style','border-bottom:1px solid #ccc');
        }

        if(query28==""){
          p28=0;
            $('#carmaxpricemsg').show();
          var message=document.getElementById('carmaxpricemsg');
           message.style.color='red';
           message.innerHTML="Required";
           $('#carmax_price').attr('style','border-bottom:1px solid #f00');
          }
          else{
            p28=1;
          $('#carmaxpricemsg').hide();
          $('#carmax_price').attr('style','border-bottom:1px solid #ccc');
        }
        if(query28<query27){
          var query29=query28;
          query28=query27;
          query27=query29;
        }
        }
        else{
          p27=1; p28=1;
        }

        if($('#rentstatus_filter').is(":checked")){
          var query30=$('#rent_status').val();
          var query31=$('#rent_start_date').val();
          var query32=$('#rent_end_date').val();
          if(query30==null){
            p29=0;
            $('#rentstatusmsg').show();
          var message=document.getElementById('rentstatusmsg');
           message.style.color='red';
           message.innerHTML="Required";
           $('#rent_status').attr('style','border:1px solid #f00');
          }
          else{
            p29=1;
          $('#rentstatusmsg').hide();
          $('#rent_status').attr('style','border:1px solid #ccc');
        }
        if(query31==""){
          p30=0;
          $('#rent_startdatemsg').show();
          var message=document.getElementById('rent_startdatemsg');
           message.style.color='red';
           message.innerHTML="Required";
        $('#rent_start_date').attr('style','border-bottom:1px solid #f00');
        }
        else{
            p30=1;
          $('#rent_startdatemsg').hide();
          $('#rent_start_date').attr('style','border:1px solid #ccc');
        }
        if(query32==""){
          p31=0;
          $('#rent_enddatemsg').show();
          var message=document.getElementById('rent_enddatemsg');
           message.style.color='red';
           message.innerHTML="Required";
        $('#rent_end_date').attr('style','border-bottom:1px solid #f00');
        }
        else{
            p31=1;
          $('#rent_enddatemsg').hide();
          $('#rent_end_date').attr('style','border-bottom:1px solid #ccc');
        }
        if(new Date(query32) < new Date(query31)){
           var query33=query32;
           query32=query31;
           query31=query33;
        }
        }
        else{
          p29=1; p30=1; p31=1;
        }



        if(p25==1 && p26==1 && p27==1 &&p28==1 && p29==1&&p30==1&&p31==1){
          var _token = $('input[name="_token"]').val();
          var postData5 = "report_type="+ query16 +"&model_fil="+$('#carmodel_filter').val()+"&stat_fil="+$('#carstatus_filter').val()+"&range_fil="+$('#carrange_filter').val()+"&rent_fil="+$('#rentstatus_filter').val()+"&model="+query25+"&status="+query26+"&min="+query27+"&max="+query28+"&rent="+query30+"&start="+query31+"&end="+query32;

            $.ajax({
            url: "{{ route('spacereport1') }}",
            method:"GET",
            data: postData5,
            contentType: "application/x-www-form-urlencoded",
            success: function(data) {
                window.location.href = "/reports/car_rental/pdf?"+postData5;
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
          }

      }
      else{
            p18=1;
           $('#cartypemsg').hide();
          $('#car_type').attr('style','border: 1px solid #ccc');
          }

          if(p18==1){
          var _token = $('input[name="_token"]').val();
          var postData5 = "report_type="+ query16;

            $.ajax({
            url: "{{ route('spacereport1') }}",
            method:"GET",
            data: postData5,
            contentType: "application/x-www-form-urlencoded",
            success: function(data) {
                window.location.href = "/reports/car_rental/pdf?"+postData5;
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
          }
    }

    else if(query=='contract'){
      var query17=$('#contract_type').val();
      if(query17==null){
        p19=0;
        $('#contracttypemsg').show();
          var message=document.getElementById('contracttypemsg');
           message.style.color='red';
           message.innerHTML="Required";
           $('#contract_type').attr('style','border:1px solid #f00');
      }
      else if(query17=='list'){
        p19=1;
        $('#contracttypemsg').hide();
        $('#contract_type').attr('style','border: 1px solid #ccc');
        var query18=$('#contractbusiness_type').val();
        if(query18==null){
          p20=0;
           $('#contractbusinesstypemsg').show();
          var message=document.getElementById('contractbusinesstypemsg');
           message.style.color='red';
           message.innerHTML="Required";
           $('#contractbusiness_type').attr('style','border:1px solid #f00');
        }
        else{
          p20=1;
          $('#contractbusinesstypemsg').hide();
        $('#contractbusiness_type').attr('style','border: 1px solid #ccc');

        if($('#Con_client_filter').is(":checked")){
        $("#Con_client_filter").val("true");
        var query36=$('#Con_clientname').val();
        console.log(query36);
        if(query36==null){
          p33=0;
           $('#Conclientnamemsg').show();
          var message=document.getElementById('Conclientnamemsg');
           message.style.color='red';
           message.innerHTML="Required";
           $('#Con_clientname').attr('style','border-bottom:1px solid #f00');
        }
        else{
         p33=1;
          $('#Conclientnamemsg').hide();
           $('#Con_clientname').attr('style','border-bottom:1px solid #ccc');
        }
        // if(cz==0){
        //   p33=0;
        //    $('#Conclientnamemsg').show();
        //   var message=document.getElementById('Conclientnamemsg');
        //    message.style.color='red';
        //    message.innerHTML="This client does not exists in the system";
        //    $('#Con_clientname').attr('style','border-bottom:1px solid #f00');
        // }
        // else{
        //  p33=1;
        //   $('#Conclientnamemsg').hide();
        //    $('#Con_clientname').attr('style','border-bottom:1px solid #ccc');
        // }
      }
      else{
        p33=1;
      }

      if($('#Con_payment_filter').is(":checked")){
        $("#Con_payment_filter").val("true");
        var query37=$('#Con_payment_status').val();
        if(query37==null){
          p34=0;
           $('#Conpaymentstatusmsg').show();
          var message=document.getElementById('Conpaymentstatusmsg');
           message.style.color='red';
           message.innerHTML="Required";
           $('#Con_payment_status').attr('style','border:1px solid #f00');
        }
        else{
         p34=1;
          $('#Conpaymentstatusmsg').hide();
           $('#Con_payment_status').attr('style','border:1px solid #ccc');
        }
      }
      else{
        p34=1;
      }
      if($('#Con_year_filter').is(":checked")){
        $("#Con_year_filter").val("true");
        var query38=$('#Con_year').val();
        if(query38==null){
          p35=0;
           $('#Conyearmsg').show();
          var message=document.getElementById('Conyearmsg');
           message.style.color='red';
           message.innerHTML="Required";
           $('#Con_year').attr('style','border:1px solid #f00');
        }
        else{
         p35=1;
          $('#Conyearmsg').hide();
           $('#Con_year').attr('style','border:1px solid #ccc');
        }
      }
      else{
        p35=1;
      }
        }
      }

        if(p19==1 && p20==1 && p33==1 && p34==1 &&p35==1){
          var _token = $('input[name="_token"]').val();
          var postData6 = "report_type="+ query17 + "&business_type="+query18 + "&c_filter=" + $('#Con_client_filter').val() + "&c_name="+ $('#Con_clientname').val()+ "&con_filter=" +$('#Con_payment_filter').val()+"&con_status="+$('#Con_payment_status').val()+"&y_filter="+$('#Con_year_filter').val()+"&year="+$('#Con_year').val()+"&lease="+$('input[name="Conyearcategory"]:checked').val();

            $.ajax({
            url: "{{ route('spacereport1') }}",
            method:"GET",
            data: postData5,
            contentType: "application/x-www-form-urlencoded",
            success: function(data) {
                window.location.href = "/reports/contracts/pdf?"+postData6;
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
        }

    }

    });

    $("#insurance_reporttype").click(function(e){
      var query=$(this).val();
      if(query=='sales'){
        $('#InsurancefilterBydiv').show();
      }
      else if(query=='clients'){
        $('#InsurancefilterBydiv').show();
      }
      else{
        $('#InsurancefilterBydiv').hide();
        $('#InsurancefilterBytype').hide();
        $('#principaltypediv').hide();
        $('#insurancetypediv').hide();
        $('#insurancepackagediv').hide();
        $('#insuranceyeardiv').hide();
        $('#udiayeardiv').hide();
        $("input[name='principal_filter']:checked").prop("checked", false);
        $("input[name='insurance_typefilter']:checked").prop("checked", false);
        $("input[name='insurance_packagefilter']:checked").prop("checked", false);
        $("#principaltype").val(" ");
        $('#insurance_type').val(" ");
        $('#insurance_package').val(" ");
        $('#udia_year').val(" ");
      }

      });

    $('#insurance_package').click(function(e){
      var query=$(this).val();
      if(query=='MOTOR'){
        $('#InsurancefilterBytype').show();
      }
      else{
        $('#InsurancefilterBytype').hide();
        //$('#InsurancefilterBytype').val(" ");
        $('#insurancetypediv').hide();
        $('#insurance_type').val(" ");
        $("input[name='insurance_typefilter']:checked").prop("checked", false);
      }
    });

    $("#principal_filter").click(function(){
    if($(this).is(":checked")){
      $(this).val("true");
      $('#principaltypediv').show();
    }
    else{
      $('#principaltypediv').hide();
      $("#principaltype").val(" ");
      $('#principaltypemsg').hide();
      $('#principaltype').attr('style','border: 1px solid #ccc');
    }

      });

    $("#insurance_typefilter").click(function(){
    if($(this).is(":checked")){
      $(this).val("true");
      $('#insurancetypediv').show();
    }
    else{
       $('#insurancetypediv').hide();
       $('#insurance_type').val(" ");
       $('#insurancetypemsg').hide();
       $('#insurance_type').attr('style','border: 1px solid #ccc');
    }

    });

    $("#insurance_packagefilter").click(function(){
    if($(this).is(":checked")){
      $(this).val("true");
      $('#insurancepackagediv').show();
    }
    else{
       $('#insurancepackagediv').hide();
       $('#insurance_package').val(" ");
       $('#insurancepackagemsg').hide();
       $('#insurance_package').attr('style','border: 1px solid #ccc');
       $('#InsurancefilterBytype').hide();
      $('#insurancetypediv').hide();
    }

    });

    $("#insurance_yearfilter").click(function(){
    if($(this).is(":checked")){
      $(this).val("true");
      $('#insuranceyeardiv').show();
      $('#udiayeardiv').show();
    }
    else{
       $('#insuranceyeardiv').hide();
       $('#udiayeardiv').hide();
       $('udiayearmsg').hide();
       $('#insuranceyearmsg').hide();
       $('#udia_year').val(" ");
       $('#insurance_year').attr('style','border: 1px solid #ccc');
       $('#udia_year').attr('style','border: 1px solid #ccc');
    }

    });

     $("#insurance_datefilter").click(function(){
    if($(this).is(":checked")){
      $(this).val("true");
      $('#insurancedatediv').show();
    }
    else{
       $('#insurancedatediv').hide();
       $('insurance_start_datemsg').hide();
       $('insurance_end_datemsg').hide();
       $('#insurance_start_date').val("");
       $('#insurance_end_date').val("");
       $('#insurance_start_date').attr('style','border-bottom: 1px solid #ccc');
       $('#insurance_end_date').attr('style','border-bottom: 1px solid #ccc');
    }

    });

    $("#vehicle_reg").select2({
    placeholder: "Select Vehicle",
    theme: "bootstrap",
    allowClear: true,
  });

       $("#carrevenuereg").select2({
    placeholder: "Select Vehicle Registration",
    theme: "bootstrap",
    allowClear: true,
  });

    $("#clientcostcentre").select2({
    placeholder: "Select Cost Centre",
    theme: "bootstrap",
    allowClear: true,
  });

  
   
    $("#Con_clientname" ).select2({
      placeholder: "Select Client",
      theme: "bootstrap",
      allowClear: true,
        ajax: { 
          url: "{{route('ajax.client_names')}}",
         method:"POST",
          dataType: 'json',
          delay: 250,
          data: function (params) {
            //console.log($('#contractbusiness_type').val());
            return {
              _token:$('input[name="_token"]').val(),
              queryy:$('#contractbusiness_type').val(),
              query: params.term // search term
            };
          },
          processResults: function (response) {
            //console.log(response);
            return {
              results: response
            };
          },
          cache: true
        }

      });


      $("#In_clientname" ).select2({
      placeholder: "Select Client",
      theme: "bootstrap",
      allowClear: true,
        ajax: { 
          url: "{{route('ajax.client_names')}}",
         method:"POST",
          dataType: 'json',
          delay: 250,
          data: function (params) {
            //console.log($('#contractbusiness_type').val());
            return {
              _token:$('input[name="_token"]').val(),
              queryy:$('#Inbusiness_type').val(),
              query: params.term // search term
            };
          },
          processResults: function (response) {
            //console.log(response);
            return {
              results: response
            };
          },
          cache: true
        }

      });

    

    });
</script>

<script>
window.addEventListener( "pageshow", function ( event ) {
  var historyTraversal = event.persisted ||
                         ( typeof window.performance != "undefined" &&
                              window.performance.navigation.type === 2 );
  if ( historyTraversal ) {
    // Handle page restore.
    window.location.reload();
  }
});
</script>

@endsection
