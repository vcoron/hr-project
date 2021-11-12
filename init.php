<?php 

include 'admin/connect.php';

$sessionUser= '';
if(isset ($_SESSION['Emp'])){
	$sessionUser=$_SESSION['Emp'];
	$sessionID=$_SESSION['Emp_ID'];
}
// Routes

$tpl = 'includes/tempalets/';
$func = 'includes/functions/';
$fonts ='layout/fonts/';

$css = 'layout/css/';
$js = 'layout/js/';



// Include The Important Files
	include $func . 'function.php';
	include $tpl . 'header.php';


?>