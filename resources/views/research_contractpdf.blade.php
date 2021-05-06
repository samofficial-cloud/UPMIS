<!DOCTYPE html>
<html>
<head>
	<title>Research Flats Accomodation Form</title>
</head>
<style type="text/css">
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

u{
    border-bottom: 1px dotted #000;
    text-decoration: none;
    width: 20px;
}

    .dottedUnderline { border-bottom: 0px dotted;  }


</style>
<body>
	<?php
		$contract = DB::table('research_flats_contracts')->where('id', $_GET['id'])->first();
		$category = DB::table('research_flats_rooms')->select('category')->where('room_no',$contract->room_no)->value('category');
	?>
	<div id="footer">
  		<div class="page-number"></div>
	</div>

	<div style="line-height: 1.5;">
		<center>
		<b>UNIVERSITY OF DAR ES SALAAM<br><br>
		<img src="{{public_path('/images/logo_udsm.jpg')}}" height="50px"></img>
     	<br>DIRECTORATE OF PLANNING DEVELOPMENT AND INVESTIMENT
    	</b><br>
    	<strong>RESEARCH FLATS ACCOMMODATION FACILITY<br>REGISTRATION FORM</strong>
    	<hr>
		</center>
	</div>
    @if($contract->client_category=='Foreigner')
	<p style="font-size: 18px;line-height: 1.8;">
        @else
        <p style="font-size: 18px;line-height: 1.4;">
        @endif
		1. Visitor's Information <br>
        <span style="padding-left: 15px;">Name: <u>{{$contract->first_name}} {{$contract->last_name}}</u></span>

        @if($contract->client_category=='Foreigner')
        <span style="padding-left: 15px;">Client Category: <u>{{$contract->client_category}} </u></span><br>
        @else
        <span style="padding-left: 15px;">Client Category: <u>{{$contract->client_category}} </u></span>
        @endif
        @if($contract->client_type!='')
        <span style="padding-left: 15px; ">Client Type: <u>{{$contract->client_type}} </u></span><br>
        @else
        @endif

        @if($contract->campus_individual!='')
            <span style="padding-left: 15px;">Campus: <u>{{$contract->campus_individual}} </u></span>
        @else
        @endif

        @if($contract->college_individual!='')
            <span style="padding-left: 15px;">College: <u>{{$contract->college_individual}} </u></span><br>
        @else
        @endif

        @if($contract->department_individual!='')
            <span style="padding-left: 15px;">Department: <u>{{$contract->department_individual}} </u></span><br>
        @else
        @endif

		2. Gender: <u>{{$contract->gender}}</u><br>
		3. Professional: <u>{{$contract->professional}}</u><br>
		4. Address:<u>{{$contract->address}}</u><span style="padding-left: 15px;">Email: <u>{{$contract->email}}</u></span><br>
			<span style="padding-left: 15px;">Cell phone: <u>{{$contract->phone_number}}</u></span><br>
		5. Nationality: <u>{{$contract->nationality}}</u><br>

        @if($contract->host_name!='')
        6. Contact Person while in Tanzania<br>
			<span style="padding-left: 15px;">Host Name: <u>{{$contract->host_name}}</u></span><span style="padding-left: 15px;">Signature: <u class="dottedUnderline">................</u></span><br>
			<span style="padding-left: 15px;">Campus: <u>{{$contract->campus_host}}</u></span><br>
			<span style="padding-left: 15px;">College/School: <u>{{$contract->college_host}}</u></span><span style="padding-left: 15px;">Department: <u>{{$contract->department_host}}</u></span><br>
			<span style="padding-left: 15px;">Address: <u>{{$contract->host_address}}</u></span><span style="padding-left: 15px;">Email:<u>{{$contract->host_email}}</u></span><br>
			<span style="padding-left: 15px;">Cell phone: <u>{{$contract->host_phone}}</u></span><br>
		7. Purpose of visit: <u>{{$contract->purpose}}</u><br>
        8. Passport No: @if($contract->passport_no=='')<u>N/A</u>@else<u>{{$contract->passport_no}}</u>@endif<span style="padding-left: 15px;">Date of issue: <u>{{date("d/m/Y",strtotime($contract->issue_date))}}</u>
			<span style="padding-left: 15px;">Place of issue: <u>{{$contract->issue_place}}</u></span><br>
		9. Room No: <u>{{$contract->room_no}}</u><br>
		10. Date of arrival: <u>{{date("d/m/Y",strtotime($contract->arrival_date))}}</u><span style="padding-left: 15px;">Time: <u>{{$contract->arrival_time}}</u></span><br>
		11. Expected date of departure: <u>{{date("d/m/Y",strtotime($contract->departure_date))}}</u><br>
		12. Mode of payment: <u>Invoice</u><br>
			@if($category=='Shared Room')
		13. Rate: Shared Room: <u>{{$contract->amount_usd}}</u><span style="padding-left: 15px;">Equivalent Tshs: <u>{{number_format($contract->amount_tzs)}}</u> per day</span>
			@elseif($category=='Single Room')
		13. Rate: Single Room: <u>{{$contract->amount_usd}}</u><span style="padding-left: 15px;">Equivalent Tshs: <u>{{number_format($contract->amount_tzs)}}</u> per day</span>
			@elseif($category=='Suit Room')
		13. Rate: Suit Room: <u>{{$contract->amount_usd}}</u><span style="padding-left: 15px;">Equivalent Tshs: <u>{{number_format($contract->amount_tzs)}}</u> per day</span>
			@endif
			<br><span style="padding-left: 20px;">Total amount USD: <u>{{number_format($contract->total_usd)}}</u></span><span style="padding-left: 15px;">Tshs: <u> {{number_format($contract->total_tzs)}}</u><br>
		14. Receipt No: <u>{{$contract->receipt_no}}</u> <span style="padding-left: 15px;">Of date: <u>{{date("d/m/Y",strtotime($contract->receipt_date))}}</u></span><br>
		15. Total No. of days stayed at Research Flats: <u>{{$contract->total_days}}</u><br>
		16. Signature of guest on departure: <u class="dottedUnderline">................</u><br>
		17. Final Payment(if applicable USD/TZS): <u class="dottedUnderline">................</u>
        @else
                        6. Purpose of visit: <u>{{$contract->purpose}}</u><br>
                        7. Passport No: @if($contract->passport_no=='')<u>N/A</u>@else<u>{{$contract->passport_no}}</u>@endif<span style="padding-left: 15px;">Date of issue: <u>{{date("d/m/Y",strtotime($contract->issue_date))}}</u>
			<span style="padding-left: 15px;">Place of issue: <u>{{$contract->issue_place}}</u></span><br>
		8. Room No: <u>{{$contract->room_no}}</u><br>
		9. Date of arrival: <u>{{date("d/m/Y",strtotime($contract->arrival_date))}}</u><span style="padding-left: 15px;">Time: <u>{{$contract->arrival_time}}</u></span><br>
		10. Expected date of departure: <u>{{date("d/m/Y",strtotime($contract->departure_date))}}</u><br>
		11. Mode of payment: <u>Invoice</u><br>
			@if($category=='Shared Room')
                                12. Rate: Shared Room: <u>{{$contract->amount_usd}}</u><span style="padding-left: 15px;">Equivalent Tshs: <u>{{number_format($contract->amount_tzs)}}</u> per day</span>
                            @elseif($category=='Single Room')
                                12. Rate: Single Room: <u>{{$contract->amount_usd}}</u><span style="padding-left: 15px;">Equivalent Tshs: <u>{{number_format($contract->amount_tzs)}}</u> per day</span>
                            @elseif($category=='Suit Room')
                                12. Rate: Suit Room: <u>{{$contract->amount_usd}}</u><span style="padding-left: 15px;">Equivalent Tshs: <u>{{number_format($contract->amount_tzs)}}</u> per day</span>
                            @endif
			<br><span style="padding-left: 20px;">Total amount USD: <u>{{number_format($contract->total_usd)}}</u></span><span style="padding-left: 15px;">Tshs: <u> {{number_format($contract->total_tzs)}}</u><br>
		13. Receipt No: <u>{{$contract->receipt_no}}</u> <span style="padding-left: 15px;">Of date: <u>{{date("d/m/Y",strtotime($contract->receipt_date))}}</u></span><br>
		14. Total No. of days stayed at Research Flats: <u>{{$contract->total_days}}</u><br>
		15. Signature of guest on departure: <u class="dottedUnderline">................</u><br>
		16. Final Payment(if applicable USD/TZS): <u class="dottedUnderline">................</u>

        @endif



	</p>

</body>
</html>
