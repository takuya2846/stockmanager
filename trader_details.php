<?php
session_start();
require('connect.php');

if (!isset($_SESSION['trader_id'])) {
  header('Location: trader.php');
  exit();
}


$tradersName = $db->prepare('SELECT * FROM traders WHERE id=?');
$tradersName->execute(array($_SESSION['trader_id']));
while ($traderName = $tradersName->fetch()) {
  $trader = $traderName['trader_name'];

  if (!empty($_SESSION['trader_name']) || !empty($_SESSION['trader_id'])) {
    unset($_SESSION['trader_name'], $_SESSION['trader_id']);
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
<div class="trader-name">
  <p ><?php print($trader); ?></p>
</div>
  <table class="radix-list">
  <tr>
    <th>商品名</th>
    <th>単価</th>
  </tr>
  <?php for ($i = 0; $i < count($_SESSION['stockname']); $i++): ?>
  <tr>
    <td>
      <?php print($_SESSION['stockname'][$i]); ?>
    </td>
    <td>
      <?php print($_SESSION['price'][$i]); ?>
    </td>
  </tr>
  <?php endfor; ?>
  </table>
  <form action="" method="post">
    <div class="jamp-btm">
      <input type="submit" name="jump_trader" value="戻る">
    </div>
  </form>
</main>
</body>
</html>