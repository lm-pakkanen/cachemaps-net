<?PHP
include_once __DIR__ . '/../../php_includes/functions.php';
require_once 'userFileHandler.php';

secure_session_start();

error_reporting(E_ALL);
ini_set('display_errors', 0);

$allowedFileTypes = array("csv");

$nickname = $_SESSION['nickname'];
$filename = $_FILES['csv-upload-choose-default']['name'];

$path = "../files/users/$nickname/";
$txtfile = $path . "files.txt";

// Require logging in
if (empty($nickname)) {
  header("Location: ../maps.php?msg=nologin");
  exit();
}

// Only allow .csv files
$ext = pathInfo($filename, PATHINFO_EXTENSION);

if (!in_array($ext, $allowedFileTypes)) {
  header("Location: ../maps.php?msg=upload_csv-file_invalid");
  exit();
}

if (!file_exists($path)) {
  mkdir($path);
}

// Don't accept empty map type
if (empty($filename)) {
  header("Location: ../maps.php?msg=create_map-noname");
  exit();
}

// !Match name of alphanumerical characters
if (!preg_match("/^[a-zA-Z0-9_öäå]+$/", substr($filename, 0, strpos($filename, ".")))) {
  header("Location: ../maps.php?msg=create_map-ill_nick");
  exit();
}

$path = $path . basename($filename);


if (move_uploaded_file($_FILES['csv-upload-choose-default']['tmp_name'], $path)) {
  // Uploading file success

  // Insert new map to database without .csv extension, public by default
  insertNewMap($nickname, substr($filename, 0, strpos($filename, ".")), "false");
  header("Location: ../maps.php?msg=upload_csv-success");
  exit();
}


// Uploading file failed
header("Location: ../maps.php?msg=upload_csv-failed");
exit();
