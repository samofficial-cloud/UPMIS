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

@endsection

@section('content')
    <div class="wrapper">
        <div class="sidebar">
            <ul style="list-style-type:none;">

                <?php
                $category=DB::table('general_settings')->where('user_roles',Auth::user()->role)->value('category');
                ?>

                <?php
                use App\hire_rate;
                use App\operational_expenditure;
                $model=hire_rate::select('vehicle_model')->get();
                $model1=hire_rate::select('vehicle_model')->get();
                ?>

                <?php
                $category=DB::table('general_settings')->where('user_roles',Auth::user()->role)->value('category');
                ?>
                <li><a href="/"><i class="fas fa-home active"></i>Home</a></li>

                    @if((Auth::user()->role!='Vote Holder')&&(Auth::user()->role!='Accountant-Cost Centre'))

                        <li class="active_nav_item"><a href="/businesses" ><i class="fa fa-building" aria-hidden="true"></i> Businesses</a></li>
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
            <div class="container " style="max-width: 100%;">
                @if ($message = Session::get('success'))
                    <div class="alert alert-success row col-xs-12" style="margin-left: -13px; margin-bottom: -1px; margin-top: 4px;">
                        <p>{{$message}}</p>
                    </div>
                @endif
                <br>
                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                        <br>
                    </div>
                @endif


                    <div class="tab" style="">


                        @if ($category=='Real Estate only' OR $category=='All')
                            <button class="tablinks_inner space_identity" onclick="openInnerInvoices(event, 'space_inner')" id="defaultBusiness"><strong>Spaces</strong></button>
                        @else
                        @endif


                        @if ($category=='CPTU only' OR $category=='All')
                            <button class="tablinks_inner bills car_identity" onclick="openInnerInvoices(event, 'car_rental_inner')"><strong>Car rental</strong></button>
                        @else
                        @endif


                        @if($category=='Insurance only' OR $category=='All')
                                <button class="tablinks_inner bills insurance_identity" onclick="openInnerInvoices(event, 'insurance_inner')"><strong>Insurance</strong></button>
                        @else
                        @endif


                    </div>

                    <div id="space_inner" style="border: 1px solid #ccc; padding: 1%;" class="tabcontent_inner">
<br>

                        @if(Auth::user()->role=='DVC Administrator' OR Auth::user()->role=='Director DPDI' OR Auth::user()->role=='Accountant' )
                        @else
                            <a data-toggle="modal" data-target="#space" class="btn button_color active" style=" color:white;   background-color: #38c172; padding: 10px;
    margin-left: -2px;
    margin-bottom: 15px;
    margin-top: 4px;" role="button" aria-pressed="true">Add New Space</a>
                        @endif



                        <div class="">

                            <center><h3><strong>Renting spaces</strong></h3></center>
                            <hr>

                            <div class="modal fade" id="space" role="dialog">

                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <b><h5 class="modal-title">Add New Renting Space</h5></b>

                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>

                                        <div class="modal-body">

                                            <form method="post" action="{{ route('add_space')}}"  id="form1" >
                                                {{csrf_field()}}


                                                <div class="form-group">
                                                    <div class="form-wrapper">
                                                        <label for="major_industry"  ><strong>Major industry <span style="color: red;"> *</span></strong></label>
                                                        <select id="getMajor"  class="form-control" name="major_industry" required>
                                                            <option value="" selected></option>

                                                            <?php
                                                            $major_industries=DB::table('space_classification')->get();


                                                            $tempOut = array();
                                                            foreach($major_industries as $values){
                                                                $iterator = new RecursiveIteratorIterator(new RecursiveArrayIterator($values));
                                                                $val = (iterator_to_array($iterator,true));
                                                                $tempoIn=$val['major_industry'];

                                                                if(!in_array($tempoIn, $tempOut))
                                                                {
                                                                    print('<option value="'.$val['major_industry'].'">'.$val['major_industry'].'</option>');
                                                                    array_push($tempOut,$tempoIn);
                                                                }

                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <br>


                                                <div id="descriptionDiv"  class="form-group">
                                                    <div class="form-wrapper">
                                                        <label for=""  ><strong>Minor industry <span style="color: red;"> *</span></strong></label>
                                                        <select id="minor_list" required class="form-control" name="minor_industry" >


                                                        </select>
                                                    </div>
                                                </div>
                                                <br>






                                                <div class="form-group">
                                                    <div class="form-wrapper">
                                                        <label for="space_location"  ><strong>Location <span style="color: red;"> *</span></strong></label>
                                                        <select class="form-control" id="space_location" required name="space_location" >
                                                            <?php
                                                            $locations=DB::table('space_locations')->get();
                                                            ?>
                                                            <option value=""></option>
                                                            @foreach($locations as $location)
                                                                <option value="{{$location->location}}">{{$location->location}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <br>



                                                <div class="form-group">
                                                    <div class="form-wrapper">
                                                        <label for="space_location"  ><strong>Sub location <span style="color: red;"> *</span></strong></label>
                                                        <input type="text"  class="form-control" id="" name="space_sub_location" value="" required autocomplete="off">
                                                    </div>
                                                </div>
                                                <br>


                                                <div class="form-group">
                                                    <div class="form-wrapper">
                                                        <label for=""  ><strong>Size (SQM)</strong></label>
                                                        <input type="number" min="1" step="0.01" class="form-control" id="" name="space_size" value=""  autocomplete="off">
                                                    </div>
                                                </div>
                                                <br>


                                                <div class="form-group">
                                                    <div class="form-wrapper">
                                                        <label for="has_water_bill"  ><strong>Required to also pay Water bill <span style="color: red;"> *</span></strong></label>
                                                        <select class="form-control" id="has_water_bill" required name="has_water_bill" >
                                                            <option value="" selected></option>
                                                            <option value="No" id="Option" >No</option>
                                                            <option value="Yes" id="Option">Yes</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <br>


                                                <div class="form-group">
                                                    <div class="form-wrapper">
                                                        <label for="has_electricity_bill"  ><strong>Required to also pay Electricity bill <span style="color: red;"> *</span></strong></label>
                                                        <select class="form-control" id="has_electricity_bill" required name="has_electricity_bill" >
                                                            <option value="" selected></option>
                                                            <option value="No" id="Option" >No</option>
                                                            <option value="Yes" id="Option">Yes</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <br>


                                                <div class="form-group">
                                                    <div class="form-wrapper">
                                                        <label for="rent_price_guide_checkbox" style="display: inline-block;"><strong>Rent Price Guide</strong></label>
                                                        <input type="checkbox"  style="display: inline-block;" value="rent_price_guide_selected" id="rent_price_guide_checkbox" name="rent_price_guide_checkbox" autocomplete="off">
                                                        <div  id="rent_price_guide_div" style="display: none;" class="form-group row">

                                                            <div class="col-4 inline_block form-wrapper">
                                                                <label  for="rent_price_guide_from" class=" col-form-label">From:</label>
                                                                <div class="">
                                                                    <input type="number" min="5" class="form-control" id="rent_price_guide_from" name="rent_price_guide_from" value=""  autocomplete="off">
                                                                </div>
                                                            </div>

                                                            <div class="col-4 inline_block form-wrapper">
                                                                <label  for="rent_price_guide_to" class=" col-form-label">To:</label>
                                                                <div  class="">
                                                                    <input type="number" min="10" class="form-control" id="rent_price_guide_to" name="rent_price_guide_to" value=""  autocomplete="off">
                                                                </div>
                                                            </div>


                                                            <div class="col-3 inline_block form-wrapper">
                                                                <label  for="rent_price_guide_currency" class="col-form-label">Currency:</label>
                                                                <div  class="">
                                                                    <select id="rent_price_guide_currency" class="form-control" name="rent_price_guide_currency" >
                                                                        <option value=""></option>
                                                                        <option value="TZS" >TZS</option>
                                                                        <option value="USD" >USD</option>
                                                                    </select>
                                                                </div>

                                                            </div>

                                                        </div>




                                                    </div>
                                                </div>


                                                <div class="form-group">
                                                    <div class="form-wrapper">
                                                        <label for=""  ><strong>Comments  </strong></label>
                                                        <input type="text" class="form-control" id="" name="comments" value=""  autocomplete="off">
                                                    </div>
                                                </div>
                                                <br>


                                                <div align="right">
                                                    <button class="btn btn-primary" type="submit">Save</button>
                                                    <button class="btn btn-danger" type="button" class="close" data-dismiss="modal">Cancel</button>
                                                </div>
                                            </form>









                                        </div>
                                    </div>
                                </div>


                            </div>

                            <?php
                            $i=1;
                            ?>



                            <table class="hover table table-striped table-bordered" id="myTable">
                                <thead class="thead-dark">
                                <tr>
                                    <th scope="col" style="color:#fff;"><center>S/N</center></th>
                                    <th scope="col" style="color:#fff;">Major Industry</th>
                                    <th scope="col" style="color:#fff;">Minor Industry</th>
                                    <th scope="col" style="color:#fff;">Space Number</th>
                                    <th scope="col"  style="color:#fff;">Location</th>
                                    <th scope="col"  style="color:#fff;">Sub Location</th>
                                    <th scope="col"  style="color:#fff;"><center>Size (SQM)</center></th>

                                    {{--          <th scope="col"  style="color:#3490dc;"><center>Rent Price Guide</center></th>--}}
                                    <th scope="col"  style="color:#fff;"><center>Status</center></th>

                                    <th scope="col"  style="color:#fff;"><center>Action</center></th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($spaces as $var)
                                    <tr>

                                        <td class=""><center>{{$i}}</center></td>
                                        <td>{{$var->major_industry}}</td>
                                        <td>{{$var->minor_industry}}</td>
                                        <td>{{$var->space_id}}</td>
                                        <td>{{$var->location}}</td>
                                        <td>{{$var->sub_location}}</td>

                                        <td><center>  @if($var->size==null)
                                                    N/A
                                                @else
                                                    {{$var->size}}
                                                @endif

                                            </center></td>



                                        {{--            <td><center>--}}

                                        {{--                @if($var->rent_price_guide_from==null)--}}
                                        {{--                  N/A--}}
                                        {{--                @else--}}
                                        {{--                  {{$var->rent_price_guide_from}} - {{$var->rent_price_guide_to}} {{$var->rent_price_guide_currency}}--}}
                                        {{--                @endif--}}

                                        {{--                </center></td>--}}

                                        <td><center>
                                                @if($var->occupation_status==1)
                                                    Occupied
                                                @else
                                                    Vacant
                                                @endif


                                            </center></td>

                                        <td><center>
                                                <a title="View more information" class="link_style" data-toggle="modal" data-target="#space_id{{$var->id}}" style="color: blue !important; text-decoration: underline !important;  cursor: pointer; display: inline-block" aria-pressed="true"><center><i class="fa fa-eye" style="font-size:20px;" aria-hidden="true"></i></center></a>
                                                <div class="modal fade" id="space_id{{$var->id}}" role="dialog">

                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <b><h5 class="modal-title">Full Space Details</h5></b>

                                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                            </div>

                                                            <div class="modal-body">
                                                                <table style="width: 100%">
                                                                    <tr>
                                                                        <td>Space number:</td>
                                                                        <td>{{$var->space_id}}</td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td>Major industry :</td>
                                                                        <td>{{$var->major_industry}}</td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td>Minor industry :</td>
                                                                        <td>{{$var->minor_industry}}</td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td>Location:</td>
                                                                        <td>{{$var->location}}</td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td>Sub location:</td>
                                                                        <td>{{$var->sub_location}}</td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td>Size (SQM):</td>
                                                                        <td>{{$var->size}}</td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td>Rent price guide:</td>
                                                                        <td>

                                                                            @if($var->rent_price_guide_from==null)
                                                                                N/A
                                                                            @else
                                                                                {{number_format($var->rent_price_guide_from)}} - {{number_format($var->rent_price_guide_to)}} {{$var->rent_price_guide_currency}}
                                                                            @endif

                                                                        </td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td>Status:</td>
                                                                        <td>

                                                                            @if($var->occupation_status==1)
                                                                                Occupied
                                                                            @else
                                                                                Vacant
                                                                            @endif

                                                                        </td>
                                                                    </tr>


                                                                    <tr>
                                                                        <td>Required to also pay electricity bill:</td>
                                                                        <td>{{$var->has_electricity_bill_space}}</td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td>Required to also pay water bill:</td>
                                                                        <td>{{$var->has_water_bill_space}}</td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td>Comments:</td>
                                                                        <td>{{$var->comments}}</td>
                                                                    </tr>




                                                                </table>
                                                                <br>
                                                                <center><button class="btn btn-danger" type="button" class="close" data-dismiss="modal">Close</button></center>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                @if(Auth::user()->role=='DVC Administrator' OR Auth::user()->role=='Director DPDI' OR Auth::user()->role=='Accountant' )
                                                @else
                                                    <a data-toggle="modal" title="Edit space information" data-target="#edit_space{{$var->id}}"  role="button" aria-pressed="true" name="editC"><i class="fa fa-edit" style="font-size:20px; color: green;"></i></a>

                                                    @if($var->occupation_status==1)

                                                    @else
                                                        <a href="/space_contract_on_fly/{{$var->id}}" title="Rent this space"><i class="fa fa-file-text" style="font-size:20px;" aria-hidden="true"></i></a>
                                                    @endif



                                                    <a data-toggle="modal" title="Delete space" data-target="#deactivate{{$var->id}}" role="button" aria-pressed="true"><i class="fa fa-trash" aria-hidden="true" style="font-size:20px; color:red;"></i></a>
                                                @endif

                                                <div class="modal fade" id="edit_space{{$var->id}}" role="dialog">

                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <b><h5 class="modal-title">Edit Renting Space Information</h5></b>

                                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                            </div>

                                                            <div class="modal-body">
                                                                <form method="post" action="{{ route('edit_space',$var->id)}}"  id="form1" >
                                                                    {{csrf_field()}}


                                                                    <div class="form-group">
                                                                        <div class="form-wrapper">
                                                                            <label for="major_industry"  ><strong>Major industry <span style="color: red;"> *</span></strong></label>
                                                                            <input type="text" class="form-control"  name="major_industry" value="{{$var->major_industry}}" readonly  autocomplete="off">

                                                                        </div>
                                                                    </div>
                                                                    <br>


                                                                    <div id="descriptionDivEdit"  class="form-group">
                                                                        <div class="form-wrapper">
                                                                            <label for=""  ><strong>Minor industry <span style="color: red;"> *</span></strong></label>
                                                                            <input type="text" class="form-control" id="major_industry_description" name="minor_industry" value="{{$var->minor_industry}}" readonly  autocomplete="off">
                                                                        </div>
                                                                    </div>
                                                                    <br>






                                                                    <div class="form-group">
                                                                        <div class="form-wrapper">
                                                                            <label for="space_location"  ><strong>Location <span style="color: red;"> *</span></strong></label>
                                                                            <input type="text" class="form-control"  name="space_location" value="{{$var->location}}" readonly  autocomplete="off">
                                                                        </div>
                                                                    </div>
                                                                    <br>


                                                                    <div class="form-group">
                                                                        <div class="form-wrapper">
                                                                            <label for="space_location"  ><strong>Sub location <span style="color: red;"> *</span></strong></label>
                                                                            <input type="text" readonly class="form-control" id="" name="space_sub_location" value="{{$var->sub_location}}"  autocomplete="off">
                                                                        </div>
                                                                    </div>
                                                                    <br>


                                                                    <div class="form-group">
                                                                        <div class="form-wrapper">
                                                                            <label for="has_water_bill"  ><strong>Required to also pay Water bill <span style="color: red;"> *</span></strong></label>
                                                                            <input type="text" readonly class="form-control" id="" name="has_water_bill" value="{{$var->has_water_bill_space}}"  autocomplete="off">
                                                                        </div>
                                                                    </div>
                                                                    <br>


                                                                    <div class="form-group">
                                                                        <div class="form-wrapper">
                                                                            <label for="has_electricity_bill"  ><strong>Required to also pay Electricity bill <span style="color: red;"> *</span></strong></label>
                                                                            <input type="text" readonly class="form-control" id="" name="has_electricity_bill" value="{{$var->has_electricity_bill_space}}"  autocomplete="off">
                                                                        </div>
                                                                    </div>
                                                                    <br>



                                                                    <div class="form-group">
                                                                        <div class="form-wrapper">
                                                                            <label for=""  ><strong>Size (SQM) <span style="color: red;"></span></strong></label>
                                                                            <input type="number" min="1" step="0.01" class="form-control" id="" name="space_size" value="{{$var->size}}"  autocomplete="off">
                                                                        </div>
                                                                    </div>
                                                                    <br>




                                                                    <div class="form-group">
                                                                        <div class="form-wrapper">
                                                                            <label for="rent_price_guide_checkbox_edit" style="display: inline-block;"><strong>Rent Price Guide</strong></label>
                                                                            @if($var->rent_price_guide_checkbox==1 AND $var->rent_price_guide_from!=null AND $var->rent_price_guide_to!=null AND $var->rent_price_guide_currency!=null)
                                                                                <input type="checkbox" checked style="display: inline-block;"  onclick="checkbox({{$var->id}});" id="rent_price_guide_checkbox_edit_filled{{$var->id}}" name="rent_price_guide_checkbox"  value="rent_price_guide_selected_edit"  autocomplete="off">

                                                                                <div id="rent_price_guide_div_edit_filled{{$var->id}}"  class="form-group row">

                                                                                    <div class="col-4 inline_block form-wrapper">
                                                                                        <label  for="rent_price_guide_from" class=" col-form-label">From:</label>
                                                                                        <div class="">
                                                                                            <input type="number" min="5" class="form-control" id="rent_price_guide_from_edit_filled{{$var->id}}" name="rent_price_guide_from" value="{{$var->rent_price_guide_from}}"  autocomplete="off">
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="col-4 inline_block  form-wrapper">
                                                                                        <label  for="rent_price_guide_to" class=" col-form-label">To:</label>
                                                                                        <div  class="">
                                                                                            <input type="number" min="10" class="form-control" id="rent_price_guide_to_edit_filled{{$var->id}}" name="rent_price_guide_to" value="{{$var->rent_price_guide_to}}"  autocomplete="off">
                                                                                        </div>
                                                                                    </div>


                                                                                    <div class="col-3 inline_block  form-wrapper">
                                                                                        <label  for="rent_price_guide_currency" class="col-form-label">Currency:</label>
                                                                                        <div  class="">
                                                                                            <select id="rent_price_guide_currency_edit_filled{{$var->id}}" class="form-control" name="rent_price_guide_currency" >
                                                                                                <option value="" ></option>

                                                                                                @if($var->rent_price_guide_currency=='TZS')
                                                                                                    <option value="USD" >USD</option>
                                                                                                    <option value="{{$var->rent_price_guide_currency}}" selected>{{$var->rent_price_guide_currency}}</option>
                                                                                                @elseif($var->rent_price_guide_currency=='USD')
                                                                                                    <option value="TZS">TZS</option>
                                                                                                    <option value="{{$var->rent_price_guide_currency}}" selected>{{$var->rent_price_guide_currency}}</option>

                                                                                                @else

                                                                                                @endif

                                                                                            </select>
                                                                                        </div>

                                                                                    </div>

                                                                                </div>

                                                                            @else
                                                                                <input type="checkbox"  style="display: inline-block;"  onclick="checkbox({{$var->id}});" id="rent_price_guide_checkbox_edit_one{{$var->id}}" name="rent_price_guide_checkbox"  value="rent_price_guide_selected_edit"  autocomplete="off">
                                                                                <div  id="rent_price_guide_div_edit{{$var->id}}"  style="display: none;" class="form-group row">

                                                                                    <div class="col-4 inline_block form-wrapper">
                                                                                        <label  for="rent_price_guide_from" class=" col-form-label">From:</label>
                                                                                        <div class="">
                                                                                            <input type="number" min="1" class="form-control" id="rent_price_guide_from_edit{{$var->id}}" name="rent_price_guide_from" value=""  autocomplete="off">
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="col-4 inline_block  form-wrapper">
                                                                                        <label  for="rent_price_guide_to" class=" col-form-label">To:</label>
                                                                                        <div  class="">
                                                                                            <input type="number" min="1" class="form-control" id="rent_price_guide_to_edit{{$var->id}}" name="rent_price_guide_to" value=""  autocomplete="off">
                                                                                        </div>
                                                                                    </div>


                                                                                    <div class="col-3 inline_block  form-wrapper">
                                                                                        <label  for="rent_price_guide_currency" class="col-form-label">Currency:</label>
                                                                                        <div  class="">
                                                                                            <select id="rent_price_guide_currency_edit{{$var->id}}" class="form-control" name="rent_price_guide_currency" >
                                                                                                <option value=""></option>
                                                                                                <option value="USD" >USD</option>
                                                                                                <option value="TZS">TZS</option>
                                                                                            </select>
                                                                                        </div>

                                                                                    </div>

                                                                                </div>
                                                                            @endif




                                                                        </div>
                                                                    </div>
                                                                    <br>


                                                                    <div class="form-group">
                                                                        <div class="form-wrapper">
                                                                            <label for=""  ><strong>Comments</strong></label>
                                                                            <input type="text" class="form-control" id="" name="comments" value="{{$var->comments}}"  autocomplete="off">
                                                                        </div>
                                                                    </div>
                                                                    <br>


                                                                    <div align="right">
                                                                        <button class="btn btn-primary" type="submit">Save</button>
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
                                                                <b><h5 class="modal-title">Are you sure you want to deactivate the space with space number {{$var->space_id}}?</h5></b>

                                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                            </div>

                                                            <div class="modal-body">
                                                                <form method="get" action="{{ route('delete_space',$var->id)}}" >
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

                                    <?php
                                    $i=$i+1;
                                    ?>
                                @endforeach





                                </tbody>
                            </table>

                        </div>

                    </div>

                    <div id="insurance_inner" style="border: 1px solid #ccc; padding: 1%;" class="tabcontent_inner">
<br>

                        @if(Auth::user()->role=='DVC Administrator' OR Auth::user()->role=='Director DPDI'  OR Auth::user()->role=='Accountant')
                        @else
                            <a data-toggle="modal" data-target="#add_insurance" class="btn button_color active" style="  color: white;  background-color: #38c172;
    padding: 10px;
    margin-left: -2px;
    margin-bottom: 15px;
    margin-top: 4px;" role="button" aria-pressed="true">Add new Insurance Package</a>
                        @endif

                        <div class="">


                            <center><h3><strong>Insurance packages</strong></h3></center>
                            <hr>
                            <div class="modal fade" id="add_insurance" role="dialog">

                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <b><h5 class="modal-title">New Insurance Package</h5></b>

                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>

                                        <div class="modal-body">
                                            <form method="post" action="{{ route('add_insurance')}}"  id="form1">
                                                {{csrf_field()}}


                                                <div class="form-group">
                                                    <div class="form-wrapper">
                                                        <label for="insurance_class"><strong>Class <span style="color: red;"> *</span></strong></label>


                                                        <select id="insurance_class" class="form-control" Required name="class">
                                                            <?php
                                                            $classes=DB::table('insurance_parameters')->get();
                                                            ?>
                                                            <option value=""></option>
                                                            @foreach($classes as $class)
                                                                @if($class->classes!=null)
                                                                    <option value="{{$class->classes}}">{{$class->classes}}</option>
                                                                @else
                                                                @endif
                                                            @endforeach
                                                        </select>


                                                    </div>
                                                </div>



                                                <div  id="insurance_companyDiv" class="form-group" style="display: none;" >
                                                    <div class="form-wrapper">
                                                        <label for="insurance_company"  ><strong>Insurance Company <span style="color: red;"> *</span></strong></label>
                                                        <?php
                                                        $companies=DB::table('insurance_parameters')->get();
                                                        ?>
                                                        <select id="insurance_company" class="form-control" required name="insurance_company">
                                                            <option value=""></option>
                                                            @foreach($companies as $var)
                                                                @if($var->company!=null)
                                                                    <option value="{{$var->company}}" >{{$var->company}}</option>
                                                                @else
                                                                @endif
                                                            @endforeach
                                                        </select>


                                                    </div>
                                                </div>


                                                <div id="TypeDiv" class="form-group" style="display: none;">
                                                    <div class="form-wrapper">
                                                        <label for="insurance_type"  ><strong>Type <span style="color: red;"> *</span></strong></label>
                                                        <select id="insurance_type"  class="form-control" name="insurance_type" required>
                                                            <option value=""></option>
                                                            <option value="THIRD PARTY" id="Option" >THIRD PARTY</option>
                                                            <option value="COMPREHENSIVE" id="Option" >COMPREHENSIVE</option>
                                                        </select>
                                                    </div>
                                                </div>


                                                <div id="TypeDivNA" class="form-group" style="display: none;">
                                                    <div class="form-wrapper">
                                                        <label for="insurance_type_na"  ><strong>Type <span style="color: red;"> *</span></strong></label>

                                                        <input type="text" class="form-control" id="insurance_type_na" name="insurance_type" readonly  value="N/A" autocomplete="off">

                                                    </div>
                                                </div>


                                                <div id="priceDiv" class="form-group" style="display: none;">
                                                    <div class="form-wrapper">
                                                        <label for="price"  ><strong>Price <span style="color: red;"> *</span></strong></label>
                                                        <input type="number" min="1" step="0.01" class="form-control" id="price" name="price"  required  autocomplete="off">
                                                    </div>
                                                </div>



                                                <div id="commissionDiv" class="form-group"  style="display: none;">
                                                    <div class="form-wrapper">
                                                        <label><strong>Commission</strong></label>

                                                        <div  id=""  class="form-group row">

                                                            <div class="col-6 inline_block form-wrapper">
                                                                <label  for="commission_percentage" class=" col-form-label">Percentage (%) <strong><span style="color: red;"> *</span></strong></label>
                                                                <div class="">
                                                                    <input type="number" min="1"  step="0.01" class="form-control"  name="commission_percentage" required value=""  id="commission_percentage" autocomplete="off">
                                                                </div>
                                                            </div>

                                                            <div class="col-6 inline_block form-wrapper">
                                                                <label  for="commission" class=" col-form-label">Amount <strong><span style="color: red;"> *</span></strong></label>
                                                                <div  class="">
                                                                    <input type="number" min="10" step="0.01" id="commission"  class="form-control" name="commission" value="" required autocomplete="off">
                                                                </div>
                                                            </div>




                                                        </div>




                                                    </div>
                                                </div>


                                                <div id="insurance_currencyDiv" class="form-group" style="display: none;">
                                                    <div class="form-wrapper">
                                                        <label for="insurance_currency"><strong>Currency <span style="color: red;"> *</span></strong></label>
                                                        <select id="insurance_currency" class="form-control" required name="insurance_currency" >
                                                            <option value=""></option>
                                                            <option value="TZS" >TZS</option>
                                                            <option value="USD" >USD</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div id="billing" class="form-group" style="display: none;">
                                                    <div class="form-wrapper">
                                                        <label for="billing"><strong>Billing <span style="color: red;"> *</span></strong></label>
                                                        <select id="billing_input" class="form-control" name="billing">
                                                            <option value=""></option>
                                                            <option value="Single billing" >Single billing</option>
                                                            <option value="Multiple billing" >Multiple billing</option>
                                                        </select>
                                                    </div>
                                                </div>


                                                <div id="number_of_installmentsDiv" style="display: none;"  class="form-group">
                                                    <label  for="number_of_installments" class=" col-form-label">Number of installments</label>

                                                        <input type="number" id="number_of_installments"  class="form-control" name="number_of_installments" readonly value="2" >

                                                </div>


                                                <div  id="first_installmentDiv" style="display: none;" class="form-group">
                                                    <label  for="first_installment" class=" col-form-label">First installment (60%)</label>

                                                        <input type="number" readonly id="first_installment"  class="form-control" name="first_installment" value="">

                                                </div>


                                                <div id="second_installmentDiv" style="display: none;" class="form-group">
                                                    <label  for="second_installment" class=" col-form-label">Second installment (40%)</label>

                                                        <input type="number" readonly id="second_installment"  class="form-control" name="second_installment" value="">

                                                </div>


                                                <div align="right">
                                                    <button class="btn btn-primary" type="submit">Save</button>
                                                    <button class="btn btn-danger" type="button" class="close" data-dismiss="modal">Cancel</button>
                                                </div>
                                            </form>


                                        </div>
                                    </div>
                                </div>


                            </div>





                            <table class="hover table table-striped table-bordered" id="myTable2">
                                <thead class="thead-dark">
                                <tr>
                                    <th scope="col" style="color:#fff;"><center>S/N</center></th>
                                    <th scope="col" style="color:#fff;"><center>Class</center></th>
                                    <th scope="col" style="color:#fff;"><center>Insurance Company</center></th>
                                    <th scope="col" style="color:#fff;"><center>Type</center></th>
                                    <th scope="col"  style="color:#fff;"><center>Price </center></th>
                                    <th scope="col"  style="color:#fff;"><center>Commission(%)</center></th>
                                    <th scope="col"  style="color:#fff;"><center>Commission</center></th>
                                    <th scope="col"  style="color:#fff;"><center>Billing</center></th>
                                    @if(Auth::user()->role=='DVC Administrator' OR Auth::user()->role=='Director DPDI' OR Auth::user()->role=='Accountant')
                                    @else
                                        <th scope="col"  style="color:#fff;"><center>Action</center></th>
                                    @endif
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($insurance as $var)
                                    <tr>

                                        <td class="counterCell text-center"></td>
                                        <td><center>{{$var->class}}</center></td>
                                        <td><center>{{$var->insurance_company}}</center></td>
                                        <td><center>{{$var->insurance_type}}</center></td>
                                        <td><center>{{number_format($var->price)}} {{$var->insurance_currency}}</center></td>
                                        <td><center>{{$var->commission_percentage}}%</center></td>
                                        <td><center>{{number_format($var->commission)}} {{$var->insurance_currency}} </center></td>
                                        <td><center> {{$var->billing}} </center></td>
                                        @if(Auth::user()->role=='DVC Administrator' OR Auth::user()->role=='Director DPDI' OR Auth::user()->role=='Accountant' )
                                        @else
                                            <td><center>



                                                    <a data-toggle="modal" data-target="#edit_insurance{{$var->id}}" role="button" aria-pressed="true" title="Edit insurance information" name="editC"><i class="fa fa-edit" style="font-size:20px; color: green;"></i></a>
                                                    <a href="/insurance_contract_on_fly/{{$var->id}}" title="Sell insurance"><i class="fa fa-file-text" aria-hidden="true" style="font-size:20px;"></i></a>

                                                    <a data-toggle="modal" title="Delete insurance package" data-target="#deactivate{{$var->id}}" role="button" aria-pressed="true"><i class="fa fa-trash" aria-hidden="true" style="font-size:20px; color:red;"></i></a>
                                                    <div class="modal fade" id="edit_insurance{{$var->id}}" role="dialog">

                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <b><h5 class="modal-title">Edit insurance package informantion</h5></b>

                                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                </div>

                                                                <div class="modal-body">
                                                                    <form method="post" action="{{ route('edit_insurance',$var->id)}}"  id="form1" >
                                                                        {{csrf_field()}}


                                                                        <div class="form-group">
                                                                            <div class="form-wrapper">
                                                                                <label for="insurance_class"><strong>Class <span style="color: red;"> *</span></strong></label>

                                                                                <input type="text" id="insurance_class_edit" class="form-control" Required name="class" readonly  value="{{$var->class}}" autocomplete="off">

                                                                            </div>
                                                                        </div>
                                                                        <br>



                                                                        <div   class="form-group"  >
                                                                            <div class="form-wrapper">
                                                                                <label for="insurance_company"><strong>Insurance Company <span style="color: red;"> *</span></strong></label>

                                                                                <input type="text" id="insurance_company_edit" class="form-control" required name="insurance_company" readonly  value="{{$var->insurance_company}}" autocomplete="off">

                                                                            </div>
                                                                        </div>
                                                                        <br>


                                                                        <div  class="form-group" >
                                                                            <div class="form-wrapper">
                                                                                <label for="insurance_type"  ><strong>Type <span style="color: red;"> *</span></strong></label>
                                                                                <input type="text" id="insurance_type_edit"  class="form-control" name="insurance_type" readonly  value="{{$var->insurance_type}}" autocomplete="off">
                                                                            </div>
                                                                        </div>
                                                                        <br>





                                                                        <div  class="form-group" >
                                                                            <div class="form-wrapper">
                                                                                <label for="price"  ><strong>Price <span style="color: red;"> *</span></strong></label>
                                                                                <input type="number" min="10" step="0.01" class="form-control" id="price_edit" name="price"  required value="{{$var->price}}" autocomplete="off">
                                                                            </div>
                                                                        </div>
                                                                        <br>



                                                                        <div  class="form-group"  >
                                                                            <div class="form-wrapper">
                                                                                <label  ><strong>Commission</strong></label>

                                                                                <div  id=""  class="form-group row">

                                                                                    <div class="col-6 inline_block form-wrapper">
                                                                                        <label  for="commission_percentage" class=" col-form-label">Percentage (%) <strong> <span style="color: red;"> *</span></strong></label>
                                                                                        <div class="">
                                                                                            <input type="number" min="1"  step="0.01" class="form-control"  name="commission_percentage" required value="{{$var->commission_percentage}}"  id="commission_percentage_edit" autocomplete="off">
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="col-6 inline_block form-wrapper">
                                                                                        <label  for="commission" class=" col-form-label">Amount <strong> <span style="color: red;">  *</span></strong></label>
                                                                                        <div  class="">
                                                                                            <input type="number" min="10" step="0.01" id="commission_edit"  class="form-control" name="commission" value="{{$var->commission}}" required autocomplete="off">
                                                                                        </div>
                                                                                    </div>




                                                                                </div>




                                                                            </div>
                                                                        </div>
                                                                        <br>


                                                                        <div class="form-group" >
                                                                            <div class="form-wrapper">
                                                                                <label for="insurance_currency"><strong>Currency <span style="color: red;"> *</span></strong></label>
                                                                                <select id="insurance_currency_edit" class="form-control" required name="insurance_currency" >
                                                                                    @if($var->insurance_currency=="TZS")
                                                                                        <option value="USD" >USD</option>
                                                                                        <option value="{{$var->insurance_currency}}" selected>{{$var->insurance_currency}}</option>
                                                                                    @elseif($var->insurance_currency=="USD")
                                                                                        <option value="TZS" >TZS</option>
                                                                                        <option value="{{$var->insurance_currency}}" selected>{{$var->insurance_currency}}</option>
                                                                                    @else
                                                                                    @endif
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                        <br>

                                                                        @if($var->billing=='Multiple billing')
                                                                        <div id="billing_edit" class="form-group">
                                                                            <div class="form-wrapper">
                                                                                <label for="billing"><strong>Billing <span style="color: red;"> *</span></strong></label>
                                                                                <select id="billing" class="form-control" required name="billing" >
                                                                                        <option value="Multiple billing" >Multiple billing</option>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                        <br>


                                                                        <div id="number_of_installmentsDivEdit"   class="form-group">
                                                                            <label  for="number_of_installments" class=" col-form-label">Number of installments</label>

                                                                                <input type="number" id="number_of_installmentsEdit"  class="form-control" name="number_of_installments" readonly value="2" >

                                                                        </div>
                                                                        <br>


                                                                        <div  id="first_installmentDivEdit"  class="form-group">
                                                                            <label  for="first_installment" class=" col-form-label">First installment</label>

                                                                                <input type="number" readonly id="first_installmentEdit"  class="form-control" name="first_installment" value="">

                                                                        </div>
                                                                        <br>


                                                                        <div id="second_installmentDivEdit"  class="form-group">
                                                                            <label  for="second_installment" class=" col-form-label">Second installment</label>

                                                                                <input type="number" readonly id="second_installmentEdit"  class="form-control" name="second_installment" value="">
                                                                        </div>
                                                                        <br>

                                                                        @else
                                                                        @endif


                                                                        <div align="right">
                                                                            <button class="btn btn-primary" type="submit">Save</button>
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
                                                                    <b><h5 class="modal-title">Are you sure you want to delete {{$var->insurance_company}}'s {{$var->insurance_type}} insurance?</h5></b>

                                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                </div>

                                                                <div class="modal-body">
                                                                    <form method="get" action="{{ route('deactivate_insurance',$var->id)}}" >
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
                                        @endif
                                    </tr>
                                @endforeach





                                </tbody>
                            </table>

                        </div>


                    </div>


                    <div id="car_rental_inner" style="border: 1px solid #ccc; padding: 1%;" class="tabcontent_inner">

                        <div class="tab">
                            <button class="tablinks" onclick="openContracts(event, 'car_list')" id="defaultOpen"><strong>VEHICLE FLEET</strong></button>
                            {{-- <button class="tablinks" onclick="openContracts(event, 'Operational')"><strong>OPERATIONAL EXPENDITURE</strong></button> --}}
                            <button class="tablinks" onclick="openContracts(event, 'hire')"><strong>HIRE RATE</strong></button>
                            <button class="tablinks" onclick="openContracts(event, 'cost_centres')"><strong>COST CENTRES</strong></button>
                            <button class="tablinks" onclick="openContracts(event, 'availability')"><strong>VEHICLE AVAILABILITY</strong></button>

                        </div>
                        <div id="car_list" class="tabcontent">
                            <br>
                            <center><h3><strong>Vehicle Fleet</strong></h3></center>
                            <hr>
                            <br>
                            @if(Auth::user()->role=='Transport Officer-CPTU' OR Auth::user()->role=='Head of CPTU' OR Auth::user()->role=='System Administrator')
                                <a title="Add a Vehicle" data-toggle="modal" data-target="#car" class="btn btn-success button_color active" style="
    padding: 10px;

    margin-bottom: 5px;
    margin-top: 4px;" role="button" aria-pressed="true">Add Vehicle</a>

                                <div class="modal fade" id="car" role="dialog">

                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <b><h5 class="modal-title">Fill the form below to add new vehicle</h5></b>

                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            </div>

                                            <div class="modal-body">
                                                <form method="post" action="{{ route('addCar') }}">
                                                    {{csrf_field()}}
                                                    <div class="form-group" id="regNodiv">
                                                        <div class="form-wrapper">
                                                            <label for="reg_no">Vehicle Registration No<span style="color: red;">*</span></label>
                                                            <input type="text" id="reg_no" name="vehicle_reg_no" class="form-control" required="" onblur="this.value=removeSpaces(this.value); javascript:this.value=this.value.toUpperCase();">
                                                        </div>
                                                    </div>

                                                    <div class="form-group" id="modeldiv">
                                                        <div class="form-wrapper">
                                                            <label for="model">Vehicle Model<span style="color: red;">*</span></label>
                                                            <select class="form-control" required="" id="model" name="model" required="">
                                                                <option value=""disabled selected hidden>select Vehicle Model</option>
                                                                @foreach($model as $model)
                                                                    <option value="{{$model->vehicle_model}}">{{$model->vehicle_model}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <div class="form-wrapper" id="clientdiv">
                                                            <label for="vehicle_status">Vehicle Status<span style="color: red;">*</span></label>
                                                            <select class="form-control" required="" id="vehicle_status" name="vehicle_status" required="">
                                                                <option value=""disabled selected hidden>select Vehicle status</option>
                                                                <option value="Running">Running</option>
                                                                <option value="Minor Repair">Minor Repair</option>
                                                                <option value="Grounded">Grounded</option>
                                                            </select>

                                                        </div>
                                                    </div>

                                                    <div class="form-group" id="hirediv">
                                                        <div class="form-wrapper">
                                                            <label for="hire_rate">Hire Rate/KM<span style="color: red;">*</span></label>
                                                            <input type="text" id="hire_rate" name="hire_rate" class="form-control" required="" onkeypress="if((this.value.length<15)&&((event.charCode >= 48 && event.charCode <= 57) || (event.charCode==46))){return true} else return false;">
                                                        </div>
                                                    </div>

                                                    <div align="right">
                                                        <button class="btn btn-primary" type="submit">Submit</button>
                                                        <button class="btn btn-danger" type="button" class="close" data-dismiss="modal">Cancel</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <br>
                            @endif


                            <table class="hover table table-striped table-bordered" id="myTable3">
                                <thead class="thead-dark">
                                <tr>
                                    <th scope="col" style="color:#fff; width: 5%;"><center>S/N</center></th>
                                    <th scope="col" style="color:#fff;"><center>Vehicle Registration No.</center></th>
                                    <th scope="col" style="color:#fff;"><center>Vehicle Model</center></th>
                                    <th scope="col" style="color:#fff;"><center>Vehicle Status</center></th>
                                    <th scope="col" style="color:#fff;"><center>Hire Rate/KM (TZS)</center></th>
                                    <th scope="col" style="color:#fff;"><center>Action</center></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($cars as $cars)
                                    <tr>
                                        <th scope="row">{{ $i }}.</th>
                                        <td><center>{{ $cars->vehicle_reg_no}}</center></td>
                                        <td>{{$cars->vehicle_model}}</td>
                                        <td>{{ $cars->vehicle_status}}</td>
                                        <td><center>{{ number_format($cars->hire_rate)}}</center></td>
                                        <td><center>
                                                <a title="View More Details" role="button" href="{{ route('CarViewMore') }}?vehicle_reg_no={{$cars->vehicle_reg_no}}"><i class="fa fa-eye" aria-hidden="true" style="font-size:20px; color:#3490dc; cursor: pointer;"></i></a>
                                                @if(Auth::user()->role=='Transport Officer-CPTU' OR Auth::user()->role=='Head of CPTU' OR Auth::user()->role=='System Administrator')
                                                    <a title="Edit Car Details" data-toggle="modal" data-target="#edit{{$cars->id}}" role="button" aria-pressed="true" id="{{$cars->id}}"><i class="fa fa-edit" style="font-size:20px; color: green; cursor: pointer;"></i></a>
                                                    <div class="modal fade" id="edit{{$cars->id}}" role="dialog">

                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <b><h5 class="modal-title">Fill the form below to edit car details</h5></b>

                                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                </div>

                                                                <div class="modal-body">
                                                                    <form method="get" action="{{ route('editcar') }}">
                                                                        {{csrf_field()}}
                                                                        <div class="form-group">
                                                                            <div class="form-wrapper">
                                                                                <label for="reg_no">Vehicle Registration No<span style="color: red;">*</span></label>
                                                                                <input type="text" id="reg_no{{$cars->id}}" name="vehicle_reg_no" class="form-control" value="{{$cars->vehicle_reg_no}}" required="" onblur="this.value=removeSpaces(this.value); javascript:this.value=this.value.toUpperCase();">
                                                                            </div>
                                                                        </div>
                                                                        <br>

                                                                        <div class="form-group">
                                                                            <div class="form-wrapper">
                                                                                <label for="model">Vehicle Model<span style="color: red;">*</span></label>
                                                                                <select class="form-control" required="" id="model{{$cars->id}}" name="model" required="">
                                                                                    <option value="{{$cars->vehicle_model}}">{{$cars->vehicle_model}}</option>
                                                                                    @foreach($model1 as $model)
                                                                                        @if($model->vehicle_model != $cars->vehicle_model)
                                                                                            <option value="{{$model->vehicle_model}}">{{$model->vehicle_model}}</option>
                                                                                        @endif
                                                                                    @endforeach
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                        <br>
                                                                        <div class="form-group">
                                                                            <div class="form-wrapper">
                                                                                <label for="vehicle_status">Vehicle Status<span style="color: red;">*</span></label>
                                                                                <select class="form-control" required="" id="vehicle_status{{$cars->id}}" name="vehicle_status" required="">
                                                                                    <option value="{{$cars->vehicle_status}}">{{$cars->vehicle_status}}</option>
                                                                                    @if($cars->vehicle_status != 'Running')
                                                                                        <option value="Running">Running</option>
                                                                                    @endif
                                                                                    @if($cars->vehicle_status != 'Minor Repair')
                                                                                        <option value="Minor Repair">Minor Repair</option>
                                                                                    @endif
                                                                                    @if($cars->vehicle_status != 'Grounded')
                                                                                        <option value="Grounded">Grounded</option>
                                                                                    @endif
                                                                                </select>

                                                                            </div>
                                                                        </div>
                                                                        <br>
                                                                        <div class="form-group">
                                                                            <div class="form-wrapper">
                                                                                <label for="hire_rate">Hire Rate/KM<span style="color: red;">*</span></label>
                                                                                <input type="text" id="hire_rate{{$cars->id}}" name="hire_rate" class="form-control" value="{{$cars->hire_rate}}" required="" onkeypress="if((this.value.length<10)&&((event.charCode >= 48 && event.charCode <= 57) || (event.charCode==46))){return true} else return false;">
                                                                            </div>
                                                                        </div>
                                                                        <br>
                                                                        <input type="text" name="id" value="{{$cars->id}}" hidden="">

                                                                        <div align="right">
                                                                            <button class="btn btn-primary" type="submit">Submit</button>
                                                                            <button class="btn btn-danger" type="button" class="close" data-dismiss="modal">Cancel</button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>



                                                    <a title="Delete this Car" data-toggle="modal" data-target="#Deactivate{{$cars->id}}" role="button" aria-pressed="true"><i class="fa fa-trash" aria-hidden="true" style="font-size:20px; color:red; cursor: pointer;"></i></a>
                                                    <div class="modal fade" id="Deactivate{{$cars->id}}" role="dialog">

                                                        <div class="modal-dialog" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <b><h5 class="modal-title" style="color: red;"><b>WARNING</b></h5></b>
                                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                </div>

                                                                <div class="modal-body">
                                                                    <p style="font-size: 20px;">Are you sure you want to delete this car?</p>
                                                                    <br>
                                                                    <div align="right">
                                                                        <a class="btn btn-info" href="{{route('deletecar',$cars->id)}}">Proceed</a>
                                                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif</center>
                                        </td>


                                    </tr>
                                    <?php
                                    $i= $i+1;
                                    ?>
                                @endforeach

                                </tbody>
                            </table>
                        </div>

                        <div id="hire" class="tabcontent" >
                            <br>
                            <center><h3><strong>Hire Rates</strong></h3></center>
                            <hr>
                            @if(Auth::user()->role=='Transport Officer-CPTU' OR Auth::user()->role=='Head of CPTU' OR Auth::user()->role=='System Administrator')
                                <a data-toggle="modal" data-target="#hiree" class="btn btn-success button_color active" style="
    padding: 10px;

    margin-bottom: 5px;
    margin-top: 4px;" role="button" aria-pressed="true">Add Rate</a>

                                <div class="modal fade" id="hiree" role="dialog">

                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <b><h5 class="modal-title">Fill the form below to add new hire rate</h5></b>

                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            </div>

                                            <div class="modal-body">
                                                <form method="post" action="{{ route('addhirerate') }}" onsubmit="return gethire()">
                                                    {{csrf_field()}}
                                                    <div class="form-group" id="modeldiv">
                                                        <div class="form-wrapper">
                                                            <label for="model">Vehicle Model<span style="color: red;">*</span></label>
                                                            <input type="text" id="hire_model" name="vehicle_model" class="form-control" required="">
                                                        </div>
                                                    </div>

                                                    <div class="form-group" id="hirediv">
                                                        <div class="form-wrapper">
                                                            <label for="hire_hire_rate">Hire Rate/Km<span style="color: red;">*</span></label>
                                                            <span id="ratemessage"></span>
                                                            <input type="text" id="hire_hire_rate" name="hire_rate" class="form-control" required="" onkeypress="if((this.value.length<10)&&((event.charCode >= 48 && event.charCode <= 57) || (event.charCode==46))){return true} else return false;">
                                                        </div>
                                                    </div>

                                                    <div align="right">
                                                        <button class="btn btn-primary" type="submit">Save</button>
                                                        <button class="btn btn-danger" type="button" class="close" data-dismiss="modal">Cancel</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <br><br>
                            @endif
                            <div class="container" style="width: 100%;">
                                <table class="hover table table-striped table-bordered" id="myTable4" style="width: 90%">
                                    <thead class="thead-dark">
                                    <tr>
                                        <th scope="col" style="color:#fff; width: 3%;"><center>S/N</center></th>
                                        <th scope="col" style="color:#fff;"><center>Vehicle Model</center></th>
                                        <th scope="col" style="color:#fff;"><center>Hire Rate/KM (TZS)</center></th>
                                        @if(Auth::user()->role=='Transport Officer-CPTU' OR Auth::user()->role=='Head of CPTU' OR Auth::user()->role=='System Administrator')
                                            <th scope="col" style="color:#fff;"><center>Action</center></th>
                                        @endif
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($rate as $rate)
                                        <tr>
                                            <th scope="row" class="counterCell text-center">.</th>
                                            <td>{{$rate->vehicle_model}}</td>
                                            <td><center>{{number_format($rate->hire_rate)}}</center></td>
                                            @if(Auth::user()->role=='Transport Officer-CPTU' OR Auth::user()->role=='Head of CPTU' OR Auth::user()->role=='System Administrator')
                                                <td><center>
                                                        <a title="Edit this Hire Rate" data-toggle="modal" data-target="#hire{{$rate->id}}" role="button" aria-pressed="true" id="{{$rate->id}}"><i class="fa fa-edit" style="font-size:20px; color: green;cursor: pointer;"></i></a>
                                                        <div class="modal fade" id="hire{{$rate->id}}" role="dialog">

                                                            <div class="modal-dialog modal-dialog-scrollable" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <b><h5 class="modal-title">Fill the form below to edit hire rate details</h5></b>

                                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                    </div>

                                                                    <div class="modal-body">
                                                                        <form method="post" action="{{ route('edithirerate') }}">
                                                                            {{csrf_field()}}
                                                                            <div class="form-group">
                                                                                <div class="form-wrapper">
                                                                                    <label for="hire_vehicle_model{{$rate->id}}">Vehicle Model<span style="color: red;">*</span></label>
                                                                                    <input type="text" id="hire_vehicle_model{{$rate->id}}" name="hire_vehicle_model" class="form-control" required="" autocomplete="off" value="{{$rate->vehicle_model}}">
                                                                                </div>
                                                                            </div>
                                                                            <br>

                                                                            <div class="form-group">
                                                                                <div class="form-wrapper">
                                                                                    <label for="hire_hire_rate{{$rate->id}}">Hire Rate/KM<span style="color: red;">*</span><span id="ratemessage{{$rate->id}}"></span></label>

                                                                                    <input type="text" id="hire_hire_rate{{$rate->id}}" name="hire_hire_rate" class="form-control" required="" value="{{$rate->hire_rate}}" onkeypress="if((this.value.length<10)&&((event.charCode >= 48 && event.charCode <= 57) || (event.charCode==46))){return true} else return false;">
                                                                                </div>
                                                                            </div>
                                                                            <br>
                                                                            <input type="text" name="id" value="{{$rate->id}}" hidden="">

                                                                            <div align="right">
                                                                                <button class="btn btn-primary" type="submit" name="rate_editSubmit" id="{{$rate->id}}">Submit</button>
                                                                                <button class="btn btn-danger" type="button" class="close" data-dismiss="modal">Cancel</button>
                                                                            </div>

                                                                        </form>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <a title="Delete this Hire Rate" data-toggle="modal" data-target="#Deactivatehire{{$rate->id}}" role="button" aria-pressed="true"><i class="fa fa-trash" aria-hidden="true" style="font-size:20px; color:red; cursor: pointer;"></i></a>
                                                        <div class="modal fade" id="Deactivatehire{{$rate->id}}" role="dialog">
                                                            <div class="modal-dialog" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <b><h5 class="modal-title" style="color: red;"><b>WARNING</b></h5></b>
                                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                    </div>

                                                                    <div class="modal-body">
                                                                        <p style="font-size: 20px;">Are you sure you want to delete this hire rate?</p>
                                                                        <br>
                                                                        <div align="right">
                                                                            <a class="btn btn-info" href="{{route('deletehirerate',$rate->id)}}">Proceed</a>
                                                                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                                                                        </div>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div></center>
                                                </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <?php
                        $today=date('Y-m-d');
                        ?>

                        <div id="availability" class="tabcontent">
                            <br>
                            <center><h3><strong>Vehicle Availability</strong></h3></center>
                            <hr>
                            <form id="msform">
                                <fieldset>
                                    <div class="form-card">
                                        {{--  <h4 class="fs-title">Please fill the form below</h4> --}}
                                        <div class="form-group row">
                                            <div class="form-wrapper col-6">
                                                <label for="start_date">Start Date<span style="color: red;">*</span></label>
                                                <input type="date" id="start_date" name="start_date" class="form-control" required="" min="{{$today}}">
                                            </div>
                                            <div class="form-wrapper col-6">
                                                <label for="end_date">End Date<span style="color: red;">*</span></label>
                                                <input type="date" id="end_date" name="end_date" class="form-control" required="" min="{{$today}}">
                                            </div>
                                        </div>
                                        <center><button class="btn btn-primary" type="submit" id="check">Submit</button></center>
                                    </div>
                                </fieldset>
                            </form>
                            <br>
                            <div id="content">
                                <center><div id="loading"></div></center>
                            </div>

                        </div>
                        <?php $k=1;?>
                        <div id="cost_centres" class="tabcontent">
                            <br>
                            <center><h3><strong>Cost Centres</strong></h3></center>
                            <hr>
                            @if(Auth::user()->role=='Transport Officer-CPTU' OR Auth::user()->role=='Head of CPTU' OR Auth::user()->role=='System Administrator')
                                <a data-toggle="modal" data-target="#cost_centree" class="btn btn-success button_color active" style="
    padding: 10px;

    margin-bottom: 5px;
    margin-top: 4px;" role="button" aria-pressed="true">Add Cost Centre</a>
                                <div class="modal fade" id="cost_centree" role="dialog">

                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <b><h5 class="modal-title">Fill the form below to add new cost centre</h5></b>

                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            </div>

                                            <div class="modal-body">
                                                <form method="post" action="{{ route('addcentre') }}">
                                                    {{csrf_field()}}
                                                    <div class="form-group" id="costcentreiddiv">
                                                        <div class="form-wrapper">
                                                            <label for="costcentreid">Cost Centre id<span style="color: red;">*</span></label>
                                                            <input type="text" id="costcentreid" name="costcentreid" class="form-control" required="" onkeypress="if((this.value.length<8)&&((event.charCode >= 48 && event.charCode <= 57) || (event.charCode==46))){return true} else return false;">
                                                        </div>
                                                    </div>

                                                    <div class="form-group" id="centrenamediv">
                                                        <div class="form-wrapper">
                                                            <label for="centrename">Cost Centre Name<span style="color: red;">*</span></label>
                                                            <input type="text" id="centrename" name="centrename" class="form-control" required="" onkeypress="if(event.charCode >= 48 && event.charCode <= 57){return false}else return true;">
                                                        </div>
                                                    </div>

                                                    <div align="right">
                                                        <button class="btn btn-primary" type="submit">Save</button>
                                                        <button class="btn btn-danger" type="button" class="close" data-dismiss="modal">Cancel</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            <br><br>
                            <div class="container" style="width: 100%;">
                                <table class="hover table table-striped table-bordered" id="myTable5" style="width: 90%">
                                    <thead class="thead-dark">
                                    <tr>
                                        <th scope="col" style="color:#fff; width: 3%;"><center>S/N</center></th>
                                        <th scope="col" style="color:#fff;"><center>Cost Centre Id</center></th>
                                        <th scope="col" style="color:#fff;"><center>Cost Centre Name</center></th>
                                        @if(Auth::user()->role=='Transport Officer-CPTU' OR Auth::user()->role=='Head of CPTU' OR Auth::user()->role=='System Administrator')
                                            <th scope="col" style="color:#fff;"><center>Action</center></th>
                                        @endif
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($costcentres as $var)
                                        <tr>
                                            <td><center>{{$k}}.</center></td>
                                            <td><center>{{$var->costcentre_id}}</center></td>
                                            <td>{{$var->costcentre}}</td>
                                            @if(Auth::user()->role=='Transport Officer-CPTU' OR Auth::user()->role=='Head of CPTU' OR Auth::user()->role=='System Administrator')
                                                <td><center>
                                                        <a title="Edit this Cost Centre Details" data-toggle="modal" data-target="#centre{{$var->id}}" role="button" aria-pressed="true" id="{{$var->id}}"><i class="fa fa-edit" style="font-size:20px; color: green; cursor: pointer;"></i></a>
                                                        <div class="modal fade" id="centre{{$var->id}}" role="dialog">

                                                            <div class="modal-dialog modal-dialog-scrollable" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <b><h5 class="modal-title">Fill the form below to edit cost centre details</h5></b>

                                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                    </div>

                                                                    <div class="modal-body">
                                                                        <form method="post" action="{{ route('editcentre') }}">
                                                                            {{csrf_field()}}
                                                                            <div class="form-group">
                                                                                <div class="form-wrapper">
                                                                                    <label for="costcentre_id{{$var->id}}">Cost Centre Id<span style="color: red;">*</span></label>
                                                                                    <input type="text" id="costcentre_id{{$var->id}}" name="costcentre_id" class="form-control" required="" autocomplete="off" value="{{$var->costcentre_id}}" onkeypress="if((this.value.length<10)&&((event.charCode >= 48 && event.charCode <= 57) || (event.charCode==46))){return true} else return false;">
                                                                                </div>
                                                                            </div>
                                                                            <br>

                                                                            <div class="form-group">
                                                                                <div class="form-wrapper">
                                                                                    <label for="centrename{{$var->id}}">Cost Centre Name<span style="color: red;">*</span></label>
                                                                                    <input type="text" id="centrename{{$var->id}}" name="centrename" class="form-control" required="" value="{{$var->costcentre}}" onkeypress="if(event.charCode >= 48 && event.charCode <= 57){return false}else return true;">
                                                                                </div>
                                                                            </div>
                                                                            <br>
                                                                            <input type="text" name="centreid" value="{{$var->id}}" hidden="">

                                                                            <div align="right">
                                                                                <button class="btn btn-primary" type="submit">Submit</button>
                                                                                <button class="btn btn-danger" type="button" class="close" data-dismiss="modal">Cancel</button>
                                                                            </div>

                                                                        </form>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <a title="Delete this cost centre" data-toggle="modal" data-target="#Deletecentre{{$var->id}}" role="button" aria-pressed="true"><i class="fa fa-trash" aria-hidden="true" style="font-size:20px; color:red; cursor: pointer;"></i></a>
                                                        <div class="modal fade" id="Deletecentre{{$var->id}}" role="dialog">
                                                            <div class="modal-dialog" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <b><h5 class="modal-title" style="color: red;"><b>WARNING</b></h5></b>
                                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                    </div>

                                                                    <div class="modal-body">
                                                                        <p style="font-size: 20px;">Are you sure you want to delete this cost centre?</p>
                                                                        <br>
                                                                        <div align="right">
                                                                            <a class="btn btn-info" href="{{route('deletecentre',$var->id)}}">Proceed</a>
                                                                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                                                                        </div>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div></center>
                                                </td>
                                            @endif

                                        </tr>
                                        <?php $k=$k+1;?>
                                    @endforeach
                                    </tbody>
                                </table>
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
        window.onload=function(){
            $("#getMajor").trigger('change');
        };
    </script>


    <script>

        $('#getMajor').on('change',function(e){
            e.preventDefault();
            var major = $(this).val();


            if(major != '')
            {
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url:"{{ route('generate_minor_list') }}",
                    method:"POST",
                    data:{major:major, _token:_token},
                    success:function(data){
                        if(data=='0'){

                        }
                        else{


                            $('#minor_list').html(data);
                        }
                    }
                });
            }
            else if(major==''){

            }
        });

    </script>

    <script>




        $("#rent_price_guide_checkbox").trigger('change');

        $('#rent_price_guide_checkbox').change(function(){

            if( $('#rent_price_guide_checkbox').prop('checked') ){

                document.getElementById("rent_price_guide_div").style.display = "block";

            } else {
                document.getElementById("rent_price_guide_div").style.display = "none";

                var input_from = document.getElementById("rent_price_guide_from");
                input_from.value = "";

                var input_to = document.getElementById("rent_price_guide_to");
                input_to.value = "";

            }


        });







        function checkbox(id) {
            //for edit case checkbox not selected
            $("#rent_price_guide_checkbox_edit_zero"+id).trigger('change');

            $('#rent_price_guide_checkbox_edit_zero'+id).change(function () {

                if ($('#rent_price_guide_checkbox_edit_zero'+id).prop('checked')) {
                    document.getElementById("rent_price_guide_div_edit"+id).style.display = "block";

                } else {
                    document.getElementById("rent_price_guide_div_edit"+id).style.display = "none";

                    var input_from = document.getElementById("rent_price_guide_from_edit"+id);
                    input_from.value = "";

                    var input_to = document.getElementById("rent_price_guide_to_edit"+id);
                    input_to.value = "";

                    var input_currency_edit = document.getElementById("rent_price_guide_currency_edit"+id);
                    input_currency_edit.value = "";



                }


            });

            //for edit case checkbox selected
            $("#rent_price_guide_checkbox_edit_one"+id).trigger('change');

            $('#rent_price_guide_checkbox_edit_one'+id).change(function () {

                if ($('#rent_price_guide_checkbox_edit_one'+id).prop('checked')) {
                    document.getElementById("rent_price_guide_div_edit"+id).style.display = "block";


                } else {
                    document.getElementById("rent_price_guide_div_edit"+id).style.display = "none";

                    var input_from = document.getElementById("rent_price_guide_from_edit"+id);
                    input_from.value = "";

                    var input_to = document.getElementById("rent_price_guide_to_edit"+id);
                    input_to.value = "";

                    var input_currency_edit = document.getElementById("rent_price_guide_currency_edit"+id);
                    input_currency_edit.value = "";


                }


            });



            //for edit case checkbox selected
            $("#rent_price_guide_checkbox_edit_filled"+id).trigger('change');

            $('#rent_price_guide_checkbox_edit_filled'+id).change(function () {

                if ($('#rent_price_guide_checkbox_edit_filled'+id).prop('checked')) {
                    document.getElementById("rent_price_guide_div_edit_filled"+id).style.display = "block";

                    var input_from = document.getElementById("rent_price_guide_from_edit_filled"+id);
                    input_from.required = true;

                    var input_to = document.getElementById("rent_price_guide_to_edit_filled"+id);
                    input_to.required = true;

                    var input_currency_edit = document.getElementById("rent_price_guide_currency_edit_filled"+id);
                    input_currency_edit.required = true;


                } else {
                    document.getElementById("rent_price_guide_div_edit_filled"+id).style.display = "none";

                    var input_from = document.getElementById("rent_price_guide_from_edit_filled"+id);
                    input_from.value = "";

                    var input_to = document.getElementById("rent_price_guide_to_edit_filled"+id);
                    input_to.value = "";

                    var input_currency_edit = document.getElementById("rent_price_guide_currency_edit_filled"+id);
                    input_currency_edit.value = "";


                    var input_from = document.getElementById("rent_price_guide_from_edit_filled"+id);
                    input_from.required = false;

                    var input_to = document.getElementById("rent_price_guide_to_edit_filled"+id);
                    input_to.required = false;

                    var input_currency_edit = document.getElementById("rent_price_guide_currency_edit_filled"+id);
                    input_currency_edit.required = false;


                }


            });




        }
    </script>





    <script type="text/javascript">
        $(document).ready(function(){
            var table = $('#myTable').DataTable( {
                dom: '<"top"fl>rt<"bottom"pi>'
            } );

            var table = $('#myTable1').DataTable( {
                dom: '<"top"l>rt<"bottom"pi>'
            } );

            var table = $('#myTable2').DataTable( {
                dom: '<"top"fl>rt<"bottom"pi>'
            } );
            var table = $('#myTable3').DataTable( {
                dom: '<"top"fl>rt<"bottom"pi>'
            } );

            var table = $('#myTable4').DataTable( {
                dom: '<"top"fl>rt<"bottom"pi>'
            } );

            var table = $('#myTable5').DataTable( {
                dom: '<"top"fl>rt<"bottom"pi>'
            } );


        });
    </script>

    <script type="text/javascript">

        function removeSpaces(string) {
            return string.split(' ').join('');
        }

        function gethire(){
            var rate=document.getElementById("hire_hire_rate").value;
            if(rate<500){
                var message=document.getElementById('ratemessage');
                message.style.color='red';
                message.innerHTML="Hire Rate/KM should be greater than TZS 500";
                return false;
            }
            else{
                var message=document.getElementById('ratemessage');
                message.innerHTML="";
                return true;
            }
        }

        $('#myTable4').on('click', '[name="rate_editSubmit"]', function(e){
            //e.preventDefault();
            var id = $(this).attr("id");
            var rate = $('#hire_hire_rate'+id).val();
            console.log(id);

            if(rate<500){
                var message=document.getElementById('ratemessage'+id);
                message.style.color='red';
                message.innerHTML="Hire Rate/KM should be greater than TZS 500";
                return false;
            }
            else{
                var message=document.getElementById('ratemessage'+id);
                message.innerHTML="";
                return true;
            }
        });


        function openContracts(evt, evtName) {
            // Declare all variables
            var i, tabcontent, tablinks;

            // Get all elements with class="tabcontent" and hide them
            tabcontent = document.getElementsByClassName("tabcontent");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }

            // Get all elements with class="tablinks" and remove the class "active"
            tablinks = document.getElementsByClassName("tablinks");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].className = tablinks[i].className.replace(" active", "");
            }

            // Show the current tab, and add an "active" class to the button that opened the tab
            document.getElementById(evtName).style.display = "block";
            evt.currentTarget.className += " active";
        }
        document.getElementById("defaultOpen").click();
    </script>
    <script type="text/javascript">
        $(document).ready(function(){
            $('#op_vehicle_reg_no').keyup(function(e){
                e.preventDefault();
                var query = $(this).val();
                if(query != ''){
                    var _token = $('input[name="_token"]').val();
                    $.ajax({
                        url:"{{ route('autocomplete.fetch2') }}",
                        method:"POST",
                        data:{query:query, _token:_token},
                        success:function(data){
                            console.log(2);
                            if(data=='0'){
                                console.log(3);
                                $('#op_vehicle_reg_no').attr('style','border:1px solid #f00');
                                a = '0';
                            }
                            else{
                                console.log(4);
                                a ='1';
                                //$('#message2').hide();
                                $('#op_vehicle_reg_no').attr('style','border:1px solid #ced4da');
                                $('#nameList').fadeIn();
                                $('#nameList').html(data);
                            }
                        }
                    });
                }
                else if(query==''){
                    a ='1';
                    //$('#message2').hide();
                    $('#op_vehicle_reg_no').attr('style','border:1px solid #ced4da');
                }
            });

            $(document).on('click', '#list', function(){
                console.log(5);
                a ='1';
                $('#op_vehicle_reg_no').attr('style','border:1px solid #ced4da');
                $('#op_vehicle_reg_no').val($(this).text());
                $('#nameList').fadeOut();

            });

            $(document).on('click', 'form', function(){

                $('#nameList').fadeOut();
            });

            $(document).ajaxSend(function(){
                $("#loading").fadeIn(250);
            });
            $(document).ajaxComplete(function(){
                $("#loading").fadeOut(250);
            });

            $("#check").click(function(e){
                $("#error").hide();
                var query = $('#start_date').val();
                var query2 = $('#end_date').val();
                if(query!='' && query2!=''){
                    if(new Date(query2) <= new Date(query)){
                        var query3=query2;
                        query2=query;
                        query=query3;
                    }
                    $.ajax({
                        url: "/car/available_cars?",
                        context: document.body,
                        data:{start_date:query,end_date:query2}
                    })
                        .done(function(fragment) {
                            $("#content").html(fragment);
                            var table = $('#myTable4').DataTable( {
                                dom: '<"top"l>rt<"bottom"pi>'
                            });
                        });
                    return false;

                }

            });

            $("#model").click(function(){
                var query = $(this).val();
                if(query!=''){
                    var _token = $('input[name="_token"]').val();
                    $.ajax({
                        url:"{{ route('autocomplete.hirerate') }}",
                        method:"POST",
                        data:{query:query, _token:_token},
                        success:function(data){
                            $('#hire_rate').val(data);
                        }
                    });
                }

            });

            $('#myTable3').on('click', '[name="model"]', function(e){
                e.preventDefault();
                var query = $(this).val();
                var id = $("#"+e.target.id).val();
                let reg = e.target.id.replace(/\D/g,'');

                if(query!=''){
                    var _token = $('input[name="_token"]').val();
                    $.ajax({
                        url:"{{ route('autocomplete.hirerate') }}",
                        method:"POST",
                        data:{query:query, _token:_token},
                        success:function(data){
                            $('#hire_rate'+reg).val(data);
                        }
                    });
                }
            });

        });


        $('#price').on('input', function(e) {
            var price=document.getElementById('price').value;

            var first_installment=0.60*price;
            var second_installment=0.40*price;


           var new_first_installment= Math.round((first_installment + Number.EPSILON) * 100) / 100;
           var new_second_installment= Math.round((second_installment + Number.EPSILON) * 100) / 100;

            $('#first_installment').val(new_first_installment);
            $('#second_installment').val(new_second_installment);

        });


        $('#insurance_type').click(function() {
            var insurance_type=document.getElementById('insurance_type').value;

            if(insurance_type=='COMPREHENSIVE'){

                $('#billing').show();

            }else{
                $('#billing').hide();
                $('#billing_input').val("");
            }


        });


        $('#billing_input').click(function() {

            var insurance_type=document.getElementById('insurance_type').value;
            var billing_type=document.getElementById('billing_input').value;

            if(billing_type=='Multiple billing') {

                if (insurance_type == 'COMPREHENSIVE') {

                    $('#number_of_installmentsDiv').show();
                    $('#first_installmentDiv').show();
                    $('#second_installmentDiv').show();


                } else {

                    $('#number_of_installmentsDiv').hide();
                    $('#first_installmentDiv').hide();
                    $('#second_installmentDiv').hide();

                }

            }else{

                $('#number_of_installmentsDiv').hide();
                $('#first_installmentDiv').hide();
                $('#second_installmentDiv').hide();


            }


        });






    </script>


    <script type="text/javascript">
        function openInnerInvoices(evt, evtName) {
            // Declare all variables
            var i, tabcontent, tablinks;

            // Get all elements with class="tabcontent" and hide them
            tabcontent = document.getElementsByClassName("tabcontent_inner");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }

            // Get all elements with class="tablinks" and remove the class "active"
            tablinks = document.getElementsByClassName("tablinks_inner");

            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].className = tablinks[i].className.replace(" active", "");
            }

            // Show the current tab, and add an "active" class to the button that opened the tab
            document.getElementById(evtName).style.display = "block";
            evt.currentTarget.className += " active";
        }
        // document.getElementById("defaultBusiness").click();
    </script>


    <script type="text/javascript">
        window.onload=function(){
                <?php
                $category=DB::table('general_settings')->where('user_roles',Auth::user()->role)->value('category');
                $space_status=0;
                $insurance_status=0;
                $car_status=0;

                if ($category=='Real Estate only' OR $category=='All') {
                    $space_status=1;
                }
                else{

                }

                if ($category=='CPTU only' OR $category=='All') {
                    $car_status=1;
                }
                else{

                }

                if ($category=='Insurance only' OR $category=='All') {
                    $insurance_status=1;
                }
                else{

                }

                ?>

            var space_x={!! json_encode($space_status) !!};
            var insurance_x={!! json_encode($insurance_status) !!};
            var car_x={!! json_encode($car_status) !!};

            if(space_x==1){

                $(".insurance_identity").removeClass("defaultBusiness");
                $(".car_identity").removeClass("defaultBusiness");
                $('.space_identity').addClass('defaultBusiness');


            }else if(insurance_x==1){
                $(".space_identity").removeClass("defaultBusiness");
                $(".car_identity").removeClass("defaultBusiness");
                $('.insurance_identity').addClass('defaultBusiness');

            }else if(car_x==1){
                $(".space_identity").removeClass("defaultBusiness");
                $(".insurance_identity").removeClass("defaultBusiness");
                $('.car_identity').addClass('defaultBusiness');

            }else{

            }



            document.querySelector('.defaultBusiness').click();

        };
    </script>


    <script type="text/javascript">
        $(document).ready(function() {

            $('#insurance_class').click(function(){
                var query3=$(this).val();
                if(query3!=''){

                    $('#insurance_companyDiv').show();

                }
                else{
                    $('#insurance_companyDiv').hide();
                    $('#TypeDiv').hide();

                    var ele4 = document.getElementById("insurance_type");
                    ele4.required = false;
                    $('#TypeDivNA').hide();
                    document.getElementById("insurance_type_na").disabled = true;
                    $('#priceDiv').hide();
                    $('#commissionDiv').hide();
                    $('#insurance_currencyDiv').hide();

                }

                if($('#TypeDivNA:visible').length!=0) {
                    var query=$('#insurance_class').val();
                    if(query=='MOTOR'){
                        $('#TypeDiv').show();
                        $('#TypeDivNA').hide();
                        document.getElementById("insurance_type_na").disabled = true;
                    }else{
                        $('#TypeDiv').hide();
                        var ele5 = document.getElementById("insurance_type");
                        ele5.required = false;
                        $('#TypeDivNA').show();
                        document.getElementById("insurance_type_na").disabled = false;

                    }
                }else if($('#TypeDiv:visible').length!=0){
                    //starts
                    var query=$('#insurance_class').val();
                    if(query=='MOTOR'){
                        $('#TypeDiv').show();
                        $('#TypeDivNA').hide();
                        document.getElementById("insurance_type_na").disabled = true;
                    }else{
                        $('#TypeDiv').hide();
                        var ele6 = document.getElementById("insurance_type");
                        ele6.required = false;
                        $('#TypeDivNA').show();
                        document.getElementById("insurance_type_na").disabled = false;

                    }
                    //ends
                }else{


                }

            });

            $('#insurance_company').click(function(){
                var query3=$(this).val();
                if(query3!=''){
                    var insurance_class=document.getElementById("insurance_class").value;
                    if(insurance_class=='MOTOR'){
                        $('#TypeDiv').show();
                    }else{
                        $('#TypeDivNA').show();
                        document.getElementById("insurance_type_na").disabled = false;
                    }

                    $('#priceDiv').show();
                    $('#commissionDiv').show();
                    $('#insurance_currencyDiv').show();

                }
                else{
                    $('#TypeDiv').hide();
                    var ele7 = document.getElementById("insurance_type");
                    ele7.required = false;
                    $('#priceDiv').hide();
                    $('#commissionDiv').hide();
                    $('#insurance_currencyDiv').hide();
                    $('#TypeDivNA').hide();

                    document.getElementById("insurance_type_na").disabled = true;
                }
            });

        });


    </script>



@endsection
