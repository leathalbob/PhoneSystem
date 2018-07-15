<?php
require_once(DOCROOT.'content/connection/db_connect.php');
require_once(DOCROOT.'content/includes/sip_functions.php');

$sip = new SIP_FUNCTIONS;
$sip->RETURN_SIP_ACCOUNTS();
