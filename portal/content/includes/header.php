<?php
$website_name = 'Addable';
$website_suffix = '';

echo '
<meta charset="utf-8" />
<title>' .$website_name;

if(strlen($website_suffix) > 0){
	echo ' - '.$website_suffix;
}

echo '</title>

<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<meta name="author" content="Addable Ltd">
<meta content="" name="description" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />

<!-- App Favicon -->
<link rel="shortcut icon" href="/content/theme/images/favicon.ico">

<!-- App Css -->
<link href="/content/theme/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="/content/theme/css/icons.css" rel="stylesheet" type="text/css" />
<link href="/content/theme/css/metismenu.min.css" rel="stylesheet" type="text/css" />
<link href="/content/theme/css/style.css" rel="stylesheet" type="text/css" />

<!-- Datatables -->
<link href="/content/theme/plugins/datatables/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css"/>
<link href="/content/theme/plugins/datatables/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css"/>
        
<!-- General -->
<link rel="stylesheet" type="text/css" media="all" href="/content/stylesheets/general.css">

<!-- OnTheFly Javascript Style -->
<style type="text/css" id="style_append"></style>

<!-- Modernizer -->
<script src="/content/theme/js/modernizr.min.js"></script>';