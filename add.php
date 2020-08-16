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
    //エラーチェック
    if ($_POST["stock_name"] == '' && $_POST["price"] == '' && $_POST["radix"] == '') {
      $error = 'blank';
    } elseif ($_POST["stock_name"] == '' || $_POST["price"] == '' || $_POST["radix"] == '') {
      $error = 'blank';       
    } else {
    //$_POSTで渡されたidからtrader_nameを取得する
        $traderId = $_POST['trader_id'];
        $traderName = $db->prepare('SELECT trader_name FROM traders WHERE id=:id');
        $traderName->bindValue(':id', $traderId, PDO::PARAM_INT);
        $traderName->execute();
        $name = $traderName->fetch();

    //$_POSTを$_SESSIONにいれる     
        $stock = [$_POST["stock_name"], $_POST["price"], $_POST["radix"], $_POST["trader_id"], $name['trader_name']];
        $_SESSION['stock'] = $stock;
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
      <tr>
        <td><input type="text" name="stock_name"></td>
        <td><input type="text" name="price"></td>
        <td><input type="text" name="radix"></td>
        <td><select class="trader_id" name="trader_id">
        <?php
          $traders = $db->query('SELECT id, trader_name FROM traders');
          $traders->execute();
          while ($trader = $traders->fetch()) {
            echo '<option value="' . $trader[0] . '">' . $trader[1] . '</option>';
          }
          ?>
        </select></td>
      </tr>
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