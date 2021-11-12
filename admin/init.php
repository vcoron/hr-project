<?php 

include 'connect.php';

// Routes

$tpl = 'includes/tempalets/';
$func = 'includes/functions/';
$fonts ='layout/fonts/';

$css = 'layout/css/';
$js = 'layout/js/';



// Include The Important Files
	include $func . 'function.php';
	include $tpl . 'header.php';


// Include Navbar On All Pages Exept The One With $noNavbar Vairable
	if(!isset($noNavbar)){
		include $tpl . 'navbar.php';
	}


?>