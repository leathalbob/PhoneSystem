<?php

echo '<div id="wrapper">';

include_once($_SERVER['DOCUMENT_ROOT'].'/content/page_content/topbar.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/content/page_content/sidebar.php');

/*$users = $addable->QUERY(array(
	'query' => 'SELECT *
		FROM users
		WHERE users_email = :usersEmail
		AND users_activation_code = :usersActivationCode',
	'replacementArray' => array('usersEmail' => base64_decode($variable3), 'usersActivationCode' => $variable4),
	'returnArray' => array('users_id','users_activation_timestamp','users_activation_completed')
));*/




echo '
<div class="content-page">
	<div class="content">
		<div class="container-fluid">';

		if($account->isReseller() === true){
			switch($variable1){
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

