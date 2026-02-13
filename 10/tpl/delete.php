<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>削除確認</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>削除確認</h1>
    <p class="error">本当に以下の会員を削除しますか？この操作は取り消せません。</p>
    
    <div style="background:#fff; padding:20px; border:1px solid #ccc;">
        <p>ID：<?php echo $row['id']; ?></p>
        <p>氏名：<?php echo $row['name']; ?></p>
        <p>メール：<?php echo $row['mail']; ?></p>
        <?php if ($row['file_name']) { ?>
            <p><img src="images/thumb_<?php echo $row['file_name']; ?>"></p>
        <?php } ?>
    </div>

    <form action="delete.php" method="post">
        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
        <br>
        <button type="button" onclick="history.back()">キャンセル</button>
        <button type="submit" name="del" style="background:red; color:white;">削除実行</button>
    </form>
</body>
</html>