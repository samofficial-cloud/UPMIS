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

                @if((Auth::user()->role!='Vote Holder')&&(Auth::user()->role!='Accountant-Cost Centre'))

                    <li><a href="/businesses"><i class="fa fa-building" aria-hidden="true"></i> Businesses</a></li>
                @else
                @endif
            <li><a href="/clients"><i class="fas fa-user"></i>Clients</a></li>
            <li><a href="/contracts_management"><i class="fas fa-file-contract"></i>Contracts</a></li>
            <li><a href="/invoice_management"><i class="fas fa-file-contract"></i>Invoices</a></li>

<li><a href="/payment_management"><i class="fas fa-money-bill"></i>Payments</a></li>
            <li><a href="/reports"><i class="fas fa-file-pdf"></i>Reports</a></li>
@admin
            <li><a href="/user_role_management"><i class="fas fa-user-friends hvr-icon" aria-hidden="true"></i>Manage Users</a></li>
<li class="active_nav_item"><a href="/system_settings"><i class="fa fa-cog pr-1" aria-hidden="true"></i>System settings</a></li>
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


        <p class="mt-1" style="font-size:30px !important; ">Insurance Companies</p>
        <hr style="    border-bottom: 1px solid #e5e5e5 !important;">






<br>
 <a style="cursor: pointer; color:white; font-weight: bold; background-color: #38c172; background-clip: border-box; border: 1px solid rgba(0, 0, 0, 0.125); padding: 1%; border-radius: 0.25rem;" data-toggle="modal"  data-target="#add_company"  role="button" aria-pressed="true" name="editC">Add New Insurance Company</a>



          <div class="modal fade" id="add_company" role="dialog">

            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <b><h5 class="modal-title">Adding new insurance company</h5></b>

                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                  <form method="post" action="{{ route('add_insurance_company')}}"  id="form1">
                    {{csrf_field()}}


                      <div class="form-group">
                          <div class="form-wrapper">
                              <label for=""  ><strong>Name<span style="color: red;"> *</span> </strong></label>
                              <input type="text" class="form-control"   name="company" value="" required autocomplete="off">

                          </div>
                      </div>
                      <br>

                      <div class="form-group">
                          <div class="form-wrapper">
                              <label for=""  ><strong>Email<span style="color: red;"> *</span> </strong></label>
                              <input type="email" class="form-control"   name="company_email" value="" required autocomplete="off">

                          </div>
                      </div>
                      <br>

                      <div class="form-group">
                          <div class="form-wrapper">
                              <label for=""  ><strong>Address<span style="color: red;"> *</span> </strong></label>
                              <input type="text" class="form-control"   name="company_address" value="" required autocomplete="off">

                          </div>
                      </div>
                      <br>

                      <div class="form-group">
                          <div class="form-wrapper">
                              <label for=""  ><strong>TIN<span style="color: red;"> *</span> </strong></label>
                              <input type="text" class="form-control" name="company_tin" value="" required autocomplete="off">

                          </div>
                      </div>
                      <br>

                    <div align="right">
                      <button class="btn btn-primary" type="submit" >Submit</button>
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
                <th scope="col" style="color:#fff;"><center>S/N</center></th>
                <th scope="col" style="color:#fff;">Name</th>
                <th scope="col" style="color:#fff;">Email</th>
                <th scope="col" style="color:#fff;">Address</th>
                <th scope="col" style="color:#fff;">TIN</th>
                <th scope="col"  style="color:#fff;"><center>Action</center></th>

              </tr>
              </thead>

              <tbody>

              @foreach($insurance_companies as $var)
                <tr>

                  <td class="text-center">{{$i}}</td>
                  <td>{{$var->company}}</td>
                  <td>{{$var->company_email}}</td>
                  <td>{{$var->company_address}}</td>
                  <td>{{$var->company_tin}}</td>

                  <td><center>


                    <a style="cursor: pointer;" data-toggle="modal" title="Edit company information" data-target="#edit_company{{$var->id}}"  role="button" aria-pressed="true" name="editC"><i class="fa fa-edit" style="font-size:25px; color: green;"></i></a>

                    <a style="cursor: pointer;" data-toggle="modal" title="Delete company" data-target="#delete_company{{$var->id}}" role="button" aria-pressed="true"><i class="fa fa-trash" aria-hidden="true" style="font-size:25px; color:red;"></i></a>




                      <div class="modal fade" id="edit_company{{$var->id}}" role="dialog">

                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <b><h5 class="modal-title">Editing {{$var->company}}'s information</h5></b>

                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                          </div>

                          <div class="modal-body">
                            <form method="post" action="{{ route('edit_insurance_company',$var->id)}}"  id="form1" >
                              {{csrf_field()}}


                              <div class="form-group">
                                <div class="form-wrapper">
                                  <label for="first_name"  ><strong>Name </strong></label>
                                  <input type="text" class="form-control" required  name="company" value="{{$var->company}}"  autocomplete="off">

                                </div>
                              </div>

                                <br>

                                <div class="form-group">
                                    <div class="form-wrapper">
                                        <label for="first_name"  ><strong>Email </strong></label>
                                        <input type="email" class="form-control" required  name="company_email" value="{{$var->company_email}}"  autocomplete="off">

                                    </div>
                                </div>

                                <br>


                                <div class="form-group">
                                    <div class="form-wrapper">
                                        <label for="first_name"  ><strong>Address </strong></label>
                                        <input type="text" class="form-control" required  name="company_address" value="{{$var->company_address}}"  autocomplete="off">

                                    </div>
                                </div>

                                <br>

                                <div class="form-group">
                                    <div class="form-wrapper">
                                        <label for="first_name"  ><strong>TIN</strong></label>
                                        <input type="text" class="form-control" required  name="company_tin" value="{{$var->company_tin}}"  autocomplete="off">

                                    </div>
                                </div>

                                <br>


                              <div align="right">
                                <button class="btn btn-primary" type="submit" >Save</button>
                                <button class="btn btn-danger" type="button" class="close" data-dismiss="modal">Cancel</button>
                              </div>
                            </form>


                          </div>
                        </div>
                      </div>


                    </div>



                    <div class="modal fade" id="delete_company{{$var->id}}" role="dialog">

                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <b><h5 class="modal-title">Are you sure you want to delete {{$var->company}} company?</h5></b>

                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                          </div>

                          <div class="modal-body">
                            <form method="get" action="{{ route('delete_insurance_company',$var->id)}}" >
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


<script type="text/javascript">
  var table = $('#myTable').DataTable( {
    dom: '<"top"fl>rt<"bottom"pi>'
  } );

</script>

@endsection
