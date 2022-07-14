<?php
session_start();
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>課題18</title>
</head>
<body>
<?php if (!isset($_SESSION['id'])) : ?>
<form action="login_check.php" method="post">
<p>メールアドレス</p>
<input type="text" name="mail">
<p>パスワード</p>
<input type="password" name="pass">
<input type="submit" value="ログイン">
</form>
<a href="post_list.php">投稿一覧へ</a>
<?php else : ?>
<?php echo $_SESSION['id'] . '<br>' . $_SESSION['name']; ?>
<br>
<a href="logout.php">ログアウトする</a>
<?php endif; ?>
</body>
</html>
