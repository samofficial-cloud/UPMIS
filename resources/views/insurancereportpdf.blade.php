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

	?>

	<center>
	<b>UNIVERSITY OF DAR ES SALAAM<br><br>
	<img src="{{public_path('/images/logo_udsm.jpg')}}" height="70px"></img>
     <br>DIRECTORATE OF PLANNING, DEVELOPMENT AND INVESTMENT  
    </b>
  @if($_GET['report_type']=='sales')
    @if(($_GET['principal_filter']=='true') && ($_GET['package_filter']=='true')&&($_GET['yr_fil']=='true'))
      @if($_GET['insurance_typefilter']=='true')
          @if($_GET['yr_cat']=='start')
         <br><br>Sales Report Whose Principal is <strong>{{$_GET['principaltype']}}</strong>, Insurance Package is <strong>{{$_GET['package']}}</strong>, Insurance Type is <strong>{{$_GET['insurance_type']}}</strong> and Commission Year is <strong>{{$_GET['yr']}}</strong>
         @elseif($_GET['yr_cat']=='end')
         <br><br>Sales Report Whose Principal is <strong>{{$_GET['principaltype']}}</strong>, Insurance Package is <strong>{{$_GET['package']}}</strong>, Insurance Type is <strong>{{$_GET['insurance_type']}}</strong> and Expiry Year is <strong>{{$_GET['yr']}}</strong>
         @endif
       @else
         @if($_GET['yr_cat']=='start')
         <br><br>Sales Report Whose Principal is <strong>{{$_GET['principaltype']}}</strong>, Insurance Package is <strong>{{$_GET['package']}}</strong> and Commission Year is <strong>{{$_GET['yr']}}</strong>
         @elseif($_GET['yr_cat']=='end')
         <br><br>Sales Report Whose Principal is <strong>{{$_GET['principaltype']}}</strong>, Insurance Package is <strong>{{$_GET['package']}}</strong> and Expiry Year is <strong>{{$_GET['yr']}}</strong>
         @endif
       @endif

    @elseif(($_GET['principal_filter']=='true') && ($_GET['package_filter']=='true')&&($_GET['yr_fil']!='true'))
      @if($_GET['insurance_typefilter']=='true')
         <br><br>Sales Report Whose Principal is <strong>{{$_GET['principaltype']}}</strong>, Insurance Package is <strong>{{$_GET['package']}}</strong> and Insurance Type is <strong>{{$_GET['insurance_type']}}</strong>
       @else
       <br><br>Sales Report Whose Principal is <strong>{{$_GET['principaltype']}}</strong> and Insurance Package is <strong>{{$_GET['package']}}</strong>
      @endif

    @elseif(($_GET['principal_filter']=='true') && ($_GET['package_filter']!='true')&&($_GET['yr_fil']=='true'))
      @if($_GET['yr_cat']=='start')
         <br><br>Sales Report Whose Principal is <strong>{{$_GET['principaltype']}}</strong> and Commission Year is <strong>{{$_GET['yr']}}</strong>
      @elseif($_GET['yr_cat']=='end')
         <br><br>Sales Report Whose Principal is <strong>{{$_GET['principaltype']}}</strong> and Expiry Year is <strong>{{$_GET['yr']}}</strong>
      @endif

    @elseif(($_GET['principal_filter']=='true') && ($_GET['package_filter']!='true')&&($_GET['yr_fil']!='true'))
     <br><br>Sales Report Whose Principal is <strong>{{$_GET['principaltype']}}</strong>

    @elseif(($_GET['principal_filter']!='true') && ($_GET['package_filter']=='true')&&($_GET['yr_fil']=='true'))
      @if($_GET['insurance_typefilter']=='true')
          @if($_GET['yr_cat']=='start')
         <br><br>Sales Report Whose Insurance Package is <strong>{{$_GET['package']}}</strong>, Insurance Type is <strong>{{$_GET['insurance_type']}}</strong> and Commission Year is <strong>{{$_GET['yr']}}</strong>
         @elseif($_GET['yr_cat']=='end')
         <br><br>Sales Report Whose Insurance Package is <strong>{{$_GET['package']}}</strong>, Insurance Type is <strong>{{$_GET['insurance_type']}}</strong> and Expiry Year is <strong>{{$_GET['yr']}}</strong>
         @endif
      @else
         @if($_GET['yr_cat']=='start')
         <br><br>Sales Report Whose Insurance Package is <strong>{{$_GET['package']}}</strong> and Commission Year is <strong>{{$_GET['yr']}}</strong>
         @elseif($_GET['yr_cat']=='end')
         <br><br>Sales Report Whose Insurance Package is <strong>{{$_GET['package']}}</strong> and Expiry Year is <strong>{{$_GET['yr']}}</strong>
         @endif
      @endif

   @elseif(($_GET['principal_filter']!='true') && ($_GET['package_filter']=='true')&&($_GET['yr_fil']!='true'))
      @if($_GET['insurance_typefilter']=='true')
         <br><br>Sales Report Whose Insurance Package is <strong>{{$_GET['package']}}</strong> and Insurance Type is <strong>{{$_GET['insurance_type']}}</strong>
      @else
       <br><br>Sales Report Whose Insurance Package is <strong>{{$_GET['package']}}</strong>
      @endif

  @elseif(($_GET['principal_filter']!='true') && ($_GET['package_filter']!='true')&&($_GET['yr_fil']=='true'))
    @if($_GET['yr_cat']=='start')
     <br><br>Sales Report Whose Commission Year is <strong>{{$_GET['yr']}}</strong>
    @elseif($_GET['yr_cat']=='end')
     <br><br>Sales Report Whose Expiry Year is <strong>{{$_GET['yr']}}</strong>
    @endif

  @elseif(($_GET['principal_filter']!='true') && ($_GET['package_filter']!='true')&&($_GET['yr_fil']!='true'))
    <br><br>Insurance Sales Report
  @endif

@elseif($_GET['report_type']=='principals')
     <br><br><strong>List of Insurance Principals</strong>


@elseif($_GET['report_type']=='clients')

  @if(($_GET['principal_filter']=='true') && ($_GET['package_filter']=='true')&&($_GET['yr_fil']=='true'))
      @if($_GET['insurance_typefilter']=='true')
        @if($_GET['yr_cat']=='start')
         <br><br>List of Insurance Clients Whose Principal is <strong>{{$_GET['principaltype']}}</strong>, Insurance Package is <strong>{{$_GET['package']}}</strong>, Insurance Type is <strong>{{$_GET['insurance_type']}}</strong> and Commission Year is <strong>{{$_GET['yr']}}</strong>
         @elseif($_GET['yr_cat']=='end')
         <br><br>List of Insurance Clients Whose Principal is <strong>{{$_GET['principaltype']}}</strong>, Insurance Package is <strong>{{$_GET['package']}}</strong>, Insurance Type is <strong>{{$_GET['insurance_type']}}</strong> and Expiry Year is <strong>{{$_GET['yr']}}</strong>
         @endif
       @else
         @if($_GET['yr_cat']=='start')
         <br><br>List of Insurance Clients Whose Principal is <strong>{{$_GET['principaltype']}}</strong>, Insurance Package is <strong>{{$_GET['package']}}</strong> and Commission Year is <strong>{{$_GET['yr']}}</strong>
         @elseif($_GET['yr_cat']=='end')
         <br><br>List of Insurance Clients Whose Principal is <strong>{{$_GET['principaltype']}}</strong>, Insurance Package is <strong>{{$_GET['package']}}</strong> and Expiry Year is <strong>{{$_GET['yr']}}</strong>
         @endif
       @endif

  @elseif(($_GET['principal_filter']=='true') && ($_GET['package_filter']=='true')&&($_GET['yr_fil']!='true'))
      @if($_GET['insurance_typefilter']=='true')
         <br><br>List of Insurance Clients Whose Principal is <strong>{{$_GET['principaltype']}}</strong>, Insurance Package is <strong>{{$_GET['package']}}</strong> and Insurance Type is <strong>{{$_GET['insurance_type']}}</strong>
      @else
       <br><br>List of Insurance Clients Whose Principal is <strong>{{$_GET['principaltype']}}</strong> and Insurance Package is <strong>{{$_GET['package']}}</strong>
      @endif

  @elseif(($_GET['principal_filter']=='true') && ($_GET['package_filter']!='true')&&($_GET['yr_fil']=='true'))
      @if($_GET['yr_cat']=='start')
         <br><br>List of Insurance Clients Whose Principal is <strong>{{$_GET['principaltype']}}</strong> and Commission Year is <strong>{{$_GET['yr']}}</strong>
      @elseif($_GET['yr_cat']=='end')
         <br><br>List of Insurance Clients Whose Principal is <strong>{{$_GET['principaltype']}}</strong> and Expiry Year is <strong>{{$_GET['yr']}}</strong>
      @endif

  @elseif(($_GET['principal_filter']=='true') && ($_GET['package_filter']!='true')&&($_GET['yr_fil']!='true'))
     <br><br>List of Insurance Clients Whose Principal is <strong>{{$_GET['principaltype']}}</strong>

  @elseif(($_GET['principal_filter']!='true') && ($_GET['package_filter']=='true')&&($_GET['yr_fil']=='true'))
      @if($_GET['insurance_typefilter']=='true')
          @if($_GET['yr_cat']=='start')
         <br><br>List of Insurance Clients Whose Insurance Package is <strong>{{$_GET['package']}}</strong>, Insurance Type is <strong>{{$_GET['insurance_type']}}</strong> and Commission Year is <strong>{{$_GET['yr']}}</strong>
         @elseif($_GET['yr_cat']=='end')
         <br><br>List of Insurance Clients Whose Insurance Package is <strong>{{$_GET['package']}}</strong>, Insurance Type is <strong>{{$_GET['insurance_type']}}</strong> and Expiry Year is <strong>{{$_GET['yr']}}</strong>
         @endif
      @else
         @if($_GET['yr_cat']=='start')
         <br><br>List of Insurance Clients Whose Insurance Package is <strong>{{$_GET['package']}}</strong> and Commission Year is <strong>{{$_GET['yr']}}</strong>
         @elseif($_GET['yr_cat']=='end')
         <br><br>List of Insurance Clients Whose Insurance Package is <strong>{{$_GET['package']}}</strong> and Expiry Year is <strong>{{$_GET['yr']}}</strong>
         @endif
      @endif

   @elseif(($_GET['principal_filter']!='true') && ($_GET['package_filter']=='true')&&($_GET['yr_fil']!='true'))
      @if($_GET['insurance_typefilter']=='true')
         <br><br>List of Insurance Clients Whose Insurance Package is <strong>{{$_GET['package']}}</strong> and Insurance Type is <strong>{{$_GET['insurance_type']}}</strong>
      @else
       <br><br>List of Insurance Clients Whose Insurance Package is <strong>{{$_GET['package']}}</strong>
      @endif

  @elseif(($_GET['principal_filter']!='true') && ($_GET['package_filter']!='true')&&($_GET['yr_fil']=='true'))
    @if($_GET['yr_cat']=='start')
     <br><br>List of Insurance Clients Whose Commission Year is <strong>{{$_GET['yr']}}</strong>
    @elseif($_GET['yr_cat']=='end')
     <br><br>List of Insurance Clients Whose Expiry Year is <strong>{{$_GET['yr']}}</strong>
    @endif

  @elseif(($_GET['principal_filter']!='true') && ($_GET['package_filter']!='true')&&($_GET['yr_fil']!='true'))
    <br><br>List of Insurance Clients
  @endif
      
@endif
</center>

<br>
 @if($_GET['report_type']=='sales')
<table class="hover table table-striped table-bordered" id="myTable">
        <thead class="thead-dark">
        <tr>
          <th scope="col" style="width: 4%;"><center>S/N</center></th>
          <th scope="col" style="width: 10%;"><center>Client Name</center></th>
          <th scope="col" style="width: 8%;"><center>Insurance Package</center></th>
          <th scope="col" style="width: 8%;"><center>Commission Date</center></th>
          <th scope="col" style="width: 8%;"><center>End Date</center></th>
           <th scope="col" style="width: 8%;"><center>Receipt No </center></th>
            {{-- <th scope="col" style="width: 9%;"><center>Currency </center></th> --}}
         {{--  <th scope="col" style="width: 12%;"><center>Sum Insured</center></th> --}}
          <th scope="col" style="width: 8%;"><center>Premium</center></th>
            <th scope="col" style="width: 14%;"><center>Actual(Excluding VAT) </center></th>
           
           
        </tr>
        </thead>
        <tbody>

        @foreach($insurance as $var)
          <tr>

            <td scope="row" class="counterCell" style="text-align: center;">.</td>
            <td>{{$var->full_name}}</td>
            <td>{{$var->insurance_class}}</td> 
            <td><center>{{date("d/m/Y",strtotime($var->commission_date))}}</center></td>
            <td><center>{{date("d/m/Y",strtotime($var->end_date))}}</center></td>
            <td><center>{{$var->receipt_no}}</center></td>
             {{-- <td><center>{{$var->currency}}</center></td> --}}
             {{--  <td style="text-align: right;">{{number_format($var->sum_insured)}}</td> --}}
              <td style="text-align: right;">{{$var->currency}} {{number_format($var->premium)}}</td>
            <td style="text-align: right;">{{$var->currency}} {{number_format($var->actual_ex_vat)}}</td>   
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
          <th scope="col" ><center>Currency</center></th>
          <th scope="col" ><center>Commision</center></th>
      </tr>
      </thead>
      <tbody>
      	 @foreach($principal as $var)
          <tr>
          	<td scope="row" class="counterCell" style="text-align: center;">.</td>
          	<td>{{$var->insurance_company}}</td>
          	<td>{{$var->insurance_type}}</td>
            <td><center>{{$var->insurance_currency}}</center></td>
          	<td style="text-align: right;">{{number_format($var->commission)}}</td>

          </tr>
          @endforeach
      	
      </tbody>
</table>
 @elseif($_GET['report_type']=='clients')
 <table style="width: 100%;">
    <thead class="thead-dark">
        <tr>
          <th scope="col" style="width: 4%;"><center>S/N</center></th>
           <th scope="col" style="width: 13%;"><center>Client Name</center></th>
           <th scope="col" style="width: 10%;"><center>Phone Number</center></th>
           <th scope="col" style="width: 14%;" ><center>Email</center></th>
          <th scope="col" style="width: 9%;"><center>Insurance Package</center></th>
          <th scope="col" style="width: 9%;" ><center>Commission Date</center></th>
          <th scope="col" style="width: 9%;" ><center>End Date</center></th>
          <th scope="col" style="width: 10%;"><center>Premium</center></th>
         {{--  <th scope="col" style="width: 10%;"><center>Receipt No</center></th> --}}      
        </tr>
    </thead>

    <tbody>

        @foreach($clients as $var)
          <tr>
            <td scope="row" class="counterCell" style="text-align: center;">.</td>
            <td>{{$var->full_name}}</td>
            <td>{{$var->phone_number}}</td>
            <td>{{$var->email}}</td>
            <td><center>{{$var->insurance_class}}</center></td>
            <td><center>{{date("d/m/Y",strtotime($var->commission_date))}}</center></td>
            <td><center>{{date("d/m/Y",strtotime($var->end_date))}}</center></td>
            <td style="text-align: right;">{{$var->currency}} {{number_format($var->premium)}}</td>
            {{-- <td><center>{{$var->receipt_no}}</center></td> --}}        
          </tr>
          @endforeach
      </tbody>
 </table>
@endif
</body>
</html>