<?php
session_start();


session_unset('Emp','Emp_ID');

session_destroy('Emp','Emp_ID');

header('Location: index.php');
exit();

?>