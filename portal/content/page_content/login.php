<?php

$addable = new ADDABLE();
$dec_variable3 = $addable->hardCode('decrypt',$variable3);

switch($variable2){
	case 'reset':

		$login_fields = '
		<form id="preset_form">
			<span class="splash-title xs-pb-20"></span>
			<div class="form-group">
				<input type="email" name="email" required="" value="" placeholder="E-mail" autocomplete="off" class="form-control">
				<div id="password_reset_status_panel">UNKNOWN ERROR</div>
			</div>
			
			<div class="form-group xs-pt-10">
				<button type="button" data-preset-submission="" class="btn btn-block btn-primary btn-xl">Reset Password</button>
			</div>
			
			<div class="form-group xs-pt-10" style="text-align:center">
				<a href="http://'.LOCAL_DOMAIN_NAME.'/login">Switch to Login</a>
			</div>
		</form>';

		break;

	/*
		$login_fields = '
		<form id="login_form">
			<span class="splash-title xs-pb-20"></span>
			<div class="form-group">
				<input type="email" name="email" required="" value="' .$addable->hardCode('decrypt',$variable4).'" placeholder="E-mail" autocomplete="off" class="form-control">
			</div>
			
			<div class="form-group signup-password">
				<input id="password" type="password" placeholder="Password" name="password"  class="form-control">
				<div id="login_status_panel">UNKNOWN ERROR</div>
			</div>
			
			<div class="form-group xs-pt-10">
				<button type="button" data-login-submission="" class="btn btn-block btn-primary btn-xl">Login</button>
			</div>
			
			<div class="form-group xs-pt-10" style="text-align:center">
				<a href="http://'.LOCAL_DOMAIN_NAME.'/login/reset">Forgot Password?</a>
			</div>
		</form>';
		break;*/
	case '':
		$login_fields = '
		<form id="login_form">
			<span class="splash-title xs-pb-20"></span>
			<div class="form-group">
				<input type="email" name="email" required="" value="' .$addable->hardCode('decrypt',$variable4).'" placeholder="E-mail" autocomplete="off" class="form-control">
			</div>
			
			<div class="form-group signup-password">
				<input id="password" type="password" placeholder="Password" name="password"  class="form-control">
				<div id="login_status_panel">UNKNOWN ERROR</div>
			</div>
			
			<div class="form-group xs-pt-10">
				<button type="button" data-login-submission="" class="btn btn-block btn-primary btn-xl">Login</button>
			</div>
			
			<div class="form-group xs-pt-10" style="text-align:center">
				<a href="http://'.LOCAL_DOMAIN_NAME.'/login/reset">Forgot Password?</a>
			</div>
		</form>';

		break;

	default:
		include_once(DOCROOT.'content/system/404.php');
}

if(!empty($login_fields)){
echo '
	<body class="be-splash-screen">
	<div class="be-wrapper be-login be-signup">
		<div class="be-content">
			<div class="main-content container-fluid">
				<div class="splash-container sign-up">
					<div class="panel panel-default panel-border-color panel-border-color-primary">
						<div class="panel-heading">
							<img src="/content/images/theme/logo-xx.png" alt="logo" width="102" height="27" class="logo-img">
						</div>
						
						<div class="panel-body">
							'.$login_fields.'
						</div>               
					</div>
					<div class="splash-footer">&copy; '.date('Y').' '.COMPANY_NAME.'</div>
				</div>
			</div>
		</div>
	</div>';
}
