<?php
session_start();
if (!isset($_SESSION['id'])) {
	header('Location:signup.php');
	exit();
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>課題18</title>
</head>
<body>
<form action="newpost_check.php" method="post">
<p>新規投稿</p>
<p>タイトル</p>
<input type="text" name="title">
<p>本文</p>
<input type="text" name="text">
<input type="submit" value="投稿">
</form>
<a href="post_list.php">投稿一覧へ</a>
</body>
</html>
