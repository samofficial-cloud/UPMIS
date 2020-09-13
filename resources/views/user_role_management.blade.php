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


        <p class="mt-1" style="  font-size:30px !important; "> Users and Role Management</p>
        <hr style="    border-bottom: 1px solid #e5e5e5 !important;">







<br>
            <a style="cursor: pointer;" data-toggle="modal" title="Add new user" data-target="#add_user"  role="button" aria-pressed="true" name="editC"><div style="float:left; background-color: #f6f6f6; background-clip: border-box; border: 1px solid rgba(0, 0, 0, 0.125); padding: 1%; border-radius: 0.25rem;"><i class="fas fa-user-plus " style="font-size:20px; color: black;     "></i>
</div></a>
            <a style="cursor: pointer; color: black !important; font-weight: bold; text-decoration: none;" href="/role_management"> <div style="float:right;      background-color: #f6f6f6; background-clip: border-box; border: 1px solid rgba(0, 0, 0, 0.125); padding: 1%; border-radius: 0.25rem;">Role management
            </div>
            </a>

            <div style="clear: both;"></div>

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

        <div style="margin-top: 2%;">
            <?php $i=1;
            ?>
            <table class="hover table table-striped table-bordered" id="myTable">


              <thead class="thead-dark">
              <tr>
                <th scope="col" style="color:#3490dc;"><center>S/N</center></th>
                <th scope="col" style="color:#3490dc;">Full Name</th>
                <th scope="col" style="color:#3490dc;">User Name</th>
                <th scope="col"  style="color:#3490dc;">Email</th>
                <th scope="col"  style="color:#3490dc;">Phone</th>
                <th scope="col"  style="color:#3490dc;">Role</th>
                <th scope="col"  style="color:#3490dc;">Cost Centre</th>
                <th scope="col"  style="color:#3490dc;">Status</th>
                <th scope="col"  style="color:#3490dc;"><center>Action</center></th>

              </tr>
              </thead>

              <tbody>

              @foreach($users as $var)
                <tr>

                  <td class=" text-center">{{$i}}</td>
                  <td>{{$var->name}}</td>
                  <td>{{$var->user_name}}</td>
                  <td>{{$var->email}}</td>
                  <td>{{$var->phone_number}}</td>
                  <td>{{$var->role}}</td>
                  <td><center>{{$var->cost_centre}}</center></td>

                  <td>  @if($var->status==0)
                       <p style="background-color: #b9b8b8; color:white; border-radius: 4px; text-align: center;">DISABLED</p>
                      @else
                         <p style="background-color: #09cd1b; color:white; border-radius: 4px;     border: 2px solid #00af0c; text-align: center;">ACTIVE</p>
                    @endif

                    </td>








                  <td><center>



@if($var->status==1)
                    <a style="cursor: pointer;" data-toggle="modal" title="Edit user information" data-target="#edit_user{{$var->id}}"  role="button" aria-pressed="true" name="editC"><i class="fas fa-user-edit" style="font-size:20px; color: black;"></i></a>

                    <a style="cursor: pointer;" data-toggle="modal" title="Deactivate user" data-target="#deactivate{{$var->id}}" role="button" aria-pressed="true"><i class="fas fa-user-slash" aria-hidden="true" style="font-size:20px; color:red;"></i></a>
                    @elseif($var->status==0)
                    <a style="cursor: pointer;" data-toggle="modal" title="Activate user" data-target="#activate{{$var->id}}" role="button" aria-pressed="true"><i class="fas fa-user" aria-hidden="true" style="font-size:20px; color:#09cd1b;"></i></a>

  @else
  @endif

                      <div class="modal fade" id="edit_user{{$var->id}}" role="dialog">

                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <b><h5 class="modal-title">Edit {{$var->name}}'s Information</h5></b>

                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                          </div>

                          <div class="modal-body">
                            <form method="post" action="{{ route('edit_user',$var->id)}}"  id="form1" >
                              {{csrf_field()}}


                              <div class="form-group">
                                <div class="form-wrapper">
                                  <label for="first_name"  ><strong>First Name <span style="color: red;"> *</span></strong></label>
                                  <input type="text" class="form-control"  name="first_name" value="{{$var->first_name}}" required autocomplete="off">

                                </div>
                              </div>
                              <br>


                              <div id="descriptionDivEdit"  class="form-group">
                                <div class="form-wrapper">
                                  <label for=""  ><strong>Last Name <span style="color: red;"> *</span></strong></label>
                                  <input type="text" class="form-control" id="" name="last_name" value="{{$var->last_name}}" required  autocomplete="off">
                                </div>
                              </div>
                              <br>


                              <div class="form-group">
                                <div class="form-wrapper">
                                  <label for="" ><strong>Email <span style="color: red;"> *</span></strong></label>
                                  <input type="email" class="form-control" id="" name="email" value="{{$var->email}}" Required autocomplete="off">
                                </div>
                              </div>
                              <br>



                              <div class="form-group">
                                <div class="form-wrapper">
                                  <label for="space_location"  ><strong>Phone Number <span style="color: red;"> *</span></strong></label>
                                  <span id="phone_msg"></span>
                                  <input type="text" id="phone_number" value="{{$var->phone_number}}" required name="phone_number" class="form-control" placeholder="0xxxxxxxxxx" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength = "10"  minlength = "10" onkeypress="if(this.value.length<10){return event.charCode >= 48 && event.charCode <= 57} else return false;">
                                </div>
                              </div>
                              <br>




                                @if($var->cost_centre!='N/A')
                              <div class="form-group">
                                <div class="form-wrapper">
                                  <label for="space_location"  ><strong>Role <span style="color: red;"> *</span></strong></label>
                                  <select required class="form-control" name="role"  onchange="SelectCheckEdit(this,{{$var->id}})" >
                                    <?php
                                    $roles=DB::table('general_settings')->get();
                                    ?>
                                      <option value="{{$var->role}}" selected >{{$var->role}}</option>
@foreach($roles as $role)

                                    @if($role->user_roles!=$var->role)
                                    <option value="{{$role->user_roles}}" >{{$role->user_roles}}</option>

                                    @else
                                      @endif
  @endforeach
                                  </select>
                                </div>
                              </div>
                              <br>
                                @else
                                    <div class="form-group">
                                        <div class="form-wrapper">
                                            <label for="space_location"  ><strong>Role <span style="color: red;"> *</span></strong></label>
                                            <select required class="form-control" name="role"  onchange="SelectCheckEditHidden(this,{{$var->id}})">
                                                <?php
                                                $roles=DB::table('general_settings')->get();
                                                ?>
                                                <option value="{{$var->role}}" selected>{{$var->role}}</option>
                                                @foreach($roles as $role)

                                                    @if($role->user_roles!=$var->role)
                                                        <option value="{{$role->user_roles}}" >{{$role->user_roles}}</option>

                                                    @else
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <br>
                                @endif



                                @if($var->cost_centre!='N/A')
                                <div id="cost_centreDivEdit{{$var->id}}" class="form-group" >
                                    <div class="form-wrapper">
                                        <label for="cost_centre"  ><strong>Cost Centre <span style="color: red;"> *</span></strong></label>
                                        <select id="cost_centre_idEdit{{$var->id}}"  class="form-control" name="cost_centre">
                                            <?php
                                            $cost_centres=DB::table('cost_centres')->get();
                                            ?>
                                            <option value="{{$var->cost_centre}}" selected>{{$var->cost_centre}}</option>
                                            @foreach($cost_centres as $cost_centre )

                                                @if($cost_centre->costcentre_id!=$var->cost_centre)
                                                <option value="{{$cost_centre->costcentre_id}}">{{$cost_centre->costcentre_id}}</option>
                                                    @else
                                                    @endif

                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <br>
                                @else


                                    <div id="cost_centreDivEditHidden{{$var->id}}" class="form-group" style="display: none;">
                                        <div class="form-wrapper">
                                            <label for="cost_centre"  ><strong>Cost Centre <span style="color: red;"> *</span></strong></label>
                                            <select id="cost_centre_idEditHidden{{$var->id}}"  class="form-control" name="cost_centre">
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


                                    @endif




                              <div align="right">
                                <button class="btn btn-primary" type="submit" onsubmit="check_phone();">Save</button>
                                <button class="btn btn-danger" type="button" class="close" data-dismiss="modal">Cancel</button>
                              </div>
                            </form>


                          </div>
                        </div>
                      </div>


                    </div>



                    <div class="modal fade" id="deactivate{{$var->id}}" role="dialog">

                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <b><h5 class="modal-title">Are you sure you want to deactivate {{$var->name}} ?</h5></b>

                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                          </div>

                          <div class="modal-body">
                            <form method="get" action="{{ route('deactivate_user',$var->id)}}" >
                              {{csrf_field()}}



                              <div align="right">
                                <button class="btn btn-primary" type="submit" id="newdata">Yes</button>
                                <button class="btn btn-danger" type="button" class="close" data-dismiss="modal">No</button>
                              </div>


                            </form>
                          </div>
                        </div>
                      </div>


                    </div>





                    <div class="modal fade" id="activate{{$var->id}}" role="dialog">

                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <b><h5 class="modal-title">Are you sure you want to activate {{$var->name}} ?</h5></b>

                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                          </div>

                          <div class="modal-body">
                            <form method="get" action="{{ route('activate_user',$var->id)}}" >
                              {{csrf_field()}}



                              <div align="right">
                                <button class="btn btn-primary" type="submit" id="newdata">Yes</button>
                                <button class="btn btn-danger" type="button" class="close" data-dismiss="modal">No</button>
                              </div>


                            </form>
                          </div>
                        </div>
                      </div>


                    </div>

                    </center>
                  </td>
                </tr>
                <?php $i=$i+1;?>
              @endforeach





              </tbody>
            </table>
        </div>


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
