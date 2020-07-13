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
table {
  counter-reset: tableCount;
  }

  .counterCell:before {
  content: counter(tableCount);
  counter-increment: tableCount;
  }
</style>
<body>
<?php
//use DB;
$today=date('Y-m-d');
if(($_GET['business_filter']=='true') && ($_GET['contract_filter']=='true') && ($_GET['payment_filter']=='true')){
	if($_GET['contract_status']==1){
		$tenants=DB::table('space_contracts')->join('clients','clients.full_name','=','space_contracts.full_name')->join('spaces','spaces.space_id','=','space_contracts.space_id_contract')->where('space_contracts.contract_status',1)->whereDate('space_contracts.end_date','>=',$today)->where('spaces.space_type',$_GET['business_type'])->distinct()->get();
	}
	else if($_GET['contract_status']==0){
		$tenants=DB::table('space_contracts')->join('clients','clients.full_name','=','space_contracts.full_name')->join('spaces','spaces.space_id','=','space_contracts.space_id_contract')->where('space_contracts.contract_status',1)->whereDate('end_date','<',$today)->where('spaces.space_type',$_GET['business_type'])->distinct()->get();
	}
	else if($_GET['contract_status']==-1){
		$tenants=DB::table('space_contracts')->join('clients','clients.full_name','=','space_contracts.full_name')->join('spaces','spaces.space_id','=','space_contracts.space_id_contract')->where('space_contracts.contract_status',0)->where('spaces.space_type',$_GET['business_type'])->distinct()->get();
	}
	
}
if(($_GET['business_filter']=='true') && ($_GET['contract_filter']=='true') && ($_GET['payment_filter']!='true')){
   	if($_GET['contract_status']==1){
		$tenants=DB::table('space_contracts')->join('clients','clients.full_name','=','space_contracts.full_name')->join('spaces','spaces.space_id','=','space_contracts.space_id_contract')->where('space_contracts.contract_status',1)->whereDate('space_contracts.end_date','>=',$today)->where('spaces.space_type',$_GET['business_type'])->distinct()->get();
	}
	else if($_GET['contract_status']==0){
		$tenants=DB::table('space_contracts')->join('clients','clients.full_name','=','space_contracts.full_name')->join('spaces','spaces.space_id','=','space_contracts.space_id_contract')->where('space_contracts.contract_status',1)->whereDate('end_date','<',$today)->where('spaces.space_type',$_GET['business_type'])->distinct()->get();
	}
	else if($_GET['contract_status']==-1){
		$tenants=DB::table('space_contracts')->join('clients','clients.full_name','=','space_contracts.full_name')->join('spaces','spaces.space_id','=','space_contracts.space_id_contract')->where('space_contracts.contract_status',0)->where('spaces.space_type',$_GET['business_type'])->distinct()->get();
	}
}
if(($_GET['business_filter']=='true') && ($_GET['contract_filter']!='true') && ($_GET['payment_filter']=='true')){
    $tenants=DB::table('space_contracts')->join('clients','clients.full_name','=','space_contracts.full_name')->join('spaces','spaces.space_id','=','space_contracts.space_id_contract')->where('space_contracts.contract_status',1)->where('spaces.space_type',$_GET['business_type'])->distinct()->get();
}
if(($_GET['business_filter']=='true') && ($_GET['contract_filter']!='true') && ($_GET['payment_filter']!='true')){
  $tenants=DB::table('space_contracts')->join('clients','clients.full_name','=','space_contracts.full_name')->join('spaces','spaces.space_id','=','space_contracts.space_id_contract')->where('space_contracts.contract_status',1)->where('spaces.space_type',$_GET['business_type'])->distinct()->get();
}
if(($_GET['business_filter']!='true') && ($_GET['contract_filter']=='true') && ($_GET['payment_filter']=='true')){
    	if($_GET['contract_status']==1){
		$tenants=DB::table('space_contracts')->join('clients','clients.full_name','=','space_contracts.full_name')->join('spaces','spaces.space_id','=','space_contracts.space_id_contract')->where('space_contracts.contract_status',1)->whereDate('space_contracts.end_date','>=',$today)->distinct()->get();
	}
	else if($_GET['contract_status']==0){
		$tenants=DB::table('space_contracts')->join('clients','clients.full_name','=','space_contracts.full_name')->join('spaces','spaces.space_id','=','space_contracts.space_id_contract')->where('space_contracts.contract_status',1)->whereDate('end_date','<',$today)->distinct()->get();
	}
	else if($_GET['contract_status']==-1){
		$tenants=DB::table('space_contracts')->join('clients','clients.full_name','=','space_contracts.full_name')->join('spaces','spaces.space_id','=','space_contracts.space_id_contract')->where('space_contracts.contract_status',0)->distinct()->get();
	}
}
if(($_GET['business_filter']!='true') && ($_GET['contract_filter']=='true') && ($_GET['payment_filter']!='true')){
if($_GET['contract_status']==1){
		$tenants=DB::table('space_contracts')->join('clients','clients.full_name','=','space_contracts.full_name')->join('spaces','spaces.space_id','=','space_contracts.space_id_contract')->where('space_contracts.contract_status',1)->whereDate('space_contracts.end_date','>=',$today)->distinct()->get();
	}
	else if($_GET['contract_status']==0){
		$tenants=DB::table('space_contracts')->join('clients','clients.full_name','=','space_contracts.full_name')->join('spaces','spaces.space_id','=','space_contracts.space_id_contract')->where('space_contracts.contract_status',1)->whereDate('end_date','<',$today)->distinct()->get();
	}
	else if($_GET['contract_status']==-1){
		$tenants=DB::table('space_contracts')->join('clients','clients.full_name','=','space_contracts.full_name')->join('spaces','spaces.space_id','=','space_contracts.space_id_contract')->where('space_contracts.contract_status',0)->distinct()->get();
	}
}
if(($_GET['business_filter']!='true') && ($_GET['contract_filter']!='true') && ($_GET['payment_filter']=='true')){
  $tenants=DB::table('space_contracts')->join('clients','clients.full_name','=','space_contracts.full_name')->join('spaces','spaces.space_id','=','space_contracts.space_id_contract')->where('space_contracts.contract_status',1)->distinct()->get();
}
if(($_GET['business_filter']!='true') && ($_GET['contract_filter']!='true') && ($_GET['payment_filter']!='true')){
  $tenants=DB::table('space_contracts')->join('clients','clients.full_name','=','space_contracts.full_name')->join('spaces','spaces.space_id','=','space_contracts.space_id_contract')->where('space_contracts.contract_status',1)->distinct()->get();
}
?>
<center>
	<b>UNIVERSITY OF DAR ES SALAAM<br><br>
	<img src="{{public_path('/images/logo_udsm.jpg')}}" height="70px"></img>
     <br>DIRECTORATE OF PLANNING, DEVELOPMENT AND INVESTIMENT  
    </b>
@if(($_GET['business_filter']=='true') && ($_GET['contract_filter']=='true') && ($_GET['payment_filter']=='true'))
@if(($_GET['contract_status']==1) && ($_GET['payment_status']==1))
<br><br><strong>List of Active Tenants who have Paid and Whose Business Type is {{$_GET['business_type']}}</strong>
@elseif(($_GET['contract_status']==1) && ($_GET['payment_status']==0))
<br><br><strong>List of Active Tenants who have Not Paid and Whose Business Type is {{$_GET['business_type']}}</strong>
@elseif(($_GET['contract_status']!=1) && ($_GET['payment_status']==1))
<br><br><strong>List of Inactive Tenants who have Paid and Whose Business Type was {{$_GET['business_type']}}</strong>
@elseif(($_GET['contract_status']!=1) && ($_GET['payment_status']!=1))
<br><br><strong>List of Inactive Tenants who have Not Paid and Whose Business Type was {{$_GET['business_type']}}</strong>
@endif
@endif
@if(($_GET['business_filter']=='true') && ($_GET['contract_filter']=='true') && ($_GET['payment_filter']!='true'))
@if($_GET['contract_status']==1)
<br><br><strong>List of Active Tenants Whose Business Type is {{$_GET['business_type']}}</strong>
@elseif($_GET['contract_status']!=1)
<br><br><strong>List of Inctive Tenants Whose Business Type was {{$_GET['business_type']}}</strong>
@endif
@endif
@if(($_GET['business_filter']=='true') && ($_GET['contract_filter']!='true') && ($_GET['payment_filter']=='true'))
@if($_GET['payment_status']==1)
<br><br><strong>List of Tenants who have Paid and Whose Business Type is {{$_GET['business_type']}}</strong>
@elseif($_GET['payment_status']==0)
<br><br><strong>List of Tenants who have Not Paid and Whose Business Type is {{$_GET['business_type']}}</strong>
@endif
@endif
@if(($_GET['business_filter']=='true') && ($_GET['contract_filter']!='true') && ($_GET['payment_filter']!='true'))
<br><br><strong>List of Tenants Whose Business Type is {{$_GET['business_type']}}</strong>
@endif
@if(($_GET['business_filter']!='true') && ($_GET['contract_filter']=='true') && ($_GET['payment_filter']=='true'))
@if(($_GET['contract_status']==1) && ($_GET['payment_status']==1))
<br><br><strong>List of Active Tenants who have Paid</strong>
@elseif(($_GET['contract_status']==1) && ($_GET['payment_status']==0))
<br><br><strong>List of Active Tenants who have Not Paid</strong>
@elseif(($_GET['contract_status']!=1) && ($_GET['payment_status']==1))
<br><br><strong>List of Inactive Tenants who have Paid</strong>
@elseif(($_GET['contract_status']!=1) && ($_GET['payment_status']!=1))
<br><br><strong>List of Inactive Tenants who have Not Paid</strong>
@endif
@endif
@if(($_GET['business_filter']!='true') && ($_GET['contract_filter']=='true') && ($_GET['payment_filter']!='true'))
@if($_GET['contract_status']==1)
<br><br><strong>List of Active Tenants</strong>
@elseif($_GET['contract_status']!=1)
<br><br><strong>List of Inctive Tenants</strong>
@endif
@endif
@if(($_GET['business_filter']!='true') && ($_GET['contract_filter']!='true') && ($_GET['payment_filter']=='true'))
@if($_GET['payment_status']==1)
<br><br><strong>List of Tenants who have Paid</strong>
@elseif($_GET['payment_status']==0)
<br><br><strong>List of Tenants who have Not Paid
@endif
@endif
@if(($_GET['business_filter']!='true') && ($_GET['contract_filter']!='true') && ($_GET['payment_filter']!='true'))
<br><br><strong>List of Active Tenants
@endif
</center>
<br>
@if(count($tenants)>0)
<table class="hover table table-striped table-bordered" id="myTable">
  <thead class="thead-dark">
    <tr>
      <th scope="col"><center>S/N</center></th>
      <th scope="col"><center>Client Name</center></th>
      <th scope="col"><center>Client Type</center></th>
      <th scope="col"><center>Space ID</center></th>
      <th scope="col"><center>Phone Number</center></th>
      <th scope="col"><center>Email</center></th>
      <th scope="col"><center>Address</center></th>
    </tr>
  </thead>
  <tbody>
    @foreach($tenants as $client)
    <tr>
      <td class="counterCell text-center">.</td>
      <td>{{$client->full_name}}</td>
      <td>{{$client->type}}</td>
      <td>{{$client->space_id_contract}} </td>
      <td>{{$client->phone_number}}</td>
      <td>{{$client->email}}</td>
      <td>{{$client->address}}</td>
      </tr>
      @endforeach
  </tbody>
</table>
@else
<h3>Sorry No data found for the specified parameters</h3>
@endif
</body>
</html>