<html>
<head>
    <title>REAL ESTATE CONTRACT</title>
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


    .dottedUnderline { border-bottom: 1px dotted;  }

    .horizontal_align {width: 25%;

        float: left;}

    .horizontal_align_right {width: 75%;

        float: left;}

    .horizontal_align_margin {width: 13.66%;

        float: left;
        margin-left: 3%;}



</style>

<body>


<div class="container">



    <center>
        <b>UNIVERSITY OF DAR ES SALAAM<br><br>
            <img src="{{public_path('/images/logo_udsm.jpg')}}" height="70px"></img>
            <br>DIRECTORATE OF PLANNING, DEVELOPMENT AND INVESTMENT
        </b>

        <h2>Real Estate Contract</h2>
    </center>



    <br>

    <h2>A. Client information</h2>



    @if($client_type=='Individual')
    <div style="width: 100%; clear: both;">
        <div class="horizontal_align" style="text-align: left; padding-left: 4%; ">First name:</div>
        <div style="text-align: left" class="dottedUnderline horizontal_align_right"><b>{{$first_name}}</b></div>

    </div>

    <div style="width: 100%; clear: both;">
        <div class="horizontal_align" style="text-align: left; padding-left: 4%; ">Last name:</div>
        <div style="text-align: left" class="dottedUnderline horizontal_align_right"><b>{{$last_name}}</b></div>

    </div>
    @elseif($client_type=='Company/Organization')
    <div style="width: 100%; clear: both;">
        <div class="horizontal_align" style="text-align: left; padding-left: 4%; ">Company name:</div>
        <div style="text-align: left" class="dottedUnderline horizontal_align_right"><b>{{$company_name}}</b></div>

    </div>
    @else
    @endif

    <div style="width: 100%; clear: both; padding-top: 1.5%;">
        <div class="horizontal_align" style="text-align: left; padding-left: 4%; ">Phone number:</div>
        <div style="text-align: left" class="dottedUnderline horizontal_align_right"><b>{{$phone_number}}</b></div>

    </div>


    <div style="width: 100%; clear: both; padding-top: 1.5%;">
        <div class="horizontal_align" style="text-align: left; padding-left: 4%; ">Email:</div>
        <div style="text-align: left" class="dottedUnderline horizontal_align_right"><b>{{$email}}</b></div>

    </div>


    <div style="width: 100%; clear: both; padding-top: 1.5%;">
        <div class="horizontal_align" style="text-align: left; padding-left: 4%; ">Address:</div>
        <div style="text-align: left" class="dottedUnderline horizontal_align_right"><b>{{$address}}</b></div>

    </div>










    <h2 style="clear: both; padding-top: 2%">B. Payment information</h2>


    <div style="width: 100%; clear: both; ">
        <div class="horizontal_align" style="text-align: left; padding-left: 4%; ">Start date:</div>
        <div style="text-align: left" class="dottedUnderline horizontal_align_right"><b>{{date("d/m/Y",strtotime($start_date))}}</b></div>

    </div>


    <div style="width: 100%; clear: both; ">
        <div class="horizontal_align" style="text-align: left; padding-left: 4%; ">Duration:</div>
        <div style="text-align: left" class="dottedUnderline horizontal_align_right"><b>{{$duration}} {{$duration_period}}</b></div>

    </div>


    <div style="width: 100%; clear: both; ">
        <div class="horizontal_align" style="text-align: left; padding-left: 4%; ">Percentage to be paid(Of total collection):</div>
        <div style="text-align: left" class="dottedUnderline horizontal_align_right"><b> {{$percentage}}%</b></div>

    </div>


    <div style="width: 100%; clear: both; ">
        <div class="horizontal_align" style="text-align: left; padding-left: 4%; ">Currency:</div>
        <div style="text-align: left" class="dottedUnderline horizontal_align_right"><b>{{$currency}} </b></div>
        <p class="pt-1"  style="padding-left: 4%;"><b>N.B</b> This is the currency that will be used for all sub-clients</p>
    </div>





    <div style="width: 100%; clear: both; ">
        <div class="horizontal_align" style="text-align: left; padding-left: 4%; ">Payment cycle:</div>
        <div style="text-align: left" class="dottedUnderline horizontal_align_right"><b>{{$payment_cycle}} Months</b></div>

    </div>






{{--    <table class="table  " style="width: 100%; ">--}}


{{--        <tr>--}}
{{--            <td>Client name:</td>--}}
{{--            <td id="client_name_confirm"> </td>--}}
{{--        </tr>--}}

{{--        <tr>--}}
{{--            <td> Phone number:</td>--}}
{{--            <td id="phone_number_confirm"></td>--}}
{{--        </tr>--}}


{{--        <tr>--}}
{{--            <td> Email:</td>--}}
{{--            <td id="email_confirm"> </td>--}}
{{--        </tr>--}}



{{--        <tr>--}}
{{--            <td>Insurance class</td>--}}
{{--            <td id="insurance_class_confirm"></td>--}}
{{--        </tr>--}}


{{--        <tr>--}}
{{--            <td>Principal:</td>--}}
{{--            <td id="insurance_company_confirm"></td>--}}
{{--        </tr>--}}

{{--        <tr>--}}
{{--            <td>Insurance type</td>--}}
{{--            <td id="insurance_type_confirm"> </td>--}}
{{--        </tr>--}}




{{--        <tr id="vehicle_registration_no_row_confirm" style="display: none;">--}}
{{--            <td> Vehicle Registration Number:</td>--}}
{{--            <td id="vehicle_registration_no_confirm"> </td>--}}
{{--        </tr>--}}


{{--        <tr id="vehicle_use_row_confirm" style="display: none;">--}}
{{--            <td>Vehicle Use:</td>--}}
{{--            <td id="vehicle_use_confirm"></td>--}}
{{--        </tr>--}}











{{--    </table>--}}

{{--    <h2>B. Payment information</h2>--}}

{{--    <table class="table" style="width: 100%; ">--}}


{{--        <tr>--}}
{{--            <td>Commission date:</td>--}}
{{--            <td id="commission_date_confirm"></td>--}}
{{--        </tr>--}}

{{--        <tr >--}}
{{--            <td style="padding-left: 2%">Duration</td>--}}
{{--            <td style="text-align: center"><b>1 year</b></td>--}}
{{--        </tr>--}}


{{--        <tr>--}}
{{--            <td>Sum insured:</td>--}}
{{--            <td id="sum_insured_confirm"></td>--}}
{{--        </tr>--}}

{{--        <tr>--}}
{{--            <td>Premium:</td>--}}
{{--            <td id="premium_confirm"></td>--}}
{{--        </tr>--}}



{{--        <tr>--}}
{{--            <td>Actual (Excluding VAT):</td>--}}
{{--            <td id="actual_ex_vat_confirm"></td>--}}
{{--        </tr>--}}


{{--        <tr id="value_row_confirm" style="display: none;" >--}}
{{--            <td>Value:</td>--}}
{{--            <td id="value_confirm"></td>--}}
{{--        </tr>--}}

{{--        <tr>--}}
{{--            <td>Commission percentage:</td>--}}
{{--            <td id="commission_percentage_confirm"></td>--}}
{{--        </tr>--}}

{{--        <tr>--}}
{{--            <td>Commission:</td>--}}
{{--            <td id="commission_confirm"></td>--}}
{{--        </tr>--}}


{{--        <tr id="cover_note_row_confirm" style="display: none;">--}}
{{--            <td>Cover note:</td>--}}
{{--            <td id="cover_note_confirm"></td>--}}
{{--        </tr>--}}

{{--        <tr id="sticker_no_row_confirm" style="display: none;">--}}
{{--            <td>Sticker number:</td>--}}
{{--            <td id="sticker_no_confirm"></td>--}}
{{--        </tr>--}}

{{--        <tr>--}}
{{--            <td>Receipt number:</td>--}}
{{--            <td id="receipt_no_confirm"></td>--}}
{{--        </tr>--}}






{{--    </table>--}}





</div>
</body>
</html>
