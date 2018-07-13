<?php
/**
 * Created by PhpStorm.
 * User: Lewis
 * Date: 16/03/2018
 * Time: 20:21
 */

echo '
<body id="load404" class="be-splash-screen fade in" style="opacity:0">
	<div class="be-wrapper be-error be-error-404">
	  <div class="be-content">
		<div class="main-content container-fluid">
		  <div class="error-container">
			<div class="error-number">404</div>
			<div class="error-description" style="text-transform:uppercase;">The page you are looking for may have been moved or removed</div>
			<div class="error-goback-text">Would you like to go home?</div>
			<div class="error-goback-button"><a href="https://'.LOCAL_DOMAIN_NAME.'" class="btn btn-xl btn-primary">Let\'s go home</a></div>
			<div class="splash-footer">&copy; '.date('Y').' '.COMPANY_NAME.'</div>
		  </div>
		</div>
	  </div>
	</div>
	
	<script type="text/javascript">
		window.onload = function() {
			document.getElementById("load404").style.opacity = "1";
		}
	</script>
';