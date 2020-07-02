@extends('layouts.app')

@section('style')
<style type="text/css">
  #msform {
    text-align: center;
    position: relative;
    margin-top: 20px
}

#msform fieldset .form-card {
    background: white;
    border: 0 none;
    border-radius: 0px;
    box-shadow: 0 2px 2px 2px rgba(0, 0, 0, 0.2);
    padding: 20px 40px 30px 40px;
    box-sizing: border-box;
    width: 94%;
    margin: 0 3% 20px 3%;
    position: relative
}

#msform fieldset {
    background: white;
    border: 0 none;
    border-radius: 0.5rem;
    box-sizing: border-box;
    width: 100%;
    margin: 0;
    padding-bottom: 20px;
    position: relative
}

#msform fieldset:not(:first-of-type) {
    display: none
}

#msform fieldset .form-card {
    text-align: left;
    color: #9E9E9E
}

#msform input,
#msform textarea {
    padding: 0px 8px 4px 8px;
    border: none;
    border-bottom: 1px solid #ccc;
    border-radius: 0px;
    margin-bottom: 25px;
    margin-top: 2px;
    width: 100%;
    box-sizing: border-box;
    /*font-family: montserrat;*/
    color: #2C3E50;
    font-size: 16px;
    letter-spacing: 1px
}

#msform input:focus,
#msform textarea:focus {
    -moz-box-shadow: none !important;
    -webkit-box-shadow: none !important;
    box-shadow: none !important;
    border: none;
    font-weight: bold;
    border-bottom: 2px solid skyblue;
    outline-width: 0
}

#msform .action-button {
    width: 100px;
    background: skyblue;
    font-weight: bold;
    color: white;
    border: 0 none;
    border-radius: 0px;
    cursor: pointer;
    padding: 10px 5px;
    margin: 10px 5px
}

#msform .action-button:hover,
#msform .action-button:focus {
    box-shadow: 0 0 0 2px white, 0 0 0 3px skyblue
}

select.list-dt {
    border: none;
    outline: 0;
    border-bottom: 1px solid #ccc;
    padding: 2px 5px 3px 5px;
    margin: 2px
}

select.list-dt:focus {
    border-bottom: 2px solid skyblue
}

.card {
    z-index: 0;
    border: none;
    border-radius: 0.5rem;
    position: relative
}

</style>

@endsection

@section('content')
<div class="wrapper">
<div class="sidebar">
        <ul style="list-style-type:none;">

            <li><a href="/"><i class="fas fa-home active"></i>Home</a></li>

            <li><a href="/Space"><i class="fas fa-building"></i>Space</a></li>
            <li><a href="#"><i class="fas fa-address-card"></i>Insurance</a></li>
            <li><a href="#"><i class="fas fa-car-side"></i>Car Rental</a></li>
            <li><a href="/clients"><i class="fas fa-user"></i>Clients</a></li>
            <div class="dropdown">
  <li class="dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
   <i class="fas fa-file-contract"></i> Contracts
  </li>
  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
    <a class="dropdown-item" href="/contracts/car_rental">Car Rental</a>
    <a class="dropdown-item" href="#">Insurance</a>
    <a class="dropdown-item" href="#">Space</a>
  </div>
</div>
            <li><a href="#"><i class="fas fa-file-invoice"></i>Invoice</a></li>
            <li><a href="#"><i class="fas fa-money-bill"></i>Payment</a></li>
            <li><a href="/reports"><i class="fas fa-file-pdf"></i>Reports</a></li>
        </ul> 
    </div>
<div class="main_content">
<div class="container-fluid" id="grad1">
    <div class="row justify-content-center mt-0">
        <div class="col-12 col-sm-9 col-md-7 col-lg-9 text-center p-0 mt-3 mb-2">
            <div class="card px-0 pt-4 pb-0 mt-3 mb-3">
                <h2><strong>Report Generation</strong></h2>
                <p>Fill all form field with (*)</p>
                <div class="row">
                    <div class="col-md-12 mx-0">
                        <form id="msform" method="post" action="#">
                            {{csrf_field()}}
                            
                             <!-- fieldsets -->
                            <fieldset>
                                <div class="form-card">
                          <div class="form-group" id="modulediv">
          <div class="form-wrapper" >
          <label for="module">Module*</label>
            <select class="form-control" required="" id="module" name="module">
              <option value="" disabled selected hidden>Select Module</option>
              <option value="car">Car Rental Module</option>
              <option value="contract">Contracts Module</option>
              <option value="insurance">Insurance Module</option>
              <option value="invoice">Invoice Module</option>
              <option value="payment">Payments Module</option>
              <option value="space">Space Module</option>
              <option value="tenant">Tenants Module</option>
            </select>
        </div>
    </div>

    <div class="form-group" id="spacetypediv" style="display: none;">
          <div class="form-wrapper">
          <label for="space_type">Select Report Type*</label>
          <span id="spacetypemsg"></span>
            <select class="form-control" id="space_type" name="space_type">
              <option value=" " disabled selected hidden>Select Report Type</option>
              <option value="list">List of Spaces</option>
              <option value="history">Space History</option>
            </select>
        </div>
    </div>

    
      <div class="form-group" id="spacefilterdiv" style="display: none;">
        <div class="form-wrapper"> 
      <label for="space_filter" style=" display: inline-block; white-space: nowrap;">Apply Filter
      <input id="space_filter" type="checkbox" name="space_filter" style="margin-bottom: 15px;" value="true"></label>
    
      </div>
    </div>

    <div class="form-group" id="space_idDiv" style="display: none;">
      <div class="form-wrapper">
      <label for="space_id"  >Space Id*</label>
      <span id="spaceidmsg"></span>
      <input type="text" class="form-control" id="space_id" name="space_id" value="">
      <div id="nameListSpaceId"></div>
      </div>
    </div>

    <div class="form-group" id="spacefilterBydate" style="display: none;">
        <div class="form-wrapper"> 
      <label for="space_filter_date" style=" display: inline-block; white-space: nowrap;">Filter By Date
      <input id="space_filter_date" type="checkbox" name="space_filter_date" style="margin-bottom: 15px;" value="true"></label>
    
      </div>
    </div>

      

    <div class="form-group" id="spacefilterBydiv" style="display: none;">
      <div class="form-wrapper">
                  <label for="Criteria">Filter By</label>
                  <div class="row">
{{-- 
                    <div class="form-wrapper col-2">
                  <label for="date" style=" display: block;
    white-space: nowrap;">Date
                  <input class="form-check-input" type="radio" name="Selection" id="date" value="date">
                </label>
                 </div> --}}

                  <div class="form-wrapper col-2" id="spacefilterprize">
                  <label for="prize" style=" display: block;
    white-space: nowrap;">Prize
                  <input class="form-check-input" type="checkbox" name="space_prize" id="space_prize" value="">
                </label>
                 </div>

                 <div class="form-wrapper col-2"> 
                  <label for="Status" style=" display: block;
    white-space: nowrap;">Occupation Status
                   <input class="form-check-input" type="checkbox" name="status" id="Status" value="">
                   </label>           
                </div>

               
               </div>
             </div>
           </div>


           <div class="form-group row" id="spacedatediv" style="display: none;">
            <div class="form-wrapper col-6">
              <label for="start_date">From*</label>
              <span id="startdatemsg"></span>
              <input type="date" id="start_date" name="start_date" class="form-control" max="<?php echo(date('Y-m-d'))?>">
            </div>
            <div class="form-wrapper col-6">
              <label for="end_date">To*</label>
              <span id="enddatemsg"></span>
              <input type="date" id="end_date" name="end_date" class="form-control" max="<?php echo(date('Y-m-d'))?>">
            </div>
          </div>

          <div class="form-group row" id="spacepricediv" style="display: none;">
            <div class="form-wrapper col-6">
              <label for="min_price">Min Price*</label>
              <span id="minpricemsg"></span>
              <input type="number" id="min_price" name="min_price" class="form-control" value="">
            </div>
            <div class="form-wrapper col-6">
              <label for="max_price">Max Price*</label>
              <span id="maxpricemsg"></span>
              <input type="number" id="max_price" name="max_price" class="form-control" value=" " >
            </div>
          </div>

          <div class="form-group" id="spaceoccupationdiv" style="display: none;">
          <div class="form-wrapper">
          <label for="space_status">Occupation Status*</label>
          <span id="spacestatusmsg"></span>
            <select class="form-control" id="space_status" name="space_status">
              <option value="" disabled selected hidden> Select Occupation Status</option>
              <option value="occupied">Occupied</option>
              <option value="vacant">Vacant</option>
            </select>
        </div>
    </div>

    
  </div>
  <div>
  <button class="btn btn-primary" type="submit" id="submitbutton">Submit</button>
  <button class="btn btn-danger" type="button" onclick="history.back()">Back</button>
     </div>
</fieldset>
</form>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
@endsection


@section('pagescript')
<script type="text/javascript">
  $(document).ready(function(){
   $("#module").click(function(){
     var query = $(this).val();
     if(query=='space'){
      $('#spacetypediv').show();
      //$('#spacefilterdiv').show();
     }
    });

   $("#space_type").click(function(){
     var query = $(this).val();
     if(query=='list'){
      $('#space_idDiv').hide();
      $('#spacefilterBydiv').show();
      $('#spacefilterBydate').hide();
      $('#spacedatediv').hide();
      $('#start_date').val("");
      $('#end_date').val("");
      $('#space_id').val("");
      $("input[name='space_filter_date']:checked").prop("checked", false);
     }
     else if(query=='history'){
      $('#spacefilterBydate').show();
      $('#space_idDiv').show();
      $('#spacefilterBydiv').hide();
      $('#spacepricediv').hide();
      $('#spaceoccupationdiv').hide();
      $("input[name='space_filter']:checked").prop("checked", false);
      $("input[name='space_prize']:checked").prop("checked", false);
      $("input[name='status']:checked").prop("checked", false);
      $('#min_price').val("");
      $('#max_price').val("");
      $('#space_status').val("");
      $('#start_date').val("");
      $('#end_date').val("");
     }
     else{
      $('#space_idDiv').hide();
      $('#spacefilterBydate').hide();
      $('#spacepricediv').hide();
      $('#spaceoccupationdiv').hide();
     }

     });

   $("#space_filter").click(function(){
    if($(this).is(":checked")){
      $('#spacefilterBydiv').show();
    }
    else{
      $('#spacefilterBydiv').hide();
      $('#spacepricediv').hide();
      $('#spaceoccupationdiv').hide();
      $('#spacedatediv').hide();
      $("input[name='space_prize']:checked").prop("checked", false);
      $("input[name='status']:checked").prop("checked", false);
      $('#min_price').val("");
      $('#max_price').val("");
      $('#space_status').val("");
      $('#start_date').val("");
      $('#end_date').val("");
    }
    });

   $("#space_filter_date").click(function(){
    if($(this).is(":checked")){
      $('#spacedatediv').show();
    }
    else{
       $('#spacedatediv').hide();
       $('#start_date').val("");
       $('#end_date').val("");
    }

    });

   $("#space_prize").click(function(){
      if($(this).is(":checked")){
      $("#space_prize").val("true");
      $('#spacepricediv').show();
    }
    else{
      $('#spacepricediv').hide();
      $('#min_price').val("");
      $('#max_price').val("");
      $("#space_prize").val("");
    }
    });

   $("#Status").click(function(){
    if($(this).is(":checked")){
       $("#Status").val("true");
      $('#spaceoccupationdiv').show();
    }
    else{
      $("#Status").val("");
      $('#spaceoccupationdiv').hide();
      $('#space_status').val("");
    }

    });


   // $("#spacefilterBydiv").click(function(){
   //  var checkboxValue = $("input[name='Selection']:checked").val();
   //  if(checkboxValue=='date'){
   //    $('#spacedatediv').show();
   //     $('#spacepricediv').hide();
   //     $('#spaceoccupationdiv').hide();
   //     $('#min_price').val("");
   //     $('#max_price').val("");
   //     $('#space_status').val("");
   //  }
   //  else if(checkboxValue=='prize'){
   //    $('#spacepricediv').show();
   //    $('#spacedatediv').hide();
   //    $('#spaceoccupationdiv').hide();
   //    $('#start_date').val("");
   //    $('#end_date').val("");
   //    $('#space_status').val("");
   //  }
   //  else if(checkboxValue=='status'){
   //    $('#spaceoccupationdiv').show();
   //    $('#spacepricediv').hide();
   //    $('#spacedatediv').hide();
   //    $('#start_date').val("");
   //    $('#end_date').val("");
   //    $('#min_price').val("");
   //    $('#max_price').val("");
   //  }

   //  });
var a;
   $('#space_id').keyup(function(e){
    e.preventDefault();
        var query = $(this).val();
        if(query != ''){
         var _token = $('input[name="_token"]').val();
         $.ajax({
          url:"{{ route('autocomplete.spaces') }}",
          method:"POST",
          data:{query:query, _token:_token},
          success:function(data){
            if(data=='0'){
             $('#space_id').attr('style','border:1px solid #f00');
             a = '0';
            }
            else{
              a ='1';
              //$('#message2').hide();
              $('#space_id').attr('style','border:1px solid #ced4da'); 
              $('#nameListSpaceId').fadeIn();  
              $('#nameListSpaceId').html(data);
          }
        }
         });
        }
        else if(query==''){
          a ='1';
              //$('#message2').hide();
              $('#space_id').attr('style','border:1px solid #ced4da');
        }
     

    });

   $(document).on('click', '#list', function(){
   a ='1';
   //$('#message2').hide();
  $('#space_id').attr('style','border:1px solid #ced4da');

        $('#space_id').val($(this).text());      
        $('#nameListSpaceId').fadeOut();

        });

   $(document).on('click', 'form', function(){
     $('#nameListSpaceId').fadeOut();  
    }); 

   $("#submitbutton").click(function(e){
       e.preventDefault();
       var p1,p2,p3,p4,p5,p6,p7;
       var query = $("#module").val();

       if(query=='space'){
        var query2 = $("#space_type").val();
        console.log(query2);
        if(query2==null){
          p1=0;
          $('#spacetypemsg').show();
             var message=document.getElementById('spacetypemsg');
             message.style.color='red';
             message.innerHTML="Required";
             $('#space_type').attr('style','border:1px solid #f00');
        }

        else if(query2=='list'){
          p1=1;
         if($('#space_prize').is(":checked")){
          var query3=$("#min_price").val();
          var query4=$("#max_price").val();
          if(query3==""){
            p2=0;
            $('#minpricemsg').show();
             var message=document.getElementById('minpricemsg');
             message.style.color='red';
             message.innerHTML="Required";
             $('#min_price').attr('style','border-bottom:1px solid #f00');
          }
          else{
            p2=1;
            $('#minpricemsg').hide();
            $('#min_price').attr('style','border-bottom: 1px solid #ccc');
          }

          if(query4==""){
            p3=0;
            $('#maxpricemsg').show();
             var message=document.getElementById('maxpricemsg');
             message.style.color='red';
             message.innerHTML="Required";
             $('#max_price').attr('style','border-bottom:1px solid #f00');
          }
          else{
            p3=1;
            $('#maxpricemsg').hide();
            $('#max_price').attr('style','border-bottom: 1px solid #ccc');
          }

         }
         else{
          p2=1;
          p3=1;
         }

         if($('#Status').is(":checked")){
          var query5=$('#space_status').val();
          console.log(query5);
          if(query5==null){
            p4=0;
             $('#spacestatusmsg').show();
             var message=document.getElementById('spacestatusmsg');
             message.style.color='red';
             message.innerHTML="Required";
             $('#space_status').attr('style','border:1px solid #f00');
          }
          else{
            p4=1;
            $('#spacestatusmsg').hide();
            $('#space_status').attr('style','border: 1px solid #ccc');
          }

         }
         else{
          p4=1;
         }

         if(p1==1&& p2==1 && p3==1 &&p4==1){
          $.ajaxSetup({
      headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    }); 

          var _token = $('input[name="_token"]').val();
          var postData = "module="+ query+ "&space_type="+ query2+ "&min_price=" + query3 + "&max_price=" +query4 + "&space_status=" +query5+"&space_prize="+$('#space_prize').val()+"&status="+ $('#Status').val();

            $.ajax({
            url: "{{ route('home') }}",
            method:"GET",
            data: postData,
            contentType: "application/x-www-form-urlencoded",
            success: function(data) {
                window.location.href = "/reports/space1/pdf?"+postData;
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });

         }
       }
       else if (query2=='history'){
        p1=1;
        var query6=$('#space_id').val();
        console.log(query6);
        if(query6==""){
          p5=0;
          $('#spaceidmsg').show();
          var message=document.getElementById('spaceidmsg');
           message.style.color='red';
           message.innerHTML="Required";
           $('#space_id').attr('style','border-bottom:1px solid #f00');
        }
        else{
          p5=1;
          $('#spaceidmsg').hide();
          $('#space_id').attr('style','border-bottom: 1px solid #ccc');
        }

         if($('#space_filter_date').is(":checked")){
          var query7=$('#start_date').val();
          var query8=$('#end_date').val();
          if(query7==""){
            p6=0;
          $('#startdatemsg').show();
          var message=document.getElementById('startdatemsg');
           message.style.color='red';
           message.innerHTML="Required";
           $('#start_date').attr('style','border-bottom:1px solid #f00');
          }
          else{
            p6=1;
          $('#startdatemsg').hide();
          $('#start_date').attr('style','border-bottom: 1px solid #ccc');
          }

          if(query8==""){
            p7=0;
            $('#enddatemsg').show();
          var message=document.getElementById('enddatemsg');
           message.style.color='red';
           message.innerHTML="Required";
           $('#end_date').attr('style','border-bottom:1px solid #f00');
          }
          else{
            p7=1;
          $('#enddatemsg').hide();
          $('#end_date').attr('style','border-bottom: 1px solid #ccc');
          }

         }
         else{
          p6=1;
          p7=1;
         }



       }
       else{
        p1=0;
                $('#spacetypemsg').hide();
                $('#space_type').attr('style','border: 1px solid #ccc');  
        }
       }


       

    });

    });
</script>

@endsection