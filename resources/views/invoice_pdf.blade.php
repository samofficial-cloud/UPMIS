<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

    <style>

        /*.container {*/
            /*width: 100%;*/
            /*!*padding-right: 15px;*!*/
            /*!*padding-left: 15px;*!*/
            /*margin-right: auto;*/
            /*margin-left: auto;*/
        /*}*/

        /*@media (min-width: 576px) {*/
            /*.container {*/
                /*max-width: 540px;*/
            /*}*/
        /*}*/

        /*@media (min-width: 768px) {*/
            /*.container {*/
                /*max-width: 720px;*/
            /*}*/
        /*}*/

        /*@media (min-width: 992px) {*/
            /*.container {*/
                /*max-width: 960px;*/
            /*}*/
        /*}*/

        /*@media (min-width: 1200px) {*/
            /*.container {*/
                /*max-width: 1140px;*/
            /*}*/
        /*}*/



        /*@media print {*/

            /*.container {*/
                /*min-width: 992px !important;*/
            /*}*/


        /*}*/


        hr {
            display: block;
            height: 1px;
            border: 0;
            border-top: 2px solid #000;
            margin: 1em 0;
            padding: 0;
        }

        table thead th { border-bottom: 2px solid #000; }

        .dottedUnderline { border-bottom: 2px dotted;  }

        .horizontal_align {width: 16.66%;

            float: left;}

        .horizontal_align_margin {width: 13.66%;

            float: left;
        margin-left: 3%;}

    </style>
</head>
<body>
<div class="container" >

<div style="text-align: center" >
<h1>University of Dar es salaam</h1>
<h2>P.O.Box 35091, Dar es salaam, TANZANIA </h2>
     <h2>TIN: 101-205-614</h2>
    <h2>INVOICE</h2>
</div>
<hr/>

<div style="width: 100%">
    <div style="float:left; width: 50%; ">
        <div style="margin-left: 20%; width:80%;">
            <p><b>Invoice No: {{$invoice_number}} </b></p>
            <p><b>Project ID: {{$project_id}}</b></p>
            <p><b>Debtor Account Code: {{$debtor_account_code}}</b></p>
            <p><b>Debtor Name: {{$debtor_name}}</b></p>
            <p><b>Debtor Address: {{$debtor_address}}</b></p>
            <p><b>Amount: {{$amount_to_be_paid}}</b></p>
            <p><b>Currency: {{$currency}}</b></p>
            <p><b>GEPG Control No.: {{$gepg_control_no}}</b></p>
            <p><b>TIN: {{$tin}}</b></p>
        </div>
    </div>

    <div style="float:left; width: 50%; ">
        <div style="margin-left: 35%; width:65%;">
            <p><b>Invoice Date: {{$invoice_date}}</b></p>
            <p><b>Period: {{$period}}</b></p>
            <p><b>Financial Year: {{$financial_year}}</b></p>
<br><br><br><br><br>
            <p><b>Max No. of Days to Pay: {{$max_no_of_days_to_pay}}</b></p>
        <p><b>Status: {{$status}}</b></p>
        <p><b>VRN: {{$vrn}}</b></p>
        </div>
    </div>

</div>


<div  style="clear: both">
    <table style="width: 100%" class="container">
        <thead >

        <tr>
            <th><center>Inc. Code</center></th>
            <th><center>Description</center></th>
            <th><center>Amount ({{$currency}})</center></th>
        </tr>
        </thead>

        <tbody>

            <tr>
                <td ><center>{{$inc_code}}</center></td>
                <td><center>{{$description}}</center></td>
                <td><center>{{$amount_to_be_paid}}</center></td>

            </tr>

            <tr><td></td><td></td><td></td></tr>
            <tr><td></td><td></td><td></td></tr>
            <tr><td></td><td></td><td></td></tr>
            <tr><td></td><td></td><td></td></tr>
            <tr><td></td><td></td><td></td></tr>
            <tr>
                <td ><center></center></td>
                <td style="text-align: right">Total:</td>
                <td><center>{{$amount_to_be_paid}}</center></td>

            </tr>

        </tbody>

    </table>

</div>
<br>

<div style="clear: both"></div>
    <div>
        <div style="float: left; "><p><b>Amount in Words   </b> </p><p class="dottedUnderline">{{$amount_in_words}} </p>

            <p><b>Please make payment through GEPG Control Number: {{$gepg_control_no}}</b></p>


        </div>

    </div>
    <div style="clear: both"></div>
    <br>
    <div style="width: 100%;">
        <div class="horizontal_align"><b>Prepared By</b></div>
        <div  class="dottedUnderline horizontal_align"><b>{{$prepared_by}}</b></div>
        <div class="horizontal_align_margin "><b>Signature</b></div>
        <div  class="dottedUnderline horizontal_align">signature</div>
        <div class="horizontal_align_margin"><b>Date</b></div>
        <div  class="dottedUnderline horizontal_align"><b>{{$today}}</b></div>
    </div>
<br><br>
    <div style="width: 100%;">
        <div class="horizontal_align"><b>Approved By</b></div>
        <div  class="dottedUnderline horizontal_align"><b>{{$approved_by}} </b></div>
        <div class="horizontal_align_margin "><b>Signature</b></div>
        <div class="dottedUnderline horizontal_align">signature</div>
        <div class="horizontal_align_margin"><b>Date</b></div>
        <div class="dottedUnderline horizontal_align"><b>{{$today}}</b></div>

    </div>
<br>
    <br>
    <br>
</div>
</body>
</html>