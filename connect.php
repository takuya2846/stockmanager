<?php
  $username = 'root';
  $password = 'root';

  try {
    $db = new PDO('mysql:dbname=stocksdb;host=localhost;charset=utf8',$username,$password);
  } catch (PDOException $e) {
    echo 'DB接続エラー：' . $e-> getMessage();
  }
?>
