<!-- 商品登録画面 -->
<?PHP
  SESSION_START();
  require('connect.php');

  //$_SESSION['stock']に値が入っていたら削除する
  if (!empty($_SESSION['stock'])) {
    unset($_SESSION['stock']);
  }

  //入力されていない項目があったら$_SESSIONへの代入をやめる
  if (!empty($_POST)) {
    for ($x = 0; $x < 5; $x++) {
      if ($_POST["stock_name$x"] == '' && $_POST["price$x"] == '' && $_POST["radix$x"] == '') {

        break;
      } elseif ($_POST["stock_name$x"] == '' || $_POST["price$x"] == '' || $_POST["radix$x"] == '') {
        $error = 'blank';
        break;
      } else {
        $stock = [$_POST["stock_name$x"], $_POST["price$x"], $_POST["radix$x"], $_POST["trader_name$x"]];
        $_SESSION['stock'][] = $stock;
      }
    }
    if (!empty($_SESSION['stock'])) {
      header('Location: add_check.php');
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
<!-- ヘッダーファイルの呼び出し -->
  <?php require('header.php'); ?>
<body>
<table class="add-table">
  <tr>
    <th>商品名</th>
    <th>単価</th>
    <th>基数</th>
    <th>担当業者名</th>
  </tr>
<!-- 入力用テーブルの作成 -->
<form action="" method="post">
  <?php 
    for ($i = 0; $i < 5; $i++):
      ?>
      <tr>
        <td><input type="text" name="stock_name<?php echo $i ?>"></td>
        <td><input type="text" name="price<?php echo $i ?>"></td>
        <td><input type="text" name="radix<?php echo $i ?>"></td>
        <td><select class="trader_name" name="trader_name<?php echo $i ?>" id="">
        <?php
          $y = 1;
          $traders = $db->query('SELECT trader_name FROM traders');
          $traders->execute();
          while ($trader = $traders->fetch()) {
            echo '<option value="' . $y . '">' . $trader[0] . '</option>';
            $y++;
          }
        ?>
        </select></td>
      </tr>
  <?php endfor; ?>
</table>
<div class="add-btn">
    <?php if (isset($error) && $error === 'blank'): ?>
      <p class="add-error">※追加項目が正しく入力されていません</p>
    <?php endif; ?>
    <input type="submit" name="add-check" value="確認">
  </div>
</form>
</body>
</html>