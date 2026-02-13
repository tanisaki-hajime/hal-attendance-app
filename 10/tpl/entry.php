<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>会員登録</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>会員登録</h1>

    <?php if ($mode == 'input') { ?>
        <form action="entry.php" method="post" enctype="multipart/form-data">
            <label>氏名<br><input type="text" name="name" value="<?php echo $name; ?>"></label>
            <?php if (isset($err['name'])) echo '<span class="error">'.$err['name'].'</span>'; ?><br>

            <label>メール<br><input type="text" name="mail" value="<?php echo $mail; ?>"></label>
            <?php if (isset($err['mail'])) echo '<span class="error">'.$err['mail'].'</span>'; ?><br>

            <label>ID<br><input type="text" name="login_id" value="<?php echo $lid; ?>"></label>
            <?php if (isset($err['lid'])) echo '<span class="error">'.$err['lid'].'</span>'; ?><br>

            <label>PASS<br><input type="password" name="password"></label>
            <?php if (isset($err['pass'])) echo '<span class="error">'.$err['pass'].'</span>'; ?><br>

            <label>画像<br><input type="file" name="img"></label><br>

            <input type="hidden" name="fname_bk" value="<?php echo $fname; ?>">
            <button type="submit" name="conf">確認画面へ</button>
        </form>

    <?php } elseif ($mode == 'conf') { ?>
        <p>この内容で登録しますか？</p>
        <form action="entry.php" method="post">
            <p>氏名：<?php echo $name; ?></p>
            <p>メール：<?php echo $mail; ?></p>
            <p>ID：<?php echo $lid; ?></p>
            <p>PASS：<?php echo str_repeat('●', mb_strlen($pass)); ?></p> <?php if ($fname) { ?>
                <p>画像：<br><img src="images/thumb_<?php echo $fname; ?>"></p>
            <?php } ?>

            <input type="hidden" name="name" value="<?php echo $name; ?>">
            <input type="hidden" name="mail" value="<?php echo $mail; ?>">
            <input type="hidden" name="login_id" value="<?php echo $lid; ?>">
            <input type="hidden" name="password" value="<?php echo $pass; ?>">
            <input type="hidden" name="fname_bk" value="<?php echo $fname; ?>">

            <button type="submit" name="back">戻る</button>
            <button type="submit" name="done">登録する</button>
        </form>

    <?php } elseif ($mode == 'done') { ?>
        <p>会員登録が完了しました。</p>
        <a href="index.php">一覧に戻る</a>
    <?php } ?>
</body>
</html>