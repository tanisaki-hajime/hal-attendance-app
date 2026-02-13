<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>ログイン</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>ログイン画面</h1>
    <?php if ($err) { ?>
        <p class="error"><?php echo $err; ?></p>
    <?php } ?>
    
    <form action="login.php" method="post">
        <label>ID：<input type="text" name="login_id"></label>
        <label>PASS：<input type="password" name="password"></label>
        <button type="submit" name="login">ログイン</button>
    </form>
    <p><a href="entry.php">新規登録</a></p>
</body>
</html>