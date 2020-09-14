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


          @if(Auth::user()->role=='DVC Administrator' OR Auth::user()->role=='Director DPDI' )
          @else
        <a data-toggle="modal" data-target="#space" class="btn button_color active" style=" color:white;   background-color: #38c172;
    padding: 10px;
    margin-left: -2px;
    margin-bottom: 5px;
    margin-top: 4px;" role="button" aria-pressed="true">Add New Space</a>
          @endif
  <br>

  <div class="">
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
                         <label for=""  ><strong>Space Number <span style="color: red;"> *</span></strong></label>
                         <input type="text" class="form-control" id="" name="space_id" value="" Required autocomplete="off">
                       </div>
                     </div>
                     <br>



                     <div class="form-group">
                       <div class="form-wrapper">
                         <label for="space_location"  ><strong>Location <span style="color: red;"> *</span></strong></label>
                         <select class="form-control" id="space_location" required name="space_location" >
                             <option value="" selected></option>
                           <option value="Mlimani City" id="Option" >Mlimani City</option>
                           <option value="UDSM Main Campus" id="Option">UDSM Main Campus</option>
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
                       <button class="btn btn-primary" type="submit">Submit</button>
                       <button class="btn btn-danger" type="button" class="close" data-dismiss="modal">Cancel</button>
                     </div>
                   </form>









      </div>
      </div>
      </div>


    </div>





      <table class="hover table table-striped table-bordered" id="myTable">
        <thead class="thead-dark">
        <tr>
          <th scope="col" style="color:#fff;"><center>S/N</center></th>
          <th scope="col" style="color:#fff;"><center>Major Industry</center></th>
          <th scope="col" style="color:#fff;"><center>Minor Industry</center></th>
          <th scope="col" style="color:#fff;"><center>Space Number</center></th>
          <th scope="col"  style="color:#fff;"><center>Location</center></th>
          <th scope="col"  style="color:#fff;"><center>Sub Location</center></th>
          <th scope="col"  style="color:#fff;"><center>Size (SQM)</center></th>

{{--          <th scope="col"  style="color:#3490dc;"><center>Rent Price Guide</center></th>--}}
          <th scope="col"  style="color:#fff;"><center>Status</center></th>

          <th scope="col"  style="color:#fff;"><center>Action</center></th>
        </tr>
        </thead>
        <tbody>

        @foreach($spaces as $var)
          <tr>

            <td class="counterCell text-center"></td>
            <td><center>{{$var->major_industry}}</center></td>
            <td><center>{{$var->minor_industry}}</center></td>
            <td><center>{{$var->space_id}}</center></td>
            <td><center>{{$var->location}}</center></td>
            <td><center>{{$var->sub_location}}</center></td>

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
                              {{$var->rent_price_guide_from}} - {{$var->rent_price_guide_to}} {{$var->rent_price_guide_currency}}
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

              @if(Auth::user()->role=='DVC Administrator' OR Auth::user()->role=='Director DPDI' )
                @else
                <a data-toggle="modal" title="Edit space information" data-target="#edit_space{{$var->id}}"  role="button" aria-pressed="true" name="editC"><i class="fa fa-edit" style="font-size:20px; color: green;"></i></a>
                <a href="/space_contract_on_fly/{{$var->id}}" title="Rent this space"><i class="fa fa-file-text" style="font-size:20px;" aria-hidden="true"></i></a>
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
                              <label for="" ><strong>Space Number <span style="color: red;"> *</span></strong></label>
                              <input type="text" class="form-control" id="" name="space_id" value="{{$var->space_id}}" readonly Required autocomplete="off">
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
                        <b><h5 class="modal-title">Are you sure you want to delete the space with space number {{$var->space_id}}?</h5></b>

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
  var table = $('#myTable').DataTable( {
    dom: '<"top"fl>rt<"bottom"pi>'
  } );

</script>


@endsection
