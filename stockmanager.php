<?php
session_start();
require('connect.php');

//$_SESSION['user_id']がなかったらindex.phpに戻る
if (!isset($_SESSION['user_id'])) {
  header('Location: index.php');
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
      //$_REQUESTがあれば$pageに代入して移動する。初期状態ではpage=1を表示
      if (isset($_REQUEST['page']) && is_numeric($_REQUEST['page'])) {
        $page = $_REQUEST['page'];
      } else {
        $page = 1;
      }
      $start = 5 * ($page - 1);
      //stockテーブルから5項目ずつ取得する
      $stocks = $db->prepare('SELECT * FROM stocks LIMIT ?, 5');
      $stocks->bindParam(1, $start, PDO::PARAM_INT);
      $stocks->execute();
      ?>
      <!-- stockテーブルの情報を表示 -->
      <?php while ($stock = $stocks->fetch()) : ?>
        <tr>
          <td><?php print($stock['id']); ?></td>
          <td><?php print($stock['stock_name']); ?></td>
          <td><?php print($stock['price']); ?></td>
          <td><?php print($stock['radix']); ?></td>
          <td><?php print($stock['stock']); ?></td>
        </tr>
      <?php endwhile; ?>
    </table>
  </main>
  <?php
  $counts = $db->query('SELECT COUNT(*) as cnt FROM stocks');
  $count = $counts->fetch();
  $max_page = ceil($count['cnt'] / 5);
  ?>
  <!-- ページ数の表示 -->
  <div class="page-list">
    <?php for ($i = 1; $i <= $max_page; $i++) { ?>
      <?php if ($page == $i) { ?>
        <a href="stockmanager.php?page=<?php print($i); ?>"><?php print($i); ?></a>
      <?php } else { ?>
        <a href="stockmanager.php?page=<?php print($i); ?>"><?php print($i); ?></a>
      <?php } ?>
    <?php } ?>
  </div>
</body>

</html>
