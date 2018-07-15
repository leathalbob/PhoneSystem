<?php
/**
 * Created by Lewis Stevens
 * Date: 15/07/2018
 * Time: 17:04
 */

 switch($variable4){
	case 'sip_phone_lines':
		include_once(DOCROOT.'content/page_content/dashboard_content/reseller/customer/sip_phone_lines.php');
		break;

	default:
		echo 'dashboard';
}