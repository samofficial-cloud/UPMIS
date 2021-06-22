<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

   <!--  <title>{{ config('app.name', 'Laravel') }}</title> -->
   <title> @yield('title')</title>

   <link rel="icon" type="image.jpg" href="{{ asset('images/logo_udsm.jpg')}}"></link>

    <!-- Scripts -->
 <script src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>
 <script src="{{ asset('js/app.js') }}" ></script>
 <script src="{{ asset('js/tablesorter.js') }}" defer></script>
 <script src="{{ asset('js/jquery.filter_input.js') }}" ></script>
 <script src="{{ asset('js/Chart.min.js') }}" ></script>

<script src="{{ asset('js/jquery.dataTables.min.js') }}" ></script>
<script src="{{ asset('js/dataTables.bootstrap.min.js') }}"></script>

<script src="{{ asset('js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('js/buttons.flash.min.js') }}"></script>

<script src="{{ asset('js/jszip.min.js') }}"></script>
<script src="{{ asset('js/pdfmake.min.js') }}"></script>
<script src="{{ asset('js/vfs_fonts.js') }}"></script>
<script src="{{ asset('js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('js/buttons.print.min.js') }}"></script>
{{--<script src="{{ asset('js/sidebar.js') }}" ></script>--}}
<script src="{{asset('select2/dist/js/select2.min.js')}}" type="text/javascript"></script>

    <script src="{{ asset('js/jquery-ui.js') }}" ></script>
    <script src="{{ asset('js/jquery.timepicker.min.js') }}" ></script>
    <script src="{{ asset('js/flatpickr.js') }}" ></script>
{{--    <script src="{{ asset('js/all.js') }}" ></script>--}}

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="{{ asset('css/font-1.css') }}" rel="stylesheet">

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/free.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/filepond.css') }}" rel="stylesheet">
    <link href="{{ asset('css/jquery-ui.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{asset('select2/dist/css/select2.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('select2-bootstrap/dist/select2-bootstrap.min.css')}}">

    <link href="{{ asset('css/jquery-ui.css') }}" rel="stylesheet">
    <link href="{{ asset('css/jquery-ui.structure.css') }}" rel="stylesheet">
    <link href="{{ asset('css/jquery-ui.theme.css') }}" rel="stylesheet">
    <link href="{{ asset('css/jquery.timepicker.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/flatpickr.min.css') }}" rel="stylesheet">
{{--    <link href="{{ asset('css/all.css') }}" rel="stylesheet">--}}
    <link rel='stylesheet' href='https://use.fontawesome.com/releases/v5.7.0/css/all.css' integrity='sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ' crossorigin='anonymous'>


     @yield('style')
</head>
<body>

    <div id="app">
        <nav class="navbar navbar-expand-sm navbar-dark color_navbar navbar-laravel" style="width: 100%">
            <div class="container" style="max-width: 1534px;">

                    {{-- {{ config('app.name', 'Laravel') }} --}}
                    <div class="d-flex flex-row">
                     <div class="pl-2">
                        <?php
                            $category=DB::table('general_settings')->where('user_roles',Auth::user()->role)->value('category');
                        ?>
                    @if(Auth::user()->password_flag=='1')
                       @if($category=='All')
                            <a class="navbar-brand" href="{{ url('/') }}">
                            <img src="{{ asset('images/logo_udsm.jpg') }}" height="70px" width="70px" /></a>
                        @elseif($category=='Insurance only')
                            <a class="navbar-brand" href="{{ route('home2') }}">
                            <img src="{{ asset('images/logo_udsm.jpg') }}" height="70px" width="70px" /></a>
                        @elseif($category=='Real Estate only')
                            <a class="navbar-brand" href="{{ route('home4') }}">
                            <img src="{{ asset('images/logo_udsm.jpg') }}" height="70px" width="70px" /></a>
                        @endif

                        @if(($category=='CPTU only') && (Auth::user()->role!='Vote Holder') && (Auth::user()->role!='Accountant-Cost Centre'))
                            <a class="navbar-brand" href="{{ route('home3') }}">
                            <img src="{{ asset('images/logo_udsm.jpg') }}" height="70px" width="70px" /></a>
                        @endif

                        @if(($category=='CPTU only') && (Auth::user()->role=='Vote Holder') && (Auth::user()->role!='Accountant-Cost Centre'))
                            <a class="navbar-brand" href="{{ route('home5') }}">
                            <img src="{{ asset('images/logo_udsm.jpg') }}" height="70px" width="70px" /></a>
                        @endif

                        @if(($category=='CPTU only') && (Auth::user()->role!='Vote Holder') && (Auth::user()->role=='Accountant-Cost Centre'))
                            <a class="navbar-brand" href="{{ route('home5') }}">
                            <img src="{{ asset('images/logo_udsm.jpg') }}" height="70px" width="70px" /></a>
                        @endif
                    @else
                    <a class="navbar-brand" href="{{ url('#') }}">
                            <img src="{{ asset('images/logo_udsm.jpg') }}" height="70px" width="70px" /></a>
                    @endif
                    </div>
                    <div class="pl-3 pt-3" style="color: #111;"><h2 style="font-size: 2vw; font-weight: 600; ">UDSM PROJECTS MANAGEMENT INFORMATION SYSTEM</h2>

                    </div>
                </div>

                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                        <?php
                            use App\notification;
                        $chats=DB::table('system_chats')->where('receiver',Auth::user()->name)->where('flag','1')->count('id');
                        $i=1;
                        $category=DB::table('general_settings')->where('user_roles',Auth::user()->role)->value('category');
                        $insurance_invoice_notifications_count_total=0;
                        $car_invoice_notifications_count_total=0;
                        $space_invoice_notifications_count_total=0;
                        $water_invoice_notifications_count_total=0;
                        $electricity_invoice_notifications_count_total=0;

                        if($category=='Insurance only' OR $category=='All'){
                           $insurance_invoice_notifications_count=DB::table('invoice_notifications')->where('invoice_category','insurance')->count('id');
                            if($insurance_invoice_notifications_count!=0){
                                $insurance_invoice_notifications_count_total=1;
                            }else{}
                        }


                        if($category=='CPTU only' OR $category=='All'){
                            if(Auth::user()->role=='Vote Holder' || Auth::user()->role=='Accountant-Cost Centre'){

                            }
                            else{
                              $car_invoice_notifications_count=DB::table('invoice_notifications')->where('invoice_category','car_rental')->count('id');
                                if($car_invoice_notifications_count!=0){
                                    $car_invoice_notifications_count_total=1;
                                }
                                else{}
                            }



                            $notifications=notification::where('flag','1')->where('role',Auth::user()->role)->get();

                            $car_notifications = DB::table('car_notifications')->where('flag','1')->where('role',Auth::user()->role)->get();

                            if(count($notifications)>0){
                               $total = 1;
                            }
                            else{
                                $total = 0;
                            }

                            if(count($car_notifications)>0){
                               $total2 = 1;
                            }
                            else{
                                $total2 = 0;
                            }



                        }

                         if($category=='Real Estate only' OR $category=='All'){
                            $space_invoice_notifications_count=DB::table('invoice_notifications')->where('invoice_category','space')->count('id');
                            if($space_invoice_notifications_count!=0){
                                $space_invoice_notifications_count_total=1;
                            }else{}

                            $water_invoice_notifications_count=DB::table('invoice_notifications')->where('invoice_category','water bill')->count('id');
                            if($water_invoice_notifications_count!=0){
                                $water_invoice_notifications_count_total=1;
                            }else{}

                            $electricity_invoice_notifications_count=DB::table('invoice_notifications')->where('invoice_category','electricity bill')->count('id');
                            if($electricity_invoice_notifications_count!=0){
                                $electricity_invoice_notifications_count_total=1;
                            }else{}
                         }





                        if($category=='All'){
                            $all_notifications_count=$car_invoice_notifications_count_total+$insurance_invoice_notifications_count_total+$space_invoice_notifications_count_total+$total+$water_invoice_notifications_count_total+$electricity_invoice_notifications_count_total+$total2;
                        }
                        elseif($category=='CPTU only'){
                            if(Auth::user()->role=='Vote Holder' || Auth::user()->role=='Accountant-Cost Centre'){
                                $all_notifications_count=$total;
                            }
                            else{
                               $all_notifications_count=$car_invoice_notifications_count_total+$total+$total2;
                            }

                        }
                        elseif($category=='Real Estate only') {
                          $all_notifications_count = $space_invoice_notifications_count_total+$water_invoice_notifications_count_total+$electricity_invoice_notifications_count_total;
                        }
                        elseif($category=='Insurance only') {
                          $all_notifications_count = $insurance_invoice_notifications_count_total;
                        }
                        else{
                            $all_notifications_count = 0;
                        }

                        ?>
                    {{-- heree --}}
                    @if(Auth::user()->password_flag=='1')
                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->

                        {{--  <a title="View Chats" class="nav-link " href="/system_chats?id=" role="button"><i class='fas fa-comment-dots' style='font-size:26px;color:#282727'></i> <span class="badge badge-danger">{{$chats}}</span>
                        </a> --}}


                        @if($all_notifications_count==0)
                            <a title="View Notifications" id="navbarDropdownNotifications" class="nav-link " href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-bell" style="font-size:26px;color:#282727"></i> <span class="badge badge-danger"></span>
                            </a>

                        @else
                                  <a title="View Notifications" id="navbarDropdownNotifications" class="nav-link " href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                      <i class="fa fa-bell" style="font-size:26px;color:#282727"></i> <span class="badge badge-danger">{{$all_notifications_count}}</span>
                                </a>
                        @endif

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownNotifications">
                            @if($category=='Real Estate only' OR $category=='All')
                                @if($space_invoice_notifications_count==1)
                                    <a class="dropdown-item" href="/invoice_management">{{$i}}. You have {{$space_invoice_notifications_count}} space invoices to review</a>

                                    <?php $i=$i+1; ?>

                                @elseif($space_invoice_notifications_count!=0)
                                    <a class="dropdown-item" href="/invoice_management">{{$i}}. You have {{$space_invoice_notifications_count}} space invoices to review</a>

                                            <?php $i=$i+1; ?>

                                @else
                                @endif

                                @if($water_invoice_notifications_count==1)
                                    <a class="dropdown-item" href="/invoice_management">{{$i}}. You have {{$water_invoice_notifications_count}} water bill invoices to review</a>

                                    <?php $i=$i+1; ?>

                                @elseif($water_invoice_notifications_count!=0)
                                    <a class="dropdown-item" href="/invoice_management">{{$i}}. You have {{$water_invoice_notifications_count}} water bill invoices to review</a>

                                            <?php $i=$i+1; ?>

                                @else
                                @endif


                                @if($electricity_invoice_notifications_count==1)
                                    <a class="dropdown-item" href="/invoice_management">{{$i}}. You have {{$electricity_invoice_notifications_count}} electricity bill invoices to review</a>

                                    <?php $i=$i+1; ?>

                                @elseif($electricity_invoice_notifications_count!=0)
                                    <a class="dropdown-item" href="/invoice_management">{{$i}}. You have {{$electricity_invoice_notifications_count}} electricity bill invoices to review</a>

                                            <?php $i=$i+1; ?>

                                @else
                                @endif
                            @endif



                            @if($category=='CPTU only' OR $category=='All')
                                @if(Auth::user()->role!='Vote Holder' && Auth::user()->role!='Accountant-Cost Centre')
                                    @if($car_invoice_notifications_count==1)
                                        <a class="dropdown-item" href="/invoice_management">{{$i}}. You have {{$car_invoice_notifications_count}} car rental invoice to review</a>
                                                <?php $i=$i+1; ?>


                                    @elseif($car_invoice_notifications_count!=0)
                                        <a class="dropdown-item" href="/invoice_management">{{$i}}. You have {{$car_invoice_notifications_count}} car rental invoices to review</a>

                                                <?php $i=$i+1; ?>
                                    @else
                                    @endif
                                @endif

                                @if($total==0)

                                @elseif($total>0)

                                    <a class="dropdown-item" href="/contracts_management">{{$i}}. You have {{count($notifications)}} pending car rental requistion application(s) to review</a>
                                    <?php $i=$i+1; ?>
                                @endif

                                @if($total2==0)

                                @elseif($total2>0)

                                    <a class="dropdown-item" href="/businesses">{{$i}}. You have {{count($car_notifications)}} pending car application(s) to review</a>
                                    <?php $i=$i+1; ?>
                                @endif
                            @endif

                            @if($category=='Insurance only' OR $category=='All')
                                @if($insurance_invoice_notifications_count==1)
                                    <a class="dropdown-item" href="/invoice_management">{{$i}}. You have {{$insurance_invoice_notifications_count}} insurance invoice to review</a>

                                @elseif($insurance_invoice_notifications_count!=0)

                                    <a class="dropdown-item" href="/invoice_management">{{$i}}. You have {{$insurance_invoice_notifications_count}} insurance invoices to review</a>



                                @else
                                @endif
                            @endif
                         </div>


                       {{--  @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else --}}
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre> {{ Auth::user()->name }} <span class="caret"></span> </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="/view_profile">Profile Details</a>
                                    {{-- <a class="dropdown-item" href="/edit">Edit Profile</a> --}}
                                    <a class="dropdown-item" href="/change_password">Change Password</a>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                       {{--  @endguest --}}
                    </ul>
                    @else
                    @endif
                    {{-- hereee --}}
                </div>
            </div>
        </nav>





                <div id="coverScreen"  class="pageLoad"></div>
        <main>
            @yield('content')
        </main>


    </div>
    <script src="{{asset('js/filepond.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/filepond.jquery.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/filepond-plugin-file-validate-size.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/filepond-plugin-file-validate-type.js')}}" type="text/javascript"></script>
    @yield('pagescript')

    <script>



        window.onload=function(){
            $("#coverScreen").hide();
        };

        // $(document).ready(function () {
        //     $("#coverScreen").hide();
        // });

        $(".date_datepicker").datepicker({
            dateFormat: 'dd/mm/yy',
            calendarWeeks: true,
            autoclose: true,
            todayHighlight: true,
            rtl: true,
            orientation:"auto"
        });

        $(".flatpickr_date").flatpickr({

            altInput: true,
            altFormat: "d/m/Y",
            dateFormat: "Y-m-d",
            // altInputClass:"white_background form-control"
            onReady: function(dateObj, dateStr, fp) {
                fp.altInput.required = fp.element.required;
                fp.altInput.removeAttribute('readonly');
                fp.altInput.onkeydown = function () { return false; };
                fp.altInput.onpaste = function () { return false; };
            }


        });



    </script>


</body>

<footer class="footer">
  <?php
  $year=date('Y');
  ?>
<div class="footer-copyright text-center py-3"> © {{$year}} Directorate of Planning, Development & Investment - UDSM. All Rights Reserved.
  </div>
</footer>
</html>
