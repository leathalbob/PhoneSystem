<?php
$addable = new ADDABLE();

$currentUser = $addable->QUERY(array(
	'query' => 'SELECT * FROM users 
		WHERE users_sessionkey1 = :sessionKey1 
		AND users_sessionkey2 = :sessionKey2',
	'replacementArray' => array(
		'sessionKey1' => $_COOKIE['sessionKey1'],
		'sessionKey2' => $_COOKIE['sessionKey2']
	),
	'returnArray' => array('users_id','users_name')
));

echo '<div id="wrapper">';

include_once($_SERVER['DOCUMENT_ROOT'].'/content/page_content/topbar.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/content/page_content/sidebar.php');

echo '
<div class="content-page">
	<div class="content">
		<div class="container-fluid">';

		if($account->isReseller() === true){
			switch($variable2){
				case 'customers':
					include_once(DOCROOT.'content/page_content/dashboard_content/reseller/dashboard_content_customers.php');
					break;

				default:
					include_once(DOCROOT.'content/page_content/dashboard_content/reseller/dashboard_content_default.php');
			}
		} else {

		}

echo '	</div>
	</div>
	
	<footer class="footer text-right">
		'.date('Y').' &copy; '.COMPANY_NAME.'
	</footer>
</div>';

