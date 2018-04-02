<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/content/connection/db_connect.php');

$return = array();
$email = $_POST['email'];
$password = $_POST['password'];


if(empty($email) || empty($password)){
	$return['status_message'] = 'All fields must be completed';
} else {
	/*if(strpos($email,'@') > 0 && strpos($email,'.') > 0){

		$account = new ACCOUNT_FUNCTION();
		$logIn = $account->resetPassword($email);

		if($logIn === false){
			$return['status_message'] = 'Login Credentials Incorrect or Account Not Active<br/><br/>
			<a href="http://'.LOCAL_DOMAIN_NAME.'/login/reset">Click Here</a> to reset your password.';
		}

	} else {
		$return['status_message'] = 'A valid email address is required';
	}*/
}
$return['status_message'] = 'no';
echo json_encode(array('status_message' => $return['status_message']));

?>