<!DOCTYPE html>
<html>
<head>
	<title>Space Report</title>
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
      
      $today= date('Y-m-d');
      
	?>
	<center>
	<b>UNIVERSITY OF DAR ES SALAAM<br><br>
	<img src="{{public_path('/images/logo_udsm.jpg')}}" height="70px"></img>
     <br>DIRECTORATE OF PLANNING, DEVELOPMENT AND INVESTMENT  
    </b>
    @if($_GET['module']=='space')
    @if($_GET['major_industry']=='list')
    @if(($_GET['space_prize']=='true') &&($_GET['location_status']=='true')&& ($_GET['status']=='true'))
    @if($_GET['space_status']=='1')
    <br><br><strong>List of Occupied Spaces at {{$_GET['location']}}Whose Price Range is Between {{number_format($_GET['min_price'])}} and {{number_format($_GET['max_price'])}}</strong>
    @elseif($_GET['space_status']=='0')
    <br><br><strong>List of Vacant Spaces at {{$_GET['location']}} Whose Price Range is Between {{number_format($_GET['min_price'])}} and {{number_format($_GET['max_price'])}}</strong>
    @endif
    @endif
    @if(($_GET['space_prize']=='true') &&($_GET['location_status']=='true')&& ($_GET['status']!='true'))
    <br><br><strong>List of Spaces at {{$_GET['location']}} Whose Price Range is Between {{number_format($_GET['min_price'])}} and {{number_format($_GET['max_price'])}}</strong>
    @endif
    @if(($_GET['space_prize']=='true')&&($_GET['location_status']!='true')&&($_GET['status']=='true'))
    @if($_GET['space_status']=='1')
    <br><br><strong>List of Occupied Spaces Whose Price Range is Between {{number_format($_GET['min_price'])}} and {{number_format($_GET['max_price'])}}</strong>
    @elseif($_GET['space_status']=='0')
     <br><br><strong>List of Vacant Spaces Whose Price Range is Between {{number_format($_GET['min_price'])}} and {{number_format($_GET['max_price'])}}</strong>
    @endif
    @endif
    @if(($_GET['space_prize']=='true') &&($_GET['location_status']!='true')&& ($_GET['status']!='true'))
     <br><br><strong>List of Spaces Whose Price Range is Between {{number_format($_GET['min_price'])}} and {{number_format($_GET['max_price'])}}</strong>
    @endif
     @if(($_GET['space_prize']!='true') &&($_GET['location_status']=='true')&& ($_GET['status']=='true'))
      @if($_GET['space_status']=='1')
    <br><br><strong>List of Occupied Spaces at {{$_GET['location']}}</strong>
    @elseif($_GET['space_status']=='0')
    <br><br><strong>List of Vacant Spaces at {{$_GET['location']}}</strong>
    @endif
     @endif
      @if(($_GET['space_prize']!='true') &&($_GET['location_status']=='true')&& ($_GET['status']!='true'))
      <br><br><strong>List of All Registered Spaces at {{$_GET['location']}}</strong>
      @endif
       @if(($_GET['space_prize']!='true') &&($_GET['location_status']!='true')&& ($_GET['status']=='true'))
      @if($_GET['space_status']=='1')
    <br><br><strong>List of Occupied Spaces</strong>
    @elseif($_GET['space_status']=='0')
    <br><br><strong>List of Vacant Spaces</strong>
    @endif
    @endif
    @if(($_GET['status']!='true')&&($_GET['location_status']!='true')&&($_GET['space_prize']!='true'))
    <br><br><strong>List of All Registered Spaces</strong>
    @endif
    @else
    <br><br><strong>List of All Registered Spaces</strong>
    @endif
    @endif
    
    </center>
<br>
@if(count($spaces)>0)
    <table class="hover table table-striped table-bordered" id="myTable">
        <thead class="thead-dark">
        <tr>
          <th scope="col"><center>S/N</center></th>
          <th scope="col"><center>Space Id</center></th>
          <th scope="col"><center>Type</center></th>
          <th scope="col" ><center>Location</center></th>
          <th scope="col" ><center>Size (SQM)</center></th>
          <th scope="col" ><center>Rent Price Guide</center></th>
        </tr>
        </thead>
        <tbody>

        @foreach($spaces as $var)
          <tr>

            <th scope="row" class="counterCell text-center">.</th>
            <td><center>{{$var->space_id}}</center></td>
            <td><center>{{$var->major_industry}}</center></td>
            <td><center>{{$var->location}}</center></td>

            <td><center>  @if($var->size==null)
                  N/A
                @else
                  {{$var->size}}
                            @endif

              </center></td>
            <td><center>{{$var->rent_price_guide_currency}} {{number_format($var->rent_price_guide_from)}} - {{number_format($var->rent_price_guide_to)}}</center></td>
        </tr>
        @endforeach
    </tbody>
</table>
@else
<h3>Sorry No data found for the specified parameters</h3>
@endif

</body>
</html>