<?php session_start();
require('connect.php');
require('header.php');

if (!empty($_POST['id'])) {
 switch ($_POST['action']) {
   case '詳細':

      $details = $db->prepare('SELECT * FROM stocks WHERE trader_id=?');
      $details->execute(array($_POST['id']));

      foreach ($details as $rows) {
        $stockName[] = $rows['stock_name'];
        $price[] = $rows['price'];
        $_SESSION['trader_id'] = $rows['trader_id'];
      }

        $_SESSION['stockname'] = $stockName;
        $_SESSION['price'] = $price;

        header('Location: trader_details.php');
        exit();

    break;

   case '編集':

        $edit = $db->prepare('SELECT * FROM traders WHERE id=?');
        $edit->execute(array($_POST['id']));

        foreach ($edit as $editData) {
          $trader_id = $editData['id'];
          $trader_name = $editData['trader_name'];
          $address = $editData['address'];
          $tel = $editData['tel'];
          $email = $editData['email'];
        }

          $_SESSION['id'] = $_POST['id'];
          $_SESSION['trader_name'] = $trader_name;
          $_SESSION['address'] = $address;
          $_SESSION['tel'] = $tel;
          $_SESSION['email'] = $email;

          header('Location: trader_edit.php');
          exit();
  }

}

if (!empty($_POST['add'])) {

  header('Location: trader_add.php');
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
  <link rel="stylesheet" href="css/style.css?v=2">
</head>
<body>
<main>
  <table class="radix-list">
  <tr>
    <th>  </th>
    <th>会社名</th>
    <th>住所</th>
    <th>電話番号</th>
    <th>e-mail</th>
  </tr>
  <form action="" method="post">
  <?php
      $traders = $db->query('SELECT * FROM traders');
      while ($trader = $traders->fetch()) {
        $traderData['id'][] = $trader['id'];
        $traderData['trader_name'][] = $trader['trader_name'];
        $traderData['address'][] = $trader['address'];
        $traderData['tel'][] = $trader['tel'];
        $traderData['email'][] = $trader['email'];
      }
      ?>
      <?php for ($i = 0; $i < count($traderData['id']); $i++): ?>
      <tr>
      <td><input type="radio" name="id" value="<?php echo($traderData['id'][$i]) ?>"></td>
      <td><?php print($traderData['trader_name'][$i]); ?></td>
      <td><?php print($traderData['address'][$i]); ?></td>
      <td><?php print($traderData['tel'][$i]); ?></td>
      <td><?php print($traderData['email'][$i]); ?></td>
      </tr>
      <?php endfor; ?>
  </table>
  <div class="trader-contents">
      <input type="submit" name="action" value="詳細">
      <input class="edit-btn" type="submit" name="action" value="編集">
      <input type="submit" name="add" value="追加">
  </div>
  </form>
</main>
</body>
</html>
