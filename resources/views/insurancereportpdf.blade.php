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

	?>

	<center>
	<b>UNIVERSITY OF DAR ES SALAAM<br><br>
	<img src="{{public_path('/images/logo_udsm.jpg')}}" height="70px"></img>
     <br>DIRECTORATE OF PLANNING, DEVELOPMENT AND INVESTMENT  
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
          <th scope="col" style="width: 4%;"><center>S/N</center></th>
          <th scope="col" style="width: 14%;"><center>Vehicle Reg No</center></th>
          <th scope="col" style="width: 12%;"><center>Commission Date</center></th>
          <th scope="col" style="width: 12%;"><center>End Date</center></th>
           <th scope="col" style="width: 12%;"><center>Receipt No </center></th>
            <th scope="col" style="width: 9%;"><center>Currency </center></th>
          <th scope="col" style="width: 12%;"><center>Sum Insured</center></th>
          <th scope="col" style="width: 12%;"><center>Premium</center></th>
            <th scope="col" style="width: 14%;"><center>Actual(Excluding VAT) </center></th>
           
           
        </tr>
        </thead>
        <tbody>

        @foreach($insurance as $var)
          <tr>

            <th scope="row" class="counterCell text-center">.</th>
            <td>{{$var->vehicle_registration_no}}</td>
            <td><center>{{date("d/m/Y",strtotime($var->commission_date))}}</center></td>
            <td><center>{{date("d/m/Y",strtotime($var->end_date))}}</center></td>
            <td><center>{{$var->receipt_no}}</center></td>
             <td><center>{{$var->currency}}</center></td>
              <td><center>{{number_format($var->sum_insured)}}</center></td>
              <td><center>{{number_format($var->premium)}}</center></td>
            <td><center>{{number_format($var->actual_ex_vat)}}</center></td>   
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
          	<th scope="row" class="counterCell">.</th>
          	<td>{{$var->insurance_company}}</td>
          	<td>{{$var->insurance_type}}</td>
          	<td>{{number_format($var->commission)}}</td>

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

            <th scope="row" class="counterCell">.</th>
            <td>{{$var->full_name}}</td>
            <td>{{$var->vehicle_registration_no}}</td>
            <td><center>{{date("d/m/Y",strtotime($var->commission_date))}}</center></td>
            <td><center>{{date("d/m/Y",strtotime($var->end_date))}}</center></td>
            <td>{{$var->receipt_no}}</td>
            <td>{{$var->currency}} {{number_format($var->sum_insured)}}</td>   
          </tr>
          @endforeach
      </tbody>
 </table>
@endif
</body>
</html>