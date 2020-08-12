<!DOCTYPE html>
<html>
<head>
	<title>Smart Bin</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
	<link rel="icon" type="image/png" href="{{asset('login/images/icons/favicon.ico')}}">
	<link rel="stylesheet" type="text/css" href="{{asset('login/vendor/bootstrap/css/bootstrap.min.css')}}">
	<link rel="stylesheet" type="text/css" href="{{asset('login/fonts/font-awesome-4.7.0/css/font-awesome.min.css')}}">
	<link rel="stylesheet" type="text/css" href="{{asset('login/vendor/animate/animate.css')}}">
	<link rel="stylesheet" type="text/css" href="{{asset('login/vendor/css-hamburgers/hamburgers.min.css')}}">
	<link rel="stylesheet" type="text/css" href="{{asset('login/vendor/animsition/css/animsition.min.css')}}">
	<link rel="stylesheet" type="text/css" href="{{asset('login/select2/select2.min.css')}}">
	<link rel="stylesheet" type="text/css" href="{{asset('login/vendor/daterangepicker/daterangepicker.css')}}">
	<link rel="stylesheet" type="text/css" href="{{asset('login/css/util.css')}}">
	<link rel="stylesheet" type="text/css" href="{{asset('login/css/main.css')}}">
</head>
<body>
	
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
                
				<form class="login100-form validate-form p-l-55 p-r-55 p-t-178" action="{{url('/checkUser')}}" method="POST" auto-compelet="off" id="LoginForm" >
					<span class="login100-form-title">
						Sign In
					</span>
                            <div id="LoginMessages" ></div>
                    <img src="img/logo.png" style="    width: inherit; margin-top:-70px;margin-bottom:-70px;"/>
					<div class="wrap-input100 validate-input m-b-16" data-validate="Please enter username">
						<input class="input100" type="text" name="txtUserName" id="txtUserName" placeholder="Username">
						<span class="focus-input100"></span>
					</div>

					<div class="wrap-input100 validate-input" data-validate = "Please enter password">
						<input class="input100" type="password" name="txtPassword" id="txtPassword" placeholder="Password">
						<span class="focus-input100"></span>
					</div>

					

					<div class="container-login100-form-btn" style="margin-top:20px;margin-bottom:20px;">
						<button class="login100-form-btn" type="submet" form="LoginForm" >
							Sign in
						</button>
					</div>

					 
				</form>
			</div>
		</div>
	</div>
	
	
         
	<script src="{{asset('login/vendor/jquery/jquery-3.2.1.min.js')}}"></script>
	<script src="{{asset('login/vendor/animsition/js/animsition.min.js')}}"></script>
	<script src="{{asset('login/vendor/bootstrap/js/popper.js')}}"></script>
	<script src="{{asset('login/vendor/bootstrap/js/bootstrap.min.js')}}"></script>
	<script src="{{asset('login/vendor/select2/select2.min.js')}}"></script>
	<script src="{{asset('login/vendor/daterangepicker/moment.min.js')}}"></script>
	<script src="{{asset('login/vendor/daterangepicker/daterangepicker.js')}}"></script>
	<script src="{{asset('login/vendor/countdowntime/countdowntime.js')}}"></script>
	<script src="{{asset('login/js/main.js')}}"></script>
    <script src="{{asset('js/CustomeJs/Login.js')}}"></script> 
</body>
</html>