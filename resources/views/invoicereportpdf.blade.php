<!DOCTYPE html>
<html>
<head>
	<title>Invoice Report</title>
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
	$i=1;
	
	?>
  <center>
	<b>UNIVERSITY OF DAR ES SALAAM<br><br>
	<img src="{{public_path('/images/logo_udsm.jpg')}}" height="70px"></img>
     <br>DIRECTORATE OF PLANNING, DEVELOPMENT AND INVESTMENT  
    </b>
    @if(($_GET['c_filter']!='true')&&($_GET['payment_filter']!='true')&&($_GET['year_filter']!='true'))
    @if(($_GET['b_type']=='Space') &&($_GET['In_type']=='rent'))
     <br><br>List of <b>Space Rent</b> Invoices
     @elseif(($_GET['b_type']=='Space') &&($_GET['In_type']=='water'))
     <br><br>List of <b>Space Water Bill</b> Invoices
      @elseif(($_GET['b_type']=='Space') &&($_GET['In_type']=='electricity'))
     <br><br>List of <b>Space Electricity Bill</b> Invoices
     @else
     <br><br>List of <b>{{$_GET['b_type']}}</b> Invoices
    @endif
    @elseif(($_GET['c_filter']!='true')&&($_GET['payment_filter']!='true')&&($_GET['year_filter']=='true'))
     @if(($_GET['b_type']=='Space') &&($_GET['In_type']=='rent'))
     <br><br>List of <b>Space Rent</b> Invoices for the Year <b>{{$_GET['year']}}</b>
     @elseif(($_GET['b_type']=='Space') &&($_GET['In_type']=='water'))
     <br><br>List of <b>Space Water Bill</b> Invoices for the Year <b>{{$_GET['year']}}</b>
      @elseif(($_GET['b_type']=='Space') &&($_GET['In_type']=='electricity'))
     <br><br>List of <b>Space Electricity Bill</b> Invoices for the Year <b>{{$_GET['year']}}</b>
     @else
     <br><br>List of <b>{{$_GET['b_type']}}</b> Invoices for the Year <b>{{$_GET['year']}}</b>
    @endif
     @elseif(($_GET['c_filter']!='true')&&($_GET['payment_filter']=='true')&&($_GET['year_filter']!='true'))
     @if(($_GET['b_type']=='Space') &&($_GET['In_type']=='rent'))
     <br><br>List of <b>{{$_GET['payment_status']}} Space Rent</b> Invoices
     @elseif(($_GET['b_type']=='Space') &&($_GET['In_type']=='water'))
     <br><br>List of <b>{{$_GET['payment_status']}} Space Water Bill</b> Invoices
      @elseif(($_GET['b_type']=='Space') &&($_GET['In_type']=='electricity'))
     <br><br>List of <b>{{$_GET['payment_status']}} Space Electricity Bill</b> Invoices
     @else
     <br><br>List of <b>{{$_GET['payment_status']}} {{$_GET['b_type']}}</b> Invoices
    @endif
     @elseif(($_GET['c_filter']!='true')&&($_GET['payment_filter']=='true')&&($_GET['year_filter']=='true'))
     @if(($_GET['b_type']=='Space') &&($_GET['In_type']=='rent'))
     <br><br>List of <b>{{$_GET['payment_status']}} Space Rent</b> Invoices for the Year <b>{{$_GET['year']}}</b>
     @elseif(($_GET['b_type']=='Space') &&($_GET['In_type']=='water'))
     <br><br>List of <b>{{$_GET['payment_status']}} Space Water Bill</b> Invoices for the Year <b>{{$_GET['year']}}</b>
      @elseif(($_GET['b_type']=='Space') &&($_GET['In_type']=='electricity'))
     <br><br>List of <b>{{$_GET['payment_status']}} Space Electricity Bill</b> Invoices for the Year <b>{{$_GET['year']}}</b>
     @else
     <br><br>List of <b>{{$_GET['payment_status']}} {{$_GET['b_type']}}</b> Invoices for the Year <b>{{$_GET['year']}}</b>
    @endif
     @elseif(($_GET['c_filter']=='true')&&($_GET['payment_filter']!='true')&&($_GET['year_filter']!='true'))
     @if(($_GET['b_type']=='Space') &&($_GET['In_type']=='rent'))
     <br><br>List of <b>{{$_GET['c_name']}} Space Rent</b> Invoices
     @elseif(($_GET['b_type']=='Space') &&($_GET['In_type']=='water'))
     <br><br>List of <b>{{$_GET['c_name']}} Space Water Bill</b> Invoices
      @elseif(($_GET['b_type']=='Space') &&($_GET['In_type']=='electricity'))
     <br><br>List of <b>{{$_GET['c_name']}} Space Electricity Bill</b> Invoices
     @else
     <br><br>List of <b>{{$_GET['c_name']}} {{$_GET['b_type']}}</b> Invoices
    @endif
    @elseif(($_GET['c_filter']=='true')&&($_GET['payment_filter']!='true')&&($_GET['year_filter']=='true'))
     @if(($_GET['b_type']=='Space') &&($_GET['In_type']=='rent'))
     <br><br>List of <b>{{$_GET['c_name']}} Space Rent</b> Invoices for the Year <b>{{$_GET['year']}}</b>
     @elseif(($_GET['b_type']=='Space') &&($_GET['In_type']=='water'))
     <br><br>List of <b>{{$_GET['c_name']}} Space Water Bill</b> Invoices for the Year <b>{{$_GET['year']}}</b>
      @elseif(($_GET['b_type']=='Space') &&($_GET['In_type']=='electricity'))
     <br><br>List of <b>{{$_GET['c_name']}} Space Electricity Bill</b> Invoices for the Year <b>{{$_GET['year']}}</b>
     @else
     <br><br>List of <b>{{$_GET['c_name']}} {{$_GET['b_type']}}</b> Invoices for the Year <b>{{$_GET['year']}}</b>
    @endif
     @elseif(($_GET['c_filter']=='true')&&($_GET['payment_filter']=='true')&&($_GET['year_filter']!='true'))
     @if(($_GET['b_type']=='Space') &&($_GET['In_type']=='rent'))
     <br><br>List of <b>{{$_GET['payment_status']}} Space Rent</b> Invoices for <b>{{$_GET['c_name']}}</b>
     @elseif(($_GET['b_type']=='Space') &&($_GET['In_type']=='water'))
     <br><br>List of <b>{{$_GET['payment_status']}} Space Water Bill</b> Invoices for <b>{{$_GET['c_name']}}</b>
      @elseif(($_GET['b_type']=='Space') &&($_GET['In_type']=='electricity'))
     <br><br>List of <b>{{$_GET['payment_status']}} Space Electricity Bill</b> Invoices for <b>{{$_GET['c_name']}}</b>
     @else
     <br><br>List of <b>{{$_GET['payment_status']}} {{$_GET['b_type']}}</b> Invoices for <b>{{$_GET['c_name']}}</b>
    @endif
    @elseif(($_GET['c_filter']=='true')&&($_GET['payment_filter']=='true')&&($_GET['year_filter']=='true'))
     @if(($_GET['b_type']=='Space') &&($_GET['In_type']=='rent'))
     <br><br>List of <b>{{$_GET['payment_status']}} Space Rent</b> Invoices for the Year <b>{{$_GET['year']}}</b> for <b>{{$_GET['c_name']}}</b> 
     @elseif(($_GET['b_type']=='Space') &&($_GET['In_type']=='water'))
     <br><br>List of <b>{{$_GET['payment_status']}} Space Water Bill</b> Invoices for the Year <b>{{$_GET['year']}}</b> for <b>{{$_GET['c_name']}}</b>
      @elseif(($_GET['b_type']=='Space') &&($_GET['In_type']=='electricity'))
     <br><br>List of <b>{{$_GET['payment_status']}} Space Electricity Bill</b> Invoices for the Year <b>{{$_GET['year']}}</b> for <b>{{$_GET['c_name']}}</b>
     @else
     <br><br>List of <b>{{$_GET['payment_status']}} {{$_GET['b_type']}}</b> Invoices for the Year <b>{{$_GET['year']}}</b> for <b>{{$_GET['c_name']}}</b>
    @endif
    @endif
</center>
<br>
<table class="hover table table-striped  table-bordered" id="myTable3">
                            <thead class="thead-dark">
                            <tr>
                                <th scope="col"><center>S/N</center></th>
                                <th scope="col" style="width: 16%;"><center>Debtor Name</center></th>
                                <th scope="col"><center>Invoice Number</center></th>
                                <th scope="col" ><center>Start Date</center></th>
                                <th scope="col" ><center>End date</center></th>
                               {{--  <th scope="col" ><center>Period</center></th> --}}
                                <th scope="col"><center>Contract Id</center></th>
                                <th scope="col" ><center>Amount</center></th>
                                <th scope="col" ><center>GEPG Control No</center></th>
                                <th scope="col" ><center>Invoice Date</center></th>
                                @if($_GET['payment_filter']=='')
                                <th scope="col" ><center>Remarks</center></th>
                                @endif
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($invoices as $var)
                                <tr>
                                    <th scope="row">{{ $i }}.</th>
                                    <td>{{$var->debtor_name}}</td>
                                    <td><center>{{$var->invoice_number}}</center></td>

                                    <td><center>{{date("d/m/Y",strtotime($var->invoicing_period_start_date))}}</center></td>
                                    <td><center>{{date("d/m/Y",strtotime($var->invoicing_period_end_date))}}</center></td>
                                   {{--  <td><center>{{$var->period}}</center></td> --}}
                                    <td><center>{{$var->contract_id}}</center></td>
                                    <td><center>{{$var->currency_invoice}} {{number_format($var->amount_to_be_paid)}}</center></td>
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
</body>
</html>