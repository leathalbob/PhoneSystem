<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/content/connection/db_connect.php');

$return = array();
$email = $_POST['email'];
$pass1 = $_POST['pass1'];
$pass2 = $_POST['pass2'];
$fname = $_POST['fname'];
$selection = $_POST['selection'];

if(empty($email) || empty($pass1) || empty($pass2)){
	$return['error_message'] = 'All fields must be completed';
} else {
	if(strpos($email,'@') > 0 && strpos($email,'.') > 0){
		if($pass1 === $pass2){
			if(strlen($pass1) > 5){

				$account = new ACCOUNT_FUNCTION();

				if($selection == 2){
					$register = $account->Register(array(
						'usersEmail' => $email,
						'usersPassword' => $pass1,
						'resellerAccount' => true,
						'usersFullName' => $fname
					));
				} else {
					$register = $account->Register(array(
						'usersEmail' => $email,
						'usersPassword' => $pass1,
						'resellerAccount' => false,
						'usersFullName' => $fname
					));
				}

				if($register === 0){
					$return['error_message'] = 'Email Address is already registered, please choose an alternative 
					or <a href="https://'.LOCALDOMAIN_NAME.'/login">Click Here</a> to login';
				} else if($register === 2){
					$return['error_message'] = 'Email Address is already registered however the account has not been activated.<br/><br/>
					The activation email has been resent.';
				}

			} else {
				$return['error_message'] = 'Password must be at least 6 characters';
			}
		} else {
			$return['error_message'] = 'Passwords do not match';
		}
	} else {
		$return['error_message'] = 'A valid email address is required';
	}
}

if(strlen($return['error_message']) > 0){
	echo json_encode(array('status' => 2,'error_message' => $return['error_message'],'a'=>$email));
} else {
	echo json_encode(array('status' => 1));
}

?>