<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>会員一覧</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div style="text-align: right;">
        ようこそ <?php echo $login_user['name']; ?> さん！
        <a href="login.php?logout=1">ログアウト</a>
    </div>

    <h1>会員一覧</h1>
    <p><a href="entry.php">新規登録</a></p>
    
    <table>
        <tr>
            <th>ID</th>
            <th>画像</th>
            <th>氏名</th>
            <th>操作</th>
        </tr>
        <?php foreach ($data as $u) { ?>
        <tr>
            <td><?php echo $u['id']; ?></td>
            <td>
                <?php if ($u['file_name']) { ?>
                    <img src="images/thumb_<?php echo $u['file_name']; ?>" width="50">
                <?php } ?>
            </td>
            <td>
                <a href="detail.php?id=<?php echo $u['id']; ?>"><?php echo $u['name']; ?></a>
            </td>
            <td>
                <a href="edit.php?id=<?php echo $u['id']; ?>">編集</a>
                | 
                <a href="delete.php?id=<?php echo $u['id']; ?>">削除</a>
            </td>
        </tr>
        <?php } ?>
    </table>

    <div class="pager">
        <?php if ($page > 1) { ?>
            <a href="index.php?page=<?php echo $page - 1; ?>">前へ</a>
        <?php } ?>
        
        <?php for ($i = 1; $i <= $total; $i++) { ?>
            <?php if ($i == $page) { ?>
                <span><?php echo $i; ?></span>
            <?php } else { ?>
                <a href="index.php?page=<?php echo $i; ?>"><?php echo $i; ?></a>
            <?php } ?>
        <?php } ?>
        
        <?php if ($page < $total) { ?>
            <a href="index.php?page=<?php echo $page + 1; ?>">次へ</a>
        <?php } ?>
    </div>
</body>
</html>