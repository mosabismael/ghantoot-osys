<?php

session_start();

$_SESSION['username'] = '';
$_SESSION['sess_id'] = '';



session_destroy();

header('location:../index.php');

?>