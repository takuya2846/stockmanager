<header>
  <div class="header-content">
    <h1>Stock　Manager</h1>
    <div class="login-message">
    <?php if(isset($_SESSION['user_id'])): ?>
        <p>ようこそ <strong><?php print($_SESSION['user_id']); ?></strong> さん</p>
    <?php endif; ?>
    </div>
    <a href="logout-output.php" onclick="return confirm('本当にログアウトしてもよろしいですか？');">ログアウト</a>
  </div>
  <div class="content-list">
    <ul>
      <li><a href="index.php">在庫一覧</a></li>
      <li><a href="input.php">発注</a></li>
      <li><a href="radix.php">基数変更</a></li>
      <li><a href="add.php">追加</a></li>
      <li><a href="trader.php">取引先管理</a></li>
    </ul>
  </div>
</header>
