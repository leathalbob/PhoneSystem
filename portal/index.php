<?php
require_once('content/connection/db_connect.php');

$account = new ACCOUNT_FUNCTION;

if($variable1 === 'logout'){
	 $account->logOut();
} else if($variable1 === 'call_in'){
	include_once(DOCROOT.'content/twi_int/call_in.php');
	exit;
} else if($variable1 === 'call_out'){
	include_once(DOCROOT.'content/twi_int/call_out.php');
	exit;
}

echo '
<!DOCTYPE html>
<html lang="en">
<head>';

	include_once(DOCROOT.'content/includes/header.php');
	include_once(DOCROOT.'content/includes/topbar.php');

echo '
</head>';

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


