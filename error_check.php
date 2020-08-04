<?php
require('connect.php');

// !emptyで$_POSTが空でなければtrue 読み込み時にfalseとして処理を行わないようにする
if (!empty($_POST)) {

// ユーザーネームに対してのエラー処理
    if ($_POST['user_name'] === '') {        //ユーザーネームが空の場合
        $error['user_name'] = 'blank';
    }

    $users = $db->prepare('SELECT user_name FROM customer');      //customertableより値を取得

    foreach ($users as $user){
        if ($_POST['user_name'] === $user['user_name']) {    //入力された値がcustomertableに存在していた場合エラーにする
            $error['user_name'] = 'duplication';
        }
    }

//ユーザーIDに対してのエラー処理
    if ($_POST['user_id'] === '') {          //ユーザーIDが空の場合
        $error['user_id'] = 'blank';
    }

    if (strlen($_POST['user_id']) < 8 || strlen($_POST['user_id']) > 8) {         //strlenを使って数値を返し、IDの文字数を判定する
        $error['user_id'] = 'length';
    }

    $users = $db->prepare('SELECT user_id FROM customer');

    foreach ($users as $user){
        if ($_POST['user_id'] === $user['user_id']) {    //入力された値がcustomertableに存在していた場合エラーにする
            $error['user_id'] = 'duplication';
        }
    }

//メールアドレスに対してのエラー処理
    if ($_POST['email'] === '') {        //メールアドレスが空の場合
        $error['email'] = 'blank';
    }

//preg_matchを使って@と@の前後を確認する マッチしたらtrueが返るので!preg_matchとしマッチしなかった時をtrueとする
    if (!preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/", $_POST['email'])) {
        $error['email'] = 'chars';
    }

    $users = $db->prepare('SELECT email FROM customer');

    foreach ($users as $user){
        if ($_POST['email'] === $user['email']) {        //入力された値がcustomertableに存在していた場合エラーにする
            $error['email'] = 'duplication';
        }
    }

//パスワードに対してのエラー処理
    if ($_POST['password'] === '') {        //パスワードが空の場合
        $error['password'] = 'blank';
    }

    if (strlen($_POST['password']) < 8 || strlen($_POST['password']) > 8) {     //strlenを使って数値を返す
        $error['password'] = 'length';
    }
    
    $users = $db->prepare('SELECT password FROM customer');

    foreach ($users as $user){
        if ($_POST['password'] === $user['password']) {     //入力された値がcustomertableに存在していた場合エラーにする
            $error['password'] = 'duplication';
        }
    }

//empty()を使って$errorが空であればページを移動してエラーチェックの処理を抜ける
    if (empty($error)) {
        $_SESSION['join'] = $_POST;
        header('Location: entry_check.php');      //header()によって(Location: Url)として指定したページにリダイレクトする
        exit();                             //リダイレクトの際に以降のコードの実行を防ぐためにexit()を書く
    }
}

if (isset($_REQUEST['action'], $_SESSION['join']) && $_REQUEST['action'] == 'rewrite') {
    $_POST = $_SESSION['join'];
}
?>