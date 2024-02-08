<?php
include_once '../../php_includes/functions.php';

secure_session_start();

error_reporting(E_ALL);
ini_set('display_errors', 0);

if (empty($_SESSION['logged_in']) || empty($_SESSION['nickname'])) { // Not logged in
  header("Location: ../index.php?msg=nologin");
  exit();
}

if (!isset($_POST['delete-account-button'])) { // Direct access
  header("Location: ../index.php?msg=noauth");
  exit();
}

$conn = database_connect();
$value = true;

// Insert deletion to database
$sql = "UPDATE " . DB_USERS_TABLE . " SET isDeleted = ? WHERE nickname = ?";

$statement = $conn->prepare($sql);
$statement->bind_param('ss', $value, $_SESSION['nickname']);
$statement->execute();

// Successfully deleted
if ($statement->store_result()) { // Success
  session_destroy();
  header("Location: ../index.php?msg=delete_account-success");
  exit();
}

header("Location: ../myaccount.php?msg=generic");
exit();
