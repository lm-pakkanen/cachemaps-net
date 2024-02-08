<?php
require_once '../../php_includes/functions.php';

function getFileInformation($nickname, $map_name)
{
  $conn = database_connect();
  $sql = "SELECT nickname, updated_at_date, isDeleted, isPrivate FROM userFiles WHERE nickname = ? && name = ?";

  $statement = $conn->prepare($sql);
  $statement->bind_param('ss', $nickname, $map_name);
  $statement->bind_result(
    $nickname,
    $updated_at_date,
    $isDeleted,
    $isPrivate
  );
  $statement->execute();
  $statement->fetch();

  return $nickname . "," . $map_name . "," . $updated_at_date . "," . $isDeleted . "," . $isPrivate;
}
?>

<?PHP
$nickname = $_GET['nickname'];
$map_name = $_GET['map_name'];
echo getFileInformation($nickname, $map_name);
?>