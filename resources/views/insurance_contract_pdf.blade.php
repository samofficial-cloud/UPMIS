<html>
<head>
    <title>INSURANCE CONTRACT</title>
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

        <h2>Insurance contract</h2>
    </center>



    <br>

    <h2>A. Client and insurance information</h2>


    <div style="width: 100%;">
        <div class="horizontal_align" style="text-align: left; padding-left: 4%; ">Client name:</div>
        <div style="text-align: left" class="dottedUnderline horizontal_align_right"><b>{{$client_name}}</b></div>

    </div>


    <div style="width: 100%; clear: both; padding-top: 1.5%;">
        <div class="horizontal_align" style="text-align: left; padding-left: 4%; ">Phone number:</div>
        <div style="text-align: left" class="dottedUnderline horizontal_align_right"><b>{{$phone_number}}</b></div>

    </div>


    <div style="width: 100%; clear: both; padding-top: 1.5%;">
        <div class="horizontal_align" style="text-align: left; padding-left: 4%; ">Email:</div>
        <div style="text-align: left" class="dottedUnderline horizontal_align_right"><b>{{$email}}</b></div>

    </div>





    <div style="width: 100%; clear: both; padding-top: 1.5%;">
        <div class="horizontal_align" style="text-align: left; padding-left: 4%; ">Insurance class:</div>
        <div style="text-align: left" class="dottedUnderline horizontal_align_right"><b>{{$insurance_class}}</b></div>

    </div>

    <div style="width: 100%; clear: both; padding-top: 1.5%;">
        <div class="horizontal_align" style="text-align: left; padding-left: 4%; ">Principal:</div>
        <div style="text-align: left" class="dottedUnderline horizontal_align_right"><b>{{$insurance_company}}</b></div>

    </div>

    @if($insurance_type=='N/A')
    @else
    <div style="width: 100%; clear: both; padding-top: 1.5%;">
        <div class="horizontal_align" style="text-align: left; padding-left: 4%; ">Insurance type:</div>
        <div style="text-align: left" class="dottedUnderline horizontal_align_right"><b>{{$insurance_type}}</b></div>
    </div>
    @endif

    @if($vehicle_registration_no!='')
    <div style="width: 100%; clear: both; padding-top: 1.5%;">
        <div class="horizontal_align" style="text-align: left; padding-left: 4%; ">Vehicle registration number:</div>
        <div style="text-align: left" class="dottedUnderline horizontal_align_right"><b>{{$vehicle_registration_no}}</b></div>

    </div>
    @else
    @endif

        @if($vehicle_use!='')
    <div style="width: 100%; clear: both; padding-top: 1.5%;">
        <div class="horizontal_align" style="text-align: left; padding-left: 4%; ">Vehicle use:</div>
        <div style="text-align: left" class="dottedUnderline horizontal_align_right"><b>{{$vehicle_use}}</b></div>

    </div>
    @else
    @endif



        <h2 style="clear: both; padding-top: 2%">B. Payment information</h2>




    <div style="width: 100%; clear: both; ">
        <div class="horizontal_align" style="text-align: left; padding-left: 4%; ">Commission date:</div>
        <div style="text-align: left" class="dottedUnderline horizontal_align_right"><b>{{date("d/m/Y",strtotime($commission_date))}}</b></div>

    </div>

    <div style="width: 100%; clear: both; padding-top: 1.3%; ">
        <div class="horizontal_align" style="text-align: left; padding-left: 4%; ">Duration:</div>
        <div style="text-align: left" class="dottedUnderline horizontal_align_right"><b>1 year</b></div>

    </div>


    <div style="width: 100%; clear: both; padding-top: 1.3%;">
        <div class="horizontal_align" style="text-align: left; padding-left: 4%; ">Sum insured:</div>
        <div style="text-align: left" class="dottedUnderline horizontal_align_right"><b>{{number_format($sum_insured)}} {{$currency}}</b></div>

    </div>


    <div style="width: 100%; clear: both; padding-top: 1.3%;">
        <div class="horizontal_align" style="text-align: left; padding-left: 4%; ">Premium:</div>
        <div style="text-align: left" class="dottedUnderline horizontal_align_right"><b>{{number_format($premium)}} {{$currency}}</b></div>

    </div>


    <div style="width: 100%; clear: both; padding-top: 1.3%;">
        <div class="horizontal_align" style="text-align: left; padding-left: 4%; ">Actual (Excluding VAT):</div>
        <div style="text-align: left" class="dottedUnderline horizontal_align_right"><b>{{number_format($actual_ex_vat)}} {{$currency}}</b></div>

    </div>



@if($value!='')
    <div style="width: 100%; clear: both; padding-top: 1.3%;">
        <div class="horizontal_align" style="text-align: left; padding-left: 4%; ">Value:</div>
        <div style="text-align: left" class="dottedUnderline horizontal_align_right"><b>{{number_format($value)}} {{$currency}}</b></div>

    </div>
    @else
    @endif


    <div style="width: 100%; clear: both; padding-top: 1.3%;">
        <div class="horizontal_align" style="text-align: left; padding-left: 4%; ">Commission percentage:</div>
        <div style="text-align: left" class="dottedUnderline horizontal_align_right"><b>{{$commission_percentage}}%</b></div>

    </div>


    <div style="width: 100%; clear: both; padding-top: 1.3%;">
        <div class="horizontal_align" style="text-align: left; padding-left: 4%; ">Commission:</div>
        <div style="text-align: left" class="dottedUnderline horizontal_align_right"><b>{{number_format($commission)}} {{$currency}}</b></div>

    </div>

    @if($cover_note!='')
    <div style="width: 100%; clear: both; padding-top: 1.3%;">
        <div class="horizontal_align" style="text-align: left; padding-left: 4%; ">Cover note:</div>
        <div style="text-align: left" class="dottedUnderline horizontal_align_right"><b>{{$cover_note}}</b></div>

    </div>
    @else
    @endif


    @if($sticker_no!='')
    <div style="width: 100%; clear: both; padding-top: 1.3%;">
        <div class="horizontal_align" style="text-align: left; padding-left: 4%; ">Sticker number:</div>
        <div style="text-align: left" class="dottedUnderline horizontal_align_right"><b>{{$sticker_no}}</b></div>

    </div>
    @else
    @endif



    <div style="width: 100%; clear: both; padding-top: 1.3%;">
        <div class="horizontal_align" style="text-align: left; padding-left: 4%; ">Receipt number:</div>
        <div style="text-align: left" class="dottedUnderline horizontal_align_right"><b>{{$receipt_no}}</b></div>

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
