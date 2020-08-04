<?php
  $username = 'b1e6180fcbc2da';
  $password = 'fbcab897';
  $dbname = 'heroku_8003064f452ae0f';
  $host = 'us-cdbr-east-02.cleardb.com';
  try {
    $db = new PDO('mysql:dbname=$dbname;host=$host;charset=utf8',$username,$password);
  } catch (PDOException $e) {
    echo 'DB接続エラー：' . $e-> getMessage();
  }
?>
