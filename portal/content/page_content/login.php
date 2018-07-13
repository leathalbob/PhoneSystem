<?php

$addable = new ADDABLE();
$dec_variable3 = $addable->hardCode('decrypt',$variable3);

switch($variable2){
	case 'reset':
		$login_fields = '
		<div class="account-logo-box">
			<h2 class="text-uppercase text-center">
				<a href="/" class="text-success">
					<span><img src="/content/theme/images/logo_dark.png" alt="" height="30"></span>
				</a>
			</h2>
			<h5 class="text-uppercase font-bold m-b-5 m-t-40">Password Reset</h5>
		</div>
		<div class="account-content">
			<form class="form-horizontal" action="#">

				<div class="form-group m-b-10 row">
					<div class="col-12">
						<input class="form-control" type="email" id="emailaddress" required="" placeholder="Email Address..">
					</div>
				</div>

				<div class="form-group row m-b-30"><div class="col-12">
				<!-- SPACING DIV -->
				</div></div>

				<div class="form-group row text-center m-t-10">
					<div class="col-12">
						<button class="btn btn-md btn-block btn-primary waves-effect waves-light" type="submit">Sign In</button>
					</div>
				</div>

			</form>

			<div class="row m-t-30 m-b-0">
				<div class="col-sm-12 text-center">
					<p class="text-muted m-b-0">Dont have an account? <a href="https://www.reviveip.com" class="text-dark m-l-5"><b>Sign Up</b></a></p>
				</div>
			</div>
		</div>';

		break;

	case '':
		$login_fields = '
		<div class="account-logo-box">
			<h2 class="text-uppercase text-center">
				<a href="/" class="text-success">
					<span><img src="/content/theme/images/logo_dark.png" alt="" height="30"></span>
				</a>
			</h2>
			<h5 class="text-uppercase font-bold m-b-5 m-t-40">Sign In</h5>
		</div>
		<div class="account-content">
			
			<div class="form-horizontal" id="login_form">
				<div class="form-group m-b-10 row">
					<div class="col-12">
						<input class="form-control" type="email" name="email" required="" placeholder="Email Address..">
					</div>
				</div>

				<div class="form-group row m-b-10">
					<div class="col-12">						
						<input class="form-control" type="password" name="password" required="" placeholder="Password..">
						<a href="/login/reset" class="text-muted pull-right"><small>Forgot your password?</small></a>
					</div>
				</div>

				<div id="login_status_panel"></div>

				<div class="form-group row text-center m-t-10">
					<div class="col-12">
						<button data-login-submission="" class="btn btn-md btn-block btn-primary waves-effect waves-light" type="submit">Sign In</button>
					</div>
				</div>
			</div>
			
			<div class="row m-t-30 m-b-0">
				<div class="col-sm-12 text-center">
					<p class="text-muted m-b-0">Dont have an account? <a href="https://'.GLOBAL_DOMAIN_NAME.'" class="text-dark m-l-5"><b>Sign Up</b></a></p>
				</div>
			</div>
		</div>';

		break;
	default:
		include_once(DOCROOT.'content/system/404.php');
}

if(!empty($login_fields)){

echo '
<body class="bg-accpunt-pages">
<section>
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<div class="wrapper-page">

					<div class="account-pages">
						<div class="account-box">
						'.$login_fields.'							
						</div>
					</div>

				</div>
			</div>
		</div>
	</div>
</section>';

}

/*
TODO: CREATE SOCIAL MEDIA OAUTH
<div class="row">
	<div class="col-sm-12">
		<div class="text-center">
			<button type="button" class="btn m-r-5 btn-facebook waves-effect waves-light">
				<i class="fa fa-facebook"></i>
			</button>
			<button type="button" class="btn m-r-5 btn-googleplus waves-effect waves-light">
				<i class="fa fa-google"></i>
			</button>
			<button type="button" class="btn m-r-5 btn-twitter waves-effect waves-light">
				<i class="fa fa-twitter"></i>
			</button>
		</div>
	</div>
</div>
*/

