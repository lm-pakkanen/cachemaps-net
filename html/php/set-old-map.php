<?PHP
include_once __DIR__ . '/../../php_includes/functions.php';
require_once 'userFileHandler.php';

secure_session_start();

error_reporting(E_ALL);
ini_set('display_errors', 0);

// Don't allow direct access
if (!isset($_POST['update-map'])) {
  header("Location: ../maps.php?msg=noauth");
  exit();
}

// Require logging in
if (empty($_SESSION['logged_in'])) {
  header("Location: ../maps.php?msg=nologin");
  exit();
}

// Don't allow empty map name
if (empty($_POST['map-name-update'])) {
  header("Location: ../maps.php?msg=update_map-name_empty");
  exit();
}

$filepath = "../files/users/" . $_SESSION['nickname'] . "/";
$map = $filepath . $_POST['map-name-update'];

$output = array();
array_push($output, $_POST['map-name-update']);

$handle = fopen($map, 'r');

if (empty($handle)) {
  header("Location: ../maps.php?msg=txt_failed");
  exit();
}

fgets($handle);

while (($data = fgets($handle)) !== false) {
  $data = trim($data);
  $line = explode(",", $data);
  $name = $line[0];
  $count = $line[1];

  if ($count > 0) {
    array_push($output, $data);
  }
}

fclose($handle);

$_SESSION['finds_list'] = $output;

$_SESSION['mapIsPrivate'] = getIsPrivateStatus(
  $_SESSION['nickname'],
  substr(
    $_POST['map-name-update'],
    0,
    strpos($_POST['map-name-update'], ".")
  )
);

$_SESSION['isMapUpdated'] = true;

// Redirect to create_map script with file list in session
header("Location: ../update_map.php");
exit();