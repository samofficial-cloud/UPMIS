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
/*table {
  counter-reset: tableCount;
  }*/

 /* .counterCell:before {
  content: counter(tableCount);
  counter-increment: tableCount;
  }*/

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
      
      $today= date('Y-m-d');
      $i=1;
      
	?>
	<center>
	<b>UNIVERSITY OF DAR ES SALAAM<br><br>
	<img src="{{public_path('/images/logo_udsm.jpg')}}" height="70px"></img>
     <br>DIRECTORATE OF PLANNING, DEVELOPMENT AND INVESTMENT  
    </b>
  @if($_GET['module']=='space')
    @if($_GET['major_industry']=='list')
        @if(($_GET['space_prize']=='true') &&($_GET['location_status']=='true')&& ($_GET['status']=='true') && ($_GET['ind_fil']=='true'))
            @if($_GET['space_status']=='1')
              <br><br>List of Occupied Spaces at <strong>{{$_GET['location']}}</strong> Whose Price Range is Between <strong>{{number_format($_GET['min_price'])}}</strong> and <strong>{{number_format($_GET['max_price'])}}</strong> and Major industry is <strong>{{$_GET['ind']}}</strong>
            @elseif($_GET['space_status']=='0')
              <br><br>List of Vacant Spaces at <strong>{{$_GET['location']}}</strong> Whose Price Range is Between <strong>{{number_format($_GET['min_price'])}}</strong> and <strong>{{number_format($_GET['max_price'])}}</strong> and Major industry is <strong>{{$_GET['ind']}}</strong>
            @endif

        @elseif(($_GET['space_prize']=='true') &&($_GET['location_status']=='true')&& ($_GET['status']=='true') && ($_GET['ind_fil']!='true'))
            @if($_GET['space_status']=='1')
              <br><br>List of Occupied Spaces at <strong>{{$_GET['location']}}</strong> Whose Price Range is Between <strong>{{number_format($_GET['min_price'])}}</strong> and <strong>{{number_format($_GET['max_price'])}}</strong>
            @elseif($_GET['space_status']=='0')
              <br><br>List of Vacant Spaces at <strong>{{$_GET['location']}}</strong> Whose Price Range is Between <strong>{{number_format($_GET['min_price'])}}</strong> and <strong>{{number_format($_GET['max_price'])}}</strong>
            @endif

        @elseif(($_GET['space_prize']=='true') &&($_GET['location_status']=='true')&& ($_GET['status']!='true') && ($_GET['ind_fil']=='true'))
            <br><br>List of Spaces at <strong>{{$_GET['location']}}</strong> Whose Price Range is Between <strong>{{number_format($_GET['min_price'])}}</strong> and <strong>{{number_format($_GET['max_price'])}}</strong> and Major industry is <strong>{{$_GET['ind']}}</strong>

        @elseif(($_GET['space_prize']=='true') &&($_GET['location_status']=='true')&& ($_GET['status']!='true') && ($_GET['ind_fil']!='true'))
            <br><br>List of Spaces at <strong>{{$_GET['location']}}</strong> Whose Price Range is Between <strong>{{number_format($_GET['min_price'])}}</strong> and <strong>{{number_format($_GET['max_price'])}}</strong>

        @elseif(($_GET['space_prize']=='true') &&($_GET['location_status']!='true')&& ($_GET['status']=='true') && ($_GET['ind_fil']=='true'))
            @if($_GET['space_status']=='1')
              <br><br>List of Occupied Spaces Whose Price Range is Between <strong>{{number_format($_GET['min_price'])}}</strong> and <strong>{{number_format($_GET['max_price'])}}</strong> and Major industry is <strong>{{$_GET['ind']}}</strong>
            @elseif($_GET['space_status']=='0')
              <br><br>List of Vacant Spaces Whose Price Range is Between <strong>{{number_format($_GET['min_price'])}}</strong> and <strong>{{number_format($_GET['max_price'])}}</strong> and Major industry is <strong>{{$_GET['ind']}}</strong>
            @endif

        @elseif(($_GET['space_prize']=='true') &&($_GET['location_status']!='true')&& ($_GET['status']=='true') && ($_GET['ind_fil']!='true'))
            @if($_GET['space_status']=='1')
              <br><br>List of Occupied Spaces Whose Price Range is Between <strong>{{number_format($_GET['min_price'])}}</strong> and <strong>{{number_format($_GET['max_price'])}}</strong>
            @elseif($_GET['space_status']=='0')
              <br><br>List of Vacant Spaces Whose Price Range is Between <strong>{{number_format($_GET['min_price'])}}</strong> and <strong>{{number_format($_GET['max_price'])}}</strong>
            @endif

        @elseif(($_GET['space_prize']=='true') &&($_GET['location_status']!='true')&& ($_GET['status']!='true') && ($_GET['ind_fil']=='true'))
            <br><br>List of Spaces Whose Price Range is Between <strong>{{number_format($_GET['min_price'])}}</strong> and <strong>{{number_format($_GET['max_price'])}}</strong> and Major industry is <strong>{{$_GET['ind']}}</strong>

        @elseif(($_GET['space_prize']=='true') &&($_GET['location_status']!='true')&& ($_GET['status']!='true') && ($_GET['ind_fil']!='true'))
            <br><br>List of Spaces Whose Price Range is Between <strong>{{number_format($_GET['min_price'])}}</strong> and <strong>{{number_format($_GET['max_price'])}}</strong>

        @elseif(($_GET['space_prize']!='true') &&($_GET['location_status']=='true')&& ($_GET['status']=='true') && ($_GET['ind_fil']=='true'))
            @if($_GET['space_status']=='1')
              <br><br>List of Occupied Spaces at <strong>{{$_GET['location']}}</strong> Whose Major industry is <strong>{{$_GET['ind']}}</strong>
            @elseif($_GET['space_status']=='0')
              <br><br>List of Vacant Spaces at <strong>{{$_GET['location']}}</strong> Whose Major industry is <strong>{{$_GET['ind']}}</strong>
            @endif

        @elseif(($_GET['space_prize']!='true') &&($_GET['location_status']=='true')&& ($_GET['status']=='true') && ($_GET['ind_fil']!='true'))
            @if($_GET['space_status']=='1')
              <br><br>List of Occupied Spaces at <strong>{{$_GET['location']}}</strong>
            @elseif($_GET['space_status']=='0')
              <br><br>List of Vacant Spaces at <strong>{{$_GET['location']}}</strong>
            @endif

        @elseif(($_GET['space_prize']!='true') &&($_GET['location_status']=='true')&& ($_GET['status']!='true') && ($_GET['ind_fil']=='true'))
          <br><br>List of Registered Spaces at <strong>{{$_GET['location']}}</strong> Whose Major industry is <strong>{{$_GET['ind']}}</strong>

        @elseif(($_GET['space_prize']!='true') &&($_GET['location_status']=='true')&& ($_GET['status']!='true') && ($_GET['ind_fil']!='true'))
          <br><br>List of All Registered Spaces at <strong>{{$_GET['location']}}</strong>

        @elseif(($_GET['space_prize']!='true') &&($_GET['location_status']!='true')&& ($_GET['status']=='true') && ($_GET['ind_fil']=='true'))
            @if($_GET['space_status']=='1')
              <br><br>List of Occupied Spaces Whose Major industry is <strong>{{$_GET['ind']}}</strong>
            @elseif($_GET['space_status']=='0')
              <br><br>List of Vacant Spaces Whose Major industry is <strong>{{$_GET['ind']}}</strong>
            @endif

        @elseif(($_GET['space_prize']!='true') &&($_GET['location_status']!='true')&& ($_GET['status']=='true') && ($_GET['ind_fil']!='true'))
            @if($_GET['space_status']=='1')
              <br><br>List of Occupied Spaces
            @elseif($_GET['space_status']=='0')
              <br><br>List of Vacant Spaces
            @endif

        @elseif(($_GET['space_prize']!='true') &&($_GET['location_status']!='true')&& ($_GET['status']!='true') && ($_GET['ind_fil']=='true'))
            <br><br>List of Registered Spaces Whose Major industry is <strong>{{$_GET['ind']}}</strong>

        @elseif(($_GET['space_prize']!='true') &&($_GET['location_status']!='true')&& ($_GET['status']!='true') && ($_GET['ind_fil']!='true'))
            <br><br>List of All Registered Spaces
        @endif
    @endif
  @endif
    
    </center>
<br>
@if(count($spaces)>0)
    <table class="hover table table-striped table-bordered" id="myTable">
        <thead class="thead-dark">
        <tr>
          <th scope="col" style="width: 5%;"><center>S/N</center></th>
          <th scope="col"><center>Space Id</center></th>
          <th scope="col"><center>Major Industry</center></th>
           <th scope="col"><center>Minor Industry</center></th>
          <th scope="col" style="width: 20%"><center>Location</center></th>
          <th scope="col" ><center>Size (SQM)</center></th>
         {{--  <th scope="col" ><center>Currency</center></th> --}}
          <th scope="col" style="width: 20%"><center>Rent Price Guide</center></th>
        </tr>
        </thead>
        <tbody>

        @foreach($spaces as $var)
          <tr>

            <td scope="row" style="text-align: center;">{{$i}}.</td>
            <td>{{$var->space_id}}</td>
            <td>{{$var->major_industry}}</td>
            <td>{{$var->minor_industry}}</td>
            <td>{{$var->location}}</td>

            <td><center>  @if($var->size==null)
                  N/A
                @else
                  {{$var->size}}
                            @endif

              </center></td>
              {{-- <td><center>{{$var->rent_price_guide_currency}}</center></td> --}}
            <td style="text-align: center;">
              @if($var->rent_price_guide_from==null OR $var->rent_price_guide_to==null)
             <center> N/A</center>
              @else
               {{$var->rent_price_guide_currency}} {{number_format($var->rent_price_guide_from)}} - {{number_format($var->rent_price_guide_to)}}
              @endif
            </td>
        </tr>
        <?php $i=$i+1;?>
        @endforeach
    </tbody>
</table>
@else
<h3>Sorry No data found for the specified parameters</h3>
@endif

</body>
</html>