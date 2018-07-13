<?php
$website_name = 'Addable';
$website_suffix = '';

echo '
<meta name="viewport" content="width=device-width, maximum-scale=1, minimum-scale=1, initial-scale=1">
<meta name="description" content="">
<meta name="keywords" content=""/>
<meta name="author" content="Addable Ltd">

<link rel="shortcut icon" href="/content/images/dest/dest/general/favicon2.ico" />
<link rel="icon" href="/content/images/dest/dest/general/favicon-32x32.png" type="image/png" sizes="32x32" />
<link rel="icon" href="/content/images/dest/dest/general/favicon-16x16.png" type="image/png" sizes="16x16" />
<title>' .$website_name;

if(strlen($website_suffix) > 0){
	echo ' - '.$website_suffix;
}

echo '</title>';

/* STYLESHEETS */
echo '
<link type="text/css" href="/content/libs/perfect-scrollbar/css/perfect-scrollbar.css"/>
<link type="text/css" href="/content/libs/material-design-icons/css/material-design-iconic-font.min.css"/><!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
<link type="text/css" href="/content/libs/jquery.vectormap/jquery-jvectormap-1.2.2.css"/>
<link type="text/css" href="/content/libs/datetimepicker/css/bootstrap-datetimepicker.min.css"/>

<link rel="stylesheet" type="text/css" href="/content/libs/jqvmap/jqvmap.min.css"/>
<link rel="stylesheet" type="text/css" href="/content/stylesheets/dashboard_style.css"/>
<link rel="stylesheet" type="text/css" media="all" href="/content/stylesheets/general.css">
<style type="text/css" id="style_append"></style>';

$page_specific_javascript = '';