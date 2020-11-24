<?php
include('navigation.php');
$_SESSION = array();
session_destroy();
header("Location:index.php");
?>
