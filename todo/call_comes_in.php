<?php

echo __DIR__ . '/twilio-php-master/Twilio/autoload.php';

use Twilio\Rest\Client;

$sid = 'AC224aa9a347959fc6471cf8e7b81d3e98';
$token = 'a22e6f5cd92801ddbe25502ee221a9c2';

$client = new Client($sid, $token);


/*
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
?>
<Response>
    <Say>Hello sexy <?php echo $name ?>.</Say>
    <Play>http://demo.twilio.com/hellomonkey/monkey.mp3</Play>
    <Gather numDigits="1" action="hello-monkey-handle-key.php" method="POST">
        <Say>To speak to a real monkey, press 1.  Press any other key to start over.</Say>
    </Gather>
</Response>*/


#require_once($_SERVER['DOCUMENT_ROOT'].'/content/twi_integration/twi_api/autoload.php');
#use Twilio\Rest\Client;

#require_once($_SERVER['DOCUMENT_ROOT'].'/content/connection/db_connect.php');
/*
#$_SERVER['DOCUMENT_ROOT'].'/content/twi_integration/twi_api/autoload.php'
if (!mkdir($_SERVER['DOCUMENT_ROOT'].'/content/twi_integrationa', 0777, true)) {
    die('Failed to create folders...');
}

echo getmyuid().':'.getmygid();

#$client = new Client(TWI_SID,TWI_TOKEN);

/*$account = $client->api
    ->accounts("ACXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX")
    ->fetch();
*/
#echo $account->dateCreated->format('Y-m-d H:i:s');


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
 * */



