<?php
include_once __DIR__ . '/../../php_includes/functions.php';
include_once __DIR__ . '../../php_includes/error_constants_inc.php';

function insertNewMap($nickname, $map_name, $isPrivate)
{

  if (mapExists($nickname, $map_name)) {
    return false;
  }

  $conn = database_connect();

  date_default_timezone_set("UTC");
  $now = time();

  $sql = "INSERT INTO " . DB_FILES_TABLE . " (nickname, name, created_at_date, updated_at_date, isPrivate) VALUES (?,?,?,?,?)";

  $statement = $conn->prepare($sql);
  $statement->bind_param('ssiii', $nickname, $map_name, $now, $now, $isPrivate);

  return !!$statement->execute();
}

// First update other variables, lastly update map name
function updateExistingMap($nickname, $map_name, $map_name_new, $isPrivate)
{
  // Make sure file exists before trying
  // to update it
  if (!mapExists($nickname, $map_name)) {
    return UPDATE_MAP_NOT_EXISTS_ERROR;
  }

  // Update map update time to now()
  if (!updateMapUpdateTime($nickname, $map_name)) {
    return UPDATE_MAP_TIME_ERROR;
  }

  // Update isPrivate variable of map
  if (!updateMapIsPrivate($nickname, $map_name, $isPrivate)) {
    return UPDATE_MAP_ISPRIVATE_ERROR;
  }

  // If new map name was entered, update map name to the new name
  if ($map_name !== $map_name_new && !empty($map_name_new)) {
    if (!updateMapName($nickname, $map_name, $map_name_new)) {
      return UPDATE_MAP_NAME_ERROR;
    }
  }

  // If none of the previous functions
  // returned early, update was successful
  return true;
}

function deleteExistingMap($nickname, $map_name)
{
  $conn = database_connect();
  $sql = "UPDATE " . DB_FILES_TABLE . " SET isDeleted = 1 WHERE nickname = ? && name = ?";

  $statement = $conn->prepare($sql);
  $statement->bind_param('ss', $nickname, $map_name);

  return $statement->execute();
}

function getAvailableMaps($nickname)
{
  $result = array();

  $conn = database_connect();

  $sql = "SELECT name FROM " . DB_FILES_TABLE . " WHERE nickname = ? AND isDeleted = false";

  $statement = $conn->prepare($sql);
  $statement->bind_param('s', $nickname);
  $statement->bind_result($result_name);

  if ($statement->execute()) {
    while ($statement->fetch()) {
      array_push($result, $result_name . ".csv");
    }
  }

  return $result;
}

function mapExists($nickname, $map_name)
{
  $conn = database_connect();

  $sql = "SELECT COUNT(*) FROM " . DB_FILES_TABLE . " WHERE nickname = ? AND name = ?";

  $statement = $conn->prepare($sql);
  $statement->bind_param('ss', $nickname, $map_name);
  $statement->bind_result($count);

  if ($statement->execute()) {
    $statement->fetch();

    if (empty($count) || $count === 0) {
      return false;
    }
  }

  return true;
}

function updateMapOwnerName($nickname, $nickname_new)
{
  $conn = database_connect();
  $sql = "UPDATE " . DB_FILES_TABLE . " SET nickname = ? WHERE nickname = ?";

  $statement = $conn->prepare($sql);
  $statement->bind_param($nickname_new, $nickname);

  return $statement->execute();
}

function updateMapName($nickname, $map_name, $map_name_new)
{
  $conn = database_connect();
  $sql = "UPDATE " . DB_FILES_TABLE . " SET name = ? WHERE name = ? && nickname = ?";

  $statement = $conn->prepare($sql);
  $statement->bind_param('sss', $map_name_new, $map_name, $nickname);

  return $statement->execute();
}

function updateMapUpdateTime($nickname, $map_name)
{
  $conn = database_connect();

  date_default_timezone_set("UTC");
  $now = time();

  $sql = "UPDATE " . DB_FILES_TABLE . " SET updated_at_date = ? where name = ? && nickname = ?";

  $statement = $conn->prepare($sql);
  $statement->bind_param('iss', $now, $map_name, $nickname);

  return $statement->execute();
}

function updateMapIsPrivate($nickname, $map_name, $isPrivate)
{
  $conn = database_connect();
  $sql = "UPDATE " . DB_FILES_TABLE . " SET isPrivate = ? WHERE name = ? && nickname = ?";

  $statement = $conn->prepare($sql);
  $statement->bind_param('iss', $isPrivate, $map_name, $nickname);

  return $statement->execute();
}

function getIsPrivateStatus($nickname, $map_name)
{
  $conn = database_connect();

  $sql = "SELECT isPrivate FROM " . DB_FILES_TABLE . " WHERE nickname = ? && name = ?";

  $statement = $conn->prepare($sql);
  $statement->bind_param('ss', $nickname, $map_name);
  $statement->bind_result($isPrivate);

  if ($statement->execute()) {
    $statement->fetch();
    return $isPrivate ? "checked" : "";
  }

  return false;
}
