<?php

echo '
<div class="row">
	<div class="col-12">
		<div class="page-title-box">
			<h4 class="page-title float-left">Dashboard</h4>

			<ol class="breadcrumb float-right">
				<li class="breadcrumb-item"><a href="/">ReviveIP</a></li>
				<li class="breadcrumb-item active">Customers</li>
			</ol>

			<div class="clearfix"></div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-lg-6">
		<div class="card-box widget-box-two widget-two-custom">
			<i class="mdi mdi-account-multiple widget-two-icon"></i>
			<div class="wigdet-two-content">
				<p class="m-0 text-uppercase font-bold font-secondary text-overflow" title="Statistics">Total Customers</p>
				<h2 class="font-600"><span data-plugin="counterup">2521</span></h2>
				<p class="m-0">&nbsp;</p>
			</div>
		</div>
	</div>
	<div class="col-lg-6">
		<div class="card-box widget-box-two widget-two-custom">
			<i class="mdi mdi-crown widget-two-icon"></i>
			<div class="wigdet-two-content">
				<p class="m-0 text-uppercase font-bold font-secondary text-overflow" title="Statistics">Total Phone Lines</p>
				<h2 class="font-600"><span data-plugin="counterup">236521</span></h2>
				<p class="m-0">&nbsp;</p>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-lg-12">
		<div class="card-box">
			<h4 class="m-t-0 header-title"><b>Unpaid Invoices</b></h4>
			<p class="text-muted font-14 m-b-20">
				A list of customers with outstanding invoices.
			</p>
	
			<div class="table-responsive">
				<table class="table table-hover m-0 table-actions-bar">
					<thead>
						<th style="text-decoration:underline">Customer Name</th>
						<th style="text-decoration:underline">Due Date</th>
						<th style="text-decoration:underline">Invoice Amount</th>
						<th  style="text-decoration:underline; width:90px; text-align:center">Action</th>
					</thead>
					<tbody>
						<tr>
							<td>
								Fake Customer
							</td>
		
							<td>
								<i class="mdi mdi-clock text-danger"></i> 13/07/2018
							</td>
		
							<td>
								<span style="padding-right:2px;">&pound;</span>3265
							</td>
		
							<td style="text-align:center">
								<a href="#" class="table-action-btn"><i class="mdi mdi-eye"></i></a>
							</td>
						</tr>
						<tr>
							<td>
								Fake Customer 2
							</td>
		
							<td>
								<i class="mdi mdi-clock text-warning"></i> '.date('d/m/Y',strtotime('+5 days', time())).'
							</td>
		
							<td>
								<span style="padding-right:2px;">&pound;</span>3265
							</td>
		
							<td style="text-align:center">
								<a href="#" class="table-action-btn"><i class="mdi mdi-eye"></i></a>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
';