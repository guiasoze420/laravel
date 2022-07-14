<?php
session_start();
$dsn = 'mysql:host=localhost;dbname=procir_itou406;charset=utf8';
$user = 'itou406';
$password = 'd8fxmiuu9l';
try {
	$dbh = new PDO($dsn, $user, $password);
} catch (PDOException $e) {
	echo 'データベースに接続できませんでした' . $e->getMessage();
	exit();
}
$id = $_GET['id'];
$sql = 'SELECT enabled FROM posts WHERE id = :id';
$stmt = $dbh->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$stmt->execute();
$enabled = $stmt->fetch(PDO::FETCH_ASSOC);
if ($enabled['enabled'] == 1) {
	$sql = 'SELECT user_id FROM posts WHERE id = :id';
	$stmt = $dbh->prepare($sql);
	$stmt->bindValue(':id', $id, PDO::PARAM_INT);
	$stmt->execute();
	$user_id = $stmt->fetch(PDO::FETCH_ASSOC);
	if ($user_id['user_id'] == $_SESSION['id']) {
		$sql = 'SELECT * FROM posts WHERE id = :id';
		$stmt = $dbh->prepare($sql);
		$stmt->bindValue(':id', $id, PDO::PARAM_INT);
		$stmt->execute();
		$post = $stmt->fetch(PDO::FETCH_ASSOC);
	} else {
		header('Location:post_list.php');
		exit();
	}
} else {
	header('Location:post_list.php');
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
<p>編集画面</p>
<form action="post_edit_check.php" method="post">
<p>タイトル</p>
<input type="text" name="title" value="<?php echo $post['title']; ?>">
<p>本文</p>
<input type="text" name="text" value="<?php echo $post['text']; ?>">
<input type="hidden" name="id" value="<?php echo $post['id']; ?>">
<input type="submit" value="送信">
</form>
<br>
<a href="post_list.php">投稿一覧へ</a>
</body>
</html>
