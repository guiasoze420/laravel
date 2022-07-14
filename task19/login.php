<?php
session_start();
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>課題19</title>
</head>
<body>
<?php if (!isset($_SESSION['id'])) : ?>
<form action="login_check.php" method="post">
<p>ログイン画面</p>
<p>メールアドレス</p>
<input type="text" name="mail">
<p>パスワード</p>
<input type="password" name="pass">
<input type="submit" value="ログイン">
<br>
<a href="password_reset_mail.php">パスワードを忘れた方はこちらへ</a>
</form>
<a href="post_list.php">投稿一覧へ</a>
<?php else : ?>
<?php echo $_SESSION['id'] . '<br>' . $_SESSION['name']; ?>
<br>
<a href="logout.php">ログアウトする</a>
<br>
<?php endif; ?>
</body>
</html>
