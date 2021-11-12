<?php
session_start();


session_unset('Admin');

session_destroy('Admin');

header('Location: index.php');
exit();

?>
