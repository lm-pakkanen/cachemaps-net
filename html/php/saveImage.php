<?php
$img = $_POST['imgBase64'];

$img = str_replace('data:image/png;base64,', '', $img);
$img = str_replace(' ', '+', $img);

$fileData = base64_decode($img);

$nickname = $_POST['nickname'];

if (!file_exists("../files/users/$nickname/")) {
  mkdir("../files/users/$nickname/");
}

$fileName = '../files/users/' . $nickname . '/' . $nickname . '.png';
file_put_contents($fileName, $fileData);