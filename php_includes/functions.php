<?php
include_once('config.php');
include_once('error_constants_inc.php');  // Error messages

secure_session_start();

error_reporting(E_ALL);
ini_set('display_errors', 0);

function secure_session_start()
{
  $secure = SECURE;
  $httponly = true;

  // Use only cookies
  if (!ini_set('session.use_only_cookies', 1) === false) {
    header("Location: ../html/index.php?msg=sec_session-generic");
    exit();
  }

  $cookieparams = session_get_cookie_params();

  session_set_cookie_params(
    $cookieparams["lifetime"],
    $cookieparams["path"],
    $cookieparams["domain"],
    $secure,
    $httponly
  );

  session_regenerate_id();
  session_save_path("/apache/sessions");
  ini_set("session.gc_probability", 1);

  session_start();
}

function database_connect()
{
  return new mysqli(DB_HOST, DB_SECURE_USER, DB_SECURE_USER_PASSWORD, DB_DATABASE);
}

function login($loginparam, $password)
{

  if (!$_SESSION['accepted_cookies']) {
    return LOGIN_NO_COOKIES_ERROR;
  }

  $loginMethod = "nickname";

  // If user entered an email, query for an email
  // Instead of nickname
  if (strpos($loginparam, "@") !== false) {
    $loginMethod = "email";
  }

  $sql = "SELECT id, nickname, email, password, account_type FROM " . DB_USERS_TABLE . " WHERE $loginMethod = ? && isDeleted = false";

  $connection = database_connect();
  $statement = $connection->prepare($sql);

  $statement->bind_param('s', $loginparam);

  $statement->execute();
  $statement->store_result();

  $statement->bind_result($user_id, $user_nickname, $user_email, $user_password, $account_type);
  $statement->fetch();

  // If user exists
  if ($statement->num_rows !== 1) {
    return LOGIN_INCORRECT_ERROR;
  }

  // Make sure user is not under brute force attack
  if (check_login_brute($user_id) === 1) {
    return LOGIN_BRUTE_ERROR;
  }

  // If password is correct, log user in
  if (password_verify($password, $user_password)) {
    $user_browser = $_SERVER['HTTP_USER_AGENT'];

    $_SESSION['user_id'] = $user_id;
    $_SESSION['nickname'] = $user_nickname;
    $_SESSION['email'] = $user_email;
    $_SESSION['logged_in'] = true;
    $_SESSION['login_string'] = hash(
      'sha512',
      $user_password . $user_browser
    );

    $_SESSION['account_type'] = $account_type;

    return true;
  } else {
    // Log failed attempts to databse
    $now = time();
    $connection->query("INSERT INTO " . DB_LOGIN_ATTEMPTS_TABLE
      . "(id, time) VALUES ('$user_id', '$now')");

    return LOGIN_INCORRECT_ERROR;
  }
}

function verify_login()
{
  if (!$_SESSION['accepted_cookies']) {
    return LOGIN_NO_COOKIES_ERROR;
  }

  if (!isset($_SESSION['user_id'], $_SESSION['login_string'])) {
    return LOGIN_VERIFY_NOLOGIN_ERROR;
  }

  $user_id = $_SESSION['user_id'];
  $login_string = $_SESSION['login_string'];

  $user_browser = $_SERVER['HTTP_USER_AGENT'];

  $connection = database_connect();

  if (!$statement = $connection->prepare("SELECT password FROM " . DB_USERS_TABLE . " WHERE id = ? LIMIT 1")) {
    return LOGIN_VERIFY_NOLOGIN_ERROR;
  }

  $statement->bind_param('i', $user_id);
  $statement->execute();
  $statement->store_result();

  if ($statement->num_rows !== 1) {
    return LOGIN_VERIFY_NOLOGIN_ERROR;
  }

  $statement->bind_result($user_password);
  $statement->fetch();
  $login_check = hash('sha512', $user_password . $user_browser);

  if (hash_equals($login_check, $login_string)) {
    return true;
  } else {
    return LOGIN_VERIFY_NOLOGIN_ERROR;
  }
}

function logout()
{
  $params = session_get_cookie_params();

  // Clear cookie
  setcookie(
    session_name(),
    '',
    time() - 42000,
    $params["path"],
    $params["domain"],
    $params["secure"],
    $params["httponly"]
  );

  // End session -> log out
  if (session_destroy()) {
    // Unset session variable
    $_SESSION = array();
    return true;
  } else {
    return false;
  }
}

function check_login_brute($user_id)
{
  $now = time();

  // Check last two hours
  $valid_attempts = $now - (2 * 60 * 60);

  // Select all login attempts less than 2 hours ago
  $connection = database_connect();

  if ($statement = $connection->prepare("SELECT time FROM " . DB_LOGIN_ATTEMPTS_TABLE . "WHERE id = ? AND time > '$valid_attempts'")) {
    $statement->bind_param('i', $user_id);

    $statement->execute();
    $statement->store_result();

    // > 5 failed logins
    return $statement->num_rows > 5;
  } else {
    return true;
  }
}

function escape_url($url)
{
  if ('' === $url) {
    return $url;
  }

  $url = preg_replace('|[^a-z0-9-~+_.?#=!&;,/:%@$\|*\'()\\x80-\\xff]|i', '', $url);
  $url = (string) $url;

  $strip = array('%0d', '%0a', '%0D', '%0A');

  $count = 1;

  while ($count) {
    $url = str_replace($strip, '', $url, $count);
  }

  $url = str_replace(';//', '://', $url);
  $url = htmlentities($url);
  $url = str_replace('&amp;', '&#038;', $url);
  $url = str_replace("'", '&#039;', $url);

  if ($url[0] !== '/') {
    return '';
  } else {
    return $url;
  }
}

function nickname_taken($nickname)
{
  $conn = database_connect();

  // Query for nickname
  $sql = "SELECT nickname FROM " . DB_USERS_TABLE . " WHERE nickname= ?";

  $statement = $conn->prepare($sql);
  $statement->bind_param('s', $_POST['register_nickname']);
  $statement->bind_result($nickname);
  $statement->execute();
  $statement->store_result();

  return $statement->num_rows > 0;
}