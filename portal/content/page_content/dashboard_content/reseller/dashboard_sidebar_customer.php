<?php
/**
 * Created by Lewis Stevens
 * Date: 15/07/2018
 * Time: 17:06
 */

echo '
<div class="left side-menu">
	<div class="slimscroll-menu" id="remove-scroll">
		<div id="sidebar-menu">	
			<ul class="metismenu" id="side-menu">			
				<li class="menu-title">Navigation</li>
				<li>
					<a href="/dashboard/customers"><i class="fi-arrow-left"></i> <span>Back to Customers</span></a>
				</li>
				<li>
					<a href="/dashboard/customer/'.$variable3.'"><i class="fi-paper"></i> <span>Dashboard</span></a>
				</li>
				<li>
					<a href="/dashboard/customer/'.$variable3.'/sip_phone_lines"><i class="fi-paper"></i> <span>Sip Phone Lines</span></a>
				</li>
				<li>
					<a href="/dashboard/customer/'.$variable3.'/sip_phone_numbers"><i class="fi-paper"></i> <span>Sip Phone Numbers</span></a>
				</li>
				<li class="disabled">
					<a><i class="fi-paper"></i> <span>Billing</span></a>
				</li>
				<li class="disabled">
					<a><i class="fi-paper"></i> <span>Store</span></a>
				</li>
			</ul>
		</div>
		<div class="clearfix"></div>
	</div>
</div>';