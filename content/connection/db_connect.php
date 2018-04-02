<?php
$twi_location = $_SERVER['DOCUMENT_ROOT'] . '/content/twi_int/twi_api/Twilio/autoload.php';
if(file_exists($twi_location)){
	require($twi_location);
} else {
	die('ERROR: COULD NOT FIND TWI AUTOLOADER');
}

class ADDABLE{
	private $HOSTNAME;
	private $DATABASE_NAME;
	private $DATABASE_USER;
	private $DATABASE_PASS;
	private $DEVMODE = TRUE;
	private $COOKIE_EXP;


	function __construct(){
		date_default_timezone_set("Europe/London");
		$this->COOKIE_EXP = (time() + ((60 * 60) * 6));

		if($this->DEVMODE === TRUE){
			$devStyle = '
			<style type="text/css">
			.xdebug-error{
				position:fixed;
				bottom:0px;
				left:0px;
				width:100%;
				max-height:70px;
				overflow-x:hidden;
				overflow-y:scroll;
			}
			</style>';

			ini_set('display_errors', '1');
			ini_set('display_startup_errors', 1);
		}
	}

	private function ConnectionDetails(){
		$this->HOSTNAME      = 'localhost';
		$this->DATABASE_NAME = 'addablen_twi_db';
		$this->DATABASE_USER = 'addablen_twi_usr';
		$this->DATABASE_PASS = '+X3LG%izMUBQ';
	}

	public function logging($message){
		$file = $_SERVER['DOCUMENT_ROOT'].'/content/logs/main_log.txt';
		$filecontent = file_get_contents($file);
		$filecontent .= '[ERROR] '.$message.'
';
		$fopen = file_put_contents($file,$filecontent);
	}

	public function QUERY($data)
    {
        $this->ConnectionDetails();
        try {
            $db = new PDO('mysql:host=' . $this->HOSTNAME . ';dbname=' . $this->DATABASE_NAME, $this->DATABASE_USER, $this->DATABASE_PASS);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $PDO_1 = $db->prepare($data['query']);
            $PDO_1->execute($data['replacementArray']);

            $return_array = array();

            if (count($data['returnArray']) > 0) {
                if ($PDO_1->errorCode() == 0) {
                    while (($row = $PDO_1->fetch()) != false) {
                        foreach ($data['returnArray'] as $field) {
                            $return_array[$field][] = $row[$field];
                        }
                    }
                }
            }

            $db = NULL;
            return $return_array;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

	public function hardCode($action, $string, $type = 0){
		$output 		= false;
		$encrypt_method = "AES-256-CBC";
		$secret_key 	= "FjkhujuiUIH41";
		$secret_iv 		= "523500bb0dfs";

		$key = hash('sha256', $secret_key);
		$iv = substr(hash('sha256', $secret_iv), 0, 16);

		if($action == 'encrypt'){
			$output = preg_replace('/[=]+/','',base64_encode(openssl_encrypt($string, $encrypt_method, $key, 0, $iv)));
		} else if($action == 'decrypt'){
			$output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
		}

		return $output;
	}

	public function getIpAddress(){
		if(!empty($_SERVER['HTTP_CLIENT_IP'])){
			$ip = $_SERVER['HTTP_CLIENT_IP'];
		} else if(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		} else {
			$ip = $_SERVER['REMOTE_ADDR'];
		}
		return $ip;
	}

}

class ACCOUNT_FUNCTION extends ADDABLE{

    public function Register($registerFields = array()){
		$users = $this->QUERY(array(
			'query' => 'SELECT * FROM users WHERE users_email = :usersEmail',
			'replacementArray' => array('usersEmail' => $registerFields['usersEmail']),
			'returnArray' => array('users_id')
		));

		if(count($users['users_id']) < 1){
			$this->QUERY(array(
				'query' => '
					INSERT INTO users (
						users_email,
						users_password
					) VALUES (
						:usersEmail,
						:usersPassword
					)',
					'replacementArray' => array(
						'usersEmail' => $registerFields['usersEmail'],
						'usersPassword' => password_hash($registerFields['usersPassword'],PASSWORD_BCRYPT)
					)
			));

			/*
			 * SEND ACTIVATION EMAILS ETC.
			 * */

			return true;
		} else {
			return false;
		}
    }

	public function logIn($username,$password){
		$users = $this->QUERY(array(
			'query' => 'SELECT * FROM users WHERE users_email = :usersEmail',
			'replacementArray' => array('usersEmail' => $username),
			'returnArray' => array('users_id','users_password')
		));

		if(password_verify($password,$users['users_password'][0])){
			$cookieKey = $this->hardCode('encrypt', $users['users_id'][0].'-'.rand(111111,999999));
			$cookieKey2 = $this->hardCode('encrypt', $this->getIpAddress());

			$this->QUERY(array(
				'query' => 'UPDATE users SET 
					users_ipaddr = "'.$this->getIpAddress().'",
					users_lastlogin = "'.date('Y-m-d H:i:s').'",
					users_sessionkey = "'.$cookieKey.'",
					users_sessionkey2 = "'.$cookieKey2.'"
				WHERE users_id = :users_id',
				'replacementArray' => array('users_id' => $users['users_id'][0]),
				'returnArray' => array()
			));

			setcookie('cookieKey1', $cookieKey, (time() + 6000), '/', $_SERVER['SERVER_NAME']);
			setcookie('cookieKey2', $cookieKey2, (time() + 6000), '/', $_SERVER['SERVER_NAME']);

			return true;
		} else {
			return false;
		}
    }

	public function logOut(){
		$this->QUERY(array(
			'query' => 'UPDATE users SET 
				users_sessionkey = "", 
				users_sessionkey2 = ""
			WHERE users_sessionkey = :sessionKey
			AND users_sessionkey2 = :sessionKey2',
			'replacementArray' => array(
				'sessionKey' => $_COOKIE['cookieKey1'],
				'sessionKey2' => $_COOKIE['cookieKey2']
			),
			'returnArray' => array()
		));

		setcookie('cookieKey1','', (time() - 6000), '/', $_SERVER['SERVER_NAME']);
		setcookie('cookieKey2','', (time() - 6000), '/', $_SERVER['SERVER_NAME']);

	}

    public function isLoggedIn(){
		$users = $this->QUERY(array(
			'query' => 'SELECT * FROM users WHERE users_sessionkey = :sessionKey, users_sessionkey2 = :sessionKey2',
			'replacementArray' => array(
				'sessionKey' => $_COOKIE['sessionKey'],
				'sessionKey2' => $_COOKIE['sessionKey2']
			),
			'returnArray' => array('users_email')
		));

		if(count($users) > 0){
			return true;
		} else {
			return false;
		}
	}

}

$root_server 		= $_SERVER['SERVER_NAME'];

$strip_array = array('www');
foreach($strip_array as $strip2){
	$strip = $strip2.'.';
	if(strpos($root_server,$strip) !== false){
		$subdomain = str_replace('.','',$strip);
	}
	$root_server = str_replace($strip,'',$root_server);
}

$root				= '/';
$image_server		= '/content/images';
$javascript_server	= '/content/javascripts';
$stylesheet_server	= '/content/stylesheets';

$mobile				= 'hidden-md hidden-lg';
$not_mobile 		= 'hidden-xxs hidden-xs hidden-sm';


if(!empty($_GET['variable1'])){ $variable1 = preg_replace('/[^\w ]+/','',$_GET['variable1']); }
if(!empty($_GET['variable2'])){	$variable2 = preg_replace('/[^\w ]+/','',$_GET['variable2']); }
if(!empty($_GET['variable3'])){ $variable3 = preg_replace('/[^\w ]+/','',$_GET['variable3']); }
if(!empty($_GET['variable4'])){ $variable4 = preg_replace('/[^\w ]+/','',$_GET['variable4']); }
if(!empty($_GET['variable5'])){ $variable5 = preg_replace('/[^\w ]+/','',$_GET['variable5']); }
