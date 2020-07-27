<!DOCTYPE html>
<html>
<head>
	<title>Insurance Report</title>
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
    use App\insurance_contract;
    use App\insurance;
    if($_GET['report_type']=='sales'){
    	if(($_GET['principal_filter']=='true') && ($_GET['insurance_typefilter']=='true')){
    		$insurance=insurance_contract::where('principal',$_GET['principaltype'])->where('insurance_type',$_GET['insurance_type'])->get();
    	}
    	if(($_GET['principal_filter']=='true') && ($_GET['insurance_typefilter']!='true')){
    		$insurance=insurance_contract::where('principal',$_GET['principaltype'])->get();
    	}
    	if(($_GET['insurance_typefilter']=='true') && ($_GET['principal_filter']!='true')){
    		$insurance=insurance_contract::where('insurance_type',$_GET['insurance_type'])->get();
    	}

    	if(($_GET['insurance_typefilter']!='true') && ($_GET['principal_filter']!='true')){
    		$insurance=insurance_contract::get();
    	}
    }
    else if($_GET['report_type']=='principals'){
    	$principal=insurance::where('status','1')->get();
    }
     else if($_GET['report_type']=='clients'){
      $clients=insurance_contract::get();
    }

	?>

	<center>
	<b>UNIVERSITY OF DAR ES SALAAM<br><br>
	<img src="{{public_path('/images/logo_udsm.jpg')}}" height="70px"></img>
     <br>DIRECTORATE OF PLANNING, DEVELOPMENT AND INVESTIMENT  
    </b>
    @if($_GET['report_type']=='sales')
    @if(($_GET['principal_filter']=='true') && ($_GET['insurance_typefilter']=='true'))
    <br><br><strong>Sales Report Whose Principal is {{$_GET['principaltype']}} and Insurance Type is {{$_GET['insurance_type']}} </strong>
    @endif
    @if(($_GET['principal_filter']=='true') && ($_GET['insurance_typefilter']!='true'))
     <br><br><strong>Sales Report Whose Principal is {{$_GET['principaltype']}}</strong>
     @endif
     @if(($_GET['insurance_typefilter']=='true') && ($_GET['principal_filter']!='true'))
     <br><br><strong>Sales Report Whose Insurance Type is {{$_GET['insurance_type']}} </strong>
     @endif
     @if(($_GET['insurance_typefilter']!='true') && ($_GET['principal_filter']!='true'))
     <br><br><strong>Sales Report</strong>
     @endif
     @elseif($_GET['report_type']=='principals')
     <br><br><strong>List of Insurance Principals</strong>
     @elseif($_GET['report_type']=='clients')
      <br><br><strong>List of Insurance Clients</strong>
    @endif
</center>

<br>
 @if($_GET['report_type']=='sales')
<table class="hover table table-striped table-bordered" id="myTable">
        <thead class="thead-dark">
        <tr>
          <th scope="col"><center>S/N</center></th>
          <th scope="col"><center>Vehicle Reg No</center></th>
          <th scope="col" ><center>Commission Date</center></th>
          <th scope="col" ><center>End Date</center></th>
           <th scope="col" ><center>Receipt No </center></th>
            <th scope="col" ><center>Currency </center></th>
          <th scope="col" ><center>Sum Insured</center></th>
          <th scope="col" ><center>Premium</center></th>
            <th scope="col" ><center>Actual(Excluding VAT) </center></th>
           
           
        </tr>
        </thead>
        <tbody>

        @foreach($insurance as $var)
          <tr>

            <td class="counterCell">.</td>
            <td><center>{{$var->vehicle_registration_no}}</center></td>
            <td><center>{{$var->commission_date}}</center></td>
            <td><center>{{$var->end_date}}</center></td>
            <td><center>{{$var->receipt_no}}</center></td>
             <td><center>{{$var->currency}}</center></td>
              <td><center>{{$var->sum_insured}}</center></td>
              <td><center>{{$var->premium}}</center></td>
            <td><center>{{$var->actual_ex_vat}}</center></td>   
          </tr>
          @endforeach
      </tbody>
  </table>
  @elseif($_GET['report_type']=='principals')
<table style="width: 90%">
	<thead>
		<tr>
	<th scope="col"><center>S/N</center></th>
          <th scope="col"><center>Principal</center></th>
          <th scope="col" ><center>Insurance Type</center></th>
          <th scope="col" ><center>Commision</center></th>
      </tr>
      </thead>
      <tbody>
      	 @foreach($principal as $var)
          <tr>
          	<td class="counterCell">.</td>
          	<td>{{$var->insurance_company}}</td>
          	<td>{{$var->insurance_type}}</td>
          	<td><center>{{$var->commission}}</center></td>

          </tr>
          @endforeach
      	
      </tbody>
</table>
 @elseif($_GET['report_type']=='clients')
 <table>
    <thead class="thead-dark">
        <tr>
          <th scope="col" style="width: 5%;"><center>S/N</center></th>
           <th scope="col"><center>Client Name</center></th>
          <th scope="col"><center>Vehicle Reg No</center></th>
          <th scope="col" style="width: 18%;" ><center>Commission Date</center></th>
          <th scope="col" ><center>End Date</center></th>
           <th scope="col" ><center>Receipt No </center></th>
          <th scope="col" ><center>Sum Insured</center></th>    
        </tr>
        </thead>
        <tbody>

        @foreach($clients as $var)
          <tr>

            <td class="counterCell">.</td>
            <td>{{$var->full_name}}</td>
            <td><center>{{$var->vehicle_registration_no}}</center></td>
            <td><center>{{$var->commission_date}}</center></td>
            <td><center>{{$var->end_date}}</center></td>
            <td><center>{{$var->receipt_no}}</center></td>
            <td><center>{{$var->currency}} {{$var->sum_insured}}</center></td>   
          </tr>
          @endforeach
      </tbody>
 </table>
@endif
</body>
</html>