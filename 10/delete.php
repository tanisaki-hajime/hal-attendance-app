<?php
require_once '../db_config.php';

// ログイン確認
if (!isset($_COOKIE['user_id'])) {
    header('Location: login.php');
    exit;
}

$id = isset($_GET['id']) ? $_GET['id'] : (isset($_POST['id']) ? $_POST['id'] : '');

if ($id == '') {
    header('Location: index.php');
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

// 論理削除
if (isset($_POST['del'])) {
    // 物理削除ではなく、deleted_at に現在時刻を入れる
    $sql = "UPDATE m_user SET deleted_at = NOW() WHERE id = " . mysqli_real_escape_string($link, $id);
    mysqli_query($link, $sql);
    mysqli_close($link);
    header('Location: index.php');
    exit;
}

// 表示用データ取得
$sql = "SELECT * FROM m_user WHERE id = " . mysqli_real_escape_string($link, $id);
$res = mysqli_query($link, $sql);
$row = mysqli_fetch_assoc($res);

mysqli_close($link);
require_once 'tpl/delete.php';
?>