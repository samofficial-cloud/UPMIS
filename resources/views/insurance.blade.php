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

            @if($category=='All')
           <li><a href="/"><i class="fas fa-home active"></i>Home</a></li>
          @elseif($category=='Insurance only')
          <li><a href="{{ route('home2') }}"><i class="fas fa-home active"></i>Home</a></li>
          @elseif($category=='Real Estate only')
          <li><a href="{{ route('home4') }}"><i class="fas fa-home active"></i>Home</a></li>
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

            @if($category=='Real Estate only' OR $category=='All')
            <li><a href="/Space"><i class="fas fa-building"></i>Space</a></li>
            @else
            @endif

            @if($category=='Insurance only' OR $category=='All')
            <li><a href="/insurance"><i class="fas fa-address-card"></i>Insurance</a></li>
    @else
    @endif
            @if(($category=='CPTU only' OR $category=='All') && (Auth::user()->role!='Vote Holder')&&(Auth::user()->role!='Accountant-Cost Centre'))
            <li><a href="/car"><i class="fas fa-car-side"></i>Car Rental</a></li>
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
      <div class="container " style="max-width: 1308px;">
        @if ($message = Session::get('success'))
          <div class="alert alert-success row col-xs-12" style="margin-left: -13px;
    margin-bottom: -1px;
    margin-top: 4px;">
            <p>{{$message}}</p>
          </div>
        @endif
            @if (session('error'))
                <div class="alert alert-danger row col-xs-12" style="margin-left: -13px; margin-bottom: -1px; margin-top: 4px;">
                   <p> {{ session('error') }}</p>
                    <br>
                </div>
            @endif

        <div>

          <br>
          <h3 style="text-align: center;">INSURANCE PACKAGES</h3>


        </div>

            @if(Auth::user()->role=='DVC Administrator' OR Auth::user()->role=='Director DPDI'  OR Auth::user()->role=='Accountant')
            @else
        <a data-toggle="modal" data-target="#add_insurance" class="btn button_color active" style="  color: white;  background-color: #38c172;
    padding: 10px;
    margin-left: -2px;
    margin-bottom: 5px;
    margin-top: 4px;" role="button" aria-pressed="true">New insurance package</a>
            @endif

  <div class="">
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
                        <select id="billing" class="form-control" required name="billing">
                            <option value=""></option>
                            <option value="N/A">N/A</option>
                            <option value="Single billing" >Single billing</option>
                            <option value="Multiple billing" >Multiple billing</option>
                        </select>
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





      <table class="hover table table-striped table-bordered" id="myTable">
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

                            <div id="billing_edit" class="form-group" >
                                <div class="form-wrapper">
                                    <label for="billing"><strong>Billing <span style="color: red;"> *</span></strong></label>
                                    <select id="billing" class="form-control" required name="billing" >

                                        @if($var->billing=="Single billing")
                                            <option value="{{$var->billing}}" selected >{{$var->billing}}</option>
                                            <option value="Multiple billing" >Multiple billing</option>
                                            <option value="N/A" >N/A</option>
                                            @elseif($var->billing=="Multiple billing")
                                            <option value="{{$var->billing}}" selected>{{$var->billing}}</option>
                                            <option value="Single billing" >Single billing</option>
                                            <option value="N/A" >N/A</option>
                                        @elseif($var->billing=="N/A")
                                            <option value="{{$var->billing}}" selected>{{$var->billing}}</option>
                                            <option value="Single billing" >Single billing</option>
                                            <option value="Multiple billing" >Multiple billing</option>
                                            @else
                                        @endif

                                    </select>
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
                        <b><h5 class="modal-title">Are you sure you want to deactivate {{$var->insurance_company}}'s {{$var->insurance_type}} insurance?</h5></b>

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
  </div>
</div>
</div>


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
        $('#billing').show();
      }
      else{
        $('#TypeDiv').hide();
        var ele7 = document.getElementById("insurance_type");
        ele7.required = false;
        $('#priceDiv').hide();
        $('#commissionDiv').hide();
        $('#insurance_currencyDiv').hide();
        $('#TypeDivNA').hide();
          $('#billing').hide();
        document.getElementById("insurance_type_na").disabled = true;
      }
    });

  });


</script>



{{--<script>--}}

{{--  $('#insurance_company').on('change',function(e){--}}
{{--    e.preventDefault();--}}
{{--    // var company_value = $(this).val();--}}
{{--    const insurance_company=document.getElementById("insurance_company").value;--}}
{{--    const insurance_class=document.getElementById("insurance_class").value;--}}
{{--    // var class_name= $('#insurance_class').val();--}}


{{--    if(insurance_company != '')--}}
{{--    {--}}
{{--      // var _token = $('input[name="_token"]').val();--}}
{{--      $.ajax({--}}
{{--        url:"{{ route('generate_type_list') }}",--}}
{{--        method:"GET",--}}
{{--        data:{insurance_company:insurance_company,insurance_class:insurance_class},--}}
{{--        success:function(data){--}}
{{--          if(data=='0'){--}}

{{--          }--}}
{{--          else{--}}
{{--console.log(data);--}}

{{--            $('#insurance_type').html(data);--}}
{{--          }--}}
{{--        }--}}
{{--      });--}}
{{--    }--}}
{{--    else if(insurance_company==''){--}}

{{--    }--}}

{{--    else{--}}

{{--    }--}}
{{--  });--}}

{{--</script>--}}


<script type="text/javascript">
  var table = $('#myTable').DataTable( {
    dom: '<"top"fl>rt<"bottom"pi>'
  } );

</script>
@endsection
