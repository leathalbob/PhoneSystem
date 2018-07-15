<?php

 if($account->isReseller() === true){

	switch($variable2){
		case 'customer':
			include_once(DOCROOT.'content/page_content/dashboard_content/reseller/dashboard_sidebar_customer.php');
			break;

		default:
			include_once(DOCROOT.'content/page_content/dashboard_content/reseller/dashboard_sidebar_default.php');
	}

} else {
	include_once(DOCROOT.'content/page_content/dashboard_content/standard/dashboard_sidebar_default.php');
}