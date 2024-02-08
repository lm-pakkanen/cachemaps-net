<?php
include_once __DIR__ . '/../../php_includes/functions.php';

secure_session_start();

error_reporting(E_ALL);
ini_set('display_errors', 0);

// Don't allow direct access
if (!isset($_POST['update-details-button'])) {
  header("Location: ../index.php?msg=noauth");
  exit();
}

if (empty($_SESSION['logged_in']) || empty($_SESSION['nickname'])) {
  header("Location: ../index.php?msg=nologin");
  exit();
}

$nickname_new = $_POST['update-details-nickname'];
$email_new = $_POST['update-details-email'];
$password_new = $_POST['update-details-password'];
$password_new_confirm = $_POST['update-details-password-confirm'];

function exists($parameter, $value)
{
  $conn = database_connect();

  // Select number of rows
  $sql = "SELECT COUNT(*) FROM " . DB_USERS_TABLE . " WHERE $parameter = ?";

  $statement = $conn->prepare($sql);
  $statement->bind_param('s', $value);
  $statement->bind_result($count);
  $statement->execute();
  $statement->store_result();

  return ($count > 0);
}

function updateFileNames($nickname_old, $nickname_new)
{
  $profile_files_folder = "../files/users/$nickname_old/";
  $profile_image_file = "../files/users/$nickname_old/$nickname_old.png";

  if (file_exists($profile_files_folder) && !rename($profile_files_folder, "../files/users/$nickname_new/")) {
    return false;
  }

  if (file_exists($profile_image_file) && !rename($profile_image_file, "../files/users/$nickname_old/$nickname_new.png")) {
    return false;
  }

  return true;
}

function updateFileOwnership($nickname_old, $nickname_new)
{
  $conn = database_connect();
  $sql = "UPDATE " . DB_FILES_TABLE . " SET nickname = ? WHERE nickname = ?";

  $statement = $conn->prepare($sql);
  $statement->bind_param('ss', $nickname_new, $nickname_old);

  return $statement->execute();
}

function updateNickname($nickname_new, $nickname)
{
  if (empty($nickname_new)) {
    return "none";
  }

  if (exists("nickname", $nickname_new)) {
    return false;
  }

  // Make sure username matches pattern
  if (!preg_match("/^[A-Za-z0-9_ÄÅÖöäå]+$/", $nickname_new)) {
    header("Location: ../myaccount.php?msg=invalid_nick");
    exit();
  }

  $conn = database_connect();

  // Update nickname
  $sql = "UPDATE " . DB_USERS_TABLE . " SET nickname = ? WHERE nickname = ?";

  $statement = $conn->prepare($sql);
  $statement->bind_param('ss', $nickname_new, $nickname);
  $statement->execute();

  if ($statement->store_result()) {
    if (!updateFileNames($nickname, $nickname_new)) {
      return false;
    }

    if (!updateFileOwnership($nickname, $nickname_new)) {
      return false;
    }

    $_SESSION['nickname'] = $nickname_new;
    return true;
  }

  return false;
}

function updateEmail($email_new, $nickname)
{
  if (empty($email_new)) {
    return "none";
  }

  // Make sure email is valid
  if (!filter_var($email_new, FILTER_VALIDATE_EMAIL)) {
    header("Location: ../myaccount.php?msg=invalid_email");
    exit();
  }

  if (exists("email", $email_new)) {
    return false;
  }

  $conn = database_connect();

  // Update email
  $sql = "UPDATE " . DB_USERS_TABLE . " SET email = ? WHERE nickname = ?";

  $statement = $conn->prepare($sql);
  $statement->bind_param('ss', $email_new, $nickname);
  $statement->execute();

  if ($statement->store_result()) {
    $_SESSION['email'] = $email_new;
    return true;
  }

  return false;
}

function updatePassword($password_new, $password_new_confirm, $loginparam, $loginmethod = "nickname")
{
  if (empty($password_new) || empty($password_new_confirm)) {
    return "none";
  }

  $conn = database_connect();

  // Make sure passwords match
  if (strcmp($password_new, $password_new_confirm) !== 0) {
    return false;
  }

  // Update password
  $password_new_hashed = password_hash($password_new, PASSWORD_BCRYPT);

  $sql = "UPDATE " . DB_USERS_TABLE . " SET password = ? WHERE $loginmethod = ?";

  $statement = $conn->prepare($sql);
  $statement->bind_param('ss', $password_new_hashed, $loginparam);
  $statement->execute();

  return $statement->store_result() ? true : false;
}

$update_email = updateEmail($email_new, $_SESSION['nickname']);
$update_password = updatePassword($password_new, $password_new_confirm, $_SESSION['nickname']);
$update_nickname = updateNickname($nickname_new, $_SESSION['nickname']);

$header = "Location: ../myaccount.php?msg=update_account-";

$email_header = (strcmp($update_email, "none") !== 0) ? $update_email === false ? "failed" : "success" : "none";
$password_header = (strcmp($update_password, "none") !== 0) ? $update_password === false ? "failed" : "success" : "none";
$nickname_header = (strcmp($update_nickname, "none") !== 0) ? $update_nickname === false ? "failed" : "success" : "none";

if (
  strcmp($nickname_header, "failed") === 0
  || strcmp($email_header, "failed") === 0
  || strcmp($password_header, "failed") === 0
) {
  header($header . "failed");
  exit();
}

if (
  strcmp($nickname_header, "success") === 0
  || strcmp($email_header, "success") === 0
  || strcmp($password_header, "success") === 0
) {
  header("Location: logout.php");
  exit();
}

if (
  strcmp($nickname_header, "none") === 0
  && strcmp($email_header, "none") === 0
  && strcmp($password_header, "none") === 0
) {
  header($header . "empty");
  exit();
}