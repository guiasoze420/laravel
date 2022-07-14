<?php
session_start();
if (isset($_SESSION['id']) && $_SESSION['id'] == $_GET['id']) {
	$dsn = 'mysql:host=localhost;dbname=procir_itou406;charset=utf8';
	$user = 'itou406';
	$password = 'd8fxmiuu9l';
	try {
		$dbh = new PDO($dsn, $user, $password);
	} catch (PDOException $e) {
		echo 'データベースに接続できませんでした' . $e->getMessage();
		exit();
	}
	$sql = 'SELECT comment FROM users WHERE id = :id';
	$stmt = $dbh->prepare($sql);
	$params = array(
		':id' => $_SESSION['id'],
	);
	$stmt->execute($params);
	$user = $stmt->fetch(PDO::FETCH_ASSOC);
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
<p>ユーザー情報編集</p>
<form action="userinfo_edit_check.php" method="post" enctype="multipart/form-data">
<p>アップロード画像</p>
<input type="file" name="image">
<p>一言コメント</p>
<input type="text" name="comment" value="<?php echo $user['comment']; ?>">
<input type="hidden" name="user_id" value="<?php echo $_GET['id']; ?>">
<input type="submit" name="upload" value="編集">
</form>
<a href="post_list.php">投稿一覧へ</a>
</body>
</html>
