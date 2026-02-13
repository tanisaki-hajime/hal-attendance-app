<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>会員詳細</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>会員詳細情報</h1>
    
    <table>
        <tr>
            <th>ID</th>
            <td><?php echo $row['id']; ?></td>
        </tr>
        <tr>
            <th>氏名</th>
            <td><?php echo $row['name']; ?></td>
        </tr>
        <tr>
            <th>ログインID</th>
            <td><?php echo $row['login_id']; ?></td>
        </tr>
        <tr>
            <th>メールアドレス</th>
            <td><?php echo $row['mail']; ?></td>
        </tr>
        <tr>
            <th>パスワード</th>
            <td>●●●●●●●●</td>
        </tr>
        <tr>
            <th>画像</th>
            <td>
                <?php if ($row['file_name']) { ?>
                    <img src="images/<?php echo $row['file_name']; ?>" style="max-width: 100%;">
                <?php } else { ?>
                    なし
                <?php } ?>
            </td>
        </tr>
    </table>
    
    <p>
        <a href="index.php">一覧に戻る</a> | 
        <a href="edit.php?id=<?php echo $row['id']; ?>">編集する</a>
    </p>
</body>
</html>