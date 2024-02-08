<?php
require '../../php_includes/functions.php';

// Dont allow map creating for restricted account type
if ($_SESSION['account_type'] === "restricted") {
  header("Location: ../index.php?msg=account_restricted");
  exit();
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

  $sql = "UPDATE " . DB_USERS_TABLE . " SET password = ? WHERE $loginmethod = ?"; // TODO

  $statement = $conn->prepare($sql);
  $statement->bind_param('ss', $password_new_hashed, $loginparam);
  $statement->execute();

  return $statement->store_result() ? true : false;
}

if (!isset($_POST['reset-password-form-submit'])) {
  header("Location: ../index.php?msg=noauth");
  exit();
}

function generatePassword($length = 10)
{
  return substr(
    str_shuffle(
      str_repeat(
        $x = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ',
        ceil($length / strlen($x))
      )
    ),
    1,
    $length
  );
}

$generated_password = generatePassword(6);
$user_email = $_POST['reset-password-form-email'];

// Update password to database
if (!updatePassword($generated_password, $generated_password, $user_email, "email")) {
  header("Location: ../login.php?msg=generic");
  exit();
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require("../extlibs/PHPMailer/src/PHPMailer.php");
require("../extlibs/PHPMailer/src/Exception.php");
require("../extlibs/PHPMailer/src/SMTP.php");

$mailer = new PHPMailer(false);
$mailer->CharSet = 'UTF-8';
$mailer->isSMTP();
$mailer->SMTPDebug = 0;

$message = <<<MESSAGE

<p>You requested to have the password of your CacheMaps.net account reset.</p>
<br />
Your password has been set to the following: <br />
<strong>$generated_password</strong><br/>
<p>It is strongly adviced to reset your password in your account settings once logged in.</p>

MESSAGE;

$altmessage = <<<ALTMESSAGE

You requested to have the password of your CacheMaps.net account reset.
Your password has been reset to the following: $generated_password. It is strongly
adviced to reset your password in your account settings once logged in.

ALTMESSAGE;

try {
  $mailer->Host = "smtp.qnet.fi";
  $mailer->Port = 25;

  // Sender, receiver
  $mailer->SetFrom("admin@cachemaps.net", "Admin");
  $mailer->addAddress("$user_email");

  // Set subject, body and alt body
  $mailer->Subject = "CacheMaps.net password reset";
  $mailer->msgHTML("$message");
  $mailer->AltBody = "$altmessage";

  // If sending failed..
  if (!$mailer->Send()) {
    header("Location: ../login.php?msg=generic");
    exit();
  }

  // If sending succeeded..
  header("Location: ../login.php?msg=password_reset-success");
  exit();
} catch (Exception $ex) {
  header("Location: ../contact.php?msg=generic"); // Don't reveal why error happened
  exit();
}