<?PHP
include_once __DIR__ . '/../../php_includes/functions.php';

secure_session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

error_reporting(E_ALL);
ini_set('display_errors', 0);

// Don't allow direct access
if (!isset($_POST['send_feedback'])) {
  header("Location: ../contact.php?msg=noauth");
  exit();
}

// Require logging in
if (empty($_SESSION['logged_in'])) {
  header("Location: ../contact.php?msg=nologin");
  exit();
}

if (empty($_POST['feedback_input'])) {
  header("Location: ../contact.php?msg=send_mail-empty");
  exit();
}

$user_email_address = $_SESSION['email'];
$admin_email_address = "admin@cachemaps.net";

require("../extlibs/PHPMailer/src/PHPMailer.php");
require("../extlibs/PHPMailer/src/Exception.php");
require("../extlibs/PHPMailer/src/SMTP.php");

$mailer = new PHPMailer(false);
$mailer->CharSet = 'UTF-8';
$mailer->isSMTP();
$mailer->SMTPDebug = 0;

try {
  // Use gmail's free SMTP server
  $mailer->Host = "mail.kolumbus.fi";
  $mailer->Port = 25;

  // Sender, receiver
  $mailer->SetFrom("$user_email_address", $_SESSION['nickname']);
  $mailer->addAddress("$admin_email_address", "Admin");

  // Set subject, body and alt body
  $mailer->Subject = $_POST['subject'];
  $message = "Sender Email: " . $user_email_address . "<br />Sender nickname: " . $_SESSION['nickname'] .
    "<br /><br /><p>Message:<br /><br />" . $_POST['feedback_input'] . "</p>";

  $mailer->msgHTML("$message");
  $mailer->AltBody = "From: " . $user_email_address . ", " . $_SESSION['nickname'] . "\n\n" . $_POST['feedback_input'];

  // If sending failed..
  if (!$mailer->Send()) {
    header("Location: ../contact.php?msg=generic");
    exit();
  }


  // If sending succeeded..
  header("Location: ../contact.php?msg=send_mail-success");
  exit();
} catch (Exception $ex) {
  header("Location: ../contact.php?msg=generic"); // Don't reveal why error happened
  exit();
}
