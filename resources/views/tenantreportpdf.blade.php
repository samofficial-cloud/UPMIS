<!DOCTYPE html>
<html>
<head>
	<title>TENANT REPORT</title>
</head>
<style>
table {
  border-collapse: collapse;
   width: 100%;
}

table, td, th {
  border: 1px solid black;
}

#header,
#footer {
  position: fixed;
  left: 0;
  right: 0;
  color: #aaa;
  font-size: 0.9em;
}
#header {
  top: 0;
  border-bottom: 0.1pt solid #aaa;
}
#footer {
  text-align: center;
  bottom: 0;
  color: black;
  font-size: 15px;
  /*border-top: 0.1pt solid #aaa;*/
}
.page-number:before {
  content: counter(page);
}

@page {
            margin: 77px 75px  !important;
            padding: 0px 0px 0px 0px !important;
        }

</style>
<body>
  <div id="footer">
  <div class="page-number"></div>
</div>
<?php
//use DB;
$today=date('Y-m-d');
$i='1';
$j=1;
?>
<center>
	<b>UNIVERSITY OF DAR ES SALAAM<br><br>
	<img src="{{public_path('/images/logo_udsm.jpg')}}" height="70px"></img>
     <br>DIRECTORATE OF PLANNING, DEVELOPMENT AND INVESTMENT
    </b>
@if($_GET['report_type']=='list')
@if(($_GET['business_filter']=='true') && ($_GET['contract_filter']=='true') && ($_GET['payment_filter']=='true'))
@if(($_GET['contract_status']==1))
<br><br><strong>List of Active Tenants who have {{$_GET['payment_status']}} for the Duration from {{date("d/m/Y",strtotime($_GET['start_date']))}} to {{date("d/m/Y",strtotime($_GET['end_date']))}} and whose Business Type is {{$_GET['business_type']}}</strong>

@elseif(($_GET['contract_status']==-1))
<br><br><strong>List of Terminated Tenants who have {{$_GET['payment_status']}} for the Duration from {{date("d/m/Y",strtotime($_GET['start_date']))}} to {{date("d/m/Y",strtotime($_GET['end_date']))}} and Whose Business Type was {{$_GET['business_type']}}</strong>
@elseif(($_GET['contract_status'] ==0))
<br><br><strong>List of Tenants whose Contract has Expired and who have {{$_GET['payment_status']}} for the Duration from {{date("d/m/Y",strtotime($_GET['start_date']))}} to {{date("d/m/Y",strtotime($_GET['end_date']))}} and whose Business Type was {{$_GET['business_type']}}</strong>
@endif
@endif
@if(($_GET['business_filter']=='true') && ($_GET['contract_filter']=='true') && ($_GET['payment_filter']!='true'))
@if($_GET['contract_status']==1)
<br><br><strong>List of Active Tenants Whose Business Type is {{$_GET['business_type']}}</strong>
@elseif($_GET['contract_status']==0)
<br><br><strong>List of Tenants whose Contract has Expired and whose Business Type was {{$_GET['business_type']}}</strong>
@elseif($_GET['contract_status']==-1)
<br><br><strong>List of Terminated Tenants whose Business Type was {{$_GET['business_type']}}</strong>
@endif
@endif
@if(($_GET['business_filter']=='true') && ($_GET['contract_filter']!='true') && ($_GET['payment_filter']=='true'))
<br><br><strong>List of Tenants who have {{$_GET['payment_status']}} for the Duration from {{date("d/m/Y",strtotime($_GET['start_date']))}} to {{date("d/m/Y",strtotime($_GET['end_date']))}} and Whose Business Type is {{$_GET['business_type']}}</strong>
@endif
@if(($_GET['business_filter']=='true') && ($_GET['contract_filter']!='true') && ($_GET['payment_filter']!='true'))
<br><br><strong>List of Tenants Whose Business Type is {{$_GET['business_type']}}</strong>
@endif
@if(($_GET['business_filter']!='true') && ($_GET['contract_filter']=='true') && ($_GET['payment_filter']=='true'))
@if(($_GET['contract_status']==1))
<br><br><strong>List of Active Tenants who have {{$_GET['payment_status']}} for the Duration from {{date("d/m/Y",strtotime($_GET['start_date']))}} to {{date("d/m/Y",strtotime($_GET['end_date']))}}</strong>
@elseif(($_GET['contract_status']==-1))
<br><br><strong>List of Terminated Tenants who have {{$_GET['payment_status']}} for the Duration from {{date("d/m/Y",strtotime($_GET['start_date']))}} to {{date("d/m/Y",strtotime($_GET['end_date']))}}</strong>
@elseif(($_GET['contract_status']==0))
<br><br><strong>List of Tenants whose Contract has Expired who have {{$_GET['payment_status']}} for the Duration from {{date("d/m/Y",strtotime($_GET['start_date']))}} to {{date("d/m/Y",strtotime($_GET['end_date']))}}</strong>
@endif
@endif
@if(($_GET['business_filter']!='true') && ($_GET['contract_filter']=='true') && ($_GET['payment_filter']!='true'))
@if($_GET['contract_status']==1)
<br><br><strong>List of Active Tenants</strong>
@elseif($_GET['contract_status']==0)
<br><br><strong>List of Tenants whose Contract has Expired</strong>
@elseif($_GET['contract_status']==-1)
<br><br><strong>List of Terminated Tenants</strong>
@endif
@endif
@if(($_GET['business_filter']!='true') && ($_GET['contract_filter']!='true') && ($_GET['payment_filter']=='true'))
<br><br><strong>List of Tenants who have {{$_GET['payment_status']}} for the Duration from {{date("d/m/Y",strtotime($_GET['start_date']))}} to {{date("d/m/Y",strtotime($_GET['end_date']))}}</strong>
@endif
@if(($_GET['business_filter']!='true') && ($_GET['contract_filter']!='true') && ($_GET['payment_filter']!='true'))
<br><br><strong>List of Tenants</strong>
@endif
@elseif($_GET['report_type']=='invoice')
@if($_GET['payment_filter']=='true')
@if($_GET['criteria']=='rent')
<br><br><strong>List of <u>{{$_GET['payment_status']}}</u> Rent Invoices for the Duration from {{date("d/m/Y",strtotime($_GET['start_date']))}} to {{date("d/m/Y",strtotime($_GET['end_date']))}}</strong>
@elseif($_GET['criteria']=='electricity')
<br><br><strong>List of <u>{{$_GET['payment_status']}}</u> Electricity Invoices for the Duration from {{date("d/m/Y",strtotime($_GET['start_date']))}} to {{date("d/m/Y",strtotime($_GET['end_date']))}} Invoices</strong>
@elseif($_GET['criteria']=='water')
<br><br><strong>List of <u>{{$_GET['payment_status']}}</u> Water Invoices for the Duration from {{date("d/m/Y",strtotime($_GET['start_date']))}} to {{date("d/m/Y",strtotime($_GET['end_date']))}}</strong>
@endif
@else
@if($_GET['criteria']=='rent')
<br><br><strong>List of Rent Invoices for the Duration from {{date("d/m/Y",strtotime($_GET['start_date']))}} to {{date("d/m/Y",strtotime($_GET['end_date']))}}</strong>
@elseif($_GET['criteria']=='electricity')
<br><br><strong>List of Electricity Invoices for the Duration from {{date("d/m/Y",strtotime($_GET['start_date']))}} to {{date("d/m/Y",strtotime($_GET['end_date']))}}</strong>
@elseif($_GET['criteria']=='water')
<br><br><strong>List of Water Invoices for the Duration from {{date("d/m/Y",strtotime($_GET['start_date']))}} to {{date("d/m/Y",strtotime($_GET['end_date']))}}</strong>
@endif
@endif
@endif
</center>
<br>
@if($_GET['report_type']=='list')
@if(count($tenants)>0)
<table class="hover table table-striped table-bordered" id="myTable">
  <thead class="thead-dark">
    <tr>
      <th scope="col"><center>S/N</center></th>
      <th scope="col" style="width: 18%;"><center>Client Name</center></th>
      <th scope="col"><center>Client Type</center></th>
      <th scope="col"><center>Real Estate Number</center></th>
      <th scope="col"><center>Phone Number</center></th>
      <th scope="col"><center>Email</center></th>
      <th scope="col"><center>Address</center></th>
      @if($_GET['contract_filter']!='true')
      <th scope="col"><center>Remarks</center></th>
      @endif
    </tr>
  </thead>
  <tbody>
    @foreach($tenants as $client)
    <tr>
      <td scope="row"><center>{{$j}}.</center></td>
      <td style="padding-left: 5px;">{{$client->full_name}}</td>
      <td style="padding-left: 5px;">{{$client->type}}</td>
      <td><center>{{$client->space_id_contract}}</center></td>
      <td><center>{{$client->phone_number}}</center></td>
      <td style="padding-left: 5px;">{{$client->email}}</td>
      <td style="padding-left: 5px;">{{$client->address}}</td>
      @if($_GET['contract_filter']!='true')
      @if($client->contract_status=='1' && $client->end_date<$today)
      <td><center>Expired</center></td>
      @elseif($client->contract_status=='1' && $client->end_date>=$today)
      <td><center>Active</center></td>
      @elseif($client->contract_status=='0')
      <td><center>Terminated</center></td>
      @endif
      @endif
      </tr>
      <?php $j=$j+1; ?>
      @endforeach
  </tbody>
</table>
@else
<h3>Sorry No data found for the specified parameters</h3>
@endif
@elseif($_GET['report_type']=='invoice')
@if(count($invoices)>0)
<table class="hover table table-striped  table-bordered" id="myTable3">
                            <thead class="thead-dark">
                            <tr>
                                <th scope="col"><center>S/N</center></th>
                                <th scope="col" ><center>Debtor Name</center></th>
                                <th scope="col"><center>Invoice Number</center></th>
                                <th scope="col" ><center>Start Date</center></th>
                                <th scope="col" ><center>End date</center></th>
                               {{--  <th scope="col" ><center>Period</center></th> --}}
                                <th scope="col"><center>Contract Id</center></th>
                                <th scope="col" ><center>Amount</center></th>
                                <th scope="col" ><center>GePG Control No</center></th>
                                <th scope="col" ><center>Invoice Date</center></th>
                                @if($_GET['payment_filter']=='')
                                <th scope="col" ><center>Remarks</center></th>
                                @endif
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($invoices as $var)
                                <tr>
                                    <td scope="row"><center>{{ $i }}.</center></td>
                                    <td><center>{{$var->debtor_name}}</center></td>
                                    <td><center>{{$var->invoice_number}}</center></td>

                                    <td><center>{{date("d/m/Y",strtotime($var->invoicing_period_start_date))}}</center></td>
                                    <td><center>{{date("d/m/Y",strtotime($var->invoicing_period_end_date))}}</center></td>
                                   {{--  <td><center>{{$var->period}}</center></td> --}}
                                    <td><center>{{$var->contract_id}}</center></td>
                                    @if($_GET['criteria']=='rent')
                                    <td><center>{{$var->currency_invoice}} {{number_format($var->amount_to_be_paid)}}</center></td>
                                    @else
                                    <td><center>{{$var->currency_invoice}} {{number_format($var->cumulative_amount)}}</center></td>
                                    @endif
                                    <td><center>{{$var->gepg_control_no}}</center></td>
                                    <td><center>{{date("d/m/Y",strtotime($var->invoice_date))}}</center></td>
                                     @if($_GET['payment_filter']=='')
                                     <td><center>{{$var->payment_status}}</center></td>
                                     @endif
                                  </tr>
                                  <?php
                                  $i=$i+1;
                                  ?>
                                  @endforeach
                                </tbody>
                              </table>
@else
<h3>Sorry No data found for the specified parameters</h3>
@endif
@endif
</body>
</html>
