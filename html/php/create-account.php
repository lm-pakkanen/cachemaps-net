<?php
require '../../php_includes/functions.php';

secure_session_start();

error_reporting(E_ALL);
ini_set('display_errors', 0);

// Don't allow direct access
if (!isset($_POST['register_submit'])) {
  header("Location: ../login.php?msg=noauth");
  exit();
}

// Don't allow empty fields
if (
  empty($_POST['register_nickname']) ||
  empty($_POST['register_password']) ||
  empty($_POST['register_email']) ||
  empty($_POST['register_password_confirm'])
) {
  header("Location: ../login.php?msg=create_account-empty");
  exit();
}

// Check for matching passwords
if (strcmp($_POST['register_password'], $_POST['register_password_confirm']) !== 0) {
  header("Location: ../login.php?msg=create_account-nomatch");
  exit();
}

// Make sure username matches pattern
if (!preg_match("/^[A-Za-z0-9_ÄÅÖöäå]+$/", $_POST['register_nickname'])) {
  header("Location: ../login.php?msg=create_account-ill_nick");
  exit();
}

// Make sure email is valid
if (!filter_var($_POST['register_email'], FILTER_VALIDATE_EMAIL)) {
  header("Location: ../login.php?msg=create_account-ill_email");
  exit();
}

if (!$_SESSION['accepted_cookies']) {
  $_SESSION['error'] = LOGIN_NO_COOKIES_ERROR;
  header("Location: ../login.php?msg=generic");
  exit();
}

$conn = database_connect();

// Query for nickname
$sql = "SELECT nickname FROM " . DB_USERS_TABLE . " WHERE nickname= ?";

$statement = $conn->prepare($sql);
$statement->bind_param('s', $_POST['register_nickname']);
$statement->bind_result($nickname);
$statement->execute();
$statement->store_result();

if ($statement->num_rows > 0) {
  header("Location: ../login.php?msg=create_account-nick_taken");
  exit();
}

// Query for email
$sql = "SELECT email FROM " . DB_USERS_TABLE . " WHERE email= ?";

$statement = $conn->prepare($sql);
$statement->bind_param('s', $_POST['register_email']);
$statement->bind_result($email);
$statement->execute();
$statement->store_result();

if ($statement->num_rows > 0) {
  header("Location: ../login.php?msg=create_account-email_taken");
  exit();
}

$password = password_hash($_POST['register_password'], PASSWORD_BCRYPT);

// Insert new user to database
$sql = "INSERT INTO " . DB_USERS_TABLE . " (nickname, email, password) VALUES (?, ?, ?)";

$statement = $conn->prepare($sql);
$statement->bind_param('sss', $_POST['register_nickname'], $_POST['register_email'], $password);
$statement->execute();

header("Location: ../login.php?msg=create_account-success");
exit();