
<?php

$addable = new ADDABLE();
$register_fields = '';

if($variable2 == 'reseller'){

	$login_fields = '
	<div class="account-logo-box">
		<h2 class="text-uppercase text-center">
			<a href="/" class="text-success">
				<span><img src="/content/theme/images/logo_dark.png" alt="" height="30"></span>
			</a>
		</h2>
		<h5 class="text-uppercase font-bold m-b-5 m-t-50">Register As A Reseller</h5>
	</div>
	<div class="account-content">
		<div class="form-horizontal" id="register_reseller_form">

			<div class="form-group row m-b-10">
				<div class="col-12">
					<input class="form-control" name="fname" type="text" id="username" required="" placeholder="Full Name..">
				</div>
			</div>

			<div class="form-group row m-b-10">
				<div class="col-12">
					<input class="form-control" name="email" type="email" id="emailaddress" required="" placeholder="Email Address..">
				</div>
			</div>

			<div class="form-group row m-b-10">
				<div class="col-12">
					<input class="form-control" type="password" required="" id="password1" data-parsley-minlength="6" placeholder="Password..">
				</div>
			</div>
			<div class="form-group row m-b-10">
				<div class="col-12">
					<input class="form-control" type="password" required="" id="password2" data-parsley-minlength="6" data-parsley-equalto="#password1" placeholder="Confirm Password..">
				</div>
			</div>
			
			<div class="form-group row m-b-10"><div class="col-12">
				<!-- SPACING DIV -->
			</div></div>

			<div class="form-group row m-b-10">
				<div class="col-12">
					<div class="checkbox checkbox-primary">
						<input id="terms_and_conditions" type="checkbox" required style="cursor:pointer">
						<label for="terms_and_conditions">
							I accept the <a href="#">Terms and Conditions</a>
						</label>
					</div>
				</div>
			</div>

			<div id="register_status_panel"></div>
			
			<div class="form-group row text-center m-t-10">
				<div class="col-12">
					<button data-register-submission="2" class="btn btn-md btn-block btn-primary waves-effect waves-light" type="submit">Sign Up</button>
				</div>
			</div>
		</div>
		
		<div class="row m-t-30 m-b-0">
			<div class="col-12 text-center">
				<p class="text-muted m-b-0">Already have an account?  <a href="/login" class="text-dark m-l-5"><b>Sign In</b></a></p>
			</div>
		</div>
	</div>';

} else if($variable2 == 'standard'){

	$login_fields = '
	<div class="account-logo-box">
		<h2 class="text-uppercase text-center">
			<a href="/" class="text-success">
				<span><img src="/content/theme/images/logo_dark.png" alt="" height="30"></span>
			</a>
		</h2>
		<h5 class="text-uppercase font-bold m-b-5 m-t-50">Register Account</h5>
	</div>
	<div class="account-content">
		<div class="form-horizontal" id="register_standard_form">

			<div class="form-group row m-b-10">
				<div class="col-12">
					<input class="form-control" name="fname" type="text" id="username" required="" placeholder="Full Name..">
				</div>
			</div>

			<div class="form-group row m-b-10">
				<div class="col-12">
					<input class="form-control" name="email" type="email" id="emailaddress" required="" placeholder="Email Address..">
				</div>
			</div>

			<div class="form-group row m-b-10">
				<div class="col-12">
					<input class="form-control" type="password" required="" id="password1" data-parsley-minlength="6" placeholder="Password..">
				</div>
			</div>
			<div class="form-group row m-b-20">
				<div class="col-12">
					<input class="form-control" type="password" required="" id="password2" data-parsley-minlength="6" data-parsley-equalto="#password1" placeholder="Confirm Password..">
				</div>
			</div>
			
			<div class="form-group row m-b-10"><div class="col-12">
				<!-- SPACING DIV -->
			</div></div>

			<div class="form-group row m-b-10">
				<div class="col-12">
					<div class="checkbox checkbox-primary">
						<input id="terms_and_conditions" type="checkbox" required style="cursor:pointer">
						<label for="terms_and_conditions">
							I accept the <a href="#">Terms and Conditions</a>
						</label>
					</div>
				</div>
			</div>

			<div id="register_status_panel"></div>
			
			<div class="form-group row text-center m-t-10">
				<div class="col-12">
					<button data-register-submission="1" class="btn btn-md btn-block btn-primary waves-effect waves-light" type="submit">Sign Up</button>
				</div>
			</div>
		</div>
		
		<div class="row m-t-30 m-b-0">
			<div class="col-12 text-center">
				<p class="text-muted m-b-0">Already have an account?  <a href="/login" class="text-dark m-l-5"><b>Sign In</b></a></p>
			</div>
		</div>
	</div>';

} else if($variable2 == 'activation'){

	$status_text = '
	<h1 class="text-error">ERROR</h1>
	<h2 class="text-uppercase text-error m-t-20" style="font-size:22px; line-height:1.25">Invalid or Expired code</h2>
	<p class="text-muted m-t-20 m-b-0">Please try again.</p>
	<a class="btn btn-md btn-block btn-primary waves-effect waves-light m-t-30" href="https://'.GLOBAL_DOMAIN_NAME.'">Register</a>';

	$users = $addable->QUERY(array(
		'query' => 'SELECT *
			FROM users
			WHERE users_email = :usersEmail
			AND users_activation_code = :usersActivationCode',
		'replacementArray' => array('usersEmail' => base64_decode($variable3), 'usersActivationCode' => $variable4),
		'returnArray' => array('users_id','users_activation_timestamp','users_activation_completed')
	));

	$currentTimestamp = time() - (3600 * 24);
	if(empty($users['users_activation_completed'][0]) || $users['users_activation_completed'][0] != 1){
		if(!empty($users['users_activation_timestamp'][0]) && (strtotime($users['users_activation_timestamp'][0]) > $currentTimestamp)){

			$users2 = $addable->QUERY(array(
				'query' => 'UPDATE users
					SET 
						users_activation_completed = "1",
						users_account_created = :accountCreated
					WHERE 
						users_id = :usersId',
				'replacementArray' => array('usersId' => $users['users_id'][0],'accountCreated' => date('Y-m-d H:i:s')),
				'returnArray' => array('users_id')
			));

			$status_text = '
			<h1 class="text-error">SUCCESS</h1>
			<h2 class="text-uppercase text-error m-t-30" style="font-size:22px; line-height:1.25">YOUR ACCOUNT HAS BEEN ACTIVATED</h2>
			<p class="text-muted m-t-30 m-b-0">Click below to login.</p>
			<a class="btn btn-md btn-block btn-primary waves-effect waves-light m-t-50" href="/login">Login</a>';

		}
	} else {

		$status_text = '
		<h1 class="text-error">ERROR</h1>
		<h2 class="text-uppercase text-error m-t-30" style="font-size:22px; line-height:1.25">Already Activated</h2>
		<p class="text-muted m-t-30 m-b-0">This account has already been activated, please login instead.</p>
		<a class="btn btn-md btn-block btn-primary waves-effect waves-light m-t-50" href="/login">Login</a>';

	}

echo '
<body class="bg-accpunt-pages">
	<section>
		<div class="container">
			<div class="row">
				<div class="col-sm-12 text-center">
					<div class="wrapper-page">
						<div class="account-pages">
							<div class="account-box">	
								<div class="account-content">
									'.$status_text.'			
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>';

} else {
	include_once(DOCROOT.'content/system/404.php');
}

if(!empty($login_fields) && $variable2 !== 'activation'){

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