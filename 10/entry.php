<?php
require_once '../db_config.php';

$mode = 'input';
$err = [];

$name = '';
$mail = '';
$lid = '';
$pass = '';
$fname = '';

// DB接続
function db_connect() {
    $link = mysqli_connect(HOST, USER, PASSWORD, DB);
    if (!$link) {
        die('DB接続失敗: ' . mysqli_connect_error());
    }
    mysqli_set_charset($link, 'utf8mb4');
    return $link;
}

// 戻るボタン
if (isset($_POST['back'])) {
    $mode = 'input';
    $name = $_POST['name'];
    $mail = $_POST['mail'];
    $lid = $_POST['login_id'];
    $fname = $_POST['fname_bk'];
    // パスワードは空にする
}

// 確認画面へ・登録ボタン
if (isset($_POST['conf']) || isset($_POST['done'])) {
    $name = $_POST['name'];
    $mail = $_POST['mail'];
    $lid = $_POST['login_id'];
    $pass = $_POST['password'];

    // 入力チェック
    if ($name == '') {
        $err['name'] = "氏名を入力してください";
    }
    
    // メールアドレスチェック
    if ($mail == '') {
        $err['mail'] = "メールアドレスを入力してください";
    } elseif (strpos($mail, '@') === false) {
        // 「@」が含まれていない場合のエラー
        $err['mail'] = "メールアドレスに「@」が含まれていません";
    }

    if ($lid == '') {
        $err['lid'] = "IDを入力してください";
    }
    
    // パスワードのチェック
    if ($mode == 'input') {
        if ($pass == '') {
            //  パスワードが空の場合
            $err['pass'] = "パスワードを入力してください";
        } elseif (count($err) > 0) {
            //  パスワードは入力したけど、他の項目（名前など）でエラーがある場合
            $err['pass'] = "セキュリティのためパスワードを削除しました。再度入力してください";
            $pass = ""; 
        }
    }

    // 画像処理
    if (isset($_FILES['img']) && $_FILES['img']['error'] == 0) {
        $ext = pathinfo($_FILES['img']['name'], PATHINFO_EXTENSION);
        $new_name = date('YmdHis') . uniqid() . '.' . $ext;
        $path = 'images/' . $new_name;
        if (move_uploaded_file($_FILES['img']['tmp_name'], $path)) {
            $fname = $new_name;
            // サムネイル作成
            list($w, $h) = getimagesize($path);
            $tw = 100; $th = $h * ($tw / $w);
            $thumb = imagecreatetruecolor($tw, $th);
            if ($ext == 'jpg' || $ext == 'jpeg') {
                $src = imagecreatefromjpeg($path);
                imagecopyresampled($thumb, $src, 0, 0, 0, 0, $tw, $th, $w, $h);
                imagejpeg($thumb, 'images/thumb_' . $new_name);
            } elseif ($ext == 'png') {
                $src = imagecreatefrompng($path);
                imagealphablending($thumb, false);
                imagesavealpha($thumb, true);
                imagecopyresampled($thumb, $src, 0, 0, 0, 0, $tw, $th, $w, $h);
                imagepng($thumb, 'images/thumb_' . $new_name);
            }
        }
    } elseif (isset($_POST['fname_bk'])) {
        $fname = $_POST['fname_bk'];
    }

    // エラーがなければ次へ
    if (count($err) == 0) {
        if (isset($_POST['conf'])) {
            $mode = 'conf';
        } elseif (isset($_POST['done'])) {
            $mode = 'done';
        }
    }
}

// 登録実行
if ($mode == 'done') {
    $link = db_connect();
    $hash = password_hash($pass, PASSWORD_DEFAULT);
    $sql = "INSERT INTO m_user (name, mail, login_id, password, file_name) VALUES ('$name', '$mail', '$lid', '$hash', '$fname')";
    mysqli_query($link, $sql);
    mysqli_close($link);
}

require_once 'tpl/entry.php';
?>