<?php
include_once __DIR__ . '/../../php_includes/functions.php';

secure_session_start();

$result = "";

$conn = database_connect();

$search_value = "%" . $_GET['value'] . "%";

if ($search_value !== "%%") {
  $sql = "SELECT nickname FROM " . DB_USERS_TABLE . " WHERE nickname LIKE ?";

  $statement = $conn->prepare($sql);
  $statement->bind_param("s", $search_value);
  $statement->bind_result($nickname);

  $statement->execute();

  while ($statement->fetch()) {
    $result .= $nickname . ",";
  }

  echo substr($result, 0, strlen($result) - 1);
}
