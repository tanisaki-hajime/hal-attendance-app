<?php
require_once '../db_config.php';

if (!isset($_COOKIE['user_id'])) header('Location: login.php');

// DB接続
function db_connect() {
    $link = mysqli_connect(HOST, USER, PASSWORD, DB);
    if (!$link) {
        die('DB接続失敗: ' . mysqli_connect_error());
    }
    mysqli_set_charset($link, 'utf8mb4');
    return $link;
}

$id = $_GET['id'];
$link = db_connect();

$sql = "SELECT * FROM m_user WHERE id = $id";
$res = mysqli_query($link, $sql);
$row = mysqli_fetch_assoc($res);

mysqli_close($link);
require_once 'tpl/detail.php';
?>