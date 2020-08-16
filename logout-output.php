<?php session_start(); ?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>在庫管理</title>
  <link rel="stylesheet" href="css/Modern Css Reset.css?v=2">
  <link rel="stylesheet" href="css/login_style.css?v=2">
</head>
<header>
  <h1>Stock　Manager</h1>
</header>
<body>
  <main>
    <div class="complete-container">
      <?php if (isset($_SESSION['user_id'])):
        unset($_SESSION['user_id']); ?>
        <div class="logout-message">
          <p>ログアウトしました</p>
        </div>
      <?php endif; ?>
      <a href="index.php">TOPへ</a>
    </div>
  </main>
</body>
</html>