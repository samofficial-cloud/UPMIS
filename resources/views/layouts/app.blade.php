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
    
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/font-awesome.min.css') }}" rel="stylesheet">

     @yield('style')
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-sm navbar-dark color_navbar navbar-laravel" style="width: 100%">
            <div class="container" style="max-width: 1534px;">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{-- {{ config('app.name', 'Laravel') }} --}}
                    <div class="d-flex flex-row">
                     <div class="pl-2">
                      <img src="{{ asset('images/logo_udsm.jpg') }}" height="70px" width="70px" />
                    </div>
                    <div class="pl-3 pt-3" style="color: #111;"><h2 style="font-size: 2vw">UDSM PROJECTS MANAGEMENT INFORMATION SYSTEM</h2>
                      
                    </div>
                </div>
                </a>
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
                                    <a class="dropdown-item" href="/profile">View Profile</a>
                                    <a class="dropdown-item" href="/edit">Edit Profile</a>
                                    <a class="dropdown-item" href="/Password">Change Password</a>
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
