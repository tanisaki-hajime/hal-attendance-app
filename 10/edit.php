<?php
require_once '../db_config.php';

// ログイン確認
if (!isset($_COOKIE['user_id'])) {
    header('Location: login.php');
    exit;
}
// DB接続
function db_connect() {
    $link = mysqli_connect(HOST, USER, PASSWORD, DB);
    if (!$link) {
        die('DB接続失敗: ' . mysqli_connect_error());
    }
    mysqli_set_charset($link, 'utf8mb4');
    return $link;
}

$link = db_connect();

// 変数初期化
$mode = 'input';
$err = [];
$id = '';
$name = '';
$mail = '';
$lid = '';
$pass = '';

// 初期アクセス（GET）または戻るボタン
if ($_SERVER['REQUEST_METHOD'] == 'GET' || isset($_POST['back'])) {
    
    // ID取得
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        // DBからデータ取得
        $sql = "SELECT * FROM m_user WHERE id = " . mysqli_real_escape_string($link, $id);
        $res = mysqli_query($link, $sql);
        $row = mysqli_fetch_assoc($res);
        if (!$row) { header('Location: index.php'); exit; }
        
        $name = $row['name'];
        $mail = $row['mail'];
        $lid = $row['login_id'];
    } elseif (isset($_POST['back'])) {
        // 戻るボタンの時はPOSTデータを復元
        $id = $_POST['id'];
        $name = $_POST['name'];
        $mail = $_POST['mail'];
        $lid = $_POST['login_id'];
        // パスワードはセキュリティのため空にする
    }
}

// 確認画面へ（POST）
if (isset($_POST['conf']) || isset($_POST['update'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $mail = $_POST['mail'];
    $lid = $_POST['login_id'];
    $pass = $_POST['password'];

    // 入力チェック（項番10）
    if ($name == '') $err['name'] = "氏名を入力してください";
    if ($mail == '') $err['mail'] = "メールアドレスを入力してください";
    if ($lid == '') $err['lid'] = "ログインIDを入力してください";
    // パスワードは空欄なら「変更なし」とみなすので必須チェックしない

    if (empty($err)) {
        if (isset($_POST['conf'])) {
            $mode = 'conf';
        } elseif (isset($_POST['update'])) {
            $mode = 'update';
        }
    }
}

// 更新実行
if ($mode == 'update') {
    // パスワード変更がある場合とない場合でSQLを分ける
    if ($pass != '') {
        $hash = password_hash($pass, PASSWORD_DEFAULT); // 項番1 ハッシュ化
        $sql = "UPDATE m_user SET name='$name', mail='$mail', login_id='$lid', password='$hash' WHERE id = $id";
    } else {
        $sql = "UPDATE m_user SET name='$name', mail='$mail', login_id='$lid' WHERE id = $id";
    }

    mysqli_query($link, $sql);
    mysqli_close($link);
    header('Location: index.php');
    exit;
}

mysqli_close($link);
require_once 'tpl/edit.php';
?>