<?php session_start(); ?>

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
    <th>ID</th>
    <th>商品名</th>
    <th>単価</th>
    <th>基数</th>
    <th>在庫数</th>
  </tr>
  <?php
    require('connect.php');

    if (isset($_REQUEST['page']) && is_numeric($_REQUEST['page'])) {
      $page = $_REQUEST['page'];
    } else {
      $page = 1;
    }
    $start = 5 * ($page - 1);

    $stocks = $db->prepare('SELECT * FROM stocks LIMIT ?, 5');
    $stocks->bindParam(1, $start, PDO::PARAM_INT);
    $stocks->execute();
    ?>

    <?php while ($stock = $stocks->fetch()): ?>
      <tr>
      <td><?php print($stock['id']); ?></td>
      <td><?php print($stock['stock_name']); ?></td>
      <td><?php print($stock['price']); ?></td>
      <td><?php print($stock['radix']); ?></td>
      <td><input type="text" name="$stock['stock']"></td>
      </tr>
    <?php endwhile; ?>
  </table>
</main>
  <?php
    $counts = $db->query('SELECT COUNT(*) as cnt FROM stocks');
    $count = $counts->fetch();
    $max_page = ceil($count['cnt'] / 5);
  ?>
  <div class="page-list">
  <?php for ($i = 1; $i <= $max_page; $i++) { ?>
    <?php if ($page == $i) { ?>
      <a href="input.php?page=<?php print($i); ?>"><?php print($i); ?></a>
    <?php } else { ?>
      <a href="input.php?page=<?php print($i); ?>"><?php print($i); ?></a>
    <?php } ?>
    <?php } ?>
  </div>
  <input class="order-check-btn" type="submit" name="check" value="確認">
</body>
</html>
