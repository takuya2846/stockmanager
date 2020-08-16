<?php
  $username = 'b9241f735a6ff1';
  $password = 'd6e9f513';
  $dbname = 'heroku_d13dc91743de744';
  $host = 'us-cdbr-east-02.cleardb.com';
  try {
    $db = new PDO('mysql:dbname=heroku_d13dc91743de744;host=us-cdbr-east-02.cleardb.com;charset=utf8',$username,$password);
  } catch (PDOException $e) {
    echo 'DB接続エラー：' . $e-> getMessage();
  }
?>
