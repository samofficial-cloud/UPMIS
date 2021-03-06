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
<body>
	<?php
	use App\space;
	use App\space_contract;
	$contracts = [];
	$i=1;
	$j=1;
	$totals = 0;
	$totals2 = 0;
	$totals3 = 0;
	$totals4 = 0;
	$income_tzs =0;
	$income_usd =0;
	$debt_tzs =0;
	$debt_usd =0;
	$industry=DB::table('space_classification')->select('major_industry')->distinct()->get();
	$industry2=DB::table('space_classification')->select('major_industry')->distinct()->get();
	 ?>
<div id="footer">
  		<div class="page-number"></div>
	</div>

	<center>
		<b>UNIVERSITY OF DAR ES SALAAM<br><br>
			<img src="{{public_path('/images/logo_udsm.jpg')}}" height="70px"></img>
     		<br>DIRECTORATE OF PLANNING, DEVELOPMENT AND INVESTMENT</b>
 				@if($_GET['criteria']=='space')
 					@if($_GET['yr_fil']=='true')
 						<br><br>Real Estate Revenue Collection and Debts Summary of the Duration <strong>{{date("d/m/Y",strtotime($_GET['start']))}}</strong> to <strong>{{date("d/m/Y",strtotime($_GET['end']))}}</strong>, for <strong>Rent</strong>
					@elseif($_GET['yr_fil']!='true')
						<br><br>Real Estate Revenue Collection and Debts Summary for <strong>Rent</strong>
					@endif
				@elseif($_GET['criteria']=='electricity')
					@if($_GET['yr_fil']=='true')
 						<br><br>Real Estate Revenue Collection and Debts Summary of the Duration <strong>{{date("d/m/Y",strtotime($_GET['start']))}}</strong> to <strong>{{date("d/m/Y",strtotime($_GET['end']))}}</strong>, for <strong>Electricity</strong>
					@elseif($_GET['yr_fil']!='true')
						<br><br>Real Estate Revenue Collection and Debts Summary for <strong>Electricity</strong>
					@endif
				@elseif($_GET['criteria']=='water')
					@if($_GET['yr_fil']=='true')
 						<br><br>Real Estate Revenue Collection and Debts Summary of the Duration <strong>{{date("d/m/Y",strtotime($_GET['start']))}}</strong> to <strong>{{date("d/m/Y",strtotime($_GET['end']))}}</strong>, for <strong>Water</strong>
					@elseif($_GET['yr_fil']!='true')
						<br><br>Real Estate Revenue Collection and Debts Summary for <strong>Water</strong>
					@endif
 				@endif
 	</center>
<h4>1. Payments Made in TZS</h4>
	<table class="hover table table-striped table-bordered">
			<thead class="thead-dark">
				<tr>
					<th scope="col" style="width: 8%;">SN</th>
					<th scope="col" >Major Industry</th>
					<th scope="col" style="width: 25%;">Revenue</th>
					<th scope="col" style="width: 25%;">Debt</th>
				</tr>
			</thead>
			<tbody>
				@foreach($industry as $industry)
				<tr>
					<td style="text-align: center;">{{$i}}.</td>
					<td>{{$industry->major_industry}}</td>

					<?php
						$contracts = space_contract::select('contract_id')
												->join('spaces','spaces.space_id','=','space_contracts.space_id_contract')
												->where('major_industry',$industry->major_industry)
												->where('space_contracts.currency','TZS')
												->distinct()
												->get();
						
							foreach($contracts as $contract){
								
								if($_GET['criteria']=='space'){
									if($_GET['yr_fil']=='true'){
										$income=DB::table('space_payments')
							        			->join('invoices','invoices.invoice_number','=','space_payments.invoice_number')
							        			->select(array(DB::raw('sum(amount_paid) as total')))
							        			->where('invoices.contract_id',$contract->contract_id)
							        			->whereBetween('date_of_payment',[ $_GET['start'] ,$_GET['end']])
							        			->value('total');

							        			if(!is_null($income)){
							        				$totals = $totals + $income;	
							        			}
							        			else{
							        				$totals = $totals;
							        			}
			        							
										$debt=DB::table('space_payments')
												->join('invoices','invoices.invoice_number','=','space_payments.invoice_number')
												->select('amount_not_paid')
												->where('invoices.contract_id',$contract->contract_id)
												->whereBetween('date_of_payment',[ $_GET['start'] ,$_GET['end']])
												->orderBy('amount_not_paid','dsc')
												->first();

												if(!is_null($debt)){
													$totals2 = $totals2 + $debt->amount_not_paid;
												}
												else{
													$totals2 = $totals2;
												}
									}
									else{
										$income=DB::table('space_payments')
							        			->join('invoices','invoices.invoice_number','=','space_payments.invoice_number')
							        			->select(array(DB::raw('sum(amount_paid) as total')))
							        			->where('invoices.contract_id',$contract->contract_id)
							        			->value('total');
							        			if(!is_null($income)){
							        				$totals = $totals + $income;	
							        			}
							        			else{
							        				$totals = $totals;
							        			}
			        							
										$debt=DB::table('space_payments')
												->join('invoices','invoices.invoice_number','=','space_payments.invoice_number')
												->select('amount_not_paid')
												->where('invoices.contract_id',$contract->contract_id)
												->orderBy('amount_not_paid','dsc')
												->first();

												if(!is_null($debt)){
													$totals2 = $totals2 + $debt->amount_not_paid;
												}
												else{
													$totals2 = $totals2;
												}
									}
								}
								elseif($_GET['criteria']=='electricity'){
									if($_GET['yr_fil']=='true'){
										$income=DB::table('electricity_bill_payments')
							        			->join('electricity_bill_invoices','electricity_bill_invoices.invoice_number','=','electricity_bill_payments.invoice_number')
							        			->select(array(DB::raw('sum(amount_paid) as total')))
							        			->where('electricity_bill_invoices.contract_id',$contract->contract_id)
							        			->whereBetween('date_of_payment',[ $_GET['start'] ,$_GET['end']])
							        			->value('total');

							        			if(!is_null($income)){
							        				$totals = $totals + $income;	
							        			}
							        			else{
							        				$totals = $totals;
							        			}
			        							
										$debt=DB::table('electricity_bill_payments')
												->join('electricity_bill_invoices','electricity_bill_invoices.invoice_number','=','electricity_bill_payments.invoice_number')
												->select('amount_not_paid')
												->where('electricity_bill_invoices.contract_id',$contract->contract_id)
												->whereBetween('date_of_payment',[ $_GET['start'] ,$_GET['end']])
												->orderBy('amount_not_paid','dsc')
												->first();

												if(!is_null($debt)){
													$totals2 = $totals2 + $debt->amount_not_paid;
												}
												else{
													$totals2 = $totals2;
												}
									}
									else{
										$income=DB::table('electricity_bill_payments')
							        			->join('electricity_bill_invoices','electricity_bill_invoices.invoice_number','=','electricity_bill_payments.invoice_number')
							        			->select(array(DB::raw('sum(amount_paid) as total')))
							        			->where('electricity_bill_invoices.contract_id',$contract->contract_id)
							        			->value('total');
							        			if(!is_null($income)){
							        				$totals = $totals + $income;	
							        			}
							        			else{
							        				$totals = $totals;
							        			}
			        							
										$debt=DB::table('electricity_bill_payments')
												->join('electricity_bill_invoices','electricity_bill_invoices.invoice_number','=','electricity_bill_payments.invoice_number')
												->select('amount_not_paid')
												->where('electricity_bill_invoices.contract_id',$contract->contract_id)
												->orderBy('amount_not_paid','dsc')
												->first();

												if(!is_null($debt)){
													$totals2 = $totals2 + $debt->amount_not_paid;
												}
												else{
													$totals2 = $totals2;
												}
									}									
								}

								elseif($_GET['criteria']=='water'){
									if($_GET['yr_fil']=='true'){
										$income=DB::table('water_bill_payments')
							        			->join('water_bill_invoices','water_bill_invoices.invoice_number','=','water_bill_payments.invoice_number')
							        			->select(array(DB::raw('sum(amount_paid) as total')))
							        			->where('water_bill_invoices.contract_id',$contract->contract_id)
							        			->whereBetween('date_of_payment',[ $_GET['start'] ,$_GET['end']])
							        			->value('total');

							        			if(!is_null($income)){
							        				$totals = $totals + $income;	
							        			}
							        			else{
							        				$totals = $totals;
							        			}
			        							
										$debt=DB::table('water_bill_payments')
												->join('water_bill_invoices','water_bill_invoices.invoice_number','=','water_bill_payments.invoice_number')
												->select('amount_not_paid')
												->where('water_bill_invoices.contract_id',$contract->contract_id)
												->whereBetween('date_of_payment',[ $_GET['start'] ,$_GET['end']])
												->orderBy('amount_not_paid','dsc')
												->first();

												if(!is_null($debt)){
													$totals2 = $totals2 + $debt->amount_not_paid;
												}
												else{
													$totals2 = $totals2;
												}
									}
									else{
										$income=DB::table('water_bill_payments')
							        			->join('water_bill_invoices','water_bill_invoices.invoice_number','=','water_bill_payments.invoice_number')
							        			->select(array(DB::raw('sum(amount_paid) as total')))
							        			->where('water_bill_invoices.contract_id',$contract->contract_id)
							        			->value('total');
							        			if(!is_null($income)){
							        				$totals = $totals + $income;	
							        			}
							        			else{
							        				$totals = $totals;
							        			}
			        							
										$debt=DB::table('water_bill_payments')
												->join('water_bill_invoices','water_bill_invoices.invoice_number','=','water_bill_payments.invoice_number')
												->select('amount_not_paid')
												->where('water_bill_invoices.contract_id',$contract->contract_id)
												->orderBy('amount_not_paid','dsc')
												->first();

												if(!is_null($debt)){
													$totals2 = $totals2 + $debt->amount_not_paid;
												}
												else{
													$totals2 = $totals2;
												}
									}									
								}
								
								

							}
						
						
					?>
					<td style="text-align: right;">{{number_format($totals)}}</td>
					<td style="text-align: right;">{{number_format($totals2)}}</td>
					<?php 
							$income_tzs = $income_tzs +$totals;
							$debt_tzs =$debt_tzs + $totals2;
					?>
				</tr>
				<?php $i =$i +1;
						$totals = 0;
						$totals2 = 0;
						 ?>
				@endforeach
			</tbody>
	</table>
	<table>
  				<tr style="width: 100%">
					<td><b>TOTAL</b></td>
					<td style="width: 25%; text-align: right;">{{number_format($income_tzs)}}</td>
  					<td style="width: 25%; text-align: right;">{{number_format($debt_tzs)}}</td>
				</tr>
</table>

<?php 
$totals = 0;
$totals2 = 0;
 ?>
<h4>2. Payments Made in USD</h4>
	<table class="hover table table-striped table-bordered">
			<thead class="thead-dark">
				<tr>
					<th scope="col" style="width: 8%;">SN</th>
					<th scope="col" >Major Industry</th>
					<th scope="col" style="width: 25%;">Revenue</th>
					<th scope="col" style="width: 25%;">Debt</th>
				</tr>
			</thead>
			<tbody>
				@foreach($industry2 as $industry)
				<tr>
					<td style="text-align: center;">{{$j}}.</td>
					<td>{{$industry->major_industry}}</td>

					<?php
					
						$contracts = space_contract::select('contract_id')
												->join('spaces','spaces.space_id','=','space_contracts.space_id_contract')
												->where('major_industry',$industry->major_industry)
												->where('space_contracts.currency','USD')
												->distinct()
												->get();
								

							foreach($contracts as $contract){
								
								if($_GET['criteria']=='space'){
									if($_GET['yr_fil']=='true'){
										$income=DB::table('space_payments')
							        			->join('invoices','invoices.invoice_number','=','space_payments.invoice_number')
							        			->select(array(DB::raw('sum(amount_paid) as total')))
							        			->where('invoices.contract_id',$contract->contract_id)
							        			->whereBetween('date_of_payment',[ $_GET['start'] ,$_GET['end']])
							        			->value('total');

							        			if(!is_null($income)){
							        				$totals = $totals + $income;	
							        			}
							        			else{
							        				$totals = $totals;
							        			}
			        							
										$debt=DB::table('space_payments')
												->join('invoices','invoices.invoice_number','=','space_payments.invoice_number')
												->select('amount_not_paid')
												->where('invoices.contract_id',$contract->contract_id)
												->whereBetween('date_of_payment',[ $_GET['start'] ,$_GET['end']])
												->orderBy('amount_not_paid','dsc')
												->first();

												if(!is_null($debt)){
													$totals2 = $totals2 + $debt->amount_not_paid;
												}
												else{
													$totals2 = $totals2;
												}
									}
									else{
										$income=DB::table('space_payments')
							        			->join('invoices','invoices.invoice_number','=','space_payments.invoice_number')
							        			->select(array(DB::raw('sum(amount_paid) as total')))
							        			->where('invoices.contract_id',$contract->contract_id)
							        			->value('total');
							        			if(!is_null($income)){
							        				$totals = $totals + $income;	
							        			}
							        			else{
							        				$totals = $totals;
							        			}
			        							
										$debt=DB::table('space_payments')
												->join('invoices','invoices.invoice_number','=','space_payments.invoice_number')
												->select('amount_not_paid')
												->where('invoices.contract_id',$contract->contract_id)
												->orderBy('amount_not_paid','dsc')
												->first();

												if(!is_null($debt)){
													$totals2 = $totals2 + $debt->amount_not_paid;
												}
												else{
													$totals2 = $totals2;
												}
									}
								}
								elseif($_GET['criteria']=='electricity'){
									if($_GET['yr_fil']=='true'){
										$income=DB::table('electricity_bill_payments')
							        			->join('electricity_bill_invoices','electricity_bill_invoices.invoice_number','=','electricity_bill_payments.invoice_number')
							        			->select(array(DB::raw('sum(amount_paid) as total')))
							        			->where('electricity_bill_invoices.contract_id',$contract->contract_id)
							        			->whereBetween('date_of_payment',[ $_GET['start'] ,$_GET['end']])
							        			->value('total');

							        			if(!is_null($income)){
							        				$totals = $totals + $income;	
							        			}
							        			else{
							        				$totals = $totals;
							        			}
			        							
										$debt=DB::table('electricity_bill_payments')
												->join('electricity_bill_invoices','electricity_bill_invoices.invoice_number','=','electricity_bill_payments.invoice_number')
												->select('amount_not_paid')
												->where('electricity_bill_invoices.contract_id',$contract->contract_id)
												->whereBetween('date_of_payment',[ $_GET['start'] ,$_GET['end']])
												->orderBy('amount_not_paid','dsc')
												->first();

												if(!is_null($debt)){
													$totals2 = $totals2 + $debt->amount_not_paid;
												}
												else{
													$totals2 = $totals2;
												}
									}
									else{
										$income=DB::table('electricity_bill_payments')
							        			->join('electricity_bill_invoices','electricity_bill_invoices.invoice_number','=','electricity_bill_payments.invoice_number')
							        			->select(array(DB::raw('sum(amount_paid) as total')))
							        			->where('electricity_bill_invoices.contract_id',$contract->contract_id)
							        			->value('total');
							        			if(!is_null($income)){
							        				$totals = $totals + $income;	
							        			}
							        			else{
							        				$totals = $totals;
							        			}
			        							
										$debt=DB::table('electricity_bill_payments')
												->join('electricity_bill_invoices','electricity_bill_invoices.invoice_number','=','electricity_bill_payments.invoice_number')
												->select('amount_not_paid')
												->where('electricity_bill_invoices.contract_id',$contract->contract_id)
												->orderBy('amount_not_paid','dsc')
												->first();

												if(!is_null($debt)){
													$totals2 = $totals2 + $debt->amount_not_paid;
												}
												else{
													$totals2 = $totals2;
												}
									}									
								}

								elseif($_GET['criteria']=='water'){
									if($_GET['yr_fil']=='true'){
										$income=DB::table('water_bill_payments')
							        			->join('water_bill_invoices','water_bill_invoices.invoice_number','=','water_bill_payments.invoice_number')
							        			->select(array(DB::raw('sum(amount_paid) as total')))
							        			->where('water_bill_invoices.contract_id',$contract->contract_id)
							        			->whereBetween('date_of_payment',[ $_GET['start'] ,$_GET['end']])
							        			->value('total');

							        			if(!is_null($income)){
							        				$totals = $totals + $income;	
							        			}
							        			else{
							        				$totals = $totals;
							        			}
			        							
										$debt=DB::table('water_bill_payments')
												->join('water_bill_invoices','water_bill_invoices.invoice_number','=','water_bill_payments.invoice_number')
												->select('amount_not_paid')
												->where('water_bill_invoices.contract_id',$contract->contract_id)
												->whereBetween('date_of_payment',[ $_GET['start'] ,$_GET['end']])
												->orderBy('amount_not_paid','dsc')
												->first();

												if(!is_null($debt)){
													$totals2 = $totals2 + $debt->amount_not_paid;
												}
												else{
													$totals2 = $totals2;
												}
									}
									else{
										$income=DB::table('water_bill_payments')
							        			->join('water_bill_invoices','water_bill_invoices.invoice_number','=','water_bill_payments.invoice_number')
							        			->select(array(DB::raw('sum(amount_paid) as total')))
							        			->where('water_bill_invoices.contract_id',$contract->contract_id)
							        			->value('total');
							        			if(!is_null($income)){
							        				$totals = $totals + $income;	
							        			}
							        			else{
							        				$totals = $totals;
							        			}
			        							
										$debt=DB::table('water_bill_payments')
												->join('water_bill_invoices','water_bill_invoices.invoice_number','=','water_bill_payments.invoice_number')
												->select('amount_not_paid')
												->where('water_bill_invoices.contract_id',$contract->contract_id)
												->orderBy('amount_not_paid','dsc')
												->first();

												if(!is_null($debt)){
													$totals2 = $totals2 + $debt->amount_not_paid;
												}
												else{
													$totals2 = $totals2;
												}
									}									
								}
	
					}
	
					?>
					<td style="text-align: right;">{{number_format($totals)}}</td>
					<td style="text-align: right;">{{number_format($totals2)}}</td>
					<?php 
							$income_usd = $income_usd +$totals;
							$debt_usd =$debt_usd + $totals2;
					?>
				</tr>
				<?php 
					$j =$j +1;
					$totals = 0;
					$totals2 = 0;
				 ?>
				@endforeach
			</tbody>
	</table>
	<table>
  				<tr style="width: 100%">
					<td><b>TOTAL</b></td>
					<td style="width: 25%; text-align: right;">{{number_format($income_usd)}}</td>
  					<td style="width: 25%; text-align: right;">{{number_format($debt_usd)}}</td>
				</tr>
</table>
</body>
</html>