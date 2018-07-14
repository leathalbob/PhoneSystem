<?php
define('DOCROOT','');
define('COMPANY_NAME','Phone Desk');
define('GLOBAL_DOMAIN_NAME','reviveip.com');
define('LOCAL_DOMAIN_NAME','portal.reviveip.com');

$twi_location = $_SERVER['DOCUMENT_ROOT'].'/content/twi_int/twi_api/Twilio/autoload.php';
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
	private $SMTP_HOST = 'mail.addable.net';
	private $SMTP_USERNAME = 'admin@brendonstore.com';
	private $SMTP_PASSWORD = 'EgressMaresHalerNoncom18';
	private $SMTP_PORT = 587;
	private $SMTP_AUTH = true;

	protected $COOKIE_EXP;

	function __construct(){
		date_default_timezone_set("Europe/London");
		$this->COOKIE_EXP = (time() + ((60 * 60) * 6));

		if($this->DEVMODE === TRUE){
			ini_set('display_errors', 1);
			ini_set('display_startup_errors', 1);
		}
	}

	private function ConnectionDetails(){
		$this->HOSTNAME      = 'localhost';
		$this->DATABASE_NAME = 'reviveip_twidb';
		$this->DATABASE_USER = 'reviveip_twiusr';
		$this->DATABASE_PASS = 'F#LRvAk5sm~IB+C2.';
	}

	public function logging($message){
		$file = DOCROOT.'content/logs/main_log.txt';
		$filecontent = file_get_contents($file);
		$filecontent .= '[ERROR] '.$message.'
';
		$fopen = file_put_contents($file,$filecontent);
	}

	public function QUERY($data){
        $this->ConnectionDetails();
        try{
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
        } catch (PDOException $e){
            return $e->getMessage();
        }
    }
	/*
	PROCEDURE STATEMENT
	$aq2 = $aq->QUERY(
		array(
			'query' => 'CALL select_accounts(:usersId)',
			'returnArray' => array('account_name'),
			'replacementArray' => array('usersId' => '1')
		)
	);
	*/

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

	public function randomValue($stringLength = 20){
		$str = "";
		$characters = array_merge(range('A','Z'), range('a','z'), range('0','9'));
		$max = count($characters) - 1;
		for ($i = 0; $i < $stringLength; $i++) {
			$rand = mt_rand(0, $max);
			$str .= $characters[$rand];
		}
		return $str;
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

	public function SendMail(
		$messages = array(
			array(
				'TO'			=> '',
				'SUBJECT'		=> '',
				'HTML_BODY'		=> '',
				'PLAIN_BODY'	=> '',
				'BCC'			=> array(),
				'FROM'			=> ''
			))
		)
	{

		if(!include($_SERVER['DOCUMENT_ROOT'].'/content/mail/PHPMailerAutoload.php')){
			return "Autoload Failed.";
		}

		foreach($messages as $message){
			if(!empty($message['TO'])){
				$mail = new PHPMailer;
				$mail->isSMTP();

				$mail->Host = $this->SMTP_HOST;
				$mail->Username = $this->SMTP_USERNAME;
				$mail->Password = $this->SMTP_PASSWORD;
				$mail->Port = $this->SMTP_PORT;
				$mail->SMTPAuth = $this->SMTP_AUTH;

				$mail->isHTML(true);
				$mail->From = $message['FROM'];
				$mail->FromName = $message['FROM'];
				$mail->addAddress($message['TO']);

				foreach($message['BCC'] as $address){
					$mail->addBcc($address);
				}

				$mail->Subject = $message['SUBJECT'];
				$mail->Body = $message['HTML_BODY'];
				$mail->AltBody = $message['PLAIN_BODY'];
				$mail->SMTPDebug = false;

				$mail->send();
				sleep(1);
			}
		}

	}
}



class ACCOUNT_FUNCTION extends ADDABLE{

    public function Register($registerFields = array()){
    	$return = 0;

		$users = $this->QUERY(array(
			'query' => 'SELECT * FROM users WHERE users_email = :usersEmail',
			'replacementArray' => array('usersEmail' => $registerFields['usersEmail']),
			'returnArray' => array('users_id')
		));

		$activationCode = $this->randomValue(30);
		$valLink = 'https://'.$_SERVER['SERVER_NAME'].'/register/activation/'.base64_encode($registerFields['usersEmail']).'/'.$activationCode;
		$email_data = array(
			'TO' => $registerFields['usersEmail'],
			'SUBJECT' => COMPANY_NAME.' Email Verification',

			'HTML_BODY' => '
			<table width="100%">
				<tr>
					<td colspan="3" height="30px">&nbsp;</td>
				</tr>
				<tr>
					<td width="40px">&nbsp;</td>
					<td style="text-align:center; font-size:40px; text-transform:uppercase;">'.COMPANY_NAME.'</td>
					<td width="40px">&nbsp;</td>
				</tr>
				<tr>
					<td colspan="3" height="30px">&nbsp;</td>
				</tr>
				<tr>
					<td width="40px">&nbsp;</td>
					<td style="text-align:center">Please click this link to verify your email account with the company '.COMPANY_NAME.'.</td>
					<td width="40px">&nbsp;</td>
				</tr>
				<tr>
					<td colspan="3" height="10px">&nbsp;</td>
				</tr>
				<tr>
					<td width="40px">&nbsp;</td>
					<td style="text-align:center"><a href="'.$valLink.'">'.$valLink.'</a></div></td>
					<td width="40px">&nbsp;</td>
				</tr>
				<tr>
					<td colspan="3" height="60px">&nbsp;</td>
				</tr>
			</table>
			',
			'PLAIN_BODY' => 'Please click this link to verify your email account with the company '.COMPANY_NAME.'. '.$valLink,

			'BCC' => array('admin@addable.net'),
			'FROM' => 'no-reply@'.GLOBAL_DOMAIN_NAME
		);

		/* TODO: REMOVE BCC USERS AFTER TESTING */

		if(count($users['users_id']) < 1){

			/* USERS DO NOT EXIST */
			$usersReseller = 0;
			if($registerFields['resellerAccount'] === true){
				$usersReseller = 1;
			}

			$this->QUERY(array(
				'query' => '
					INSERT INTO users (
						users_email,
						users_name,
						users_password,
						users_reseller,
						users_activation_code,
						users_activation_timestamp
					) VALUES (
						:usersEmail,
						:usersFullName,
						:usersPassword,
						:usersReseller,
						:usersActivationCode,
						:usersActivationTimestamp
					)',
					'replacementArray' => array(
						'usersEmail' => $registerFields['usersEmail'],
						'usersFullName' => $registerFields['usersFullName'],
						'usersPassword' => password_hash($registerFields['usersPassword'],PASSWORD_BCRYPT),
						'usersReseller' => $usersReseller,
						'usersActivationCode' => $activationCode,
						'usersActivationTimestamp' => date("Y-m-d H:i:s")
					)
			));

			$email = new ADDABLE;
			$email->SendMail(array($email_data));

			$return = 1;

		} else {

			/* USERS EXIST BUT NOT ACTIVATED */
			$users_unregistered = $this->QUERY(array(
				'query' => 'SELECT * FROM users WHERE users_email = :usersEmail AND users_activation_completed = "0"',
				'replacementArray' => array('usersEmail' => $registerFields['usersEmail']),
				'returnArray' => array('users_id')
			));

			if(count($users_unregistered['users_id']) > 0){

				$this->QUERY(array(
					'query' => '
						UPDATE users SET 
							users_activation_code = :usersActivationCode,
							users_activation_timestamp = :usersActivationTimestamp
						WHERE users_email = :usersEmail',
						'replacementArray' => array(
							'usersEmail' => $registerFields['usersEmail'],
							'usersActivationCode' => $activationCode,
							'usersActivationTimestamp' => date("Y-m-d H:i:s")
						)
				));

				$email = new ADDABLE;
				$email->SendMail(array($email_data));

				$return = 2;
			}

		}

		return $return;
    }

	public function resetPassword($username,$pass1,$pass2,$authCode){
		$users = $this->QUERY(array(
			'query' => 'SELECT * FROM users WHERE users_email = :usersEmail',
			'replacementArray' => array('usersEmail' => $username),
			'returnArray' => array('users_id')
		));

		if(count($users['users_id']) > 0){
			if(!empty($authcode)){


			} else {
				$activationCode = $this->randomValue(40);
				$valLink = 'https://'.LOCAL_DOMAIN_NAME.'/login/reset/'.base64_encode($username).'/'.$activationCode;

				$email_data = array(
					'TO' => $username,
					'SUBJECT' => COMPANY_NAME.' Password Reset',

					'HTML_BODY' => '
					<table width="100%">
						<tr>
							<td colspan="3" height="30px">&nbsp;</td>
						</tr>
						<tr>
							<td width="40px">&nbsp;</td>
							<td style="text-align:center; font-size:40px; text-transform:uppercase;">'.COMPANY_NAME.'</td>
							<td width="40px">&nbsp;</td>
						</tr>
						<tr>
							<td colspan="3" height="30px">&nbsp;</td>
						</tr>
						<tr>
							<td width="40px">&nbsp;</td>
							<td style="text-align:center">Please click this link to reset your password.</td>
							<td width="40px">&nbsp;</td>
						</tr>
						<tr>
							<td width="40px">&nbsp;</td>
							<td style="text-align:center"><a href="'.$valLink.'">'.$valLink.'</a></div></td>
							<td width="40px">&nbsp;</td>
						</tr>
						<tr>
							<td colspan="3" height="10px">&nbsp;</td>
						</tr>
						<tr>
							<td colspan="3" height="60px">&nbsp;</td>
						</tr>
					</table>
					',
					'PLAIN_BODY' => 'Please click this link to reset your password. '.$valLink,

					'BCC' => array('thendy@addable.co.uk','lstevens@addable.co.uk'),
					'FROM' => 'no-reply@'.GLOBAL_DOMAIN_NAME
				);

				$this->QUERY(array(
					'query' => '
						UPDATE users SET 
							users_activation_code = :usersActivationCode,
							users_activation_timestamp = :usersActivationTimestamp
						WHERE users_email = :usersEmail',
						'replacementArray' => array(
							'usersEmail' => $username,
							'usersActivationCode' => $activationCode,
							'usersActivationTimestamp' => date("Y-m-d H:i:s")
						)
				));

				/* TODO: REMOVE BCC'S AFTER TESTING */

				$email = new ADDABLE;
				$email->SendMail(array($email_data));
			}
		}
	}

	public function logIn($username,$password){
		$users = $this->QUERY(array(
			'query' => 'SELECT * FROM users WHERE users_email = :usersEmail AND users_activation_completed = "1"',
			'replacementArray' => array('usersEmail' => $username),
			'returnArray' => array('users_id','users_password')
		));

		if(password_verify($password,$users['users_password'][0])){
			$sessionKey1 = $this->hardCode('encrypt', $users['users_id'][0].'-'.rand(111111,999999));
			$sessionKey2 = $this->hardCode('encrypt', $this->getIpAddress());

			$this->QUERY(array(
				'query' => 'UPDATE users SET 
					users_ipaddr = "'.$this->getIpAddress().'",
					users_lastlogin = "'.date('Y-m-d H:i:s').'",
					users_sessionkey1 = "'.$sessionKey1.'",
					users_sessionkey2 = "'.$sessionKey2.'"
				WHERE users_id = :users_id',
				'replacementArray' => array('users_id' => $users['users_id'][0]),
				'returnArray' => array()
			));

			setcookie('sessionKey1', $sessionKey1, $this->COOKIE_EXP, '/', GLOBAL_DOMAIN_NAME);
			setcookie('sessionKey2', $sessionKey2, $this->COOKIE_EXP, '/', GLOBAL_DOMAIN_NAME);

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
			WHERE users_sessionkey = :sessionKey1
			AND users_sessionkey2 = :sessionKey2',
			'replacementArray' => array(
				'sessionKey1' => $_COOKIE['sessionKey1'],
				'sessionKey2' => $_COOKIE['sessionKey2']
			),
			'returnArray' => array()
		));

		setcookie('sessionKey1','', $this->COOKIE_EXP, '/', GLOBAL_DOMAIN_NAME);
		setcookie('sessionKey2','', $this->COOKIE_EXP, '/', GLOBAL_DOMAIN_NAME);

	}

    public function isLoggedIn(){
		$users = $this->QUERY(array(
			'query' => 'SELECT * FROM users 
				WHERE users_sessionkey1 = :sessionKey1 
				AND users_sessionkey2 = :sessionKey2',

			'replacementArray' => array(
				'sessionKey1' => $_COOKIE['sessionKey1'],
				'sessionKey2' => $_COOKIE['sessionKey2']
			),
			'returnArray' => array('users_id')
		));

		if(count($users['users_id']) > 0){
			return true;
		} else {
			return false;
		}
	}

	public function isReseller(){
		if($this->isLoggedIn() === true){
			$users = $this->QUERY(array(
				'query' => 'SELECT * FROM users 
					WHERE users_sessionkey1 = :sessionKey1 
					AND users_sessionkey2 = :sessionKey2',

				'replacementArray' => array(
					'sessionKey1' => $_COOKIE['sessionKey1'],
					'sessionKey2' => $_COOKIE['sessionKey2']
				),
				'returnArray' => array('users_id','users_reseller')
			));

			if($users['users_reseller'][0] === '1'){
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}

	public function getAllFromSessionKey($input = array()){
		$users = $this->QUERY(array(
			'query' => 'SELECT * FROM users 
				WHERE users_sessionkey1 = :sessionKey1 
				AND users_sessionkey2 = :sessionKey2',

			'replacementArray' => array(
				'sessionKey1' => $_COOKIE['sessionKey1'],
				'sessionKey2' => $_COOKIE['sessionKey2']
			),
			'returnArray' => $input
		));

		return $users;
	}
}

$mobile				= 'hidden-md hidden-lg';
$not_mobile 		= 'hidden-xxs hidden-xs hidden-sm';

if(!empty($_GET['variable1'])){ $variable1 = preg_replace('/[^\w ]+/','',$_GET['variable1']); }
if(!empty($_GET['variable2'])){	$variable2 = preg_replace('/[^\w ]+/','',$_GET['variable2']); }
if(!empty($_GET['variable3'])){ $variable3 = preg_replace('/[^\w ]+/','',$_GET['variable3']); }
if(!empty($_GET['variable4'])){ $variable4 = preg_replace('/[^\w ]+/','',$_GET['variable4']); }
if(!empty($_GET['variable5'])){ $variable5 = preg_replace('/[^\w ]+/','',$_GET['variable5']); }
