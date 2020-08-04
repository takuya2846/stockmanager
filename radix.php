<?php
session_start();
require('connect.php');

// $_POSTの確認
if (!empty($_POST)) {
    print_r($_POST);
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
        <th>ID</th>
        <th>商品名</th>
        <th>単価</th>
        <th>基数</th>
        <th>変更後</th>
        <th>在庫数</th>
      </tr>
      <?php
                
        $stocks = $db->query('SELECT * FROM stocks');
        $stocks->execute();
        ?>
        <form action="" method="post">
        <?php $x = 0; ?>
        <?php while ($stock = $stocks->fetch()): ?>
          <tr>
          <td><input type="hidden" name="id<?php echo($x) ?>" value="<?php echo($stock['id']) ?>"><p><?php print($stock['id']); ?></p></td>
            <td><?php print($stock['id']); ?></td>
            <td><?php print($stock['stock_name']); ?></td>
            <td><?php print($stock['price']); ?></td>
            <td><?php print($stock['radix']); ?></td>
          <!-- $_POSTで全ての値を返すためにname属性を変える -->
            <td><input type="text" name="after_radix<?php echo($x) ?>" value="<?php print($stock['radix']); ?>"></td>
            <td><?php print($stock['stock']); ?></td>
          </tr>
        <?php $x++; ?>
        <?php endwhile; ?>
      </table>
      <div class="check-btn-area">
        <input class="check-btn" type="submit" name="after_radix-btn" value="確認">
      </div>
      </form>
    </main>
  </body>
</html>
