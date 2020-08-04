<?php
session_start();
require('connect.php');

// $_SESSION['stock']がなかったらsign-up.phpに戻る
if (!isset($_SESSION['stock'])) {
  header('Location: add.php');
  exit();
}

// データベースへの登録
if (!empty($_POST)) {
  $stocks = $db->prepare('INSERT INTO stocks SET stock_name=?,price=?,radix=?,trader_id=?');
    for ($x = 0; $x < 5; $x++) {
      if (isset($_SESSION['stock'][$x])) {
        echo $stocks->execute(array(
          $_SESSION['stock'][$x][0],
          $_SESSION['stock'][$x][1],
          $_SESSION['stock'][$x][2],
          $_SESSION['stock'][$x][3]
        ));
      }
  }
  unset($_SESSION['stock']);

  header('Location: add.php');
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
<header>
  <div class="add_check-title">
    <h1>Stock　Manager</h1>
  </div>
</header>
<body>
  <main>
    <div class="add_check-text">
      <p>以下の内容でお間違いないですか？</p>
      <p>お間違いがなければ登録ボタンを押してください。</p>
      <p>訂正する場合は戻るより再度入力をお願いいたします。</p>
    </div>
      <form action="" method="post">
        <input type="hidden" name="action" value="submit"/>
          <table class="add_check-table">
            <tr>
              <th>商品名</th>
              <th>単価</th>
              <th>基数</th>
              <th>担当業者名</th>
            </tr>
              <?php $tradersData = $db->query('SELECT trader_name FROM traders');
              while ($traderData = $tradersData->fetch()) {
                $traderId[] = $traderData[0];
              }
              ?>
            <?php for ($x = 0; $x < 5; $x++): ?>
              <?php if(isset($_SESSION['stock'][$x])): ?>
              <tr>
                <td>
                <p><?php print(htmlspecialchars($_SESSION['stock'][$x][0], ENT_QUOTES)); ?></p>
              </td>
              <td>
                <p><?php print(htmlspecialchars($_SESSION['stock'][$x][1], ENT_QUOTES)); ?></p>
              </td>
              <td>
                <p><?php print(htmlspecialchars($_SESSION['stock'][$x][2], ENT_QUOTES)); ?></p>
              </td>
              <td>
                <?php
                $traderNumber = $_SESSION['stock'][$x][3] - 1;
                print(htmlspecialchars($traderId[$traderNumber], ENT_QUOTES));
                ?>
                <p>
                </p>
              </td>
              </tr>
              <?php endif; ?>
            <?php endfor; ?>
          </table>
          <div class="add_check-btn">
            <a href="add.php" >戻る</a>
            <input type="submit" onclick="return confirm('登録しました')" value="登録"/>
          </div>
      </form>
  </main>
</body>
</html>