<!DOCTYPE html>
<html lang="en">
<head>
	<title>UPMIS Login</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/iconic/css/material-design-iconic-font.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
<!--===============================================================================================-->
    <link rel="icon" type="image.jpg" href="{{ asset('images/logo_udsm.jpg') }}"></link>
</head>
<style type="text/css">
	div.modal-form {
    /* font-size: 150%; */
    width: 820px !important;
    height: 480px;
    margin: 2px auto;
    background-color: #ddd;
    border-top: solid 5px #2d4a84;
    border-bottom: solid 2px green;
    -moz-border-radius: 10px;
    -webkit-border-radius: 10px;
    border-radius: 10px;
    -moz-box-shadow: 0 0 2em #ccc;
    -webkit-box-shadow: 0 0 2em #ccc;
    box-shadow: 0 0 2em #ccc;
}

.login_left {
    width: 439px;
    float: left;
    border-right: 1px solid #EBEBEB;
    height: 345px;
    padding-left: 6px;
}
.login_right {
    width: 345px;
    float: right;
}
.login-height {
    height: 345px;
}
.tr_logp {
    background-position: 475px -1px;
    background-repeat: no-repeat;
    font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
    border-bottom: solid 1px #ebebeb;
    font-size: 20px;
    padding: 17px 20px 8px 20px;
    margin-bottom: 10px;
    margin-top: 2px;
    color: #008fc2;
    font-size: 18px;
}

.carousel .carousel-item {
  height: 345px;
}

.carousel-item img {
    position: absolute;
    object-fit:cover;
    top: 0;
    left: 0;
    min-height: 345px;
}
.tr_logo {
    /* border: solid 1px blue; */
    height: 100px;
    width: 800px;
    /*margin: 4em auto 1px;*/
   background-image: url(images/logo_udsm.jpg);
    background-position: 25px center;
    background-repeat: no-repeat;
     background-size: 100px 100px;
}
 .tr_logo #tr_head {
    font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
    font-size: 23px;
    word-spacing: 3px;
    font-weight: bold;
    margin-left: 57px;
    color: #000;
    margin-bottom: 3px;
    padding-top: 18px;
    text-align: center;
}
.tr_logo #tr_tail {
    font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
    font-size: 27px;
    font-weight: 400;
    color: #2d4a84;
    margin-top: 0px;
    text-align: center;
    text-indent: 100px;
}

input#user_name {
    background-image: url(images/username.png);
     background-size: 24px 24px;
    background-repeat: no-repeat;
    text-indent: 24px;
    background-position: 5px 3px;
    height: 31px;
}
input#search:focus {
    background-image:none;
    text-indent:0px
    }

 input#password {
    background-image: url(images/password.png);
    background-repeat: no-repeat;
    background-position: 5px 3px;
     height: 31px;
     text-indent: 20px
}
</style>
<body>
	<div class="limiter">
		<div class="container-login100" style="background-image: url('images/bg-02.png');">
			<div >
        <div class="col-12 col-sm-9 col-md-7 col-lg-9 text-center p-0 mt-3 mb-2">
        	
		<div class="modal-form">
            <div class="tr_logo"><center>
                
                <p id="tr_head">University of Dar es Salaam</p>
                <p id="tr_tail">UDSM's Projects Management Information System</p></center>
            </div>
            <br>
			<div class="login-height">
            <div class="login_left">
    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
  <ol class="carousel-indicators">
    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
    <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
    <li data-target="#carouselExampleIndicators" data-slide-to="3"></li>
    <li data-target="#carouselExampleIndicators" data-slide-to="4"></li>
  </ol>
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img class="d-block w-100 h-100" src="/images/mcity_12.jpg" alt="First slide">
      <div class="carousel-caption d-none d-md-block">
    <h5>Mlimani Conference Center</h5>
    {{-- <p style="color:#fff;">Mlimani City Conference Centre helps you host conference at its state-of-the-art conference halls.</p> --}}
  </div>
    </div>
    <div class="carousel-item">
      <img class="d-block w-100 h-100" src="/images/mcity_2.jpg" alt="Second slide">
      <div class="carousel-caption d-none d-md-block">
    <h5>Mlimani City Mall</h5>
   {{--  <p style="color:#fff;">Mlimani City shopping mall offers an exquisite shopping experience for its visitors.</p> --}}
  </div>
    </div>
    <div class="carousel-item">
      <img class="d-block w-100 h-100" src="/images/mcity_31.jpg" alt="Third slide">
       <div class="carousel-caption d-none d-md-block">
    <h5>Mlimani Offices</h5>
    {{-- <p style="color:#fff;">Mlimani City Office Park offers secure, well-managed business addresses for entrepreneurs.</p> --}}
  </div>
    </div>
    <div class="carousel-item">
      <img class="d-block w-100 h-100" src="/images/villa1.jpg" alt="Fourth slide">
       <div class="carousel-caption d-none d-md-block">
    <h5 style="color:black;">Mlimani Villas</h5>
    {{-- <p style="color:black;">Mlimani villas are fully furnished and having a landscaped private garden</p> --}}
  </div>
    </div>
    <div class="carousel-item">
      <img class="d-block w-100 h-100" src="/images/udia1.jpeg" alt="Fifth slide">
       <div class="carousel-caption d-none d-md-block">
   {{--  <h5 style="color:black;">UDSM Insurance Agency</h5> --}}
    
  </div>
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
            <div class="login_right">
            	<div class="tr_logp">
            		<h5>Login to your Account</h5>
            	</div>
            	<form method="POST" action="{{ route('login.custom')}}">
					 @csrf
					<div class="form-group row">
                            <label for="email" class="col-md-3 col-form-label">{{ __('Username') }}</label>

                            <div class="col-md-8">
                                <input id="user_name" type="text" class="form-control{{ $errors->has('user_name') ? ' is-invalid' : '' }}" placeholder="" name="user_name" value="" required>

                                @if ($errors->has('user_name'))
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('user_name') }}</strong>
                                    </span>
                              @endif
                            </div>
                        </div>

					 <div class="form-group row">
                            <label for="password" class="col-md-3 col-form-label">{{ __('Password') }}</label>

                            <div class="col-md-8">
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

				{{-- 	<div class="form-group row">
                            <div class="col-md-10 offset-md-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember" style="padding-left: 7.25rem;">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div> --}}

					 <div class="form-group">
                            <div>
                            <center>
                                <button type="submit" class="btn btn-primary" style="border-radius: 25px;background: -webkit-linear-gradient(bottom, #7579ff, #6924ef);">
                                    {{ __('Login') }}
                                </button>
                                </center>
                            </div>
                             <div><center>
                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </center>
                            </div>
                            </div>
				</form>
           </div>
        </div>
        </div>
		</div>
	</div>
</div>
	</div>

	<div id="dropDownSelect1"></div>
	
<!--===============================================================================================-->
	<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/bootstrap/js/popper.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/daterangepicker/moment.min.js"></script>
	<script src="vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
	<script src="vendor/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
	<script src="js/main.js"></script>

</body>
</html>