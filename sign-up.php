<?php
session_start();
require('error_check.php');
?>

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
        <?php require('connect.php'); ?>
        <div class="sign-up-window">
            <form action="" method="post">
                <!-- ユーザーネーム -->
                <div class="user-info">
                    <p><label for="name">ニックネーム：</label></p>
                    <input id="name" type="text" name="user_name" value="<?php if (isset($_POST['user_name'])) {print(htmlspecialchars($_POST['user_name'], ENT_QUOTES));
                     } ?>"> 
                    <?php if (isset($error['user_name'])): ?>
                    <?php if ($error['user_name'] === 'blank'): ?>
                      <p class="error">※ニックネームを入力してください</p>
                    <?php endif; ?>
                    <?php if ($error['user_name'] === 'duplication'): ?>
                      <p class="error">※このニックネームは既に使用されています</p>
                    <?php endif; ?>
                    <?php endif; ?>             
                </div>
                <!-- ユーザーID -->
                <div class="user-info">
                    <p><label for="user">ユーザーID：</label></p>
                    <input id="user" type="text" name="user_id" value="<?php if (isset($_POST['user_id'])) {
                        print(htmlspecialchars($_POST['user_id'], ENT_QUOTES));
                     } ?>">
                    <p class="user-info-text">半角英数字を使った8文字で入力してください</p>                   
                    <?php if (isset($error['user_id'])): ?>
                    <?php if ($error['user_id'] === 'blank'): ?>
                    <p class="error">※ユーザーIDを入力してください</p>
                    <?php endif; ?>
                    <?php if ($error['user_id'] === 'length'): ?>
                    <p class="error">※ユーザーIDは8文字で入力してください</p>
                    <?php endif; ?>
                    <?php if ($error['user_id'] === 'duplication'): ?>
                      <p class="error">※このユーザーIDは既に使用されています</p>
                    <?php endif; ?>
                    <?php endif; ?>
                </div>
                <!-- アドレス -->
                <div class="user-info">
                    <p><label for="email">Email　　：</label></p>
                    <input id="email" type="text" name="email" value="<?php if (isset($_POST['email'])) {
                        print(htmlspecialchars($_POST['email'], ENT_QUOTES));
                     } ?>">
                    <?php if (isset($error['email'])): ?>             
                    <?php if ($error['email'] === 'blank'): ?>
                    <p class="error">※メールアドレスが正しくありません</p>
                    <?php endif; ?>
                    <?php if ($error['email'] === 'chars'): ?>
                    <p class="error">※@の有無又は@以降を確認してください</p>
                    <?php endif; ?>
                    <?php if ($error['email'] === 'duplication'): ?>
                      <p class="error">※このメールアドレスは既に使用されています</p>
                    <?php endif; ?>
                    <?php endif; ?>
                </div>
                <!-- パスワード -->
                <div class="user-info">
                    <p><label for="ps">パスワード：</label></p>
                    <input id="ps" type="password" name="password" value="<?php if (isset($_POST['password'])) {
                      print(htmlspecialchars($_POST['password'], ENT_QUOTES));
                     } ?>">
                    <p class="user-info-text">半角英数字を使った8文字で入力してください</p>
                    <?php if (isset($error['password'])): ?>
                    <?php if ($error['password'] === 'blank'): ?>
                    <p class="error">※パスワードを入力してください</p>
                    <?php endif; ?>
                    <?php if ($error['password'] === 'length'): ?>
                    <p class="error">※パスワードは8文字で入力してください</p>
                    <?php endif; ?>
                    <?php if ($error['password'] === 'duplication'): ?>
                      <p class="error">※このパスワードは既に使用されています</p>
                    <?php endif; ?>
                    <?php endif; ?>
                </div>
                <input class="login-btn" type="submit" value="新規登録">
            </form>
        </div>
      </main>
    </body>
</html>