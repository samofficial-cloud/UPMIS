<!DOCTYPE html>
<html>
<head>
	<title>Debt Summary</title>
</head>
<style>
table {
  border-collapse: collapse;
   width: 100%;

}

table, td, th {
  border: 1px solid black;
}
tbody{
	/*font-size: 15px;*/
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
<?php
	/* $contract_id = [];
	$contract_id[]= DB::table('invoices')
				->select('invoices.contract_id','debtor_name','major_industry','sub_location','currency')
				->join('space_contracts','space_contracts.contract_id','=','invoices.contract_id')
				->join('spaces','spaces.space_id','=','space_contracts.space_id_contract')
				->distinct()
				->get(); */

	$a=0;
	$b=0;
	$c=0;
	$d=0;
	$e=0;
	$f=0;
	$g=0;

$cptu_debt=0;
$cptu_income=0;
$udia_tzsdebt=0;
$udia_usddebt=0;
$udia_tzsincome=0;
$udia_usdincome=0;
$space_tzsdebt =0;
$space_usddebt = 0;
$space_tzsincome =0;
$space_usdincome = 0;
$water_tzsdebt =0;
$water_usddebt = 0;
$water_tzsincome =0;
$water_usdincome = 0;
$electric_tzsdebt =0;
$electric_usddebt = 0;
$electric_tzsincome =0;
$electric_usdincome = 0;
$flats_usdincome = 0;
$flats_tzsincome = 0;
$flats_usddebt = 0;
$flats_tzsdebt =0;
?>
<body>
	<div id="footer">
  		<div class="page-number"></div>
	</div>

	<center>
		<b>UNIVERSITY OF DAR ES SALAAM<br><br>
			<img src="{{public_path('/images/logo_udsm.jpg')}}" height="70px"></img>
     		<br>DIRECTORATE OF PLANNING, DEVELOPMENT AND INVESTMENT</b>
     		@if($_GET['b_type']=='Space')
     			@if($_GET['criteria']=='space')
 					@if(($_GET['bus_fil']=='true') && ($_GET['loc_fil']=='true') && ($_GET['yr_fil']=='true'))
 						<br><br>Real Estate Revenue Collection and Debts Summary of the Duration <strong>{{date("d/m/Y",strtotime($_GET['start']))}}</strong> to <strong>{{date("d/m/Y",strtotime($_GET['end']))}}</strong>, for <strong>Rent</strong>, whose business is <strong>{{$_GET['biz']}}</strong> and  Location is <strong>{{$_GET['loc']}}</strong>
 					@elseif(($_GET['bus_fil']=='true') && ($_GET['loc_fil']=='true') && ($_GET['yr_fil']!='true'))
 						<br><br>Real Estate Revenue Collection and Debts Summary for <strong>Rent</strong>, whose business is <strong>{{$_GET['biz']}}</strong> and Location is <strong>{{$_GET['loc']}}</strong>
 					@elseif(($_GET['bus_fil']=='true') && ($_GET['loc_fil']!='true') && ($_GET['yr_fil']=='true'))
 						<br><br>Real Estate Revenue Collection and Debts Summary of the Duration <strong>{{date("d/m/Y",strtotime($_GET['start']))}}</strong> to <strong>{{date("d/m/Y",strtotime($_GET['end']))}}</strong>, for <strong>Rent</strong> and whose business is <strong>{{$_GET['biz']}}</strong>
 					@elseif(($_GET['bus_fil']=='true') && ($_GET['loc_fil']!='true') && ($_GET['yr_fil']!='true'))
 						<br><br>Real Estate Revenue Collection and Debts Summary for <strong>Rent</strong>, whose business is <strong>{{$_GET['biz']}}</strong>
 					@elseif(($_GET['bus_fil']!='true') && ($_GET['loc_fil']=='true') && ($_GET['yr_fil']=='true'))
 						<br><br>Real Estate Revenue Collection and Debts Summary of the Duration <strong>{{date("d/m/Y",strtotime($_GET['start']))}}</strong> to <strong>{{date("d/m/Y",strtotime($_GET['end']))}}</strong>, for <strong>Rent</strong> and whose Location is <strong>{{$_GET['loc']}}</strong>
 					@elseif(($_GET['bus_fil']!='true') && ($_GET['loc_fil']=='true') && ($_GET['yr_fil']!='true'))
 						<br><br>Real Estate Revenue Collection and Debts Summary for <strong>Rent</strong> and Location is <strong>{{$_GET['loc']}}</strong>
 					@elseif(($_GET['bus_fil']!='true') && ($_GET['loc_fil']!='true') && ($_GET['yr_fil']=='true'))
 						<br><br>Real Estate Revenue Collection and Debts Summary of the Duration <strong>{{date("d/m/Y",strtotime($_GET['start']))}}</strong> to <strong>{{date("d/m/Y",strtotime($_GET['end']))}}</strong>, for <strong>Rent</strong>
 					@elseif(($_GET['bus_fil']!='true') && ($_GET['loc_fil']!='true') && ($_GET['yr_fil']!='true'))
 						<br><br>Real Estate Revenue Collection and Debts Summary for <strong>Rent</strong>
					@endif

				@elseif($_GET['criteria']=='electricity')
 					@if(($_GET['bus_fil']=='true') && ($_GET['loc_fil']=='true') && ($_GET['yr_fil']=='true'))
 						<br><br>Real Estate Revenue Collection and Debts Summary of the Duration <strong>{{date("d/m/Y",strtotime($_GET['start']))}}</strong> to <strong>{{date("d/m/Y",strtotime($_GET['end']))}}</strong>, for <strong>Electricity</strong>, whose business is <strong>{{$_GET['biz']}}</strong> and Location is <strong>{{$_GET['loc']}}</strong>
 					@elseif(($_GET['bus_fil']=='true') && ($_GET['loc_fil']=='true') && ($_GET['yr_fil']!='true'))
 						<br><br>Real Estate Revenue Collection and Debts Summary for <strong>Electricity</strong>, whose business is <strong>{{$_GET['biz']}}</strong> and Location is <strong>{{$_GET['loc']}}</strong>
 					@elseif(($_GET['bus_fil']=='true') && ($_GET['loc_fil']!='true') && ($_GET['yr_fil']=='true'))
 						<br><br>Real Estate Revenue Collection and Debts Summary of the Duration <strong>{{date("d/m/Y",strtotime($_GET['start']))}}</strong> to <strong>{{date("d/m/Y",strtotime($_GET['end']))}}</strong>, for <strong>Electricity</strong> and whose business is <strong>{{$_GET['biz']}}</strong>
 					@elseif(($_GET['bus_fil']=='true') && ($_GET['loc_fil']!='true') && ($_GET['yr_fil']!='true'))
 						<br><br>Real Estate Revenue Collection and Debts Summary for <strong>Electricity</strong>, whose business is <strong>{{$_GET['biz']}}</strong>
 					@elseif(($_GET['bus_fil']!='true') && ($_GET['loc_fil']=='true') && ($_GET['yr_fil']=='true'))
 						<br><br>Real Estate Revenue Collection and Debts Summary of the Duration <strong>{{date("d/m/Y",strtotime($_GET['start']))}}</strong> to <strong>{{date("d/m/Y",strtotime($_GET['end']))}}</strong>, for <strong>Electricity</strong> and whose Location is <strong>{{$_GET['loc']}}</strong>
 					@elseif(($_GET['bus_fil']!='true') && ($_GET['loc_fil']=='true') && ($_GET['yr_fil']!='true'))
 						<br><br>Real Estate Revenue Collection and Debts Summary for <strong>Electricity</strong> and Location is <strong>{{$_GET['loc']}}</strong>
 					@elseif(($_GET['bus_fil']!='true') && ($_GET['loc_fil']!='true') && ($_GET['yr_fil']=='true'))
 						<br><br>Real Estate Revenue Collection and Debts Summary of the Duration <strong>{{date("d/m/Y",strtotime($_GET['start']))}}</strong> to <strong>{{date("d/m/Y",strtotime($_GET['end']))}}</strong>, for <strong>Electricity</strong>
 					@elseif(($_GET['bus_fil']!='true') && ($_GET['loc_fil']!='true') && ($_GET['yr_fil']!='true'))
 						<br><br>Real Estate Revenue Collection and Debts Summary for <strong>Electricity</strong>
					@endif

				@elseif($_GET['criteria']=='water')
 					@if(($_GET['bus_fil']=='true') && ($_GET['loc_fil']=='true') && ($_GET['yr_fil']=='true'))
 						<br><br>Real Estate Revenue Collection and Debts Summary of the Duration <strong>{{date("d/m/Y",strtotime($_GET['start']))}}</strong> to <strong>{{date("d/m/Y",strtotime($_GET['end']))}}</strong>, for <strong>Water</strong>, whose business is <strong>{{$_GET['biz']}}</strong> and Location is <strong>{{$_GET['loc']}}</strong>
 					@elseif(($_GET['bus_fil']=='true') && ($_GET['loc_fil']=='true') && ($_GET['yr_fil']!='true'))
 						<br><br>Real Estate Revenue Collection and Debts Summary for <strong>Water</strong>, whose business is <strong>{{$_GET['biz']}}</strong> and Location is <strong>{{$_GET['loc']}}</strong>
 					@elseif(($_GET['bus_fil']=='true') && ($_GET['loc_fil']!='true') && ($_GET['yr_fil']=='true'))
 						<br><br>Real Estate Revenue Collection and Debts Summary of the Duration <strong>{{date("d/m/Y",strtotime($_GET['start']))}}</strong> to <strong>{{date("d/m/Y",strtotime($_GET['end']))}}</strong>, for <strong>Water</strong> and whose business is <strong>{{$_GET['biz']}}</strong>
 					@elseif(($_GET['bus_fil']=='true') && ($_GET['loc_fil']!='true') && ($_GET['yr_fil']!='true'))
 						<br><br>Real Estate Revenue Collection and Debts Summary for <strong>Water</strong>, whose business is <strong>{{$_GET['biz']}}</strong>
 					@elseif(($_GET['bus_fil']!='true') && ($_GET['loc_fil']=='true') && ($_GET['yr_fil']=='true'))
 						<br><br>Real Estate Revenue Collection and Debts Summary of the Duration <strong>{{date("d/m/Y",strtotime($_GET['start']))}}</strong> to <strong>{{date("d/m/Y",strtotime($_GET['end']))}}</strong>, for <strong>Water</strong> and whose Location is <strong>{{$_GET['loc']}}</strong>
 					@elseif(($_GET['bus_fil']!='true') && ($_GET['loc_fil']=='true') && ($_GET['yr_fil']!='true'))
 						<br><br>Real Estate Revenue Collection and Debts Summary for <strong>Water</strong> and Location is <strong>{{$_GET['loc']}}</strong>
 					@elseif(($_GET['bus_fil']!='true') && ($_GET['loc_fil']!='true') && ($_GET['yr_fil']=='true'))
 						<br><br>Real Estate Revenue Collection and Debts Summary of the Duration <strong>{{date("d/m/Y",strtotime($_GET['start']))}}</strong> to <strong>{{date("d/m/Y",strtotime($_GET['end']))}}</strong>,  for <strong>Water</strong>
 					@elseif(($_GET['bus_fil']!='true') && ($_GET['loc_fil']!='true') && ($_GET['yr_fil']!='true'))
 						<br><br>Real Estate Revenue Collection and Debts Summary for <strong>Water</strong>
 					@endif
				@endif

 			@elseif($_GET['b_type']=='Car Rental')
 				@if($_GET['yr2_fil']=='true')
 					<br><br>CPTU Revenue Collection and Debts Summary of the Duration <strong>{{date("d/m/Y",strtotime($_GET['start2']))}}</strong> to <strong>{{date("d/m/Y",strtotime($_GET['end2']))}}</strong>
 				@else
 					<br><br>CPTU Revenue Collection and Debts Summary
 				@endif
 			@elseif($_GET['b_type']=='Insurance')
 				@if($_GET['yr2_fil']=='true')
 					<br><br>UDIA Revenue Collection and Debts Summary of the Duration <strong>{{date("d/m/Y",strtotime($_GET['start2']))}}</strong> to <strong>{{date("d/m/Y",strtotime($_GET['end2']))}}</strong>
				@else
					<br><br>UDIA Revenue Collection and Debts Summary
				@endif
			@elseif($_GET['b_type']=='All')
				@if($_GET['yr2_fil']=='true')
 					<br><br>Revenue Collection and Debts Summary of the Duration <strong>{{date("d/m/Y",strtotime($_GET['start2']))}}</strong> to <strong>{{date("d/m/Y",strtotime($_GET['end2']))}}</strong>
				@else
					<br><br>Revenue Collection and Debts Summary
				@endif
 			@endif

     </center>
<br>
@if($_GET['b_type']=='Space')
	@if($_GET['show']=='clients')
		<table class="hover table table-striped table-bordered">
			<thead class="thead-dark">
				<tr>
					<th scope="col" style="width: 5%;">SN</th>
					<th scope="col">Client Name</th>
					<th scope="col"style="width: 10%;">Contract Id</th>
					<th scope="col" style="width: 14%;">Major Industry</th>
					<th scope="col" style="width: 17%;">Location</th>
					<th scope="col" style="width: 8%;">Currency</th>
					<th scope="col" style="width: 12%;">Revenue</th>
					<th scope="col" style="width: 12%;">Debt</th>
				</tr>
			</thead>
			<tbody>

				@for($z = 0; $z < count($contract_id); $z++)
					@foreach($contract_id[$z] as $contract)
						<?php $a = $a+1;?>
					<tr>
						<td style="text-align: center">{{$a}}.</td>
						<td>{{$contract->debtor_name}}</td>
						<td style="text-align: center">{{$contract->contract_id}}</td>
						<td>{{$contract->major_industry}}</td>
						<td>{{$contract->sub_location}}</td>
						<td style="text-align: center">{{$contract->currency}}</td>
						<?php
							$income=array();
								if($_GET['criteria']=='space'){
									if($_GET['yr_fil']=='true'){
										$income=DB::table('space_payments')
							        			->join('invoices','invoices.invoice_number','=','space_payments.invoice_number')
							        			->select(array(DB::raw('sum(amount_paid) as total')))
							        			->where('invoices.contract_id',$contract->contract_id)
							        			->wherebetween('date_of_payment',[ $_GET['start'] ,$_GET['end']])
							        			->value('total');

										$debt=DB::table('space_payments')
												->join('invoices','invoices.invoice_number','=','space_payments.invoice_number')
												->select('amount_not_paid')
												->where('invoices.contract_id',$contract->contract_id)
												->wherebetween('date_of_payment',[ $_GET['start'] ,$_GET['end']])
												->orderBy('amount_not_paid','dsc')
												->first();
									}
									else{
										$income=DB::table('space_payments')
							        			->join('invoices','invoices.invoice_number','=','space_payments.invoice_number')
							        			->select(array(DB::raw('sum(amount_paid) as total')))
							        			->where('invoices.contract_id',$contract->contract_id)
							        			->value('total');

										$debt=DB::table('space_payments')
												->join('invoices','invoices.invoice_number','=','space_payments.invoice_number')
												->select('amount_not_paid')
												->where('invoices.contract_id',$contract->contract_id)
												->orderBy('amount_not_paid','dsc')
												->first();
									}

								}
								elseif($_GET['criteria']=='electricity'){
									if($_GET['yr_fil']=='true'){
										$income=DB::table('electricity_bill_payments')
							        			->join('electricity_bill_invoices','electricity_bill_invoices.invoice_number','=','electricity_bill_payments.invoice_number')
							        			->select(array(DB::raw('sum(amount_paid) as total')))
							        			->where('electricity_bill_invoices.contract_id',$contract->contract_id)
							        			->wherebetween('date_of_payment',[ $_GET['start'] ,$_GET['end']])
							        			->value('total');

										$debt=DB::table('electricity_bill_payments')
												->join('electricity_bill_invoices','electricity_bill_invoices.invoice_number','=','electricity_bill_payments.invoice_number')
												->select('amount_not_paid')
												->where('electricity_bill_invoices.contract_id',$contract->contract_id)
												->wherebetween('date_of_payment',[ $_GET['start'] ,$_GET['end']])
												->orderBy('amount_not_paid','dsc')
												->first();
									}
									else{
										$income=DB::table('electricity_bill_payments')
							        			->join('electricity_bill_invoices','electricity_bill_invoices.invoice_number','=','electricity_bill_payments.invoice_number')
							        			->select(array(DB::raw('sum(amount_paid) as total')))
							        			->where('electricity_bill_invoices.contract_id',$contract->contract_id)
							        			->value('total');

										$debt=DB::table('electricity_bill_payments')
												->join('electricity_bill_invoices','electricity_bill_invoices.invoice_number','=','electricity_bill_payments.invoice_number')
												->select('amount_not_paid')
												->where('electricity_bill_invoices.contract_id',$contract->contract_id)
												->orderBy('amount_not_paid','dsc')
												->first();
									}


								}

								elseif($_GET['criteria']=='water'){
									if($_GET['yr_fil']=='true'){
										$income=DB::table('water_bill_payments')
							        			->join('water_bill_invoices','water_bill_invoices.invoice_number','=','water_bill_payments.invoice_number')
							        			->select(array(DB::raw('sum(amount_paid) as total')))
							        			->where('water_bill_invoices.contract_id',$contract->contract_id)
							        			->wherebetween('date_of_payment',[ $_GET['start'] ,$_GET['end']])
							        			->value('total');

										$debt=DB::table('water_bill_payments')
												->join('water_bill_invoices','water_bill_invoices.invoice_number','=','water_bill_payments.invoice_number')
												->select('amount_not_paid')
												->where('water_bill_invoices.contract_id',$contract->contract_id)
												->wherebetween('date_of_payment',[ $_GET['start'] ,$_GET['end']])
												->orderBy('amount_not_paid','dsc')
												->first();
									}
									else{
										$income=DB::table('water_bill_payments')
							        			->join('water_bill_invoices','water_bill_invoices.invoice_number','=','water_bill_payments.invoice_number')
							        			->select(array(DB::raw('sum(amount_paid) as total')))
							        			->where('water_bill_invoices.contract_id',$contract->contract_id)
							        			->value('total');

										$debt=DB::table('water_bill_payments')
												->join('water_bill_invoices','water_bill_invoices.invoice_number','=','water_bill_payments.invoice_number')
												->select('amount_not_paid')
												->where('water_bill_invoices.contract_id',$contract->contract_id)
												->orderBy('amount_not_paid','dsc')
												->first();
									}


								}


					 	?>
						 <td style="text-align: right;">{{number_format($income)}}</td>
						 <?php
						 	if($contract->currency=='TZS'){
						 		$space_tzsincome = $space_tzsincome +$income;
						 	}
						 	elseif($contract->currency=='USD'){
						 		$space_usdincome = $space_usdincome +$income;
						 	}
						 ?>
						 @if(!isset($debt))
						 <td style="text-align: right;">0</td>
						 <?php
						 	if($contract->currency=='TZS'){
						 		$space_tzsdebt = $space_tzsdebt +0;
						 	}
						 	elseif($contract->currency=='USD'){
						 		$space_usddebt = $space_usddebt +0;
						 	}
						 ?>
						 @else
						 <td style="text-align: right;">{{number_format($debt->amount_not_paid)}}</td>
						 <?php
						 	if($contract->currency=='TZS'){
						 		$space_tzsdebt = $space_tzsdebt +$debt->amount_not_paid;
						 	}
						 	elseif($contract->currency=='USD'){
						 		$space_usddebt = $space_usddebt +$debt->amount_not_paid;
						 	}
						 ?>
						 @endif

					</tr>
					@endforeach
				@endfor

			</tbody>
		</table>
		<table>
  				<tr style="width: 100%">
					<td rowspan="2"><b>TOTAL</b></td>
					<td style="width: 8%; text-align: right;"><center>TZS</center></td>
					<td style="width: 12%; text-align: right;">{{number_format($space_tzsincome)}}</td>
  					<td style="width: 12%; text-align: right;">{{number_format($space_tzsdebt)}}</td>
				</tr>
				<tr style="width: 100%">
					{{-- <td><b>TOTAL</b></td> --}}
					<td style="width: 8%; text-align: right;"><center>USD</center></td>
					<td style="width: 12%; text-align: right;">{{number_format($space_usdincome)}}</td>
  					<td style="width: 12%; text-align: right;">{{number_format($space_usddebt)}}</td>
				</tr>
</table>
	@endif
	@elseif($_GET['b_type']=='Car Rental')
	<table class="hover table table-striped table-bordered">
			<thead class="thead-dark">
				<tr>
					<th scope="col" style="width: 5%;">SN</th>
					<th scope="col">Client Name</th>
					<th scope="col"style="width: 10%;">Contract Id</th>
					<th scope="col" style="width: 14%;">Cost Centre ID</th>
					<th scope="col" style="width: 14%;">Cost Centre Name</th>
					<th scope="col" style="width: 17%;">Destination</th>
					<th scope="col" style="width: 8%;">Currency</th>
					<th scope="col" style="width: 12%;">Revenue</th>
					<th scope="col" style="width: 12%;">Debt</th>
				</tr>
			</thead>
			<tbody>

				@for($z = 0; $z < count($contract_id); $z++)
					@foreach($contract_id[$z] as $contract)
						<?php $a = $a+1;?>
					<tr>
						<td style="text-align: center">{{$a}}.</td>
						<td>{{$contract->debtor_name}}</td>
						<td style="text-align: center">{{$contract->contract_id}}</td>
						<td style="text-align: center">{{$contract->cost_centre}}</td>
                        <?php $cost_centre_name=DB::table('cost_centres')->where('costcentre_id',$contract->cost_centre)->value('costcentre');   ?>

                        <td style="text-align: center">{{$cost_centre_name}}</td>
						<td>{{$contract->destination}}</td>
						<td style="text-align: center">TZS</td>
						<?php
							$income=array();

							if($_GET['yr2_fil']=='true'){
								$income=DB::table('car_rental_payments')
							        			->join('car_rental_invoices','car_rental_invoices.invoice_number','=','car_rental_payments.invoice_number')
							        			->select(array(DB::raw('sum(amount_paid) as total')))
							        			->where('car_rental_invoices.contract_id',$contract->contract_id)
							        			->wherebetween('date_of_payment',[ $_GET['start2'] ,$_GET['end2']])
							        			->value('total');

										$debt=DB::table('car_rental_payments')
												->join('car_rental_invoices','car_rental_invoices.invoice_number','=','car_rental_payments.invoice_number')
												->select('amount_not_paid')
												->where('car_rental_invoices.contract_id',$contract->contract_id)
												->wherebetween('date_of_payment',[ $_GET['start2'] ,$_GET['end2']])
												->orderBy('amount_not_paid','dsc')
												->first();
							}
							else{
								$income=DB::table('car_rental_payments')
							        			->join('car_rental_invoices','car_rental_invoices.invoice_number','=','car_rental_payments.invoice_number')
							        			->select(array(DB::raw('sum(amount_paid) as total')))
							        			->where('car_rental_invoices.contract_id',$contract->contract_id)
							        			->value('total');

										$debt=DB::table('car_rental_payments')
												->join('car_rental_invoices','car_rental_invoices.invoice_number','=','car_rental_payments.invoice_number')
												->select('amount_not_paid')
												->where('car_rental_invoices.contract_id',$contract->contract_id)
												->orderBy('amount_not_paid','dsc')
												->first();
							}



						?>
						<td style="text-align: right;">{{number_format($income)}}</td>
						<?php $cptu_income= $cptu_income + $income; ?>
					 	@if(!isset($debt))
						 	<td style="text-align: right;">0</td>
						 	<?php $cptu_debt= $cptu_debt + 0; ?>
						@else
						 <td style="text-align: right;">{{number_format($debt->amount_not_paid)}}</td>
						 <?php $cptu_debt= $cptu_debt + $debt->amount_not_paid; ?>
						@endif
					</tr>
					@endforeach
					@endfor
				</tbody>
			</table>
			<table>
  				<tr style="width: 100%">
					<td><b>TOTAL</b></td>
					<td style="width: 12%; text-align: right;">{{number_format($cptu_income)}}</td>
  					<td style="width: 12%; text-align: right;">{{number_format($cptu_debt)}}</td>
				</tr>
			</table>
@elseif($_GET['b_type']=='Insurance')
<table class="hover table table-striped table-bordered">
			<thead class="thead-dark">
				<tr>
					<th scope="col" style="width: 7%;">SN</th>
					<th scope="col">Client Name</th>
					<th scope="col" style="width: 12%;">Currency</th>
					<th scope="col" style="width: 18%;">Revenue</th>
					<th scope="col" style="width: 18%;">Debt</th>
				</tr>
			</thead>
			<tbody>
				@for($z = 0; $z < count($contract_id); $z++)
					@foreach($contract_id[$z] as $contract)
						<?php $a = $a+1;?>
						<tr>
							<td style="text-align: center">{{$a}}.</td>
							<td>{{$contract->debtor_name}}</td>
							<td style="text-align: center;">{{$contract->currency_invoice}}</td>
							<?php
							$income=array();
								if($_GET['yr2_fil']=='true'){
									$income=DB::table('insurance_payments')
							        			->join('insurance_invoices','insurance_invoices.invoice_number','=','insurance_payments.invoice_number')
							        			->select(array(DB::raw('sum(amount_paid) as total')))
							        			->where('insurance_invoices.debtor_name',$contract->debtor_name)
							        			->wherebetween('date_of_payment',[ $_GET['start2'] ,$_GET['end2']])
							        			->value('total');

										$debt=DB::table('insurance_payments')
												->join('insurance_invoices','insurance_invoices.invoice_number','=','insurance_payments.invoice_number')
												->select('amount_not_paid')
												->where('insurance_invoices.debtor_name',$contract->debtor_name)
												->wherebetween('date_of_payment',[ $_GET['start2'] ,$_GET['end2']])
												->orderBy('amount_not_paid','dsc')
												->first();
								}
								else{
									$income=DB::table('insurance_payments')
							        			->join('insurance_invoices','insurance_invoices.invoice_number','=','insurance_payments.invoice_number')
							        			->select(array(DB::raw('sum(amount_paid) as total')))
							        			->where('insurance_invoices.debtor_name',$contract->debtor_name)
							        			->value('total');

										$debt=DB::table('insurance_payments')
												->join('insurance_invoices','insurance_invoices.invoice_number','=','insurance_payments.invoice_number')
												->select('amount_not_paid')
												->where('insurance_invoices.debtor_name',$contract->debtor_name)
												->orderBy('amount_not_paid','dsc')
												->first();

								}


						?>
						<td style="text-align: right;">{{number_format($income)}}</td>

						<?php
							if($contract->currency_invoice=='USD'){
								$udia_usdincome= $udia_usdincome + $income;
							}
							elseif($contract->currency_invoice=='TZS'){
								$udia_tzsincome= $udia_tzsincome + $income;
							}
					 	?>
					 	@if(!isset($debt))
						 	<td style="text-align: right;">0</td>
						 	<?php
						 	if($contract->currency_invoice=='USD'){
								$udia_usddebt= $udia_usddebt +0;
							}
							elseif($contract->currency_invoice=='TZS'){
								$udia_tzsdebt= $udia_tzsdebt +0;
							}
							?>
						@else
						 	<td style="text-align: right;">{{number_format($debt->amount_not_paid)}}</td>
						 	<?php
						 	if($contract->currency_invoice=='USD'){
								$udia_usddebt= $udia_usddebt +$debt->amount_not_paid;
							}
							elseif($contract->currency_invoice=='TZS'){
								$udia_tzsdebt= $udia_tzsdebt +$debt->amount_not_paid;
							}
							 ?>
						 @endif
						</tr>
					@endforeach
				@endfor
			</tbody>
</table>
<table>
  				<tr style="width: 100%">
					<td rowspan="2"><b>TOTAL</b></td>
					<td style="width: 12%; text-align: right;"><center>TZS</center></td>
					<td style="width: 18%; text-align: right;">{{number_format($udia_tzsincome)}}</td>
  					<td style="width: 18%; text-align: right;">{{number_format($udia_tzsdebt)}}</td>
				</tr>
				<tr style="width: 100%">
					{{-- <td><b>TOTAL</b></td> --}}
					<td style="width: 12%; text-align: right;"><center>USD</center></td>
					<td style="width: 18%; text-align: right;">{{number_format($udia_usdincome)}}</td>
  					<td style="width: 18%; text-align: right;">{{number_format($udia_usddebt)}}</td>
				</tr>
</table>
@elseif($_GET['b_type']=='All')
<h4>1. Real Estate - Rent</h4>
		<table class="hover table table-striped table-bordered">
			<thead class="thead-dark">
				<tr>
					<th scope="col" style="width: 5%;">SN</th>
					<th scope="col">Client Name</th>
					<th scope="col"style="width: 10%;">Contract Id</th>
					<th scope="col" style="width: 14%;">Major Industry</th>
					<th scope="col" style="width: 17%;">Location</th>
					<th scope="col" style="width: 8%;">Currency</th>
					<th scope="col" style="width: 12%;">Revenue</th>
					<th scope="col" style="width: 12%;">Debt</th>
				</tr>
			</thead>
			<tbody>

				@for($z = 0; $z < count($contract_id); $z++)
					@foreach($contract_id[$z] as $contract)
						<?php $a = $a+1;?>
					<tr>
						<td style="text-align: center">{{$a}}.</td>
						<td>{{$contract->debtor_name}}</td>
						<td style="text-align: center">{{$contract->contract_id}}</td>
						<td>{{$contract->major_industry}}</td>
						<td>{{$contract->sub_location}}</td>
						<td style="text-align: center">{{$contract->currency}}</td>
						<?php
							$income=array();

									if($_GET['yr2_fil']=='true'){
										$income=DB::table('space_payments')
							        			->join('invoices','invoices.invoice_number','=','space_payments.invoice_number')
							        			->select(array(DB::raw('sum(amount_paid) as total')))
							        			->where('invoices.contract_id',$contract->contract_id)
							        			->wherebetween('date_of_payment',[ $_GET['start2'] ,$_GET['end2']])
							        			->value('total');

										$debt=DB::table('space_payments')
												->join('invoices','invoices.invoice_number','=','space_payments.invoice_number')
												->select('amount_not_paid')
												->where('invoices.contract_id',$contract->contract_id)
												->wherebetween('date_of_payment',[ $_GET['start2'] ,$_GET['end2']])
												->orderBy('amount_not_paid','dsc')
												->first();
									}
									else{
										$income=DB::table('space_payments')
							        			->join('invoices','invoices.invoice_number','=','space_payments.invoice_number')
							        			->select(array(DB::raw('sum(amount_paid) as total')))
							        			->where('invoices.contract_id',$contract->contract_id)
							        			->value('total');

										$debt=DB::table('space_payments')
												->join('invoices','invoices.invoice_number','=','space_payments.invoice_number')
												->select('amount_not_paid')
												->where('invoices.contract_id',$contract->contract_id)
												->orderBy('amount_not_paid','dsc')
												->first();
									}




					 	?>
						 <td style="text-align: right;">{{number_format($income)}}</td>
						 <?php
						 	if($contract->currency=='TZS'){
						 		$space_tzsincome = $space_tzsincome +$income;
						 	}
						 	elseif($contract->currency=='USD'){
						 		$space_usdincome = $space_usdincome +$income;
						 	}
						 ?>
						 @if(!isset($debt))
						 <td style="text-align: right;">0</td>
						 <?php
						 	if($contract->currency=='TZS'){
						 		$space_tzsdebt = $space_tzsdebt +0;
						 	}
						 	elseif($contract->currency=='USD'){
						 		$space_usddebt = $space_usddebt +0;
						 	}
						 ?>
						 @else
						 <td style="text-align: right;">{{number_format($debt->amount_not_paid)}}</td>
						 <?php
						 	if($contract->currency=='TZS'){
						 		$space_tzsdebt = $space_tzsdebt +$debt->amount_not_paid;
						 	}
						 	elseif($contract->currency=='USD'){
						 		$space_usddebt = $space_usddebt +$debt->amount_not_paid;
						 	}
						 ?>
						 @endif

					</tr>
					@endforeach
				@endfor

			</tbody>
		</table>
		<table>
  				<tr style="width: 100%">
					<td rowspan="2"><b>TOTAL</b></td>
					<td style="width: 8%; text-align: right;"><center>TZS</center></td>
					<td style="width: 12%; text-align: right;">{{number_format($space_tzsincome)}}</td>
  					<td style="width: 12%; text-align: right;">{{number_format($space_tzsdebt)}}</td>
				</tr>
				<tr style="width: 100%">
					{{-- <td><b>TOTAL</b></td> --}}
					<td style="width: 8%; text-align: right;"><center>USD</center></td>
					<td style="width: 12%; text-align: right;">{{number_format($space_usdincome)}}</td>
  					<td style="width: 12%; text-align: right;">{{number_format($space_usddebt)}}</td>
				</tr>
</table>


<h4>2. Real Estate - Water Bills</h4>
<table class="hover table table-striped table-bordered">
			<thead class="thead-dark">
				<tr>
					<th scope="col" style="width: 5%;">SN</th>
					<th scope="col">Client Name</th>
					<th scope="col"style="width: 10%;">Contract Id</th>
					<th scope="col" style="width: 14%;">Major Industry</th>
					<th scope="col" style="width: 17%;">Location</th>
					<th scope="col" style="width: 8%;">Currency</th>
					<th scope="col" style="width: 12%;">Revenue</th>
					<th scope="col" style="width: 12%;">Debt</th>
				</tr>
			</thead>
			<tbody>

				@for($z = 0; $z < count($contract_id2); $z++)
					@foreach($contract_id2[$z] as $contract)
						<?php $b = $b+1;?>
					<tr>
						<td style="text-align: center">{{$b}}.</td>
						<td>{{$contract->debtor_name}}</td>
						<td style="text-align: center">{{$contract->contract_id}}</td>
						<td>{{$contract->major_industry}}</td>
						<td>{{$contract->sub_location}}</td>
						<td style="text-align: center">{{$contract->currency}}</td>
						<?php
							$income=array();
									if($_GET['yr2_fil']=='true'){
										$income=DB::table('water_bill_payments')
							        			->join('water_bill_invoices','water_bill_invoices.invoice_number','=','water_bill_payments.invoice_number')
							        			->select(array(DB::raw('sum(amount_paid) as total')))
							        			->where('water_bill_invoices.contract_id',$contract->contract_id)
							        			->wherebetween('date_of_payment',[ $_GET['start2'] ,$_GET['end2']])
							        			->value('total');

										$debt=DB::table('water_bill_payments')
												->join('water_bill_invoices','water_bill_invoices.invoice_number','=','water_bill_payments.invoice_number')
												->select('amount_not_paid')
												->where('water_bill_invoices.contract_id',$contract->contract_id)
												->wherebetween('date_of_payment',[ $_GET['start2'] ,$_GET['end2']])
												->orderBy('amount_not_paid','dsc')
												->first();
									}
									else{
										$income=DB::table('water_bill_payments')
							        			->join('water_bill_invoices','water_bill_invoices.invoice_number','=','water_bill_payments.invoice_number')
							        			->select(array(DB::raw('sum(amount_paid) as total')))
							        			->where('water_bill_invoices.contract_id',$contract->contract_id)
							        			->value('total');

										$debt=DB::table('water_bill_payments')
												->join('water_bill_invoices','water_bill_invoices.invoice_number','=','water_bill_payments.invoice_number')
												->select('amount_not_paid')
												->where('water_bill_invoices.contract_id',$contract->contract_id)
												->orderBy('amount_not_paid','dsc')
												->first();
									}

					 	?>
						 <td style="text-align: right;">{{number_format($income)}}</td>
						 <?php
						 	if($contract->currency=='TZS'){
						 		$water_tzsincome = $water_tzsincome +$income;
						 	}
						 	elseif($contract->currency=='USD'){
						 		$water_usdincome = $water_usdincome +$income;
						 	}
						 ?>
						 @if(!isset($debt))
						 <td style="text-align: right;">0</td>
						 <?php
						 	if($contract->currency=='TZS'){
						 		$water_tzsdebt = $water_tzsdebt +0;
						 	}
						 	elseif($contract->currency=='USD'){
						 		$water_usddebt = $water_usddebt +0;
						 	}
						 ?>
						 @else
						 <td style="text-align: right;">{{number_format($debt->amount_not_paid)}}</td>
						 <?php
						 	if($contract->currency=='TZS'){
						 		$water_tzsdebt = $water_tzsdebt +$debt->amount_not_paid;
						 	}
						 	elseif($contract->currency=='USD'){
						 		$water_usddebt = $water_usddebt +$debt->amount_not_paid;
						 	}
						 ?>
						 @endif

					</tr>
					@endforeach
				@endfor

			</tbody>
		</table>
		<table>
  				<tr style="width: 100%">
					<td rowspan="2"><b>TOTAL</b></td>
					<td style="width: 8%; text-align: right;"><center>TZS</center></td>
					<td style="width: 12%; text-align: right;">{{number_format($water_tzsincome)}}</td>
  					<td style="width: 12%; text-align: right;">{{number_format($water_tzsdebt)}}</td>
				</tr>
				<tr style="width: 100%">
					{{-- <td><b>TOTAL</b></td> --}}
					<td style="width: 8%; text-align: right;"><center>USD</center></td>
					<td style="width: 12%; text-align: right;">{{number_format($water_usdincome)}}</td>
  					<td style="width: 12%; text-align: right;">{{number_format($water_usddebt)}}</td>
				</tr>
</table>


<h4>3. Real Estate - Electricity Bills</h4>
<table class="hover table table-striped table-bordered">
			<thead class="thead-dark">
				<tr>
					<th scope="col" style="width: 5%;">SN</th>
					<th scope="col">Client Name</th>
					<th scope="col"style="width: 10%;">Contract Id</th>
					<th scope="col" style="width: 14%;">Major Industry</th>
					<th scope="col" style="width: 17%;">Location</th>
					<th scope="col" style="width: 8%;">Currency</th>
					<th scope="col" style="width: 12%;">Revenue</th>
					<th scope="col" style="width: 12%;">Debt</th>
				</tr>
			</thead>
			<tbody>

				@for($z = 0; $z < count($contract_id3); $z++)
					@foreach($contract_id3[$z] as $contract)
						<?php $c = $c+1;?>
					<tr>
						<td style="text-align: center">{{$c}}.</td>
						<td>{{$contract->debtor_name}}</td>
						<td style="text-align: center">{{$contract->contract_id}}</td>
						<td>{{$contract->major_industry}}</td>
						<td>{{$contract->sub_location}}</td>
						<td style="text-align: center">{{$contract->currency}}</td>
						<?php
							$income=array();
									if($_GET['yr2_fil']=='true'){
										$income=DB::table('electricity_bill_payments')
							        			->join('electricity_bill_invoices','electricity_bill_invoices.invoice_number','=','electricity_bill_payments.invoice_number')
							        			->select(array(DB::raw('sum(amount_paid) as total')))
							        			->where('electricity_bill_invoices.contract_id',$contract->contract_id)
							        			->wherebetween('date_of_payment',[ $_GET['start2'] ,$_GET['end2']])
							        			->value('total');

										$debt=DB::table('electricity_bill_payments')
												->join('electricity_bill_invoices','electricity_bill_invoices.invoice_number','=','electricity_bill_payments.invoice_number')
												->select('amount_not_paid')
												->where('electricity_bill_invoices.contract_id',$contract->contract_id)
												->wherebetween('date_of_payment',[ $_GET['start2'] ,$_GET['end2']])
												->orderBy('amount_not_paid','dsc')
												->first();
									}
									else{
										$income=DB::table('electricity_bill_payments')
							        			->join('electricity_bill_invoices','electricity_bill_invoices.invoice_number','=','electricity_bill_payments.invoice_number')
							        			->select(array(DB::raw('sum(amount_paid) as total')))
							        			->where('electricity_bill_invoices.contract_id',$contract->contract_id)
							        			->value('total');

										$debt=DB::table('electricity_bill_payments')
												->join('electricity_bill_invoices','electricity_bill_invoices.invoice_number','=','electricity_bill_payments.invoice_number')
												->select('amount_not_paid')
												->where('electricity_bill_invoices.contract_id',$contract->contract_id)
												->orderBy('amount_not_paid','dsc')
												->first();
									}


					 	?>
						 <td style="text-align: right;">{{number_format($income)}}</td>
						 <?php
						 	if($contract->currency=='TZS'){
						 		$electric_tzsincome = $electric_tzsincome +$income;
						 	}
						 	elseif($contract->currency=='USD'){
						 		$electric_usdincome = $electric_usdincome +$income;
						 	}
						 ?>
						 @if(!isset($debt))
						 <td style="text-align: right;">0</td>
						 <?php
						 	if($contract->currency=='TZS'){
						 		$electric_tzsdebt = $electric_tzsdebt +0;
						 	}
						 	elseif($contract->currency=='USD'){
						 		$electric_usddebt = $electric_usddebt +0;
						 	}
						 ?>
						 @else
						 <td style="text-align: right;">{{number_format($debt->amount_not_paid)}}</td>
						 <?php
						 	if($contract->currency=='TZS'){
						 		$electric_tzsdebt = $electric_tzsdebt +$debt->amount_not_paid;
						 	}
						 	elseif($contract->currency=='USD'){
						 		$electric_usddebt = $electric_usddebt +$debt->amount_not_paid;
						 	}
						 ?>
						 @endif

					</tr>
					@endforeach
				@endfor

			</tbody>
		</table>
		<table>
  				<tr style="width: 100%">
					<td rowspan="2"><b>TOTAL</b></td>
					<td style="width: 8%; text-align: right;"><center>TZS</center></td>
					<td style="width: 12%; text-align: right;">{{number_format($electric_tzsincome)}}</td>
  					<td style="width: 12%; text-align: right;">{{number_format($electric_tzsdebt)}}</td>
				</tr>
				<tr style="width: 100%">
					{{-- <td><b>TOTAL</b></td> --}}
					<td style="width: 8%; text-align: right;"><center>USD</center></td>
					<td style="width: 12%; text-align: right;">{{number_format($electric_usdincome)}}</td>
  					<td style="width: 12%; text-align: right;">{{number_format($electric_usddebt)}}</td>
				</tr>
</table>

<h4>4. Insurance</h4>
<table class="hover table table-striped table-bordered">
			<thead class="thead-dark">
				<tr>
					<th scope="col" style="width: 7%;">SN</th>
					<th scope="col">Client Name</th>
					<th scope="col" style="width: 12%;">Currency</th>
					<th scope="col" style="width: 18%;">Revenue</th>
					<th scope="col" style="width: 18%;">Debt</th>
				</tr>
			</thead>
			<tbody>
				@for($z = 0; $z < count($contract_id5); $z++)
					@foreach($contract_id5[$z] as $contract)
						<?php $d = $d+1;?>
						<tr>
							<td style="text-align: center">{{$d}}.</td>
							<td>{{$contract->debtor_name}}</td>
							<td style="text-align: center;">{{$contract->currency_invoice}}</td>
							<?php
							$income=array();
								if($_GET['yr2_fil']=='true'){
									$income=DB::table('insurance_payments')
							        			->join('insurance_invoices','insurance_invoices.invoice_number','=','insurance_payments.invoice_number')
							        			->select(array(DB::raw('sum(amount_paid) as total')))
							        			->where('insurance_invoices.debtor_name',$contract->debtor_name)
							        			->wherebetween('date_of_payment',[ $_GET['start2'] ,$_GET['end2']])
							        			->value('total');

										$debt=DB::table('insurance_payments')
												->join('insurance_invoices','insurance_invoices.invoice_number','=','insurance_payments.invoice_number')
												->select('amount_not_paid')
												->where('insurance_invoices.debtor_name',$contract->debtor_name)
												->wherebetween('date_of_payment',[ $_GET['start2'] ,$_GET['end2']])
												->orderBy('amount_not_paid','dsc')
												->first();
								}
								else{
									$income=DB::table('insurance_payments')
							        			->join('insurance_invoices','insurance_invoices.invoice_number','=','insurance_payments.invoice_number')
							        			->select(array(DB::raw('sum(amount_paid) as total')))
							        			->where('insurance_invoices.debtor_name',$contract->debtor_name)
							        			->value('total');

										$debt=DB::table('insurance_payments')
												->join('insurance_invoices','insurance_invoices.invoice_number','=','insurance_payments.invoice_number')
												->select('amount_not_paid')
												->where('insurance_invoices.debtor_name',$contract->debtor_name)
												->orderBy('amount_not_paid','dsc')
												->first();

								}


						?>
						<td style="text-align: right;">{{number_format($income)}}</td>

						<?php
							if($contract->currency_invoice=='USD'){
								$udia_usdincome= $udia_usdincome + $income;
							}
							elseif($contract->currency_invoice=='TZS'){
								$udia_tzsincome= $udia_tzsincome + $income;
							}
					 	?>
					 	@if(!isset($debt))
						 	<td style="text-align: right;">0</td>
						 	<?php
						 	if($contract->currency_invoice=='USD'){
								$udia_usddebt= $udia_usddebt +0;
							}
							elseif($contract->currency_invoice=='TZS'){
								$udia_tzsdebt= $udia_tzsdebt +0;
							}
							?>
						@else
						 	<td style="text-align: right;">{{number_format($debt->amount_not_paid)}}</td>
						 	<?php
						 	if($contract->currency_invoice=='USD'){
								$udia_usddebt= $udia_usddebt +$debt->amount_not_paid;
							}
							elseif($contract->currency_invoice=='TZS'){
								$udia_tzsdebt= $udia_tzsdebt +$debt->amount_not_paid;
							}
							 ?>
						 @endif
						</tr>
					@endforeach
				@endfor
			</tbody>
</table>
<table>
  				<tr style="width: 100%">
					<td rowspan="2"><b>TOTAL</b></td>
					<td style="width: 12%; text-align: right;"><center>TZS</center></td>
					<td style="width: 18%; text-align: right;">{{number_format($udia_tzsincome)}}</td>
  					<td style="width: 18%; text-align: right;">{{number_format($udia_tzsdebt)}}</td>
				</tr>
				<tr style="width: 100%">
					{{-- <td><b>TOTAL</b></td> --}}
					<td style="width: 12%; text-align: right;"><center>USD</center></td>
					<td style="width: 18%; text-align: right;">{{number_format($udia_usdincome)}}</td>
  					<td style="width: 18%; text-align: right;">{{number_format($udia_usddebt)}}</td>
				</tr>
</table>
<h4>5. Car Rental</h4>
	<table class="hover table table-striped table-bordered">
			<thead class="thead-dark">
				<tr>
					<th scope="col" style="width: 5%;">SN</th>
					<th scope="col">Client Name</th>
					<th scope="col"style="width: 10%;">Contract Id</th>
					<th scope="col" style="width: 14%;">Cost Centre ID</th>
					<th scope="col" style="width: 14%;">Cost Centre Name</th>
					<th scope="col" style="width: 17%;">Destination</th>
					<th scope="col" style="width: 8%;">Currency</th>
					<th scope="col" style="width: 12%;">Revenue</th>
					<th scope="col" style="width: 12%;">Debt</th>
				</tr>
			</thead>
			<tbody>

				@for($z = 0; $z < count($contract_id4); $z++)
					@foreach($contract_id4[$z] as $contract)
						<?php $e = $e+1;?>
					<tr>
						<td style="text-align: center">{{$e}}.</td>
						<td>{{$contract->debtor_name}}</td>
						<td style="text-align: center">{{$contract->contract_id}}</td>
						<td style="text-align: center">{{$contract->cost_centre}}</td>
                        <?php $cost_centre_name=DB::table('cost_centres')->where('costcentre_id',$contract->cost_centre)->value('costcentre');   ?>

                        <td style="text-align: center">{{$cost_centre_name}}</td>
						<td>{{$contract->destination}}</td>
						<td style="text-align: center">TZS</td>
						<?php
							$income=array();

							if($_GET['yr2_fil']=='true'){
								$income=DB::table('car_rental_payments')
							        			->join('car_rental_invoices','car_rental_invoices.invoice_number','=','car_rental_payments.invoice_number')
							        			->select(array(DB::raw('sum(amount_paid) as total')))
							        			->where('car_rental_invoices.contract_id',$contract->contract_id)
							        			->wherebetween('date_of_payment',[ $_GET['start2'] ,$_GET['end2']])
							        			->value('total');

										$debt=DB::table('car_rental_payments')
												->join('car_rental_invoices','car_rental_invoices.invoice_number','=','car_rental_payments.invoice_number')
												->select('amount_not_paid')
												->where('car_rental_invoices.contract_id',$contract->contract_id)
												->wherebetween('date_of_payment',[ $_GET['start2'] ,$_GET['end2']])
												->orderBy('amount_not_paid','dsc')
												->first();
							}
							else{
								$income=DB::table('car_rental_payments')
							        			->join('car_rental_invoices','car_rental_invoices.invoice_number','=','car_rental_payments.invoice_number')
							        			->select(array(DB::raw('sum(amount_paid) as total')))
							        			->where('car_rental_invoices.contract_id',$contract->contract_id)
							        			->value('total');

										$debt=DB::table('car_rental_payments')
												->join('car_rental_invoices','car_rental_invoices.invoice_number','=','car_rental_payments.invoice_number')
												->select('amount_not_paid')
												->where('car_rental_invoices.contract_id',$contract->contract_id)
												->orderBy('amount_not_paid','dsc')
												->first();
							}



						?>
						<td style="text-align: right;">{{number_format($income)}}</td>
						<?php $cptu_income= $cptu_income + $income; ?>
					 	@if(!isset($debt))
						 	<td style="text-align: right;">0</td>
						 	<?php $cptu_debt= $cptu_debt + 0; ?>
						@else
						 <td style="text-align: right;">{{number_format($debt->amount_not_paid)}}</td>
						 <?php $cptu_debt= $cptu_debt + $debt->amount_not_paid; ?>
						@endif
					</tr>
					@endforeach
					@endfor
				</tbody>
			</table>
			<table>
  				<tr style="width: 100%">
					<td><b>TOTAL</b></td>
					<td style="width: 12%; text-align: right;">{{number_format($cptu_income)}}</td>
  					<td style="width: 12%; text-align: right;">{{number_format($cptu_debt)}}</td>
				</tr>
			</table>

			<h4>6. Research Flats</h4>
<table class="hover table table-striped table-bordered">
			<thead class="thead-dark">
				<tr>
					<th scope="col" style="width: 7%;">SN</th>
					<th scope="col">Client Name</th>
					<th scope="col" style="width: 12%;">Currency</th>
					<th scope="col" style="width: 18%;">Revenue</th>
					<th scope="col" style="width: 18%;">Debt</th>
				</tr>
			</thead>
			<tbody>
				@for($z = 0; $z < count($contract_id6); $z++)
					@foreach($contract_id6[$z] as $contract)
						<?php $g = $g+1;?>
						<tr>
							<td style="text-align: center">{{$d}}.</td>
							<td>{{$contract->debtor_name}}</td>
							<td style="text-align: center;">{{$contract->currency_invoice}}</td>
							<?php
							$income=array();
								if($_GET['yr2_fil']=='true'){
									$income=DB::table('research_flats_payments')
							        			->join('research_flats_invoices','research_flats_invoices.invoice_number','=','research_flats_payments.invoice_number')
							        			->select(array(DB::raw('sum(amount_paid) as total')))
							        			->where('research_flats_invoices.debtor_name',$contract->debtor_name)
							        			->wherebetween('date_of_payment',[ $_GET['start2'] ,$_GET['end2']])
							        			->value('total');

										$debt=DB::table('research_flats_payments')
												->join('research_flats_invoices','research_flats_invoices.invoice_number','=','research_flats_payments.invoice_number')
												->select('amount_not_paid')
												->where('research_flats_invoices.debtor_name',$contract->debtor_name)
												->wherebetween('date_of_payment',[ $_GET['start2'] ,$_GET['end2']])
												->orderBy('amount_not_paid','dsc')
												->first();
								}
								else{
									$income=DB::table('research_flats_payments')
							        			->join('research_flats_invoices','research_flats_invoices.invoice_number','=','research_flats_payments.invoice_number')
							        			->select(array(DB::raw('sum(amount_paid) as total')))
							        			->where('research_flats_invoices.debtor_name',$contract->debtor_name)
							        			->value('total');

										$debt=DB::table('research_flats_payments')
												->join('research_flats_invoices','research_flats_invoices.invoice_number','=','research_flats_payments.invoice_number')
												->select('amount_not_paid')
												->where('research_flats_invoices.debtor_name',$contract->debtor_name)
												->orderBy('amount_not_paid','dsc')
												->first();

								}


						?>
						<td style="text-align: right;">{{number_format($income)}}</td>

						<?php
							if($contract->currency_invoice=='USD'){
								$flats_usdincome= $flats_usdincome + $income;
							}
							elseif($contract->currency_invoice=='TZS'){
								$flats_tzsincome= $flats_tzsincome + $income;
							}
					 	?>
					 	@if(!isset($debt))
						 	<td style="text-align: right;">0</td>
						 	<?php
						 	if($contract->currency_invoice=='USD'){
								$flats_usddebt= $flats_usddebt +0;
							}
							elseif($contract->currency_invoice=='TZS'){
								$flats_tzsdebt= $flats_tzsdebt +0;
							}
							?>
						@else
						 	<td style="text-align: right;">{{number_format($debt->amount_not_paid)}}</td>
						 	<?php
						 	if($contract->currency_invoice=='USD'){
								$flats_usddebt= $flats_usddebt +$debt->amount_not_paid;
							}
							elseif($contract->currency_invoice=='TZS'){
								$flats_tzsdebt= $flats_tzsdebt +$debt->amount_not_paid;
							}
							 ?>
						 @endif
						</tr>
					@endforeach
				@endfor
			</tbody>
</table>
<table>
  				<tr style="width: 100%">
					<td rowspan="2"><b>TOTAL</b></td>
					<td style="width: 12%; text-align: right;"><center>TZS</center></td>
					<td style="width: 18%; text-align: right;">{{number_format($flats_tzsincome)}}</td>
  					<td style="width: 18%; text-align: right;">{{number_format($flats_tzsdebt)}}</td>
				</tr>
				<tr style="width: 100%">
					{{-- <td><b>TOTAL</b></td> --}}
					<td style="width: 12%; text-align: right;"><center>USD</center></td>
					<td style="width: 18%; text-align: right;">{{number_format($flats_usdincome)}}</td>
  					<td style="width: 18%; text-align: right;">{{number_format($flats_usddebt)}}</td>
				</tr>
</table>

	<h4>Summary</h4>
	<table>
		<thead>
		<tr>
			<th>SN</th>
			<th>Business</th>
			<th>Revenue (TZS)</th>
			<th>Revenue (USD)</th>
			<th>Debt (TZS)</th>
			<th>Debt (USD)</th>
		</tr>
		</thead>
		<tbody>
			<tr>
				<td style="text-align: center;">{{$f + 1}}.</td>
				<td>Real Estate - Rent</td>
				<td style="text-align: right;">{{number_format($space_tzsincome)}}</td>
				<td style="text-align: right;">{{number_format($space_usdincome)}}</td>
				<td style="text-align: right;">{{number_format($space_tzsdebt)}}</td>
				<td style="text-align: right;">{{number_format($space_usddebt)}}</td>
			</tr>
			<tr>
				<td style="text-align: center;">{{$f + 2}}.</td>
				<td>Real Estate - Water</td>
				<td style="text-align: right;">{{number_format($water_tzsincome)}}</td>
				<td style="text-align: right;">{{number_format($water_usdincome)}}</td>
				<td style="text-align: right;">{{number_format($water_tzsdebt)}}</td>
				<td style="text-align: right;">{{number_format($water_usddebt)}}</td>
			</tr>
			<tr>
				<td style="text-align: center;">{{$f + 3}}.</td>
				<td>Real Estate - Electricity</td>
				<td style="text-align: right;">{{number_format($electric_tzsincome)}}</td>
				<td style="text-align: right;">{{number_format($electric_usdincome)}}</td>
				<td style="text-align: right;">{{number_format($electric_tzsdebt)}}</td>
				<td style="text-align: right;">{{number_format($electric_usddebt)}}</td>
			</tr>
			<tr>
				<td style="text-align: center;">{{$f + 4}}.</td>
				<td>Insurance</td>
				<td style="text-align: right;">{{number_format($udia_tzsincome)}}</td>
				<td style="text-align: right;">{{number_format($udia_usdincome)}}</td>
				<td style="text-align: right;">{{number_format($udia_tzsdebt)}}</td>
				<td style="text-align: right;">{{number_format($udia_usddebt)}}</td>
			</tr>
			<tr>
				<td style="text-align: center;">{{$f + 5}}.</td>
				<td>Car Rental</td>
				<td style="text-align: right;">{{number_format($cptu_income)}}</td>
				<td style="text-align: right;">0</td>
				<td style="text-align: right;">{{number_format($cptu_debt)}}</td>
				<td style="text-align: right;">0</td>
			</tr>
			<tr>
				<td style="text-align: center;">{{$f + 4}}.</td>
				<td>Research Flats</td>
				<td style="text-align: right;">{{number_format($flats_tzsincome)}}</td>
				<td style="text-align: right;">{{number_format($flats_usdincome)}}</td>
				<td style="text-align: right;">{{number_format($flats_tzsdebt)}}</td>
				<td style="text-align: right;">{{number_format($flats_usddebt)}}</td>
			</tr>
			<?php
			 $total_incometzs = $space_tzsincome +$electric_tzsincome+$water_tzsincome+$cptu_income+$udia_tzsincome+$flats_tzsincome;
			 $total_incomeusd =$space_usdincome + $electric_usdincome +$water_usdincome + $udia_usdincome+$flats_usdincome;
			 $total_debttzs = $space_tzsdebt +$electric_tzsdebt + $water_tzsdebt +$cptu_debt +$udia_tzsdebt+$flats_tzsdebt;
			 $total_debtusd = $space_usddebt + $electric_usddebt + $water_usddebt+$udia_usddebt+$flats_usddebt;
			 ?>
			<tr>
				<td colspan="2"><b>TOTAL</b></td>
				<td style="text-align: right;">{{number_format($total_incometzs)}}</td>
				<td style="text-align: right;">{{number_format($total_incomeusd)}}</td>
				<td style="text-align: right;">{{number_format($total_debttzs)}}</td>
				<td style="text-align: right;">{{number_format($total_debtusd)}}</td>
			</tr>
		</tbody>
	</table>
@endif
</body>
</html>
