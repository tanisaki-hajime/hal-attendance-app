<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>会員情報編集</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>会員情報編集</h1>

    <?php if ($mode == 'input') { ?>
        <form action="edit.php" method="post">
            <input type="hidden" name="id" value="<?php echo $id; ?>">

            <label>氏名<br>
                <input type="text" name="name" value="<?php echo $name; ?>">
            </label>
            <?php if (isset($err['name'])) echo '<p class="error">'.$err['name'].'</p>'; ?>

            <label>ログインID<br>
                <input type="text" name="login_id" value="<?php echo $lid; ?>">
            </label>
            <?php if (isset($err['lid'])) echo '<p class="error">'.$err['lid'].'</p>'; ?>

            <label>メールアドレス<br>
                <input type="text" name="mail" value="<?php echo $mail; ?>">
            </label>
            <?php if (isset($err['mail'])) echo '<p class="error">'.$err['mail'].'</p>'; ?>

            <label>パスワード（変更する場合のみ入力）<br>
                <input type="password" name="password">
            </label>
            
            <br>
            <button type="submit" name="conf">確認画面へ</button>
        </form>
        <p><a href="index.php">一覧に戻る</a></p>

    <?php } elseif ($mode == 'conf') { ?>
        <p>以下の内容で更新しますか？</p>
        <form action="edit.php" method="post">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <input type="hidden" name="name" value="<?php echo $name; ?>">
            <input type="hidden" name="mail" value="<?php echo $mail; ?>">
            <input type="hidden" name="login_id" value="<?php echo $lid; ?>">
            <input type="hidden" name="password" value="<?php echo $pass; ?>">

            <table>
                <tr>
                    <th>氏名</th>
                    <td><?php echo $name; ?></td>
                </tr>
                <tr>
                    <th>ログインID</th>
                    <td><?php echo $lid; ?></td>
                </tr>
                <tr>
                    <th>メールアドレス</th>
                    <td><?php echo $mail; ?></td>
                </tr>
                <tr>
                    <th>パスワード</th>
                    <td>
                        <?php 
                        if ($pass != '') {
                            // 入力されたパスワードの文字数分「●」を繰り返す
                            echo str_repeat('●', mb_strlen($pass)); 
                        } else {
                            echo '（変更なし）';
                        }
                        ?>
                    </td>
                </tr>
            </table>

            <button type="submit" name="back">戻る</button>
            <button type="submit" name="update">更新する</button>
        </form>
    <?php } ?>
</body>
</html>