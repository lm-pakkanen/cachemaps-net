<?php
include_once __DIR__ . '/../../php_includes/functions.php';
require_once 'userFileHandler.php';

secure_session_start();

error_reporting(E_ALL);
ini_set('display_errors', 0);

require("municipalities.php");

// Require logging in
if (empty($_SESSION['logged_in'])) {
  header("Location: ../update_map.php?msg=nologin");
  exit();
}

// Don't allow direct access
if (!isset($_POST['create-map-button'])) {
  header("Location: ../update_map.php?msg=noauth");
  exit();
}

// Don't accept empty map type
if (empty($_POST['create-map-name'])) {
  header("Location: ../update_map.php?msg=update_map-noname");
  exit();
}

// !Match name of alphanumerical characters
if (!preg_match("/^[a-zA-Z0-9_öäå]+$/", $_POST['create-map-name'])) {
  header("Location: ../update_map.php?msg=update_map-ill_nick");
  exit();
}

$nickname = $_SESSION['nickname'];
$filetype = $_POST['create-map-name'];
$isPrivate = isset($_POST['isPrivate']);
$filename = $filetype . ".csv";
$previous_map_name = $_SESSION['previous_map_name'];
$filecontents = "Municipality,Count\n";
$filepath = "../files/users/" . $nickname . "/";
$txtfile = $filepath . "files.txt";

if (!file_exists($filepath)) {
  mkdir($filepath);
}

foreach ($municipalities as $municipality) {
  if (isset($_POST[$municipality . "-checkbox"])) { // If checked
    if (!empty($_POST[$municipality . "-count"])) { // If count is set
      if (!preg_match("/^[0-9]+$/", $_POST[$municipality . "-count"])) {
        header("Location: ../update_map.php?msg=update_map-nan_input");
        exit();
      } else {
        $filecontents .= $municipality . "," . $_POST[$municipality . "-count"] . "\n";
      }
    } else { // If count is not set
      $filecontents .= $municipality . ",1\n";
    }
  } else { // If not checked
    $filecontents .= $municipality . ",0\n";
  }
}

if (mapExists($nickname, $previous_map_name)) {
  if (!updateExistingMap($nickname, $previous_map_name, $filetype, $isPrivate)) {
    header("Location: ../update_map.php?msg=update_map-failed");
    exit();
  }
} else if (!insertNewMap($nickname, $filetype, $isPrivate)) {
  header("Location: ../update_map.php?msg=insert_map-failed");
  exit();
}

// Delete old version of file
if (file_exists($filepath . $filename)) {
  unlink($filepath . $filename);
}

// Create new version of file
$handle = fopen($filepath . $filename, 'w');

if (empty($handle)) {
  header("Location: ../update_map.php?msg=txt_failed");
  exit();
}

fwrite($handle, $filecontents);
fclose($handle);

header("Location: ../maps.php?msg=update_map-success");
exit();