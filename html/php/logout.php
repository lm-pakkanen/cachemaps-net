<?php
include_once '../../php_includes/functions.php';

secure_session_start();

$header = "https://CacheMaps.net/index.php";

$success = "?msg=logout-success";
$fail = "?msg=generic";

if (logout()) {
  header("Location: " . $header . $success);
  exit();
}

header("Location: " . $header . $fail);
exit();