<?php 
  session_start();
  require('connect.php');
  
  //送信された時のエラーチェック
  if (!empty($_POST)) {
    if ($_POST['trader_name'] === '') {
      $error['trader_name'] = 'blank';
    }

    if ($_POST['address'] === '') {
      $error['address'] = 'blank';
    }

    if ($_POST['tel'] === '') {
      $error['tel'] = 'blank';
    }

    if (strlen($_POST['tel']) === 10 || strlen($_POST['tel']) === 11) {
    } else {
      $error['tel'] = 'length';
    }

    if (!is_numeric($_POST['tel'])) {
      $error['tel'] = 'unusable';
    }

    if ($_POST['email'] === '') {
      $error['email'] = 'blank';
    }
    
    if (!preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/", $_POST['email'])) {
      $error['email'] = 'chars';
    }
  
  //押されたボタンによって処理を分岐
  switch ($_POST['change_btn']) {
    case '追加':
      if (empty($error)) {

      $insertDatas['trader_name'] = $_POST['trader_name'];
      $insertDatas['address'] = $_POST['address'];
      $insertDatas['tel'] = $_POST['tel'];
      $insertDatas['email'] = $_POST['email'];

      $changeDatas = $db->prepare('INSERT INTO traders (trader_name, address, tel, email) VALUES (?, ?, ?, ?)');
      $changeDatas->execute([$insertDatas['trader_name'], $insertDatas['address'], $insertDatas['tel'], $insertDatas['email']]);

      unset($_SESSION['trader_name']);
      unset($_SESSION['address']);
      unset($_SESSION['tel']);
      unset($_SESSION['email']);
      unset($_SESSION['id']);

      header ('Location: trader.php');
      exit();
    }

      break;
      
    case '戻る':
      unset($_SESSION['trader_name']);
      unset($_SESSION['address']);
      unset($_SESSION['tel']);
      unset($_SESSION['email']);
      unset($_SESSION['id']);
        
        header ('Location: trader.php');
        exit();  
  }
}  
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>在庫管理</title>
  <link rel="stylesheet" href="css/Modern Css Reset.css?v=2">
  <link rel="stylesheet" href="css/style.css?v=2">
</head>
  <?php require('header.php'); ?>
<body>
<main>
  <table class="radix-list">
  <tr>
    <th>会社名</th>
    <th>住所</th>
    <th>電話番号</th>
    <th>e-mail</th>
  <form action="" method="post">
  </tr>
    <td><input type="text" name="trader_name" value="<?php if(isset($_POST['trader_name'])) {
      print(htmlspecialchars($_POST['trader_name'], ENT_QUOTES));
    } ?>"></td>
    <td><input type="text" name="address" value="<?php if (isset($_POST['address'])) {
      print(htmlspecialchars($_POST['address'], ENT_QUOTES)); 
    }
    ?>"></td>
    <td><input type="text" name="tel" value="<?php if (isset($_POST['tel'])) {
      print(htmlspecialchars($_POST['tel'], ENT_QUOTES));
    }
    ?>"></td>
    <td><input type="text" name="email" value="<?php if (isset($_POST['email'])) {
      print(htmlspecialchars($_POST['email'], ENT_QUOTES));
    }
    ?>"></td>
  </tr>
  </table>
  <?php if (isset($error)): ?>
      <p class="trader-error">※入力に誤りがあります。確認の上、入力し直してください。</p>
  <?php endif; ?>
    <div class="change-btn">
      <input type="submit" name="change_btn" onclick="return confirm('以下の内容を追加してよろしいですか？');" value="追加">
      <input type="submit" name="change_btn" value="戻る">
    </div>
  </form>
</main>
</body>
</html>
