<!-- resources/views/login.blade.php -->

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		<title>Login</title>

		<link rel="icon" type="image/ico" href="assets/images/favicon.ico"/>

		<link href="assets/css/plugins.css" rel="stylesheet">
		<link href="assets/css/custom.css" rel="stylesheet">

		<style>
			body { font-size:14px; overflow-y:hidden; }
		</style>

		<script src="assets/js/plugins.js"></script>
	</head>
	<body>
		<div class="video-wrapper">
			<video playsinline="playsinline" autoplay="autoplay" muted="muted" loop="loop">
				<source src="assets/video/bg-video.mp4" type="video/mp4">
			</video>
		</div>
		<div class="login-form-wrapper radius box-shadow bg-white">
            <form method="POST" action="{{ route('login') }}">
                @csrf
				<div class="brand-logo"><img src="assets/images/ssl-logo.svg" alt="Stesalit" class="img-fluid" /></div>
				<div class="gap"></div>
				<div class="title">Next Gen IoT Enterprise Solutions</div>
				<div class="sub-title">Welcome back! Login to your account</div>
				<div class="gap"></div>
				<div class="form-wrapper">
                @if ($errors->any())
                    <div>
                        <ul style="color:red">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
					<div class="mb-3">
						<label class="form-label color-black">Username</label>
						<div class="form-field-wrapper radius">
							<div class="row g-0 align-items-center">
								<div class="col-1">
									<i data-feather="user" class="icon"></i>
								</div>
								<div class="col-11">
                                <input type="email" id="email" class="form-control username" name="email" value="{{ old('email') }}" required autofocus>
								</div>
							</div>
						</div>
					</div>
					<div class="mb-3">
						<label class="form-label color-black">Password</label>
						<div class="form-field-wrapper radius">
							<div class="row g-0 align-items-center">
								<div class="col-1">
									<i data-feather="lock" class="icon"></i>
								</div>
								<div class="col-11">
									<div class="input-group">
                                        <input type="password" class="form-control password" id="password" name="password" required autocomplete="current-password">
										<div class="input-group-append password-toggle ms-3"><i data-feather="eye-off" class="icon eyeoff"></i><i data-feather="eye" class="icon eyeon" style="display:none;"></i></div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="mb-3">
						<div class="row align-items-center">
							<div class="col-6">
								<label class="checkbox checkbox-container m-0" style="font-weight:normal;">
				                    <input type="checkbox" value="remember-me" id="remember_me"> Remember me
				                    <span class="checkmark"></span>
				                </label>
							</div>
							<div class="col-6 text-end">
								<a href="#">Forget Password?</a>
							</div>
						</div>
					</div>
					<div class="mb-3">
						<button type="submit" id="logins" name="login" class="btn button-blue w-100 btn-shadow">Log In</button>
					</div>
					<div class="text-center">Don't have an account? <a href="#">Create an account</a></div>
				</div>
			</form>
		</div>

		<script>
			feather.replace();

			jQuery(document).ready(function($){

				$('.password-toggle').click(function(){
					event.preventDefault();
					$('.eyeoff').toggle();
					$('.eyeon').toggle();
				    let input = $(this).prev();
				    input.attr('type', input.attr('type') === 'password' ? 'text' : 'password');
				});


				if (localStorage.chkbx && localStorage.chkbx != ''){
                    $('#remember_me').attr('checked', 'checked');
                    $('#username').val(localStorage.usrname);
                    $('#pass').val(localStorage.pass);
                } else {
                    $('#remember_me').removeAttr('checked');
                    $('#username').val('');
                    $('#pass').val('');
                }
                $('#remember_me').click(function(){
                    if ($('#remember_me').is(':checked')) {
                        localStorage.usrname = $('#username').val();
                        localStorage.pass = $('#pass').val();
                        localStorage.chkbx = $('#remember_me').val();
                    } else {
                        localStorage.usrname = '';
                        localStorage.pass = '';
                        localStorage.chkbx = '';
                    }
                });

			});
		</script>
	</body>
</html>