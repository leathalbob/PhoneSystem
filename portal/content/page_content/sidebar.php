<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 29/04/2018
 * Time: 20:21
 */

 if($account->isReseller() === true){
	include_once(DOCROOT.'content/page_content/dashboard_content/reseller/dashboard_sidebar_default.php');
} else {
	include_once(DOCROOT.'content/page_content/dashboard_content/standard/dashboard_sidebar_default.php');
}

echo '
<div class="left side-menu">
	<div class="slimscroll-menu" id="remove-scroll">
		<div id="sidebar-menu">	
			<ul class="metismenu" id="side-menu">			
				<li class="menu-title">Navigation</li>
				
				<li>
					<a href="#"><i class="fi-paper"></i> <span>Customers</span></a>
				</li>
				<li>
					<a href="#"><i class="fi-paper"></i> <span>Billing</span></a>
				</li>
				<li>
					<a href="#"><i class="fi-paper"></i> <span>Store</span></a>
				</li>
				<li>
					<a href="#" class="disabled"><i class="fi-paper"></i> <span>Support</span></a>
				</li>
			</ul>
		</div>
		<div class="clearfix"></div>
	</div>
</div>';