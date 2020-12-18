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
      <div class="container " style="max-width: 100%;">
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


    </div>
  </div>
</div>
</div>






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
