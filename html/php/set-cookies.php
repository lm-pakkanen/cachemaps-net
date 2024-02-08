<?php
include_once __DIR__ . '/../../php_includes/functions.php';

secure_session_start();

$value = $_GET['value'];

$_SESSION['accepted_cookies'] = $value === "true" ? true : false;
exit();