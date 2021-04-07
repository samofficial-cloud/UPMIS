@extends('layouts.app')

@section('style')
<style type="text/css">
  div.dataTables_filter{
    padding-left:878px;
    padding-bottom:20px;
  }

  div.dataTables_length label {
    font-weight: normal;
    text-align: left;
    white-space: nowrap;
    display: inline-block;
  }

  div.dataTables_length select {
    height:25px;
    width:10px;
    font-size: 70%;
  }
  table.dataTable {
    font-family:"Nunito", sans-serif;
    font-size: 15px;



  }
  table.dataTable.no-footer {
    border-bottom: 0px solid #111;
  }

  hr {
    margin-top: 0rem;
    margin-bottom: 2rem;
    border: 0;
    border-bottom: 2px solid #505559;
  }
  .form-inline .form-control {
    width: 100%;
  }

  .form-wrapper{
    width: 100%
  }

  .form-inline label {
    justify-content: left;
  }

/*  .card:hover {
    cursor: not-allowed;
    animation-duration: 20ms;
    animation-timing-function: linear;
    animation-iteration-count: 10;
    animation-name: wiggle;
  }*/

  @keyframes wiggle {
  0% { transform: translate(0px, 0); }
 /* 10% { transform: translate(-1px, 0); }
  20% { transform: translate(1px, 0); }
  30% { transform: translate(-1px, 0); }
  40% { transform: translate(1px, 0); }
  50% { transform: translate(-2px, 0); }
  60% { transform: translate(2px, 0); }
  70% { transform: translate(-2px, 0); }*/
  80% { transform: translate(2px, 0); }
  90% { transform: translate(-2px, 0); }
  100% { transform: translate(0, 0); }
}
</style>

@endsection
@section('content')
<div class="wrapper">
  <?php $a=1; $b=1; $c=1; $d=1; $i=1;?>
<div class="sidebar">
        <ul style="list-style-type:none;">

            <?php
            $category=DB::table('general_settings')->where('user_roles',Auth::user()->role)->value('category');
            ?>

            @if($category=='All')
           <li class="active_nav_item"><a href="/"><i class="fas fa-home active"></i>Home</a></li>
          @elseif($category=='Insurance only')
          <li><a href="{{ route('home2') }}"><i class="fas fa-home active"></i>Home</a></li>
          @elseif($category=='Real Estate only')
          <li><a href="{{ route('home4') }}"><i class="fas fa-home active"></i>Home</a></li>
          @elseif($category=='Research Flats only')
          <li><a href="{{ route('home6') }}"><i class="fas fa-home active"></i>Home</a></li>
           @endif
          @if(($category=='CPTU only') && (Auth::user()->role!='Vote Holder') && (Auth::user()->role!='Accountant-Cost Centre'))
          <li><a href="{{ route('home3') }}"><i class="fas fa-home active"></i>Home</a></li>
          @endif
          @if(($category=='CPTU only') && (Auth::user()->role=='Vote Holder') && (Auth::user()->role!='Accountant-Cost Centre'))
          <li><a href="{{ route('home5') }}"><i class="fas fa-home active"></i>Home</a></li>
          @endif
          @if(($category=='CPTU only') && (Auth::user()->role!='Vote Holder') && (Auth::user()->role=='Accountant-Cost Centre'))
            <li><a href="{{ route('home5') }}"><i class="fas fa-home active"></i>Home</a></li>
          @endif



                @if((Auth::user()->role!='Vote Holder')&&(Auth::user()->role!='Accountant-Cost Centre'))

                <li><a href="/businesses"><i class="fa fa-building" aria-hidden="true"></i> Businesses</a></li>
                @else
                @endif


    @if((Auth::user()->role!='Vote Holder')&&(Auth::user()->role!='Accountant-Cost Centre'))

            <li><a href="/clients"><i class="fas fa-user"></i>Clients</a></li>
    @endif
            <li><a href="/contracts_management"><i class="fas fa-file-contract"></i>Contracts</a></li>
            <li><a href="/invoice_management"><i class="fas fa-file-contract"></i>Invoices</a></li>

<li><a href="/payment_management"><i class="fas fa-money-bill"></i>Payments</a></li>
 @if((Auth::user()->role!='Vote Holder')&&(Auth::user()->role!='Accountant-Cost Centre'))
            <li><a href="/reports"><i class="fas fa-file-pdf"></i>Reports</a></li>
  @endif
                @admin
                <li><a href="/user_role_management"><i class="fas fa-user-friends hvr-icon" aria-hidden="true"></i>Manage Users</a></li>
                <li><a href="/system_settings"><i class="fa fa-cog pr-1" aria-hidden="true"></i>System settings</a></li>
                @endadmin
        </ul>
    </div>
<div class="main_content">
  <br>
  <div class="container" style="max-width: 100%;">
    <br>
    <h4><center>LOG SHEET</center></h4>
    <hr>
    @if ($message = Session::get('errors'))
          <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <p>{{$message}}</p>
          </div>
        @endif

      @if ($message = Session::get('success'))
      <div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <p>{{$message}}</p>
      </div>
    @endif
      <table class="hover table table-bordered" style="background: white; font-weight: bold; width: 80%;">
        <tr>
          <td style="width: 35%;">Type of Car: {{$model}} </td>
          <td style="width: 65%;">Car Number: {{$details->vehicle_reg_no}}</td>
        </tr>
        <tr>
          <td>Driver's Name: {{$details->driver_name}} </td>
          <td>Driver Contact Number: </td>
        </tr>
        <tr>
          <td>Name of User: {{$details->fullName}} </td>
          <td>College/School/Department/Unit: {{$details->faculty}}</td>
        </tr>
      </table>
    <form method="post" action="{{ route('addlogsheet') }}">
      {{csrf_field()}}
      <table class="hover table table-bordered  table-striped" id="myTable">
        <thead class="thead-dark">
          <th scope="col" style="color:#fff;"><center>SN</center></th>
          <th scope="col" style="color:#fff;"><center>Date</center></th>
          <th scope="col" style="color:#fff;"><center>Time Starting</center></th>
          <th scope="col" style="color:#fff;"><center>Mileage Out</center></th>
          <th scope="col" style="color:#fff;"><center>Time Closing</center></th>
          <th scope="col" style="color:#fff;"><center>Mileage In</center></th>
          {{-- <th scope="col" style="color:#fff;"><center>Driver's Sign</center></th>
          <th scope="col" style="color:#fff;"><center>Approve Sign</center></th> --}}
          <th scope="col" style="color:#fff;"><center>Mileage</center></th>
          <th scope="col" style="color:#fff;"><center>Standing Charge Hours</center></th>
          <th scope="col" style="color:#fff;"><center>Standing Charge in KM</center></th>
        </thead>
        <tbody>
          <th scope="row">{{ $i }}.</th>
          <td><input type="date" id="2" name="date2" class="form-control" required="" max="<?php echo(date('Y-m-d'))?>"></td>
          <td><input type="time" id="3" name="start_time3" class="form-control" required=""></td>
          <td><input type="text" id="4" name="mileage_out4" class="form-control mileage_out" required="" onkeypress="if((this.value.length<15)&&((event.charCode >= 48 && event.charCode <= 57) || (event.charCode==46))){return true} else return false;"></td>
          <td><input type="time" id="5" name="time_closing5" class="form-control" required=""></td>
          <td><input type="text" id="6" name="mileage_in6" class="form-control mileage_in" required="" onkeypress="if((this.value.length<15)&&((event.charCode >= 48 && event.charCode <= 57) || (event.charCode==46))){return true} else return false;"></td>
          {{-- <td></td>
          <td></td> --}}
          <td><input type="text" id="7" name="mileage7" class="form-control" required="" onkeypress="if((this.value.length<15)&&((event.charCode >= 48 && event.charCode <= 57) || (event.charCode==46))){return true} else return false;"></td>
          <td><input type="text" id="8" name="standing_hrs8" class="form-control" required="" onkeypress="if((this.value.length<15)&&((event.charCode >= 48 && event.charCode <= 57) || (event.charCode==46))){return true} else return false;"></td>
          <td><input type="text" id="9" name="standing_km9" class="form-control" required="" onkeypress="if((this.value.length<15)&&((event.charCode >= 48 && event.charCode <= 57) || (event.charCode==46))){return true} else return false;"></td>
        </tbody>
      </table>

      <input type="number" name="totalrows" id="totalrows" value="1" hidden=""/>
      <input type="text" name="contract_id" id="contract_id" value="{{$details->id}}" hidden=""/>

      <div align="left">
        <button type="button" class="btn btn-success" onclick="javascript:appendRow();">Add New Row</button>
        <button type="button" class="btn btn-danger" onclick="javascript:deleteRows();" style="display: none;" id="deleterowbutton">Delete Row</button>
        <button type="submit" class="btn btn-primary">Submit</button>
      </div>
    </form>
  </div>
</div>
</div>
@endsection

@section('pagescript')
<script type="text/javascript">
    function appendRow() {
        var tbl = document.getElementById('myTable'), // table reference
            row = tbl.insertRow(tbl.rows.length),      // append table row
            i;

      // insert table cells to the new row
        for (i = 0; i < tbl.rows[0].cells.length; i++){
          createCell(row.insertCell(i), i);
        }

      document.getElementById('deleterowbutton').style.display='inline-block';
      gettotalrows();
      y=0;
    }

    function createCell(cell, text) {
      var today={!! json_encode(date('Y-m-d')) !!};
      if(text==0){
        var a=document.getElementById('myTable').rows.length;
        var b=a-1;
        txt = document.createTextNode(b+'.');
        cell.appendChild(txt);
      }

      if(text == 1){
        var a=document.getElementById('myTable').rows.length,
        b=a-2,
        c=b*9,
        pointer=c+2;
      var div = document.createElement('input'); 
        div.setAttribute('type', 'date');
        div.setAttribute('class', 'form-control');
        div.setAttribute('name', 'date'+pointer);
        div.setAttribute('id', pointer);
        div.setAttribute('max', today);
        div.setAttribute('required', ' ');
        //div.setAttribute('onblur', "getdata((((document.getElementById('myTable').rows.length)-2)*5)+2)");
        cell.appendChild(div); 
      }

      if(text == 2){
        var a=document.getElementById('myTable').rows.length,
        b=a-2,
        c=b*9,
        pointer=c+3;
      var div = document.createElement('input'); 
        div.setAttribute('type', 'time');
        div.setAttribute('class', 'form-control');
        div.setAttribute('name', 'start_time'+pointer);
         div.setAttribute('id', pointer);
        div.setAttribute('required', ' ');
        cell.appendChild(div); 
      }

      if(text == 3){
        var a=document.getElementById('myTable').rows.length,
        b=a-2,
        c=b*9,
        pointer=c+4;
      var div = document.createElement('input'); 
        div.setAttribute('type', 'text');
        div.setAttribute('class', 'form-control mileage_out');
        div.setAttribute('name', 'mileage_out'+pointer);
        div.setAttribute('onblur', 'mileage_calc2('+pointer+')');
        div.setAttribute('id', pointer);
        div.setAttribute('onkeypress', "if((this.value.length<15)&&((event.charCode >= 48 && event.charCode <= 57) || (event.charCode==46))){return true} else return false;");
         div.setAttribute('required', ' '); 
        cell.appendChild(div); 
      }

      if(text == 4){
        var a=document.getElementById('myTable').rows.length,
        b=a-2,
        c=b*9,
        pointer=c+5;
      var div = document.createElement('input'); 
        div.setAttribute('type', 'time');
        div.setAttribute('class', 'form-control');
        div.setAttribute('name', 'time_closing'+pointer);
         div.setAttribute('id', pointer);
         div.setAttribute('required', ' '); 
        cell.appendChild(div); 
      }

      if(text == 5){
        var a=document.getElementById('myTable').rows.length,
        b=a-2,
        c=b*9,
        pointer=c+6;
      var div = document.createElement('input'); 
        div.setAttribute('type', 'text');
        div.setAttribute('class', 'form-control mileage_in');
        div.setAttribute('name', 'mileage_in'+pointer);
        div.setAttribute('id', pointer);
        div.setAttribute('onblur', 'mileage_calc('+pointer+')');
        div.setAttribute('onkeypress', "if((this.value.length<15)&&((event.charCode >= 48 && event.charCode <= 57) || (event.charCode==46))){return true} else return false;");
         div.setAttribute('required', ' '); 
        cell.appendChild(div); 
      }

       if(text == 6){
        var a=document.getElementById('myTable').rows.length,
        b=a-2,
        c=b*9,
        pointer=c+7;
      var div = document.createElement('input'); 
        div.setAttribute('type', 'text');
        div.setAttribute('class', 'form-control');
        div.setAttribute('name', 'mileage'+pointer);
         div.setAttribute('id', pointer);
        div.setAttribute('onkeypress', "if((this.value.length<15)&&((event.charCode >= 48 && event.charCode <= 57) || (event.charCode==46))){return true} else return false;");
         div.setAttribute('required', ' '); 
        cell.appendChild(div); 
      }

      if(text == 7){
        var a=document.getElementById('myTable').rows.length,
        b=a-2,
        c=b*9,
        pointer=c+8;
      var div = document.createElement('input'); 
        div.setAttribute('type', 'text');
        div.setAttribute('class', 'form-control');
        div.setAttribute('name', 'standing_hrs'+pointer);
         div.setAttribute('id', pointer);
        div.setAttribute('onkeypress', "if((this.value.length<15)&&((event.charCode >= 48 && event.charCode <= 57) || (event.charCode==46))){return true} else return false;");
         div.setAttribute('required', ' '); 
        cell.appendChild(div); 
      }

      if(text == 8){
        var a=document.getElementById('myTable').rows.length,
        b=a-2,
        c=b*9,
        pointer=c+9;
      var div = document.createElement('input'); 
        div.setAttribute('type', 'text');
        div.setAttribute('class', 'form-control');
        div.setAttribute('name', 'standing_km'+pointer);
         div.setAttribute('id', pointer);
        div.setAttribute('onkeypress', "if((this.value.length<15)&&((event.charCode >= 48 && event.charCode <= 57) || (event.charCode==46))){return true} else return false;");
         div.setAttribute('required', ' '); 
        cell.appendChild(div); 
      }
                    
}

function deleteRows() {
        var tbl = document.getElementById('myTable'),
            lastRow = tbl.rows.length - 1;
            tbl.deleteRow(lastRow);
        var newlastRow=tbl.rows.length - 1;

        if(newlastRow<=1){
          document.getElementById('deleterowbutton').style.display='none';
        }

        gettotalrows();
        y=1;
}

function gettotalrows(){
  var x= ((document.getElementById('myTable').rows.length)-1);
  document.getElementById('totalrows').value=x;
}

function mileage_calc(ids){
    var value = $('#'+ids).val();
   var id = ids,
        id2 = parseInt(id) - 2,
        id3 = parseInt(id) + 1,
        id4 = parseInt(id) + 2,
        id5 = parseInt(id) + 3;

  if(value!=""){
    var value2 = $('#'+id2).val();
    if(value2!=""){
      var mileage = Math.abs(value - value2);
      $('#'+id3).val(mileage);
      var area={!! json_encode($details->area_of_travel) !!};
      if(area=='Within'){
        $('#'+id5).val('0');
      }
      else if(area=='Outside'){
        $('#'+id4).val('0');
        if(mileage>100){
          $('#'+id5).val('10000');
        }
        else if(mileage<100){
           $('#'+id5).val('50000');
        }
      }
        
    }
  }
}

function mileage_calc2(ids){
   var value = $('#'+ids).val();
   var id = ids,
        id2 = parseInt(id) + 2,
        id3 = parseInt(id) + 3,
        id4 = parseInt(id) + 4,
        id5 = parseInt(id) + 5;

        if(value!=""){
          var value2 = $('#'+id2).val();
            if(value2!=""){
              var mileage = Math.abs(value2 - value);
              $('#'+id3).val(mileage);
              var area={!! json_encode($details->area_of_travel) !!};
              if(area=='Within'){
                $('#'+id5).val('0');
              }
              else if(area=='Outside'){
                $('#'+id4).val('0');
                    if(mileage>100){
                      $('#'+id5).val('10000');
                    }
                    else if(mileage<100){
                       $('#'+id5).val('50000');
                    }
              }
            }
        }
}

$('.mileage_in').blur(function(e){
  
  var value = $(this).val();
   var id = e.target.id,
        id2 = parseInt(id) - 2,
        id3 = parseInt(id) + 1,
        id4 = parseInt(id) + 2,
        id5 = parseInt(id) + 3;

  if(value!=""){
    var value2 = $('#'+id2).val();
    if(value2!=""){
      var mileage = Math.abs(value - value2);
      $('#'+id3).val(mileage);
      var area={!! json_encode($details->area_of_travel) !!};
      if(area=='Within'){
        $('#'+id5).val('0');
      }
      else if(area=='Outside'){
        $('#'+id4).val('0');
        if(mileage>100){
          $('#'+id5).val('10000');
        }
        else if(mileage<100){
           $('#'+id5).val('50000');
        }
      }
        
    }
  }
})

$('.mileage_out').blur(function(e){
  var value = $(this).val();
   var id = e.target.id,
        id2 = parseInt(id) + 2,
        id3 = parseInt(id) + 3,
        id4 = parseInt(id) + 4,
        id5 = parseInt(id) + 5;

        if(value!=""){
          var value2 = $('#'+id2).val();
            if(value2!=""){
              var mileage =Math.abs(value2 - value);
              $('#'+id3).val(mileage);
              var area={!! json_encode($details->area_of_travel) !!};
              if(area=='Within'){
                $('#'+id5).val('0');
              }
              else if(area=='Outside'){
                $('#'+id4).val('0');
                    if(mileage>100){
                      $('#'+id5).val('10000');
                    }
                    else if(mileage<100){
                       $('#'+id5).val('50000');
                    }
              }
            }
        }

})
</script>

@endsection