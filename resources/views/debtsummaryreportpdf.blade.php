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
 						<br><br>Real Estate Revenue Collection and Debts Summary for <strong>Rent</strong>, whose business is <strong>{{$_GET['biz']}}</strong>, Location is <strong>{{$_GET['loc']}}</strong> and year is <strong>{{$_GET['yr']}}</strong>
 					@elseif(($_GET['bus_fil']=='true') && ($_GET['loc_fil']=='true') && ($_GET['yr_fil']!='true'))
 						<br><br>Real Estate Revenue Collection and Debts Summary for <strong>Rent</strong>, whose business is <strong>{{$_GET['biz']}}</strong> and Location is <strong>{{$_GET['loc']}}</strong>
 					@elseif(($_GET['bus_fil']=='true') && ($_GET['loc_fil']!='true') && ($_GET['yr_fil']=='true'))
 						<br><br>Real Estate Revenue Collection and Debts Summary for <strong>Rent</strong>, whose business is <strong>{{$_GET['biz']}}</strong> and year is <strong>{{$_GET['yr']}}</strong>
 					@elseif(($_GET['bus_fil']=='true') && ($_GET['loc_fil']!='true') && ($_GET['yr_fil']!='true'))
 						<br><br>Real Estate Revenue Collection and Debts Summary for <strong>Rent</strong>, whose business is <strong>{{$_GET['biz']}}</strong>
 					@elseif(($_GET['bus_fil']!='true') && ($_GET['loc_fil']=='true') && ($_GET['yr_fil']=='true'))
 						<br><br>Real Estate Revenue Collection and Debts Summary for <strong>Rent</strong>, Location is <strong>{{$_GET['loc']}}</strong> and year is <strong>{{$_GET['yr']}}</strong>
 					@elseif(($_GET['bus_fil']!='true') && ($_GET['loc_fil']=='true') && ($_GET['yr_fil']!='true'))
 						<br><br>Real Estate Revenue Collection and Debts Summary for <strong>Rent</strong> and Location is <strong>{{$_GET['loc']}}</strong>
 					@elseif(($_GET['bus_fil']!='true') && ($_GET['loc_fil']!='true') && ($_GET['yr_fil']=='true'))
 						<br><br>Real Estate Revenue Collection and Debts Summary for <strong>Rent</strong> and year is <strong>{{$_GET['yr']}}</strong>
 					@elseif(($_GET['bus_fil']!='true') && ($_GET['loc_fil']!='true') && ($_GET['yr_fil']!='true'))
 						<br><br>Real Estate Revenue Collection and Debts Summary for <strong>Rent</strong>
					@endif

				@elseif($_GET['criteria']=='electricity')
 					@if(($_GET['bus_fil']=='true') && ($_GET['loc_fil']=='true') && ($_GET['yr_fil']=='true'))
 						<br><br>Real Estate Revenue Collection and Debts Summary for <strong>Electricity</strong>, whose business is <strong>{{$_GET['biz']}}</strong>, Location is <strong>{{$_GET['loc']}}</strong> and year is <strong>{{$_GET['yr']}}</strong>
 					@elseif(($_GET['bus_fil']=='true') && ($_GET['loc_fil']=='true') && ($_GET['yr_fil']!='true'))
 						<br><br>Real Estate Revenue Collection and Debts Summary for <strong>Electricity</strong>, whose business is <strong>{{$_GET['biz']}}</strong> and Location is <strong>{{$_GET['loc']}}</strong>
 					@elseif(($_GET['bus_fil']=='true') && ($_GET['loc_fil']!='true') && ($_GET['yr_fil']=='true'))
 						<br><br>Real Estate Revenue Collection and Debts Summary for <strong>Electricity</strong>, whose business is <strong>{{$_GET['biz']}}</strong> and year is <strong>{{$_GET['yr']}}</strong>
 					@elseif(($_GET['bus_fil']=='true') && ($_GET['loc_fil']!='true') && ($_GET['yr_fil']!='true'))
 						<br><br>Real Estate Revenue Collection and Debts Summary for <strong>Electricity</strong>, whose business is <strong>{{$_GET['biz']}}</strong>
 					@elseif(($_GET['bus_fil']!='true') && ($_GET['loc_fil']=='true') && ($_GET['yr_fil']=='true'))
 						<br><br>Real Estate Revenue Collection and Debts Summary for <strong>Electricity</strong>, Location is <strong>{{$_GET['loc']}}</strong> and year is <strong>{{$_GET['yr']}}</strong>
 					@elseif(($_GET['bus_fil']!='true') && ($_GET['loc_fil']=='true') && ($_GET['yr_fil']!='true'))
 						<br><br>Real Estate Revenue Collection and Debts Summary for <strong>Electricity</strong> and Location is <strong>{{$_GET['loc']}}</strong>
 					@elseif(($_GET['bus_fil']!='true') && ($_GET['loc_fil']!='true') && ($_GET['yr_fil']=='true'))
 						<br><br>Real Estate Revenue Collection and Debts Summary for <strong>Electricity</strong> and year is <strong>{{$_GET['yr']}}</strong>
 					@elseif(($_GET['bus_fil']!='true') && ($_GET['loc_fil']!='true') && ($_GET['yr_fil']!='true'))
 						<br><br>Real Estate Revenue Collection and Debts Summary for <strong>Electricity</strong>
					@endif

				@elseif($_GET['criteria']=='water')
 					@if(($_GET['bus_fil']=='true') && ($_GET['loc_fil']=='true') && ($_GET['yr_fil']=='true'))
 						<br><br>Real Estate Revenue Collection and Debts Summary for <strong>Water</strong>, whose business is <strong>{{$_GET['biz']}}</strong>, Location is <strong>{{$_GET['loc']}}</strong> and year is <strong>{{$_GET['yr']}}</strong>
 					@elseif(($_GET['bus_fil']=='true') && ($_GET['loc_fil']=='true') && ($_GET['yr_fil']!='true'))
 						<br><br>Real Estate Revenue Collection and Debts Summary for <strong>Water</strong>, whose business is <strong>{{$_GET['biz']}}</strong> and Location is <strong>{{$_GET['loc']}}</strong>
 					@elseif(($_GET['bus_fil']=='true') && ($_GET['loc_fil']!='true') && ($_GET['yr_fil']=='true'))
 						<br><br>Real Estate Revenue Collection and Debts Summary for <strong>Water</strong>, whose business is <strong>{{$_GET['biz']}}</strong> and year is <strong>{{$_GET['yr']}}</strong>
 					@elseif(($_GET['bus_fil']=='true') && ($_GET['loc_fil']!='true') && ($_GET['yr_fil']!='true'))
 						<br><br>Real Estate Revenue Collection and Debts Summary for <strong>Water</strong>, whose business is <strong>{{$_GET['biz']}}</strong>
 					@elseif(($_GET['bus_fil']!='true') && ($_GET['loc_fil']=='true') && ($_GET['yr_fil']=='true'))
 						<br><br>Real Estate Revenue Collection and Debts Summary for <strong>Water</strong>, Location is <strong>{{$_GET['loc']}}</strong> and year is <strong>{{$_GET['yr']}}</strong>
 					@elseif(($_GET['bus_fil']!='true') && ($_GET['loc_fil']=='true') && ($_GET['yr_fil']!='true'))
 						<br><br>Real Estate Revenue Collection and Debts Summary for <strong>Water</strong> and Location is <strong>{{$_GET['loc']}}</strong>
 					@elseif(($_GET['bus_fil']!='true') && ($_GET['loc_fil']!='true') && ($_GET['yr_fil']=='true'))
 						<br><br>Real Estate Revenue Collection and Debts Summary for <strong>Water</strong> and year is <strong>{{$_GET['yr']}}</strong>
 					@elseif(($_GET['bus_fil']!='true') && ($_GET['loc_fil']!='true') && ($_GET['yr_fil']!='true'))
 						<br><br>Real Estate Revenue Collection and Debts Summary for <strong>Water</strong>
 					@endif
				@endif
     			
 			@elseif($_GET['b_type']=='Car Rental')
 				@if($_GET['yr2_fil']=='true')
 					<br><br>CPTU Revenue Collection and Debts Summary for year <strong>{{$_GET['yr2']}}</strong>
 				@else
 					<br><br>CPTU Revenue Collection and Debts Summary
 				@endif
 			@elseif($_GET['b_type']=='Insurance')
 				@if($_GET['yr2_fil']=='true')
 					<br><br>UDIA Revenue Collection and Debts Summary for year <strong>{{$_GET['yr2']}}</strong>
				@else
					<br><br>UDIA Revenue Collection and Debts Summary for year
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
							        			->whereYear('invoicing_period_start_date',$_GET['yr'])
							        			->value('total'); 

										$debt=DB::table('space_payments')
												->join('invoices','invoices.invoice_number','=','space_payments.invoice_number')
												->select('amount_not_paid')
												->where('invoices.contract_id',$contract->contract_id)
												->whereYear('invoicing_period_start_date',$_GET['yr'])
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
							        			->whereYear('invoicing_period_start_date',$_GET['yr'])
							        			->value('total'); 

										$debt=DB::table('electricity_bill_payments')
												->join('electricity_bill_invoices','electricity_bill_invoices.invoice_number','=','electricity_bill_payments.invoice_number')
												->select('amount_not_paid')
												->where('electricity_bill_invoices.contract_id',$contract->contract_id)
												->whereYear('invoicing_period_start_date',$_GET['yr'])
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
							        			->whereYear('invoicing_period_start_date',$_GET['yr'])
							        			->value('total'); 

										$debt=DB::table('water_bill_payments')
												->join('water_bill_invoices','water_bill_invoices.invoice_number','=','water_bill_payments.invoice_number')
												->select('amount_not_paid')
												->where('water_bill_invoices.contract_id',$contract->contract_id)
												->whereYear('invoicing_period_start_date',$_GET['yr'])
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
						 <td style="text-align: right;">{{number_format($debt->amount_not_paid)}}</td>
						
					</tr>
					@endforeach
				@endfor
				
			</tbody>
		</table>
	@endif
	@elseif($_GET['b_type']=='Car Rental')
	<table class="hover table table-striped table-bordered">
			<thead class="thead-dark">
				<tr>
					<th scope="col" style="width: 5%;">SN</th>
					<th scope="col">Client Name</th>
					<th scope="col"style="width: 10%;">Contract Id</th>
					<th scope="col" style="width: 14%;">Cost Center</th>
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
						<td>{{$contract->destination}}</td>
						<td style="text-align: center">TZS</td>
						<?php
							$income=array();

							if($_GET['yr2_fil']=='true'){
								$income=DB::table('car_rental_payments')
							        			->join('car_rental_invoices','car_rental_invoices.invoice_number','=','car_rental_payments.invoice_number')
							        			->select(array(DB::raw('sum(amount_paid) as total')))
							        			->where('car_rental_invoices.contract_id',$contract->contract_id)
							        			->whereYear('invoicing_period_start_date',$_GET['yr2'])
							        			->value('total'); 

										$debt=DB::table('car_rental_payments')
												->join('car_rental_invoices','car_rental_invoices.invoice_number','=','car_rental_payments.invoice_number')
												->select('amount_not_paid')
												->where('car_rental_invoices.contract_id',$contract->contract_id)
												->whereYear('invoicing_period_start_date',$_GET['yr2'])
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
					 	<td style="text-align: right;">{{number_format($debt->amount_not_paid)}}</td>
					</tr>
					@endforeach
					@endfor
				</tbody>
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
							        			->whereYear('invoicing_period_start_date',$_GET['yr2'])
							        			->value('total'); 

										$debt=DB::table('insurance_payments')
												->join('insurance_invoices','insurance_invoices.invoice_number','=','insurance_payments.invoice_number')
												->select('amount_not_paid')
												->where('insurance_invoices.debtor_name',$contract->debtor_name)
												->whereYear('invoicing_period_start_date',$_GET['yr2'])
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
					 	<td style="text-align: right;">{{number_format($debt->amount_not_paid)}}</td>
						</tr>
					@endforeach
				@endfor
			</tbody>
</table>
@endif
</body>
</html>