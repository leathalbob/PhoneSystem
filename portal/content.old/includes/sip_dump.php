<?php
require_once(DOCROOT.'content/connection/db_connect.php');
require_once(DOCROOT.'content/includes/sip_functions.php');

$sip = new SIP_FUNCTIONS;
$sip->SIP_DUMP();
