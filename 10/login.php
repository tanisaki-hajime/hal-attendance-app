<?php
require_once '../db_config.php';

$err = "";

if (isset($_POST['login'])) {
    $login_id = $_POST['login_id'];
    $pass = $_POST['password'];

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
    
    //  削除済みでないユーザーを探す 
    $sql = "SELECT * FROM m_user WHERE login_id = '" . mysqli_real_escape_string($link, $login_id) . "' AND deleted_at IS NULL";
    $res = mysqli_query($link, $sql);
    $row = mysqli_fetch_assoc($res);

    if ($row && password_verify($pass, $row['password'])) {
        setcookie('user_id', $row['id'], time() + 1209600);
        header('Location: index.php');
        exit;
    } else {
        $err = "ログイン失敗";
    }
    mysqli_close($link);
}

if (isset($_GET['logout'])) {
    setcookie('user_id', '', time() - 3600);
    header('Location: login.php');
    exit;
}

require_once 'tpl/login.php';
?>