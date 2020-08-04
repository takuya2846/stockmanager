<?php 
  session_start();
  require('connect.php');
  if (!isset($_SESSION['trader_name'])) {
    header('Location: trader.php');
    exit();
  }

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
  }

  if (!empty($_POST['change_btn'])) {
  switch ($_POST['change_btn']) {
    case '訂正':
      if (empty($error)) {

        $upDateDatas['trader_name'] = $_POST['trader_name'];
        $upDateDatas['address'] = $_POST['address'];
        $upDateDatas['tel'] = $_POST['tel'];
        $upDateDatas['email'] = $_POST['email'];
        $upDateDatas['id'] = $_SESSION['id'];

        $changeDatas = $db->prepare('UPDATE traders SET trader_name=?, address=?, tel=?, email=? WHERE id=?');
        $changeDatas->execute([$upDateDatas['trader_name'], $upDateDatas['address'], $upDateDatas['tel'], $upDateDatas['email'], $upDateDatas['id']]);

        unset($_SESSION['trader_name']);
        unset($_SESSION['address']);
        unset($_SESSION['tel']);
        unset($_SESSION['email']);
        unset($_SESSION['id']);
        
        header ('Location: trader.php');
        exit();
      } 

      break;

    case '削除':
      if (empty($error)) {

        $deletetDatas['id'] = $_SESSION['id'];
  
        $addDatas = $db->prepare('DELETE FROM traders WHERE id=? LIMIT 1');
        $addDatas->execute([$deletetDatas['id']]);
  
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
    <td><input type="text" name="trader_name" value="<?php if(isset($_SESSION['trader_name'])) {
      print(htmlspecialchars($_SESSION['trader_name'], ENT_QUOTES));
    } ?>"></td>
    <td><input type="text" name="address" value="<?php if (isset($_SESSION['address'])) {
      print(htmlspecialchars($_SESSION['address'], ENT_QUOTES)); 
    }
    ?>"></td>
    <td><input type="text" name="tel" value="<?php if (isset($_SESSION['tel'])) {
      print(htmlspecialchars($_SESSION['tel'], ENT_QUOTES));
    }
    ?>"></td>
    <td><input type="text" name="email" value="<?php if (isset($_SESSION['email'])) {
      print(htmlspecialchars($_SESSION['email'], ENT_QUOTES));
    }
    ?>"></td>
  </tr>
  </table>
  <?php if (isset($error)): ?>
      <p class="trader-error">※入力に誤りがあります。確認の上、入力し直してください。</p>
  <?php endif; ?>
    <div class="change-btn">
      <input type="submit" name="change_btn" onclick="return confirm('以下の内容で訂正してよろしいですか？');" value="訂正">
      <input type="submit" name="change_btn" onclick="return confirm('以下の内容で削除してよろしいですか？');" value="削除">
      <input type="submit" name="change_btn" value="戻る">
    </div>
  </form>
</main>
</body>
</html>
