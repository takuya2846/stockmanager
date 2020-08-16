<?php
session_start();
require('connect.php');

// $_POSTの確認
if (!empty($_POST)) {
  //$_POSTの値を分割する
    $result = array_chunk($_POST, 2);
    $afRadix = $db->prepare('UPDATE stocks SET radix=:radix WHERE id=:id');
    for ($y = 0; $y < count($_POST); $y++) {
      $afRadix->bindParam(':id', $result[$y][0], PDO::PARAM_INT);
      $afRadix->bindParam(':radix', $result[$y][1], PDO::PARAM_INT);
      $afRadix->execute();
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
            <!-- type属性をhiddenにしてIDの値を送信する様にする。inputの外でDBより取得したIDを表示させる -->
            <td><input type="hidden" name="id<?php echo($x) ?>" value="<?php print($stock['id']); ?>"><?php print($stock['id']); ?></td>
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
        <input class="check-btn" type="submit" value="確認">
      </div>
      </form>
    </main>
  </body>
</html>
