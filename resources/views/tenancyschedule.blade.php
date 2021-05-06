<!DOCTYPE html>
<html>
<head>
	<title>Tenancy Schedule Report</title>
</head>
<style>
table {
  border-collapse: collapse;
   width: 100%;
   font-size: 14px;
}

table, td, th {
  border: 1px solid black;
}
/*table {
  counter-reset: tableCount;
  }*/

 /* .counterCell:before {
  content: counter(tableCount);
  counter-increment: tableCount;
  }*/

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
<?php
	$invoice=[];
    $contract_id=[];
      $k=0;

  	$x1= $_GET['start'];
	$x2= $_GET['duration'];
	if($x2>5){
		$x2=5;
	}
	$x3=$x1+$x2-1;
?>
<body>
	<div id="footer">
  		<div class="page-number"></div>
	</div>

	<center>
		<b>UNIVERSITY OF DAR ES SALAAM<br><br>
			<img src="{{public_path('/images/logo_udsm.jpg')}}" height="70px"></img>
     		<br>DIRECTORATE OF PLANNING, DEVELOPMENT AND INVESTMENT

		@if(($_GET['b_fil']=='true') && ($_GET['l_fil']=='true'))
			<br><br>Tenancy Schedule {{DateTime::createFromFormat('!m', $x1)->format('F')}} {{$_GET['year']}} to {{DateTime::createFromFormat('!m', $x3)->format('F')}} {{$_GET['year']}} for {{$_GET['b_type']}} at {{$_GET['loc']}} Area
		@elseif(($_GET['b_fil']=='true') && ($_GET['l_fil']!='true'))
			<br><br>Tenancy Schedule {{DateTime::createFromFormat('!m', $x1)->format('F')}} {{$_GET['year']}} to {{DateTime::createFromFormat('!m', $x3)->format('F')}} {{$_GET['year']}} for {{$_GET['b_type']}}
		@elseif(($_GET['b_fil']!='true') && ($_GET['l_fil']=='true'))
			<br><br>Tenancy Schedule {{DateTime::createFromFormat('!m', $x1)->format('F')}} {{$_GET['year']}} to {{DateTime::createFromFormat('!m', $x3)->format('F')}} {{$_GET['year']}} at {{$_GET['loc']}} Area
		@elseif(($_GET['b_fil']!='true') && ($_GET['l_fil']!='true'))
			<br><br>Tenancy Schedule {{DateTime::createFromFormat('!m', $x1)->format('F')}} {{$_GET['year']}} to {{DateTime::createFromFormat('!m', $x3)->format('F')}} {{$_GET['year']}}
		@endif
		</b>
	</center>
<br>

<table class="hover table table-striped table-bordered">
	<thead class="thead-dark">
	<tr>
		<th scope="col" style="width: 5%;">SN</th>
		<th scope="col" style="width: 9%;">Real Estate Number</th>
		<th scope="col" style="width: 20%;">Tenant Name</th>
		<th scope="col">Lease Start</th>
		<th scope="col">Lease End</th>
		<th scope="col">ESC. %</th>
		<th scope="col" style="width: 7%;">Currency</th>
		@for($month=$x1; $month<=$x3; $month++)
			<th scope="col">{{DateTime::createFromFormat('!m', $month)->format('F')}}</th>
		@endfor
	</tr>
	</thead>
	<tbody>
		@foreach($details as $detail)
			<?php
				$k =$k+1;
				$contract_id= array();
				$invoice= array();
				$contract_id[] = DB::table('invoices')
								->select('contract_id')
								->where('contract_id',$detail->contract_id)
								->distinct()->pluck('contract_id')
								->toArray();

				foreach($contract_id[0] as $id){

        			for ($days_backwards = $x1; $days_backwards <= $x3; $days_backwards++) {

    					$invoice[] = DB::table('space_payments')
    								->join('invoices','invoices.invoice_number','=','space_payments.invoice_number')
    								->select('amount_paid')
    								->where('contract_id',$id)
    								->whereMonth('invoicing_period_start_date',$days_backwards)
    								->whereYear('invoicing_period_start_date',$_GET['year'])
    								->where('invoices.payment_status','!=','Not paid')
    								->pluck('amount_paid')
    								->toArray();
      				}

    			}

			?>
		<tr>
			<td><center>{{$k}}.</center></td>
			<td>{{$detail->space_id_contract}}</td>
			<td>{{$detail->debtor_name}}</td>
			<td><center>{{date("d/m/Y",strtotime($detail->start_date))}}</center></td>
			<td><center>{{date("d/m/Y",strtotime($detail->end_date))}}</center></td>
			<td style="text-align: center;">{{$detail->escalation_rate}}</td>
			<td style="text-align: center;">{{$detail->currency}}</td>
			@for ($i=0; $i <sizeof($invoice) ; $i++)
      				@if(!empty($invoice[$i][0]))
      					<td style="text-align: right;">{{number_format($invoice[$i][0])}}</td>
      				@else
      					<td style="text-align: center;">0</td>
      				@endif
			@endfor

		</tr>
		@endforeach


	</tbody>
</table>
</body>
</html>
