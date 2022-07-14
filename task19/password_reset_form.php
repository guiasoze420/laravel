<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>課題19</title>
</head>
<body>
<form action="password_reset_form_check.php?token=<?php echo $_GET['token']; ?>" method="post">
<p>パスワード再設定申請</p>
<p>新規パスワードを入力してください</p>
<input type="text" name="new_pass">
<input type="submit" value="送信">
</form>
<a href="login.php">ログインへ</a>
</body>
</html>
