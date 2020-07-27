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
<li><a href="/invoice_management"><i class="fas fa-file-invoice"></i>Invoice</a></li>
<li><a href="/payment_management"><i class="fas fa-money-bill"></i>Payment</a></li>
            <li><a href="/reports"><i class="fas fa-file-pdf"></i>Reports</a></li>
        </ul>
    </div>
<div class="main_content">
<div class="container-fluid" id="grad1">
    <div class="row justify-content-center mt-0">
        <div class="col-12 col-sm-9 col-md-7 col-lg-9 text-center p-0 mt-3 mb-2">
            <div class="card px-0 pt-4 pb-0 mt-3 mb-3">
                <h2><strong>Report Generation</strong></h2>
                <p>Fill all form field with (*)</p>
                <div class="row">
                    <div class="col-md-12 mx-0">
                        <form id="msform" method="post" action="#">
                            {{csrf_field()}}

                             <!-- fieldsets -->
                            <fieldset>
                                <div class="form-card">
                          <div class="form-group" id="modulediv">
          <div class="form-wrapper" >
          <label for="module">Module*</label>
            <select class="form-control" required="" id="module" name="module">
              <option value="" disabled selected hidden>Select Module</option>
              <option value="car">Car Rental Module</option>
              <option value="contract">Contracts Module</option>
              <option value="insurance">Insurance Module</option>
              <option value="invoice">Invoice Module</option>
              <option value="payment">Payments Module</option>
              <option value="space">Space Module</option>
              <option value="tenant">Tenants Module</option>
            </select>
        </div>
    </div>

    <div class="form-group" id="spacetypediv" style="display: none;">
          <div class="form-wrapper">
          <label for="space_type">Select Report Type*</label>
          <span id="spacetypemsg"></span>
            <select class="form-control" id="space_type" name="space_type">
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

    <div class="form-group" id="space_idDiv" style="display: none;">
      <div class="form-wrapper">
      <label for="space_id"  >Space Id*</label>
      <span id="spaceidmsg"></span>
      <input type="text" class="form-control" id="space_id" name="space_id" value="" autocomplete="off">
      <div id="nameListSpaceId"></div>
      </div>
    </div>

    <div class="form-group" id="spacefilterBydate" style="display: none;">
        <div class="form-wrapper">
      <label for="space_filter_date" style=" display: inline-block; white-space: nowrap;">Filter By Date
      <input id="space_filter_date" type="checkbox" name="space_filter_date" style="margin-bottom: 15px;" value=""></label>

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

                  <div class="form-wrapper col-2" id="spacefilterprize">
                  <label for="prize" style=" display: block;
    white-space: nowrap;">Prize
                  <input class="form-check-input" type="checkbox" name="space_prize" id="space_prize" value="">
                </label>
                 </div>

                 <div class="form-wrapper col-3">
                  <label for="Status" style=" display: block;
    white-space: nowrap;">Occupation
    <input class="form-check-input" type="checkbox" name="status" id="Status" value="">
                   </label>
                </div>

                <div class="form-wrapper col-3">
                  <label for="location_filter" style=" display: block;
    white-space: nowrap;">Location
                   <input class="form-check-input" type="checkbox" name="location_filter" id="location_filter" value="">
                   </label>
                </div>


               </div>
             </div>
           </div>


           <div class="form-group row" id="spacedatediv" style="display: none;">
            <div class="form-wrapper col-6">
              <label for="start_date">From*</label>
              <span id="startdatemsg"></span>
              <input type="date" id="start_date" name="start_date" class="form-control" max="<?php echo(date('Y-m-d'))?>">
            </div>
            <div class="form-wrapper col-6">
              <label for="end_date">To*</label>
              <span id="enddatemsg"></span>
              <input type="date" id="end_date" name="end_date" class="form-control">
            </div>
          </div>

          <div class="form-group row" id="spacepricediv" style="display: none;">
            <div class="form-wrapper col-6">
              <label for="min_price">Min Price*</label>
              <span id="minpricemsg"></span>
              <input type="number" id="min_price" name="min_price" class="form-control" value="">
            </div>
            <div class="form-wrapper col-6">
              <label for="max_price">Max Price*</label>
              <span id="maxpricemsg"></span>
              <input type="number" id="max_price" name="max_price" class="form-control" value=" " >
            </div>
          </div>

          <div class="form-group" id="spaceoccupationdiv" style="display: none;">
          <div class="form-wrapper">
          <label for="space_status">Occupation Status*</label>
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
          <label for="insurance_reporttype">Select Report Type*</label>
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

                  <div class="form-wrapper col-3">
                  <label for="principal_filter" style=" display: block;
    white-space: nowrap;">Principal
                  <input class="form-check-input" type="checkbox" name="principal_filter" id="principal_filter" value="">
                </label>
                 </div>

                 <div class="form-wrapper col-3">
                  <label for="insurance_typefilter" style=" display: block;
    white-space: nowrap;">Insurance Type
                   <input class="form-check-input" type="checkbox" name="insurance_typefilter" id="insurance_typefilter" value="">
                   </label>
                </div>
               </div>
             </div>
           </div>

           <div class="form-group" id="Locationtypediv" style="display: none;">
          <div class="form-wrapper">
          <label for="Locationtype">Select Location*</label>
          <span id="Locationtypemsg"></span>
            <select class="form-control" id="Locationtype" name="Locationtype">
              <option value="" disabled selected hidden>Select Location</option>
              <option value="Mlimani City">Mlimani City</option>
              <option value="UDSM Main Campus">UDSM Main Campus</option>
            </select>
        </div>
    </div>

           <div class="form-group" id="principaltypediv" style="display: none;">
          <div class="form-wrapper">
          <label for="principaltype">Select Principal*</label>
          <span id="principaltypemsg"></span>
            <select class="form-control" id="principaltype" name="principaltype">
              <option value=" " disabled selected hidden>Select Principal</option>
              <option value="BRITAM">BRITAM</option>
              <option value="ICEA LION">ICEA LION</option>
              <option value="NIC">NIC</option>
            </select>
        </div>
    </div>

    <div class="form-group" id="insurancetypediv" style="display: none;">
          <div class="form-wrapper">
          <label for="insurance_type">Select Insurance Type*</label>
          <span id="insurancetypemsg"></span>
            <select class="form-control" id="insurance_type" name="insurance_type">
              <option value=" " disabled selected hidden>Select Insurance Type</option>
              <option value="COMPREHENSIVE">COMPREHENSIVE</option>
              <option value="THIRD PARTY">THIRD PARTY</option>
            </select>
        </div>
    </div>

    <div class="form-group" id="tenanttypediv" style="display: none;">
          <div class="form-wrapper">
          <label for="tenant_type">Select Report Type*</label>
          <span id="tenanttypemsg"></span>
            <select class="form-control" id="tenant_type" name="tenant_type">
              <option value=" " disabled selected hidden>Select Report Type</option>
              <option value="list">List of Tenants</option>
            </select>
        </div>
    </div>

    <div class="form-group" id="TenantfilterBydiv" style="display: none;">
      <div class="form-wrapper">
                  <label for="Criteria">Filter By</label>
                  <div class="row">

                  <div class="form-wrapper col-3">
                  <label for="business_filter" style=" display: block;
    white-space: nowrap;">Business Type
                  <input class="form-check-input" type="checkbox" name="business_filter" id="business_filter" value="">
                </label>
                 </div>

                 <div class="form-wrapper col-3">
                  <label for="contract_filter" style=" display: block;
    white-space: nowrap;">Contract Status
                   <input class="form-check-input" type="checkbox" name="contract_filter" id="contract_filter" value="">
                   </label>
                </div>

                <div class="form-wrapper col-3">
                  <label for="payment_filter" style=" display: block;
    white-space: nowrap;">Payment Status
                   <input class="form-check-input" type="checkbox" name="payment_filter" id="payment_filter" value="">
                   </label>
                </div>
               </div>
             </div>
           </div>


           <div class="form-group" id="businesstypediv" style="display: none;">
          <div class="form-wrapper">
          <label for="business_type">Select Business Type*</label>
          <span id="businesstypemsg"></span>
            <select class="form-control" id="business_type" name="business_type">
              <option value=" " disabled selected hidden>Select Business Type</option>
              <option value="Cafeteria">CAFETERIA</option>
              <option value="Mall-Shop">MALL SHOP</option>
              <option value="Office block">OFFICE BLOCK</option>
              <option value="Stationery">STATIONERY</option>
              <option value="Villa">VILLA</option>
            </select>
        </div>
    </div>

    <div class="form-group" id="contractstatusdiv" style="display: none;">
          <div class="form-wrapper">
          <label for="contract_status">Select Contract Status*</label>
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
          <label for="payment_status">Select Payment Status*</label>
          <span id="paymentstatusmsg"></span>
            <select class="form-control" id="payment_status" name="payment_status">
              <option value=" " disabled selected hidden>Select Payment Status</option>
              <option value="1">Paid</option>
              <option value="0">Not Paid</option>
            </select>
        </div>
    </div>

    <div class="form-group" id="cartypediv" style="display: none;">
          <div class="form-wrapper">
          <label for="car_type">Select Report Type*</label>
          <span id="cartypemsg"></span>
            <select class="form-control" id="car_type" name="car_type">
              <option value=" " disabled selected hidden>Select Report Type</option>
              {{-- <option value="car history">List of Car Rental History</option> --}}
              <option value="cars">List of Rental Cars</option>
              <option value="clients">List of Clients</option>
            </select>
        </div>
    </div>

    <div class="form-group" id="contracttypediv" style="display: none;">
          <div class="form-wrapper">
          <label for="contract_type">Select Report Type*</label>
          <span id="contracttypemsg"></span>
            <select class="form-control" id="contract_type" name="contract_type">
              <option value=" " disabled selected hidden>Select Report Type</option>
              <option value="list">List of Contracts</option>
            </select>
        </div>
    </div>

    <div class="form-group" id="contractbusinesstypediv" style="display: none;">
          <div class="form-wrapper">
          <label for="contractbusiness_type">Select Business Type*</label>
          <span id="contractbusinesstypemsg"></span>
            <select class="form-control" id="contractbusiness_type" name="contractbusiness_type">
              <option value=" " disabled selected hidden>Select Business Type</option>
              <option value="Space">SPACE</option>
              <option value="Insurance">INSURANCE</option>
              <option value="Car Rental">CAR RENTAL</option>
            </select>
        </div>
    </div>

      <div class="form-group" id="ContractfilterBydiv" style="display: none;">
      <div class="form-wrapper">
                  <label for="Criteria">Filter By</label>
                  <div class="row">

                  <div class="form-wrapper col-3">
                  <label for="client_filter" style=" display: block;
    white-space: nowrap;">Client Type
                  <input class="form-check-input" type="checkbox" name="client_filter" id="client_filter" value="">
                </label>
                 </div>

               </div>
             </div>
           </div>

           <div class="form-group" id="clienttypediv" style="display: none;">
          <div class="form-wrapper">
          <label for="client_type">Select Client Type*</label>
          <span id="clienttypemsg"></span>
            <select class="form-control" id="client_type" name="client_type">
              <option value=" " disabled selected hidden>Select Client Type</option>
              <option value="Individual">Individual</option>
              <option value="Company">Company</option>
            </select>
        </div>
    </div>


  </div>
  <div>
  <button class="btn btn-primary" type="submit" id="submitbutton">Submit</button>
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
<script type="text/javascript">
  $(document).ready(function(){
   $("#module").click(function(){
     var query = $(this).val();
     if(query=='space'){
      $('#spacetypediv').show();
       $('#insurancereporttypediv').hide();
       $('#InsurancefilterBydiv').hide();
       $('#principaltypediv').hide();
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
       $('#insurance_reporttype').val(" ");
       $('#principaltype').val(" ");
       $('#insurance_type').val(" ");
       $('#tenant_type').val(" ");
       $('#business_type').val(" ");
       $('#contract_status').val(" ");
       $('#payment_status').val(" ");
       $('#cartypediv').hide();
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
     }
     else if(query=='insurance'){
       $('#spacetypediv').hide();
       $('#spacefilterdiv').hide();
       $('#space_idDiv').hide();
       $('#spacefilterBydate').hide();
       $('#spacefilterBydiv').hide();
       $('#spacedatediv').hide();
       $('#spacepricediv').hide();
       $('#Locationtypediv').hide();
       $('#spaceoccupationdiv').hide();
       $('#TenantfilterBydiv').hide();
       $('#businesstypediv').hide();
       $('#contractstatusdiv').hide();
       $('#paymentstatusdiv').hide();
       $('#space_type').val(" ");
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
       $("input[name='status']:checked").prop("checked", false);
       $("input[name='business_filter']:checked").prop("checked", false);
       $("input[name='contract_filter']:checked").prop("checked", false);
       $("input[name='payment_filter']:checked").prop("checked", false);
       $('#business_type').val(" ");
       $('#contract_status').val(" ");
       $('#payment_status').val(" ");
       $('#tenant_type').val(" ");
       $('#cartypediv').hide();
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
     }
     else if(query=='tenant'){
       $('#tenanttypediv').show();
       $('#spacetypediv').hide();
       $('#spacefilterdiv').hide();
       $('#space_idDiv').hide();
       $('#spacefilterBydate').hide();
       $('#spacefilterBydiv').hide();
       $('#spacedatediv').hide();
       $('#spacepricediv').hide();
       $('#Locationtypediv').hide();
       $('#spaceoccupationdiv').hide();
       $('#insurancereporttypediv').hide();
       $('#InsurancefilterBydiv').hide();
       $('#principaltypediv').hide();
       $('#insurancetypediv').hide();
       $('#space_type').val(" ");
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
       $("input[name='status']:checked").prop("checked", false);
       $('#insurancereporttypediv').hide();
       $('#InsurancefilterBydiv').hide();
       $('#principaltypediv').hide();
       $('#insurancetypediv').hide();
       $('#cartypediv').hide();
       $('#car_type').val(" ");
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
     }
     else if(query=='car'){
      $('#cartypediv').show();
       $('#spacetypediv').hide();
       $('#spacefilterdiv').hide();
       $('#space_idDiv').hide();
       $('#spacefilterBydate').hide();
       $('#spacefilterBydiv').hide();
       $('#spacedatediv').hide();
       $('#spacepricediv').hide();
       $('#Locationtypediv').hide();
       $('#spaceoccupationdiv').hide();
       $('#TenantfilterBydiv').hide();
       $('#businesstypediv').hide();
       $('#contractstatusdiv').hide();
       $('#paymentstatusdiv').hide();
       $('#tenanttypediv').hide();
       $('#space_type').val(" ");
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
       $("input[name='status']:checked").prop("checked", false);
       $("input[name='business_filter']:checked").prop("checked", false);
       $("input[name='contract_filter']:checked").prop("checked", false);
       $("input[name='payment_filter']:checked").prop("checked", false);
       $("input[name='principal_filter']:checked").prop("checked", false);
       $("input[name='insurance_typefilter']:checked").prop("checked", false);
       $('#contracttypediv').hide();
       $('#contractbusinesstypediv').hide();
       $('#ContractfilterBydiv').hide();
       $('#clienttypediv').hide();
       $("input[name='client_filter']:checked").prop("checked", false);
       $('#contract_type').val(" ");
       $('#contractbusiness_type').val(" ");
       $('#client_type').val(" ");
     }
     else if(query=='contract'){
      $('#contracttypediv').show();
      $('#insurancereporttypediv').hide();
       $('#InsurancefilterBydiv').hide();
       $('#principaltypediv').hide();
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
       $('#insurance_reporttype').val(" ");
       $('#principaltype').val(" ");
       $('#insurance_type').val(" ");
       $('#tenant_type').val(" ");
       $('#business_type').val(" ");
       $('#contract_status').val(" ");
       $('#payment_status').val(" ");
       $('#cartypediv').hide();
       $('#car_type').val(" ");
       $('#tenanttypediv').hide();
       $('#spacetypediv').hide();
       $('#spacefilterdiv').hide();
       $('#space_idDiv').hide();
       $('#spacefilterBydate').hide();
       $('#spacefilterBydiv').hide();
       $('#spacedatediv').hide();
       $('#spacepricediv').hide();
       $('#Locationtypediv').hide();
       $('#spaceoccupationdiv').hide();
       $('#space_type').val(" ");
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
     }
    });



   $("#space_type").click(function(){
     var query = $(this).val();
     if(query=='list'){
      $('#space_idDiv').hide();
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
      $('#space_idDiv').show();
      $('#spacefilterBydiv').hide();
      $('#spacepricediv').hide();
      $('#Locationtypediv').hide();
      $('#spaceoccupationdiv').hide();
      $("input[name='space_filter']:checked").prop("checked", false);
      $("input[name='space_prize']:checked").prop("checked", false);
      $("input[name='location_filter']:checked").prop("checked", false);
      $("input[name='status']:checked").prop("checked", false);
      $('#min_price').val("");
      $('#max_price').val("");
      $('#space_status').val("");
      $('#start_date').val("");
      $('#end_date').val("");
     }
     else{
      $('#space_idDiv').hide();
      $('#spacefilterBydate').hide();
      $('#spacepricediv').hide();
      $('#Locationtypediv').hide();
      $('#spaceoccupationdiv').hide();
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
      $("#payment_filter").val("true");
    }
    else{
      $("#payment_filter").val("");
      $('#payment_status').val(" ");
      $('#paymentstatusdiv').hide();
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
      $('#ContractfilterBydiv').show();
    }
   });


var a;
   $('#space_id').keyup(function(e){
    e.preventDefault();
        var query = $(this).val();
        if(query != ''){
         var _token = $('input[name="_token"]').val();
         $.ajax({
          url:"{{ route('autocomplete.spaces') }}",
          method:"POST",
          data:{query:query, _token:_token},
          success:function(data){
            if(data=='0'){
             $('#space_id').attr('style','border:1px solid #f00');
             a = '0';
            }
            else{
              a ='1';
              //$('#message2').hide();
              $('#space_id').attr('style','border:1px solid #ced4da');
              $('#nameListSpaceId').fadeIn();
              $('#nameListSpaceId').html(data);
          }
        }
         });
        }
        else if(query==''){
          a ='1';
              //$('#message2').hide();
              $('#space_id').attr('style','border:1px solid #ced4da');
        }


    });

   $(document).on('click', '#list', function(){
   a ='1';
   //$('#message2').hide();
  $('#space_id').attr('style','border:1px solid #ced4da');

        $('#space_id').val($(this).text());
        $('#nameListSpaceId').fadeOut();

        });

   $(document).on('click', 'form', function(){
     $('#nameListSpaceId').fadeOut();
    });

$("#tenant_type").click(function(){
 var query= $(this).val();
 if(query=='list'){
  $('#TenantfilterBydiv').show();
 }
   });

   $("#submitbutton").click(function(e){
       e.preventDefault();
       var p1,p2,p3,p4,p5,p6,p7,p8,p9,p10,p11,p12,p13,p14,p15,p16,p17,p18,p19,p20,p21;
       var query = $("#module").val();

       if(query=='space'){
        var query2 = $("#space_type").val();
        if(query2==null){
          p1=0;
          $('#spacetypemsg').show();
             var message=document.getElementById('spacetypemsg');
             message.style.color='red';
             message.innerHTML="Required";
             $('#space_type').attr('style','border:1px solid #f00');
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

         if(p1==1&& p2==1 && p3==1 &&p4==1&&p13==1){
          $.ajaxSetup({
      headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

          var _token = $('input[name="_token"]').val();
          var postData = "module="+ query+ "&space_type="+ query2+ "&min_price=" + query3 + "&max_price=" +query4 + "&space_status=" +query5+"&space_prize="+$('#space_prize').val()+"&status="+ $('#Status').val()+"&location="+queryA+"&location_status="+$('#location_filter').val();

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
        console.log(query6);
        if(query6==""){
          p5=0;
          $('#spaceidmsg').show();
          var message=document.getElementById('spaceidmsg');
           message.style.color='red';
           message.innerHTML="Required";
           $('#space_id').attr('style','border-bottom:1px solid #f00');
        }
        else{
          p5=1;
          $('#spaceidmsg').hide();
          $('#space_id').attr('style','border-bottom: 1px solid #ccc');
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
                $('#space_type').attr('style','border: 1px solid #ccc');
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
      else if(query9=='sales'){
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

        if(p8==1 && p9==1 &&p10==1){
          var _token = $('input[name="_token"]').val();
          var postData2 = "report_type="+ query9+ "&principaltype="+ query10+ "&insurance_type=" + query11 + "&principal_filter=" + $('#principal_filter').val() + "&insurance_typefilter=" + $('#insurance_typefilter').val();

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
      else{
            p14=1;
           $('#tenanttypemsg').hide();
          $('#tenant_type').attr('style','border: 1px solid #ccc');
          }

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
        }
        else{
          p17=1;
        }

        if(p14==1 && p15==1 && p16==1 && p17==1){
           var _token = $('input[name="_token"]').val();
          var postData4 = "report_type="+ query12+ "&business_filter="+ $('#business_filter').val()+ "&business_type=" + query13 + "&contract_filter=" + $('#contract_filter').val() + "&contract_status=" + query14 +"&payment_filter="+$('#payment_filter').val()+"&payment_status="+query15;

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
        }
      }




        if($('#client_filter').is(":checked")){
          var query19 =$('#client_type').val();
          if(query19==null){
            p21=0;
          $('#clienttypemsg').show();
          var message=document.getElementById('clienttypemsg');
           message.style.color='red';
           message.innerHTML="Required";
           $('#client_type').attr('style','border:1px solid #f00');
          }
          else{
            p21=1;
           $('#clienttypemsg').hide();
          $('#client_type').attr('style','border: 1px solid #ccc');
          }
        }
        else{
          p21=1;
        }

        if(p19==1 && p20==1 && p21==1){
          var _token = $('input[name="_token"]').val();
          var postData6 = "report_type="+ query17 + "&business_type="+query18 + "&client_filter=" + $('#client_filter').val() + "&client_type="+ query19;

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
      else{
        $('#InsurancefilterBydiv').hide();
        $('#principaltypediv').hide();
        $('#insurancetypediv').hide();
        $("input[name='principal_filter']:checked").prop("checked", false);
        $("input[name='insurance_typefilter']:checked").prop("checked", false);
        $("#principaltype").val(" ");
        $('#insurance_type').val(" ");
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
