<?php
/**
 * Created by Lewis Stevens
 * Date: 15/07/2018
 * Time: 19:59
 */

$sipAccount = new SIP_FUNCTIONS;

/*
========================================================
Delete All Sub-Accounts

foreach($sipAccount->RETURN_ACTIVE_SIP_ACCOUNTS() as $account){
	$sipAccount->DELETE_SIP_ACCOUNT($account['AccountId']);
}
========================================================
Create SubAccount

$sipAccount->CREATE_SIP_ACCOUNT('1')
========================================================
*/

echo "SIP

";

#echo $sipAccount->CREATE_SIP_ACCOUNT('1');
#echo $sipAccount->RENAME_SIP_ACCOUNT('1','ttt');
echo $sipAccount->GET_SIP_ACCOUNT_USAGE('1');
