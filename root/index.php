<?php
	
	
	
	include('functions.php');
	require_once './auth.php';
	
	
?>
<!DOCTYPE html>
<html lang="en"><head>
	<!-- Basic Page Needs
	–––––––––––––––––––––––––––––––––––––––––––––––––– -->
	
	<meta charset="utf-8">
	<title>Fotoalbum</title>
	
	
	
	<meta name="description" content="">
	
	
	<meta name="author" content="">
	
	<!-- Mobile Specific Metas
	–––––––––––––––––––––––––––––––––––––––––––––––––– -->
	
	<meta name="viewport" content="width=device-width, initial-scale=1">
	
	<!-- FONT
	–––––––––––––––––––––––––––––––––––––––––––––––––– -->
	
	<link href="//fonts.googleapis.com/css?family=Raleway:400,300,600" rel="stylesheet" type="text/css">
	
	<!-- CSS
	–––––––––––––––––––––––––––––––––––––––––––––––––– -->
	
	<link rel="stylesheet" href="css/normalize.css">
	
	
	<link rel="stylesheet" href="css/skeleton.css">
	
	<link rel="stylesheet" href="css/custom.css">
	
	<link rel="stylesheet" href="css/navbar.css">
	
	<link rel="stylesheet" href="css/font-awesome-4.5.0/css/font-awesome.css">
	
	<!-- Favicon
	–––––––––––––––––––––––––––––––––––––––––––––––––– -->
	
	<link rel="icon" type="image/png" href="images/favicon.png">
	
	</head><body>
<!-- Primary Page Layout
–––––––––––––––––––––––––––––––––––––––––––––––––– -->
<div class="site_bg">
</div>
<?php
include('navbar.php');
include($page.'.php');
?>


<!-- End Document
–––––––––––––––––––––––––––––––––––––––––––––––––– -->
</body></html>