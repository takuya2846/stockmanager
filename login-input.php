<?php
session_start();
require('connect.php');

//データベース内の情報と入力内容の照らし合わせる認証処理
if (!empty($_POST)) {
    if ($_POST['user_id'] !== '' && $_POST['password'] !== '') {
        $login = $db->prepare('SELECT * FROM customer WHERE user_id=? AND password=?'); //ログインに必要な情報を参照するsqlを発行する
        $login->execute(array(              //$loginのuser_is=?とpassword=?の?に対して$_POSTの値をいれる
            $_POST['user_id'],
            sha1($_POST['password'])
        ));

        $member = $login->fetch();

        if ($member) {
            $_SESSION['user_id'] = $member['user_id'];
            $_SESSION['time'] = time();
            header('Location: index.php');
            exit();
        } else {
//データベースの情報と一致しなかった時
            $error['login'] = 'failed';
        } 
//入力しないで送信した時の処理
        } elseif ($_POST['user_id'] == '' && $_POST['password'] == '') {
            $error['user_id'] = 'blank';
            $error['password'] = 'blank';
        } elseif ($_POST['user_id'] == '') {
            $error['user_id'] = 'blank';
        } else {
            $error['password'] = 'blank';
        }
}

//新規登録された時に完了画面から情報を持ってくる
if (isset($_POST['action']) && $_REQUEST['action'] == 'user-data' && isset($_SESSION['join'])) {
    $_POST = $_SESSION['join'];
}
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
    <body>
        <header>
            <h1>Stock　Manager</h1>
        </header>
        <form action="" method="post">
            <div class="login-window">
                <!-- ユーザーID -->
                <div class="user-info">
                    <p><label for="user">ユーザーID：</label></p>
                    <input id="user" type="text" name="user_id" value="<?php if (isset($_POST['user_id'])) {
                        print(htmlspecialchars($_POST['user_id'], ENT_QUOTES));
                     } ?>">
                    <?php if (isset($error['user_id']) && $error['user_id'] === 'blank'): ?>
                    <p class="error">※ユーザーIDを入力してください</p>
                    <?php endif; ?>
                </div>
                <!-- パスワード -->
                <div class="user-info">
                    <p><label for="ps">パスワード：</label></p>
                    <input id="ps" type="password" name="password" value="<?php if(isset($_POST['password'])) {print(htmlspecialchars($_POST['password'], ENT_QUOTES));} ?>">
                    <?php if (isset($error['password']) && $error['password'] === 'blank'): ?>
                    <p class="error">※パスワードを入力してください</p>
                    <?php endif; ?>
                    <?php if (isset($error['login']) && $error['login'] === 'failed'): ?>
                    <p class="error">* ログインに失敗しました。正しくご記入してください</p>
                    <?php endif; ?>
                </div>
                <input class="login-btn" type="submit" name="login" value="ログイン">
            </div>
            </form>
        <div class="sign-up">
            <a href="sign-up.php">新規登録</a>
            <p>はこちら</p>
        </div>
    </body>
</html>