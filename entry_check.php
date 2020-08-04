<?php
session_start();
require('connect.php');

//$_SESSION['join']がなかったらsign-up.phpに戻る
if (!isset($_SESSION['join'])) {
  header('Location: sign-up.php');
  exit();
}

//データベースへの登録
if (!empty($_POST)) {
  $statement = $db->prepare('INSERT INTO customer SET user_name=?,user_id=?,email=?,password=?,created=NOW()');
  echo $statement->execute(array(
    $_SESSION['join']['user_name'],
    $_SESSION['join']['user_id'],
    $_SESSION['join']['email'],
    sha1($_SESSION['join']['password'])
  ));
  $_SESSION['user_id'] = $_SESSION['join']['user_id'];

  unset($_SESSION['join']);

  header('Location: complete.php');
  exit();
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>在庫管理</title>
  <link rel="stylesheet" href="css/Modern Css Reset.css?v=2">
  <link rel="stylesheet" href="css/login_style.css?v=2">
</head>
<header>
  <h1>Stock　Manager</h1>
</header>
<body>
  <main>
    <div class="entry-container">
      <p>以下の内容でお間違いないですか？</p>
      <form action="" method="post">
        <input type="hidden" name="action" value="submit"/>
        <p>ニックネーム</p>
        <?php print(htmlspecialchars($_SESSION['join']['user_name'], ENT_QUOTES)); ?>
        <p>ユーザーID</p>
        <?php print(htmlspecialchars($_SESSION['join']['user_id'], ENT_QUOTES)); ?>
        <p>メールアドレス</p>
        <?php print(htmlspecialchars($_SESSION['join']['email'], ENT_QUOTES)); ?>
        <p>お間違いがなければ登録ボタンを押してください</p>
        <p>訂正する場合は戻るより再度入力をお願いいたします。</p>
        <a href="sign-up.php?action=rewrite" >戻る</a>
        <input type="submit" value="登録"/>
      </form>
    </div>
  </main>
</body>
</html>