<?php

$addable = new ADDABLE();
$register_fields = '';

if($variable2 == 'reseller'){

	$register_fields = '
	<div class="panel-body">
		<form id="register_reseller_form">
		<span class="splash-title xs-pb-20"></span>
			<div class="form-group">
				<input type="email" name="email" required="" value="' .$addable->hardCode('decrypt',$variable4).'" placeholder="E-mail" autocomplete="off" class="form-control">
			</div>
			<div class="form-group row signup-password">
				<div class="col-xs-6">
					<input name="pass1" type="password" pattern=".{6,}" required="" title="Minimum of 6 Characters Required" placeholder="Password" class="form-control">
				</div>
				<div class="col-xs-6">
					<input name="pass2" type="password" pattern=".{6,}" required="" title="Minimum of 6 Characters Required" placeholder="Confirm Password" class="form-control">
				</div>
			</div>
			<div class="form-group xs-pt-10">
				<div>
					By creating an account, you agree to the <a href="/terms_and_conditions">terms and conditions</a>.</label>
				</div>
				<input type="hidden" name="acctype" value="'.$addable->hardCode('encrypt',$variable2).'"/>
				<div id="register_status_panel" >UNKNOWN ERROR</div>
			</div>
			<div class="form-group xs-pt-10">
				<button type="button" data-register-submission="2" class="btn btn-block btn-primary btn-xl">Create Your Reseller Account</button>
			</div>
			<div class="form-group xs-pt-10" style="text-align:center">
				<a href="/login">Switch to Login</a>
			</div>
		</form>
	</div>';

	$page_specific_javascript .= '
	$("#register_reseller_form input:nth(0)").focus();';

} else if($variable2 == 'standard'){

	/* TODO: FINISH THIS SECTION */
	$register_fields = '
	<div class="panel-body">
		<form>
			<span class="splash-title xs-pb-20"></span>
			<div class="form-group">
				<input type="email" name="email" required="" value="' .$addable->hardCode('decrypt',$variable4).'" required="" placeholder="E-mail" autocomplete="off" class="form-control">
			</div>
			<div class="form-group row signup-password">
				<div class="col-xs-6">
					<input id="pass1" type="password" pattern=".{6,}" required="" title="Minimum of 6 Characters Required" placeholder="Password" name="pass1" required="" class="form-control">
				</div>
				<div class="col-xs-6">
					<input type="password" pattern=".{6,}" required="" title="Minimum of 6 Characters Required" placeholder="Confirm Password" name="pass2" required="" class="form-control">
				</div>
			</div>
			<div class="form-group xs-pt-10">
				<div class="be-checkbox">
					<input type="checkbox" name="terms" id="remember">
					<label for="remember">By creating an account, you agree the <a href="/terms_and_conditions">terms and conditions</a>.</label>
				</div>
				<div id="register_status_panel">UNKNOWN ERROR</div>
				<input type="hidden" name="acctype" value="'.$addable->hardCode('encrypt',$variable2).'"/>
			</div>
			<div class="form-group xs-pt-10">
				<button type="button" data-register-submission="1" class="btn btn-block btn-primary btn-xl">Create Your Standard Account</button>
			</div>
			<div class="form-group xs-pt-10" style="text-align:center">
				<a href="/login">Switch to Login</a>
			</div>
		</form>
	</div>';

} else if($variable2 == 'activation'){

	$activation_text = 'This code is invalid or has expired.<br/><br/>
	Please register again to generate a new code.';

	$users = $addable->QUERY(array(
		'query' => 'SELECT * FROM users WHERE users_email = :usersEmail',
		'replacementArray' => array('usersEmail' => base64_decode($variable3)),
		'returnArray' => array('users_id','users_activation_code','users_activation_timestamp','users_activation_completed')
	));

	$expiry_time = strtotime('+1 day',$users['users_activation_timestamp'][0]);

	if($users['users_activation_completed'][0] == 1){
		$activation_text = 'This account has already been activated.<br/><br/>
		<a href="https://'.LOCALDOMAIN_NAME.'/login">Click Here</a> to login';

	} else {
		if(
			!empty($users['users_activation_code'][0])
			&& $users['users_activation_code'][0] === $variable4
			&& (date('Y-m-d h:i:s') < $expiry_time)
		){
			$activation_text = 'Your account has been successfully activated<br/><br/>
			<a href="https://'.LOCALDOMAIN_NAME.'/login">Click Here</a> to login';

			$addable->QUERY(array(
				'query' => 'UPDATE users SET users_activation_completed = 1 WHERE users_email = :usersEmail',
				'replacementArray' => array('usersEmail' => base64_decode($variable3)),
				'returnArray' => array('users_id')
			));

		}
	}

	$register_fields .= '
	<div class="panel-body">
		<form>
			<span class="splash-title xs-pb-20"></span>
			<div class="form-group" style="text-align:center;">
			'.$activation_text.'<br/><br/>
			</div>
		</form>
	</div>';

} else {
	include_once(DOCROOT.'content/system/404.php');
}

if(!empty($register_fields)){
echo '
<body class="be-splash-screen">
	<div class="be-wrapper be-login be-signup">
		<div class="be-content">
			<div class="main-content container-fluid">
				<div class="splash-container sign-up">
					<div class="panel panel-default panel-border-color panel-border-color-primary">
						<div class="panel-heading">
							<img src="/content/images/dest/theme/logo-xx.png" alt="logo" width="102" height="27" class="logo-img">
						</div>
						'.$register_fields.'
					</div>
					<div class="splash-footer">&copy; '.date('Y').' '.COMPANY_NAME.'</div>
				</div>
			</div>
		</div>
	</div>';
}
