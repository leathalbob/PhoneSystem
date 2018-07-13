<?php
require_once('content/connection/db_connect.php');

$account = new ACCOUNT_FUNCTION;
if($variable1 == 'logmein'){
	$account->login('lewisstevens1@gmail.com','davemira');

	header('Location: /logmein2');

} else if($variable1 == 'logmein2'){
	if($account->isLoggedIn() === true){
		echo '<h2 style="text-align:center"><br/><br/>You are logged in.</h2>	
		<h5 style="text-align:center">SessionKey: ['.$_COOKIE['sessionKey1'].'] - SessionKey2: ['.$_COOKIE['sessionKey2'].']</h5>
		<a href="/logmein" style="text-align:center; width:100%; float:left">Reload</a>';
	} else {
		echo '<h2 style="text-align:center"><br/><br/>You are not logged in.</h2>
		<h5 style="text-align:center">SessionKey: ['.$_COOKIE['sessionKey1'].'] - SessionKey2: ['.$_COOKIE['sessionKey2'].']</h5>
		<a href="/logmein" style="text-align:center; width:100%; float:left">Reload</a>';
	}
}

echo '
<!DOCTYPE html>
<html lang="en">
<head>';

	include_once(DOCROOT.'content/includes/header.php');
	include_once(DOCROOT.'content/includes/topbar.php');

echo '
</head>';

if($variable1 == 'logmein' || $variable1 == 'logmein2'){
	exit;
}

if($account->isLoggedIn() === true){

	switch($variable1){

		case 'terms_and_conditions':
			include_once(DOCROOT.'content/page_content/terms_and_conditions.php');
			break;

		case 'dashboard':
			include_once(DOCROOT.'content/page_content/dashboard.php');
			break;

		default:
			echo '<script type="text/javascript"> window.location.href="/dashboard"; </script>';

	}

} else {

	switch($variable1){

		case 'login':
			include_once(DOCROOT.'content/page_content/login.php');
			break;

		case 'register':
			include_once(DOCROOT.'content/page_content/register.php');
			break;

		default:
			echo '<script type="text/javascript"> window.location.href="/login"; </script>';

	}

}

include_once(DOCROOT.'content/includes/footer.php');

echo '
</body>
</html>';

?>


