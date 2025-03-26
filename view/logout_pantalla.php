<?php

require_once __DIR__.'/../includes/config.php';

session_start();
session_destroy();
header("Location: login_pantalla.php");
exit;
?>
