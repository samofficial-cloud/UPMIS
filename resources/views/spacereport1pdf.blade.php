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
      use App\space;
      use App\space_contract;
      $today= date('Y-m-d');
      if($_GET['module']=='space'){
      	if($_GET['space_type']=='list'){
      		if(($_GET['space_prize']=='true') && ($_GET['status']=='true') &&($_GET['location_status']=='true')){
            if($_GET['space_status']=='1'){
            $space=space::where('status','1')->where('location',$_GET['location'])->get();
        foreach ($space as $var){
            $active= space_contract::select('location','size','rent_price_guide','space_id','space_type')->join('spaces','spaces.space_id', '=', 'space_contracts.space_id_contract')->where('space_id_contract',$var->space_id)->where('spaces.min_price','>=',$_GET['min_price'])->where('spaces.max_price','<=',$_GET['max_price'])->whereDate('end_date', '>=', $today)->distinct()->get();
            $spaces[]=$active;
        }
        $spaces=array_flatten($spaces);
        
            }
            elseif($_GET['space_status']=='0'){
               $space=space::where('status','1')->where('location',$_GET['location'])->where('min_price','>=',$_GET['min_price'])->where('max_price','<=',$_GET['max_price'])->get();
              foreach($space as $var){
                $inactive=space_contract::where('space_id_contract',$var->space_id)->whereDate('end_date', '>=', $today)->get();
                
                if(count($inactive)==0){
                  $space2[]=$var->space_id;
                }else
                {   
                
              }
                }
                foreach($space2 as $var){
                  $space3=space::where('space_id',$var)->get();
                  $spaces[]=$space3;
                }
                 $spaces=array_flatten($spaces);
            }
            
      			}

      			if(($_GET['space_prize']=='true') &&($_GET['location_status']=='true')&& ($_GET['status']!='true')){
      				$spaces=space::where('min_price','>=',$_GET['min_price'])->where('max_price','<=',$_GET['max_price'])->where('status','1')->where('location',$_GET['location'])->get();
      			}

            if(($_GET['space_prize']=='true') &&($_GET['location_status']!='true')&& ($_GET['status']=='true')){
               if($_GET['space_status']=='1'){
            $space=space::where('status','1')->get();
        foreach ($space as $var){
            $active= space_contract::select('location','size','rent_price_guide','space_id','space_type')->join('spaces','spaces.space_id', '=', 'space_contracts.space_id_contract')->where('space_id_contract',$var->space_id)->where('min_price','>=',$_GET['min_price'])->where('max_price','<=',$_GET['max_price'])->whereDate('end_date', '>=', $today)->distinct()->get();
            $spaces[]=$active;
        }
        $spaces=array_flatten($spaces);
        
            }
            elseif($_GET['space_status']=='0'){
               $space=space::where('status','1')->where('min_price','>=',$_GET['min_price'])->where('max_price','<=',$_GET['max_price'])->get();
              foreach($space as $var){
                $inactive=space_contract::where('space_id_contract',$var->space_id)->whereDate('end_date', '>=', $today)->get();
                
                if(count($inactive)==0){
                  $space2[]=$var->space_id;
                }else
                {
                 
                
              }
             
                }
               

                foreach($space2 as $var){
                  $space3=space::where('space_id',$var)->get();
                  $spaces[]=$space3;
                }
                 $spaces=array_flatten($spaces);
                

            }
            }

            if(($_GET['space_prize']=='true') &&($_GET['location_status']!='true')&& ($_GET['status']!='true')){
              $spaces=space::where('min_price','>=',$_GET['min_price'])->where('max_price','<=',$_GET['max_price'])->where('status','1')->get();
            }
      			
      		
          if(($_GET['space_prize']!='true') && ($_GET['location_status']=='true') && ($_GET['status']=='true')){
            if($_GET['space_status']=='1'){
            $space=space::where('status','1')->where('location',$_GET['location'])->get();
        foreach ($space as $var){
            $active= space_contract::select('location','size','rent_price_guide','space_id','space_type')->join('spaces','spaces.space_id', '=', 'space_contracts.space_id_contract')->where('space_id_contract',$var->space_id)->whereDate('end_date', '>=', $today)->distinct()->get();
            $spaces[]=$active;
            
        }
        $spaces=array_flatten($spaces);
            }

            elseif($_GET['space_status']=='0'){
               $space=space::where('status','1')->where('location',$_GET['location'])->get();
              foreach($space as $var){
                $inactive=space_contract::where('space_id_contract',$var->space_id)->whereDate('end_date', '>=', $today)->get();
                
                if(count($inactive)==0){
                  $space2[]=$var->space_id;
                }else
                {
                 
                
              }
             
                }
               

                foreach($space2 as $var){
                  $space3=space::where('space_id',$var)->get();
                  $spaces[]=$space3;
                }
                 $spaces=array_flatten($spaces);
                

            }
            
            
          }

          if(($_GET['space_prize']!='true')&&($_GET['location_status']=='true') && ($_GET['status']!='true')){
            $spaces=space::where('status','1')->where('location',$_GET['location'])->get();
          }

          if(($_GET['space_prize']!='true')&&($_GET['location_status']!='true') && ($_GET['status']=='true')){
            if($_GET['space_status']=='1'){
            $space=space::where('status','1')->get();
        foreach ($space as $var){
            $active= space_contract::select('location','size','rent_price_guide','space_id','space_type')->join('spaces','spaces.space_id', '=', 'space_contracts.space_id_contract')->where('space_id_contract',$var->space_id)->whereDate('end_date', '>=', $today)->distinct()->get();
            $spaces[]=$active;
            
        }
        $spaces=array_flatten($spaces);
            }

            elseif($_GET['space_status']=='0'){
               $space=space::where('status','1')->get();
              foreach($space as $var){
                $inactive=space_contract::where('space_id_contract',$var->space_id)->whereDate('end_date', '>=', $today)->get();
                
                if(count($inactive)==0){
                  $space2[]=$var->space_id;
                }else
                {
                 
                
              }
             
                }
               

                foreach($space2 as $var){
                  $space3=space::where('space_id',$var)->get();
                  $spaces[]=$space3;
                }
                 $spaces=array_flatten($spaces);
                

            }
            
          }

          if(($_GET['status']!='true') &&($_GET['location_status']!='true')&& ($_GET['space_prize']!='true')){
            $spaces=space::where('status','1')->get();
          }
          
      	}
      }
	?>
	<center>
	<b>UNIVERSITY OF DAR ES SALAAM<br><br>
	<img src="{{public_path('/images/logo_udsm.jpg')}}" height="70px"></img>
     <br>DIRECTORATE OF PLANNING, DEVELOPMENT AND INVESTIMENT  
    </b>
    @if($_GET['module']=='space')
    @if($_GET['space_type']=='list')
    @if(($_GET['space_prize']=='true') &&($_GET['location_status']=='true')&& ($_GET['status']=='true'))
    @if($_GET['space_status']=='1')
    <br><br><strong>List of Occupied Spaces at {{$_GET['location']}}Whose Price Range Between{{$_GET['min_price']}} and {{$_GET['max_price']}}</strong>
    @elseif($_GET['space_status']=='0')
    <br><br><strong>List of Vacant Spaces at {{$_GET['location']}} Whose Price Range Between{{$_GET['min_price']}} and {{$_GET['max_price']}}</strong>
    @endif
    @endif
    @if(($_GET['space_prize']=='true') &&($_GET['location_status']=='true')&& ($_GET['status']!='true'))
    <br><br><strong>List of Spaces at {{$_GET['location']}} Whose Price Range Between{{$_GET['min_price']}} and {{$_GET['max_price']}}</strong>
    @endif
    @if(($_GET['space_prize']=='true')&&($_GET['location_status']!='true')&&($_GET['status']=='true'))
    @if($_GET['space_status']=='1')
    <br><br><strong>List of Occupied Spaces Whose Price Range Between{{$_GET['min_price']}} and {{$_GET['max_price']}}</strong>
    @elseif($_GET['space_status']=='0')
     <br><br><strong>List of Vacant Spaces Whose Price Range Between{{$_GET['min_price']}} and {{$_GET['max_price']}}</strong>
    @endif
    @endif
    @if(($_GET['space_prize']=='true') &&($_GET['location_status']!='true')&& ($_GET['status']!='true'))
     <br><br><strong>List of Spaces Whose Price Range Between{{$_GET['min_price']}} and {{$_GET['max_price']}}</strong>
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

            <td class="counterCell text-center">.</td>
            <td><center>{{$var->space_id}}</center></td>
            <td><center>{{$var->space_type}}</center></td>
            <td><center>{{$var->location}}</center></td>

            <td><center>  @if($var->size==null)
                  N/A
                @else
                  {{$var->size}}
                            @endif

              </center></td>
            <td><center>{{$var->rent_price_guide}}</center></td>
        </tr>
        @endforeach
    </tbody>
</table>
@else
<h3>Sorry No data found for the specified parameters</h3>
@endif

</body>
</html>