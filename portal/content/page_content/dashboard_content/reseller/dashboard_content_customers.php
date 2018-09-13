<?php
/**
 * Created by Lewis Stevens
 * Date: 14/07/2018
 * Time: 13:25
 */

echo '
<div class="row">
	<div class="col-12">
		<div class="page-title-box">
			<h4 class="page-title float-left">Tickets</h4>

			<ol class="breadcrumb float-right">
				<li class="breadcrumb-item"><a href="/dashboard">ReviveIP</a></li>
				<li class="breadcrumb-item active">Tickets</li>
			</ol>

			<div class="clearfix"></div>
		</div>
	</div>
</div>';

$getCustomers = $addable->QUERY(array(
	'query' => 'SELECT * FROM company
	LEFT JOIN users
	ON company.company_id = users.users_company_match_id
	WHERE users.users_reseller = "0"
	AND users.users_parent_id = :parentId',
	'replacementArray' => array(
		'parentId' => $currentUser['users_id'][0]
	),
	'returnArray' => array(
		'company_id',
		'company_name',
		'company_main_contact_name',
		'company_main_contact_number',
		'company_account_number'
	)
));

$getTotalLines = $addable->QUERY(array(
	'query' => 'SELECT * FROM line
	LEFT JOIN company
	ON line.line_company_match = company.company_id
	LEFT JOIN users
	ON company.company_id = users.users_company_match_id
	WHERE users.users_reseller = "0"
	AND users.users_parent_id = :parentId',
	'replacementArray' => array(
		'parentId' => $currentUser['users_id'][0]
	),
	'returnArray' => array(
		'line_id'
	)
));

echo '
<div class="row">
	<div class="col-12">
		<div class="card-box">
			<h4 class="header-title m-b-15 m-t-0">Manage Customers</h4>

			<div class="text-center m-b-30">
				<div class="row">
					<div class="col-xs-12 col-sm-4">
						<div class="m-t-20 m-b-20">
							<h3 class="m-b-10">'.count($getCustomers['company_id']).'</h3>
							<p class="text-uppercase m-b-5 font-13 font-600">Total Customers</p>
						</div>
					</div>
					<div class="col-xs-12 col-sm-4">
						<div class="m-t-20 m-b-20">
							<h3 class="m-b-10">'.count($getTotalLines['line_id']).'</h3>
							<p class="text-uppercase m-b-5 font-13 font-600">Total Lines</p>
						</div>
					</div>
					<div class="col-xs-12 col-sm-4">
						<div class="m-t-20 m-b-20">
							<h3 class="m-b-10 text-danger">25000</h3>
							<p class="text-uppercase m-b-5 font-13 font-600">Overdue Invoices</p>
						</div>
					</div>
				</div>
			</div>

			<table id="datatable" class="table table-hover m-0 tickets-list table-actions-bar dt-responsive nowrap" cellspacing="0" width="100%">
				<thead>
				<tr>
					<th>ID</th>
					<th>Account Ref</th>
					<th>Company Name</th>
					<th>Contact Name</th>
					<th>Contact Number</th>
					<th>Status</th>
					<th class="hidden-sm" style="text-align:center">Action</th>
				</tr>
				</thead>
				<tbody>';

				for($i = 0; $i < count($getCustomers['company_id']); $i++){
					echo '
					<tr>
						<td><b>#'.$getCustomers['company_id'][$i].'</b></td>
						<td><b>'.$getCustomers['company_account_number'][$i].'</b></td>
						<td><span class="m-l-5"><b>'.$getCustomers['company_name'][$i].'</b></span></td>
						<td>'.$getCustomers['company_main_contact_name'][$i].'</td>
						<td>'.$getCustomers['company_main_contact_number'][$i].'</td>
						<td><span class="label label-success">Active</span></td>
						<td style="text-align:center">
							<a href="/dashboard/customer/'.$addable->hardcode('encrypt',$getCustomers['company_id'][$i]).'">
							    <i class="mdi mdi-account-switch m-r-10 text-muted font-18 vertical-middle" title="Switch to Customer"></i>
							</a>
						</td>
					</tr>';
				}

				echo '
				</tbody>
			</table>
		</div>
	</div>
</div>
';