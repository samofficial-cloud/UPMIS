
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <style>
        hr {
            display: block;
            height: 1px;
            border: 0;
            border-top: 1px solid #ccc;
            margin: 1em 0;
            padding: 0;
        }

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
        <div style="margin-left: 40%; width:60%;">
        <p>Invoice No:</p>
        <p>Period:</p>
        <p>Revenue Centre:</p>
        <p>Debtor ID:</p>
        <p>Debtor Name:</p>
        <p>TIN:</p>
        </div>
    </div>

    <div style="float:left; width: 50%; ">
        <div style="margin-left: 30%; width:70%;">
        <p>Invoice Date:</p>
        <p>Financial Year:</p>
        <p>Project ID:</p>
        <p>Status:</p>
        <p>VRN:</p>
        </div>
    </div>

</div>



    <table id="mytableDetailedinstructor" class="table table-bordered table-striped">
        <thead class="thead-dark">
        <tr>
            <th>Inc. Code</th>
            <th>Description</th>
            <th>Amount(TZS)</th>
        </tr>
        </thead>

        <tbody>

            <tr>
                <td >757565</td>
                <td>Web hosting income being charges for webhosting and domain</td>
                <td>166,000</td>

            </tr>

        </tbody>

    </table>



</div>
</body>
</html>
