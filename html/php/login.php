<?php
include_once '../../php_includes/functions.php';

secure_session_start();

// Already logged in
if (
  isset($_SESSION['user_id']) ||
  isset($_SESSION['nickname']) ||
  isset($_SESSION['email']) ||
  isset($_SESSION['logged_in']) ||
  isset($_SESSION['login_string'])
) {
  header("Location: ../login.php?msg=login-sess_exists");
  exit();
}

if (isset($_POST['submit_login'], $_POST['login_parameter'], $_POST['login_password'])) {
  $login_param = $_POST['login_parameter'];
  $login_password = $_POST['login_password'];

  $loginResult = login($login_param, $login_password);

  if ($loginResult === true) {
    header("Location: ../index.php?msg=login-success");
    exit();
  }

  $_SESSION['error'] = $loginResult;
  header("Location: ../login.php?msg=generic");
  exit();
}

header("Location: ../login.php?msg=generic");
exit();
