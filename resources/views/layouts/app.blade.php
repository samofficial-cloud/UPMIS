<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

   <!--  <title>{{ config('app.name', 'Laravel') }}</title> -->
   <title> @yield('title')</title>

   <link rel="icon" type="image.jpg" href="{{ asset('images/logo_udsm.jpg') }}"></link>

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
<script src="{{ asset('js/sidebar.js') }}" ></script>


    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="{{ asset('css/font-1.css') }}" rel="stylesheet">

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/free.min.css') }}" rel="stylesheet">

     @yield('style')
</head>
<body>

    <div id="app">
        <nav class="navbar navbar-expand-sm navbar-dark color_navbar navbar-laravel" style="width: 100%">
            <div class="container" style="max-width: 1534px;">
               
                    {{-- {{ config('app.name', 'Laravel') }} --}}
                    <div class="d-flex flex-row">
                     <div class="pl-2">
                         <a class="navbar-brand" href="{{ url('/') }}">
                      <img src="{{ asset('images/logo_udsm.jpg') }}" height="70px" width="70px" /></a>
                    </div>
                    <div class="pl-3 pt-3" style="color: #111;"><h2 style="font-size: 2vw">UDSM's PROJECTS MANAGEMENT INFORMATION SYSTEM</h2>

                    </div>
                </div>
                
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                       
                        <?php

                        $chats=DB::table('system_chats')->where('receiver',Auth::user()->name)->where('flag','1')->count('id');

                        $insurance_invoice_notifications_count_total=0;
                        $car_invoice_notifications_count_total=0;
                        $space_invoice_notifications_count_total=0;
                        $water_invoice_notifications_count_total=0;
                        $electricity_invoice_notifications_count_total=0;

                        $insurance_invoice_notifications_count=DB::table('invoice_notifications')->where('invoice_category','insurance')->count('id');
                        if($insurance_invoice_notifications_count!=0){
                            $insurance_invoice_notifications_count_total=1;
                        }else{}

                        $car_invoice_notifications_count=DB::table('invoice_notifications')->where('invoice_category','car_rental')->count('id');
                        if($car_invoice_notifications_count!=0){
                            $car_invoice_notifications_count_total=1;
                        }else{}

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

                        use App\notification;
                        $notifications=notification::where('flag','1')->where('role',Auth::user()->role)->get();
                        $i=1;

                        $total=count($notifications);


                        $total_invoice_notifications=$car_invoice_notifications_count_total+$insurance_invoice_notifications_count_total+$space_invoice_notifications_count_total+$total+$water_invoice_notifications_count_total+$electricity_invoice_notifications_count_total;

                        ?>

                         <a class="nav-link " href="/system_chats?id=" role="button"><i class='fas fa-comment-dots' style='font-size:26px;color:#282727'></i> <span class="badge badge-danger">{{$chats}}</span>
                        </a>


                        @if(Auth::user()->invoice_notification_flag==1)


                                @if($total_invoice_notifications==0)
                            <a id="navbarDropdownNotifications" class="nav-link " href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-bell" style="font-size:26px;color:#282727"></i> <span class="badge badge-danger"></span>
                            </a>

                                    @else
                                  <a id="navbarDropdownNotifications" class="nav-link " href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                      <i class="fa fa-bell" style="font-size:26px;color:#282727"></i> <span class="badge badge-danger">{{$total_invoice_notifications}}</span>
                                </a>
                                @endif
                                @else
                            {{--other notifications--}}
                            @if($total==0)
                                <a id="navbarDropdownNotifications" class="nav-link " href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-bell" style="font-size:26px;color:#282727"></i> <span class="badge badge-danger"></span>
                                </a>

                            @else
                                <a id="navbarDropdownNotifications" class="nav-link " href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-bell" style="font-size:26px;color:#282727"></i> <span class="badge badge-danger">{{$total}}</span>
                                </a>
                            @endif

                        @endif







                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownNotifications">
                                    @if($space_invoice_notifications_count==1 AND (Auth::user()->invoice_notification_flag==1))



                                        <a class="dropdown-item" href="/invoice_management">{{$i}}. You have {{$space_invoice_notifications_count}} space invoice to review</a>
                                    @elseif($space_invoice_notifications_count!=0 AND (Auth::user()->invoice_notification_flag==1))



                                        <a class="dropdown-item" href="/invoice_management">{{$i}}. You have {{$space_invoice_notifications_count}} space invoices to review</a>
                                    @else
                                    @endif



                                        @if($car_invoice_notifications_count==1 AND (Auth::user()->invoice_notification_flag==1))




                                            <a class="dropdown-item" href="/car_rental_invoice_management">{{$i}}. You have {{$car_invoice_notifications_count}} car rental invoice to review</a>
                                            <?php
                                            $i=$i+1;
                                            ?>


                                        @elseif($car_invoice_notifications_count!=0 AND (Auth::user()->invoice_notification_flag==1))


                                            <a class="dropdown-item" href="/car_rental_invoice_management">{{$i}}. You have {{$car_invoice_notifications_count}} car rental invoices to review</a>

                                            <?php
                                            $i=$i+1;
                                            ?>
                                        @else
                                        @endif

                                        @if($insurance_invoice_notifications_count==1 AND (Auth::user()->invoice_notification_flag==1))

                                            <a class="dropdown-item" href="/insurance_invoice_management">{{$i}}. You have {{$insurance_invoice_notifications_count}} insurance invoice to review</a>
                                            <?php
                                            $i=$i+1;
                                            ?>
                                        @elseif($insurance_invoice_notifications_count!=0 AND (Auth::user()->invoice_notification_flag==1))

                                            <a class="dropdown-item" href="/insurance_invoice_management">{{$i}}. You have {{$insurance_invoice_notifications_count}} insurance invoices to review</a>
                                            <?php
                                            $i=$i+1;
                                            ?>
                                        @else
                                        @endif


                                        @if($water_invoice_notifications_count==1 AND (Auth::user()->invoice_notification_flag==1))

                                            <a class="dropdown-item" href="/water_bills_invoice_management">{{$i}}. You have {{$water_invoice_notifications_count}} water invoice to review</a>
                                            <?php
                                            $i=$i+1;
                                            ?>
                                        @elseif($water_invoice_notifications_count!=0 AND (Auth::user()->invoice_notification_flag==1))

                                            <a class="dropdown-item" href="/water_bills_invoice_management">{{$i}}. You have {{$water_invoice_notifications_count}} water invoices to review</a>
                                            <?php
                                            $i=$i+1;
                                            ?>
                                        @else
                                        @endif


                                        @if($electricity_invoice_notifications_count==1 AND (Auth::user()->invoice_notification_flag==1))

                                            <a class="dropdown-item" href="/electricity_bills_invoice_management">{{$i}}. You have {{$electricity_invoice_notifications_count}} electricity invoice to review</a>
                                            <?php
                                            $i=$i+1;
                                            ?>
                                        @elseif($electricity_invoice_notifications_count!=0 AND (Auth::user()->invoice_notification_flag==1))

                                            <a class="dropdown-item" href="/electricity_bills_invoice_management">{{$i}}. You have {{$electricity_invoice_notifications_count}} electricity invoices to review</a>
                                            <?php
                                            $i=$i+1;
                                            ?>
                                        @else
                                        @endif




                                        @if($total==0)




                                        @elseif($total>0)


                                            @foreach($notifications as $notifications)
                                                <a class="dropdown-item" href="{{ route('ShowNotifications',$notifications->id
                                ) }}">{{$i}}. {{$notifications->message}}</a>
                                                <?php
                                                $i=$i+1;
                                                ?>
                                            @endforeach

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
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

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
                </div>
            </div>
        </nav>

        <main>
            @yield('content')
        </main>
    </div>
    @yield('pagescript')
</body>

<footer class="footer">
  <?php
  $year=date('Y');
  ?>
<div class="footer-copyright text-center py-3"> © {{$year}} Directorate of Planning, Development & Investment - UDSM. All Rights Reserved.
  </div>
</footer>
</html>
