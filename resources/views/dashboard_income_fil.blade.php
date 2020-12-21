<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<?php $year = date('Y');?>
	{{-- <script src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>
 <script src="{{ asset('js/app.js') }}" ></script>
 <link href="{{ asset('css/app.css') }}" rel="stylesheet"> --}}

            <div id="content">
            <h4 class="card-title" style="font-family: sans-serif;">UDIA, CPTU and Space Income Generation {{$_GET['year']}}</h4>
            <hr>
            <div >
    <center><div id="loading"></div></center>
  </div>
<div class="card-deck">
  <div class="card border-info">
     {!! $chart4->container() !!}
  </div>
  <div class="card border-info">
     {!! $chart5->container() !!}
  </div>
  <div class="card border-info">
     {!! $chart6->container() !!}
  </div>
</div>
</div>

<script src="{{ asset('js/Chart.min.js') }}" ></script>
			{!! $chart4->script() !!}
          	{!! $chart5->script() !!}
           	{!! $chart6->script() !!}
</body>
</html>