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
    font-family: "Nunito", sans-serif;
    font-size: 15px;



  }
  table.dataTable.no-footer {
    border-bottom: 0px solid #111;
  }

  hr {
    margin-top: 0rem;
    margin-bottom: 2rem;
    border: 0;
    border: 2px solid #505559;
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
</style>

<style>
  tfoot {
    display: table-header-group;
  }
</style>

@endsection

@section('content')
<div class="wrapper">
<div class="sidebar">
        <ul style="list-style-type:none;">

            <?php
            $category=DB::table('general_settings')->where('user_roles',Auth::user()->role)->value('category');
            ?>
            <li><a href="/"><i class="fas fa-home active"></i>Home</a></li>

            @if($category=='Real Estate only' OR $category=='All')
            <li><a href="/Space"><i class="fas fa-building"></i>Space</a></li>
            @else
            @endif
            @if($category=='Insurance only' OR $category=='All')
            <li><a href="/insurance"><i class="fas fa-address-card"></i>Insurance</a></li>
    @else
    @endif
            @if($category=='CPTU only' OR $category=='All')
            <li><a href="/car"><i class="fas fa-car-side"></i>Car Rental</a></li>
    @else
    @endif
            <li><a href="/clients"><i class="fas fa-user"></i>Clients</a></li>
            <li><a href="/contracts_management"><i class="fas fa-file-contract"></i>Contracts</a></li>
            <li><a href="/invoice_management"><i class="fas fa-file-contract"></i>Invoices</a></li>

<li><a href="/payment_management"><i class="fas fa-money-bill"></i>Payments</a></li>
            <li><a href="/reports"><i class="fas fa-file-pdf"></i>Reports</a></li>
@admin
            <li><a href="/user_role_management"><i class="fas fa-user-friends hvr-icon" aria-hidden="true"></i>Manage Users</a></li>
<li><a href="/system_settings"><i class="fa fa-cog pr-1" aria-hidden="true"></i>System settings</a></li>
          @endadmin
        </ul>
    </div>

    <div class="main_content">
      <div class="container " style="max-width: 1308px;">
        @if (session('error'))
          <div class="alert alert-danger row col-xs-12" style="margin-left: -13px; margin-bottom: -1px; margin-top: 4px;">
            {{ session('error') }}
            <br>
          </div>
        @endif

          @if ($message = Session::get('success'))
            <div class="alert alert-success row col-xs-12" style="margin-left: -13px; margin-bottom: -1px; margin-top: 4px;">
              <p>{{$message}}</p>
            </div>
          @endif


        <p class="mt-1" style="font-size:30px !important;">Real Estate Settings</p>
        <hr style="    border-bottom: 1px solid #e5e5e5 !important;">







<br>



<span>Payment cycle options: </span>&nbsp;&nbsp;&nbsp;<span><a href="/payment_cycle_options">Change</a>

            <div class="modal fade" id="add_user" role="dialog">

            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <b><h5 class="modal-title">Adding new user</h5></b>

                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                  <form method="post" action="{{ route('add_user')}}"  id="form1" >
                    {{csrf_field()}}


                    <div class="form-group">
                      <div class="form-wrapper">
                        <label for="first_name"  ><strong>First Name <span style="color: red;"> *</span></strong></label>
                        <input type="text" class="form-control"  name="first_name" value="" required autocomplete="off">

                      </div>
                    </div>
                    <br>


                    <div id="descriptionDivEdit"  class="form-group">
                      <div class="form-wrapper">
                        <label for=""  ><strong>Last Name <span style="color: red;"> *</span></strong></label>
                        <input type="text" class="form-control" id="" name="last_name" value="" required  autocomplete="off">
                      </div>
                    </div>
                    <br>


                    <div class="form-group">
                      <div class="form-wrapper">
                        <label for="" ><strong>Email <span style="color: red;"> *</span></strong></label>
                        <input type="email" class="form-control" id="" name="email" value="" Required autocomplete="off">
                      </div>
                    </div>
                    <br>



                    <div class="form-group">
                      <div class="form-wrapper">
                        <label for="space_location"  ><strong>Phone Number <span style="color: red;"> *</span></strong></label>
                        <span id="phone_msg"></span>
                        <input type="text" id="phone_number" value="" required name="phone_number" class="form-control" placeholder="0xxxxxxxxxx" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength = "10"  minlength = "10" onkeypress="if(this.value.length<10){return event.charCode >= 48 && event.charCode <= 57} else return false;">
                      </div>
                    </div>
                    <br>





                    <div class="form-group">
                      <div class="form-wrapper">
                        <label for="space_location"  ><strong>Role <span style="color: red;"> *</span></strong></label>
                        <select required class="form-control" name="role" onchange="SelectCheck(this)" >
                          <?php
                            $roles=DB::table('general_settings')->get();
                            ?>
                          <option value="" selected ></option>
                          @foreach($roles as $role )


                                <option value="{{$role->user_roles}}" >{{$role->user_roles}}</option>


                            @endforeach
                        </select>
                      </div>
                    </div>
                    <br>


                      <div id="cost_centreDiv" class="form-group" style="display: none;">
                          <div class="form-wrapper">
                              <label for="cost_centre"  ><strong>Cost Centre <span style="color: red;"> *</span></strong></label>
                              <select id="cost_centre_id"  class="form-control" name="cost_centre">
                                  <?php
                                  $cost_centres=DB::table('cost_centres')->get();
                                  ?>
                                  <option value=""></option>
                                  @foreach($cost_centres as $cost_centre )


                                      <option value="{{$cost_centre->costcentre_id}}">{{$cost_centre->costcentre_id}}</option>


                                  @endforeach
                              </select>
                          </div>
                      </div>
                      <br>


                    <div align="right">
                      <button class="btn btn-primary" type="submit" onsubmit="check_phone();">Submit</button>
                      <button class="btn btn-danger" type="button" class="close" data-dismiss="modal">Cancel</button>
                    </div>
                  </form>


                </div>
              </div>
            </div>


          </div>





            </span>

            <form method="post" action=""  id="form1" >
                {{csrf_field()}}


                <div class="form-group">
                    <div class="form-wrapper">
                        <label for="first_name" class="col-3" style="display: inline !important;" ><strong>First Name <span style="color: red;"> *</span></strong></label>
                        <input type="text" class="form-control col-9"  name="first_name" value="" style="display: inline !important;" required autocomplete="off">

                    </div>
                </div>
                <br>


                <div id="descriptionDivEdit"  class="form-group">
                    <div class="form-wrapper">
                        <label for=""  ><strong>Last Name <span style="color: red;"> *</span></strong></label>
                        <input type="text" class="form-control" id="" name="last_name" value="" required  autocomplete="off">
                    </div>
                </div>
                <br>


                <div class="form-group">
                    <div class="form-wrapper">
                        <label for="" ><strong>Email <span style="color: red;"> *</span></strong></label>
                        <input type="email" class="form-control" id="" name="email" value="" Required autocomplete="off">
                    </div>
                </div>
                <br>



                <div class="form-group">
                    <div class="form-wrapper">
                        <label for="space_location"  ><strong>Phone Number <span style="color: red;"> *</span></strong></label>
                        <span id="phone_msg"></span>
                        <input type="text" id="phone_number" value="" required name="phone_number" class="form-control" placeholder="0xxxxxxxxxx" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength = "10"  minlength = "10" onkeypress="if(this.value.length<10){return event.charCode >= 48 && event.charCode <= 57} else return false;">
                    </div>
                </div>
                <br>





                <div class="form-group">
                    <div class="form-wrapper">
                        <label for="space_location"  ><strong>Role <span style="color: red;"> *</span></strong></label>
                        <select required class="form-control" name="role" onchange="SelectCheck(this)" >
                            <?php
                            $roles=DB::table('general_settings')->get();
                            ?>
                            <option value="" selected ></option>
                            @foreach($roles as $role )


                                <option value="{{$role->user_roles}}" >{{$role->user_roles}}</option>


                            @endforeach
                        </select>
                    </div>
                </div>
                <br>


                <div id="cost_centreDiv" class="form-group" style="display: none;">
                    <div class="form-wrapper">
                        <label for="cost_centre"  ><strong>Cost Centre <span style="color: red;"> *</span></strong></label>
                        <select id="cost_centre_id"  class="form-control" name="cost_centre">
                            <?php
                            $cost_centres=DB::table('cost_centres')->get();
                            ?>
                            <option value=""></option>
                            @foreach($cost_centres as $cost_centre )


                                <option value="{{$cost_centre->costcentre_id}}">{{$cost_centre->costcentre_id}}</option>


                            @endforeach
                        </select>
                    </div>
                </div>
                <br>


                <div align="right">
                    <button class="btn btn-primary" type="submit" onsubmit="check_phone();">Submit</button>
                    <button class="btn btn-danger" type="button" class="close" data-dismiss="modal">Cancel</button>
                </div>
            </form>




    </div>
  </div>
</div>
</div>
@endsection

@section('pagescript')
<script>

    function SelectCheck(nameSelect) {

        if (nameSelect.value =='Vote Holder') {
            document.getElementById("cost_centreDiv").style.display = "block";
            document.getElementById("cost_centre_id").disabled=false;
            var ele7 = document.getElementById("cost_centre_id");


            ele7.required = true;

        }else if(nameSelect.value =='Accountant'){

            document.getElementById("cost_centreDiv").style.display = "block";
            document.getElementById("cost_centre_id").disabled=false;
            var ele7 = document.getElementById("cost_centre_id");


            ele7.required = true;

        }
        else{
            var ele7 = document.getElementById("cost_centre_id");
            ele7.required = false;
            document.getElementById("cost_centre_id").disabled=true;
            document.getElementById("cost_centreDiv").style.display = "none";
        }

    }


    function SelectCheckEdit(nameSelect,id) {
console.log('edit function called');
        if (nameSelect.value =='Vote Holder') {
            document.getElementById("cost_centreDivEdit"+id).style.display = "block";

            document.getElementById("cost_centre_idEdit"+id).disabled=false;
            var ele7 = document.getElementById("cost_centre_idEdit"+id);
            ele7.required = true;

            var ele8 = document.getElementById("cost_centre_idEditHidden"+id);
            ele8.required = true;
            document.getElementById("cost_centreDivEditHidden"+id).style.display = "block";
            document.getElementById("cost_centre_idEditHidden"+id).disabled=false;



            console.log('vote holder called');

        }else if(nameSelect.value =='Accountant'){

            document.getElementById("cost_centreDivEdit"+id).style.display = "block";

            document.getElementById("cost_centre_idEdit"+id).disabled=false;
            var ele7 = document.getElementById("cost_centre_idEdit"+id);
            ele7.required = true;

            var ele8 = document.getElementById("cost_centre_idEditHidden"+id);
            ele8.required = true;
            document.getElementById("cost_centreDivEditHidden"+id).style.display = "block";
            document.getElementById("cost_centre_idEditHidden"+id).disabled=false;


        }
        else{
            var ele7 = document.getElementById("cost_centre_idEdit"+id);
            ele7.required = false;
            document.getElementById("cost_centre_idEdit"+id).disabled=true;
            document.getElementById("cost_centreDivEdit"+id).style.display = "none";

            var ele9 = document.getElementById("cost_centre_idEditHidden"+id);
            ele9.required = false;
            document.getElementById("cost_centre_idEditHidden"+id).disabled=true;
            document.getElementById("cost_centreDivEditHidden"+id).style.display = "none";
        }

    }



    function SelectCheckEditHidden(nameSelect,id) {
        console.log('edit function called');
        if (nameSelect.value =='Vote Holder') {


            var ele8 = document.getElementById("cost_centre_idEditHidden"+id);
            ele8.required = true;
            document.getElementById("cost_centreDivEditHidden"+id).style.display = "block";
            document.getElementById("cost_centre_idEditHidden"+id).disabled=false;



            console.log('vote holder called');

        }else if(nameSelect.value =='Accountant'){

            var ele8 = document.getElementById("cost_centre_idEditHidden"+id);
            ele8.required = true;
            document.getElementById("cost_centreDivEditHidden"+id).style.display = "block";
            document.getElementById("cost_centre_idEditHidden"+id).disabled=false;


        }
        else{

            var ele9 = document.getElementById("cost_centre_idEditHidden"+id);
            ele9.required = false;
            document.getElementById("cost_centre_idEditHidden"+id).disabled=true;
            document.getElementById("cost_centreDivEditHidden"+id).style.display = "none";
        }

    }



  function check_phone(){

    var phone_digits=$('#phone_number').val().length;

    if(phone_digits<10) {
      p2=0;
      $('#phone_msg').show();
      var message = document.getElementById('phone_msg');
      message.style.color = 'red';
      message.innerHTML = "Digits cannot be less than 10";
      $('#phone_number').attr('style', 'border-bottom:1px solid #f00');

    }else{
      $('#phone_msg').hide();
      $('#phone_number').attr('style','border-bottom: 1px solid #ccc');
    }

  }

</script>

<script type="text/javascript">
  var table = $('#myTable').DataTable( {
    dom: '<"top"fl>rt<"bottom"pi>'
  } );

</script>

@endsection
