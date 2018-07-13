<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/content/connection/db_connect.php');

$return = array();
$email = $_POST['email'];
$password = $_POST['password'];


if(empty($email) || empty($password)){
	$return['error_message'] = 'All fields must be completed';
} else {
	if(strpos($email,'@') > 0 && strpos($email,'.') > 0){

		$account = new ACCOUNT_FUNCTION();
		$logIn = $account->logIn($email,$password);

		if($logIn === false){
			$return['error_message'] = 'Login Credentials Incorrect or Account Not Active<br/><br/>
			<a href="https://'.LOCALDOMAIN_NAME.'/login/reset">Click Here</a> to reset your password.';
		}

	} else {
		$return['error_message'] = 'A valid email address is required';
	}
}

if(strlen($return['error_message']) > 0){
	echo json_encode(array('status' => 2,'error_message' => $return['error_message']));
} else {
	echo json_encode(array('status' => 1));
}

?>