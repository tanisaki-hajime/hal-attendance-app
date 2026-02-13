<?php
require_once '../db_config.php';

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

// ログインユーザー名取得
$uid = $_COOKIE['user_id'];
$sql = "SELECT name FROM m_user WHERE id = " . mysqli_real_escape_string($link, $uid);
$res = mysqli_query($link, $sql);
$login_user = mysqli_fetch_assoc($res);

// ページャー設定
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;
$limit = 10; 
$offset = ($page - 1) * $limit;

// 件数取得（削除済みを除く） 
$sql_cnt = "SELECT COUNT(*) as cnt FROM m_user WHERE deleted_at IS NULL";
$res_cnt = mysqli_query($link, $sql_cnt);
$row_cnt = mysqli_fetch_assoc($res_cnt);
$total = ceil($row_cnt['cnt'] / $limit);

//  データ取得（削除済みを除く）
$sql = "SELECT * FROM m_user WHERE deleted_at IS NULL ORDER BY id DESC LIMIT $offset, $limit";
$res = mysqli_query($link, $sql);
$data = [];
while ($row = mysqli_fetch_assoc($res)) {
    $data[] = $row;
}

mysqli_close($link);

require_once 'tpl/index.php';
?>