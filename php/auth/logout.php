<?php
session_start();

session_unset();
session_destroy();

header('location: ../components/home.php');
exit;
?>