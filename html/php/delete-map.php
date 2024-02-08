<?PHP
require_once '../../php_includes/functions.php';
require_once 'userFileHandler.php';

secure_session_start();

// Production use
error_reporting(E_ALL);
ini_set('display_errors', 0);

// Dont allow direct access
if (!isset($_POST['delete-map'])) {
  header("Location: ../maps.php?msg=noauth");
  exit();
}

// Require logging in
if (empty($_SESSION['logged_in'])) {
  header("Location: ../maps.php?msg=nologin");
  exit();
}

if (empty($_POST['map-name-update'])) {
  header("Location: ../maps.php?msg=delete_map-empty");
  exit();
}

$map = $_POST['map-name-update'];

// Delete map from database, but do not actually remove file
if (deleteExistingMap($_SESSION['nickname'], substr($map, 0, strpos($map, ".")))) {
  header("Location: ../maps.php?msg=delete_map-success");
  exit();
}

header("Location: ../maps.php?msg=delete_map-fail");
exit();