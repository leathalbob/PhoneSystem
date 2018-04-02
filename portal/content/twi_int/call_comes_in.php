<?php
require_once(DOCROOT.'content/connection/db_connect.php');
require_once(DOCROOT.'content/includes/sip_functions.php');

/* ONLY REQUIRED FOR VIEWING */
require_once(DOCROOT.'content/includes/header.php');
echo '<div id="sip_dump"><iframe src="/dashboard/content/includes/sip_dump.php"></iframe></div>';

$sip = new SIP_FUNCTIONS;
var_dump($sip->GET_SIP_ACCOUNT_USAGE("ACfc09fb17c8ec8af2a4d0a27eeb7d747d"));
/*var_dump($sip->RETURN_SIP_ACCOUNTS());

#

$users = $this->QUERY(array(
	'query' => 'SELECT * FROM users WHERE users_email = :usersEmail',
	'replacementArray' => array('usersEmail' => $registerFields['usersEmail']),
	'returnArray' => array('users_id')
));

/*

use Twilio\Rest\Client;

$client = new Client(TWI_SID, TWI_TOKEN);
foreach ($client->api->accounts->read() as $account) {
    echo var_dump($account).'<br/>
    ';
}

$account = $client->api
    ->accounts("ACXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX")
    ->fetch();

*/
/*
echo $account->dateCreated->format('Y-m-d H:i:s');

*/
#require __DIR__.'/content/twi_integration/twi_api/autoload.php';


#twilio-php-master/Twilio/autoload.php';



/*
 * $_SERVER['DOCUMENT_ROOT']
 * require '/home/addablenet/public_html/twilio-php-master/Twilio/autoload.php';
 * */




/*


*/


/*$addable = new ADDABLE;
$addable->QUERY(array(
    'query' => 'INSERT INTO logging (logging_dump) VALUES (\''.json_encode($_POST).'\')',
    'replacementArray' => array(),
    'returnArray' => array()
));

$account_sid = $_POST['AccountSid'];
$calling_from = $_POST['From'];
$calling_to = $_POST['To'];

header("content-type: text/xml");
echo '<?xml version="1.0" encoding="UTF-8"?>
<Response>
    <Say>Hello Mr Stranger. I note that you are calling from "'.$calling_from.'". The number you are trying to call is "'.$calling_to.'"</Say>
    <Play>http://demo.twilio.com/hellomonkey/monkey.mp3</Play>
    <Dial>
        <Sip>sip:100@addable.sip.us1.twilio.com</Sip>
    </Dial>
</Response>';

/*
 * TOKENS IN DB CONNECT FOR PHP SCRIPTS.. HAVE SCRIPT GENERATE A NEW ACCOUNT AND SUBACCOUNT.
 *
 * <Gather numDigits="1" action="hello-monkey-handle-key.php" method="POST">
        <Say>To speak to a real monkey, press 1.  Press any other key to start over.</Say>
    </Gather>


$people = array(
    "+447581715724"=>"Curious George",
    "+14158675310"=>"Boots",
    "+14158675311"=>"Virgil",
    "+14158675312"=>"Marcel"
);

if(!$name = $people[$_REQUEST['From']])
    $name = "Monkey";

header("content-type: text/xml");
echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";

<Response>
    <Say>Hello sexy <?php echo $name ?>.</Say>
    <Play>http://demo.twilio.com/hellomonkey/monkey.mp3</Play>
    <Gather numDigits="1" action="hello-monkey-handle-key.php" method="POST">
        <Say>To speak to a real monkey, press 1.  Press any other key to start over.</Say>
    </Gather>
</Response>*/
