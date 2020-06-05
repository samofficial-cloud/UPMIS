<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

   <!--  <title>{{ config('app.name', 'Laravel') }}</title> -->
   <title> @yield('title')</title>

   <link rel="icon" type="image.jpg" href="{{ asset('img/logo_udsm.jpg') }}"></link>

    <!-- Scripts -->
      <script src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>
      <script src="{{ asset('js/app.js') }}" ></script>
      <script src="{{ asset('js/tablesorter.js') }}" defer></script>
      <script src="{{ asset('js/jquery.filter_input.js') }}" ></script>

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
    {{-- <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css"> --}}
 {{--  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> --}}
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/font-awesome.min.css') }}" rel="stylesheet">

     @yield('style')
</head>
<body>
    <div class="container" style="max-width: 1534px;">
       <div class="row" style="width: 102%">
        <nav class="navbar navbar-expand-sm navbar-dark color_navbar navbar-laravel" style="width: 100%">
            {{-- <div class=""> --}}
                <a class="navbar-brand col-lg-3">
                    <!-- {{ config('app.name', 'Laravel') }} -->
                    <div class="d-flex flex-row">
                     <div class="pl-2">
                      <img src="{{ asset('images/logo_udsm.jpg') }}" height="70px" width="70px" />
                    </div>
                    <div class="pl-3 pt-3"><h2>UDSM PLANNING MANAGEMENT INFORMATION SYSTEM</h2>
                      
                    </div>
                </div>

                </a>
                <div class="col-lg-9">
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
                       
                          
                                  <i class="fa fa-bell" style="font-size:36px;color:#282727"></i>

                        <a id="navbarDropdownNotifications" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          0     
                                </a>
                                
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownNotifications">
                                  <a class="dropdown-item" href="#">You have no new notification</a>
                                </div>
                        
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    DPDI USER <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                   <a class="dropdown-item" href="/profile">View Profile</a>
                                    <a class="dropdown-item" href="/edit">Edit Profile</a>
                                    <a class="dropdown-item" href="/Password">Change Password</a> 

                                </div>
                            </li>
                    </ul>
                </div>
              </div>
        </nav>
      </div>
    </div>
    <div class="wrapper">
<div class="sidebar">
        <ul style="list-style-type:none;">
            <li><a href="#"><i class="fas fa-home"></i>Home</a></li>
            <li><a href="#"><i class="fas fa-building"></i>Space</a></li>
            <li><a href="#"><i class="fas fa-address-card"></i>Insurance</a></li>
            <li><a href="#"><i class="fas fa-car-side"></i>Car Rental</a></li>
            <li><a href="#"><i class="fas fa-user"></i>Clients</a></li>
            <li><a href="#"><i class="fas fa-file-contract"></i>Contracts</a></li>
            <li><a href="#"><i class="fas fa-file-invoice"></i>Invoice</a></li>
            <li><a href="#"><i class="fas fa-money-bill"></i>Payment</a></li>
            <li><a href="#"><i class="fas fa-file-pdf"></i>Reports</a></li>
        </ul> 
    </div>
<div class="main_content">
{{-- <h1 class="page-header">Dashboard</h1> --}}
<div class="flex-container">
<div style="flex-grow: 1" class="card shadow-sm p-10 mb-10 bg-white  flex_container_div">
<div class="flex_container_inside">
<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
  <ol class="carousel-indicators">
    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
    <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
  </ol>
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img class="d-block w-100 h-75" src="/images/mcity_1.jpg" alt="First slide">
    </div>
    <div class="carousel-item">
      <img class="d-block w-100 h-75" src="/images/mcity_2.jpg" alt="Second slide">
    </div>
    <div class="carousel-item">
      <img class="d-block w-100 h-75" src="/images/mcity_3.jpg" alt="Third slide">
    </div>
  </div>
  <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>
  </div>
</div>
<br>
<div class="card-deck">
  <div class="card">
    <div class="card-body">
      <h4 class="card-title"><i class="fas fa-bullhorn blink" style="font-size:24px;"></i> Announcements</h4>
      <ul class="list-group list-group-flush">
    <li class="list-group-item"> Call for Tender Application</li>
    <li class="list-group-item">University of Dar es salaam Insurance Agency</li>
    <li class="list-group-item">Elimika kuhusu ugonjwa wa homa kali ya mapafu unaosababishwa na virusi vya CORONA</li>
  </ul>
    </div>
    </div>
    <div class="card">
    <div class="card-body">
      <h4 class="card-title"><i class="fas fa-external-link-alt"></i> Quick Links</h4>
      <ul class="list-group list-group-flush">
    <li class="list-group-item"><a href="#">VoteBook</a></li>
    <li class="list-group-item"><a href="#">Feza</a></li>
    <li class="list-group-item"><a href="#">Aris</a></li>
  </ul>
    </div>
  </div>
  </div>
</div>
<br>
<footer class="footer">
  <?php
  $year=date('Y');
  ?>
<div class="footer-copyright text-center py-3"> © {{$year}} Directorate of Planning, Development & Investment - UDSM. All Rights Reserved.
  </div>
</footer>

</div>
</div>


</body>
</html>
