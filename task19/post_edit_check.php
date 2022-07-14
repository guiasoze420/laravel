<?php
session_start();
if (empty($_POST['title']) || empty($_POST['text'])) {
	$msg = '空欄があります';
} else {
	$dsn = 'mysql:host=localhost;dbname=procir_itou406;charset=utf8';
	$user = 'itou406';
	$password = 'd8fxmiuu9l';
	try {
		$dbh = new PDO($dsn, $user, $password);
	} catch (PDOException $e) {
		$msg = 'データベースに接続できませんでした' . $e->getMessage();
		exit();
	}
	$id = $_POST['id'];
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
			$title = $_POST['title'];
			$text = $_POST['text'];
			$id = $_POST['id'];
			$created_at = date('Y-m-d H:i');
			$sql = 'UPDATE posts SET title = :title, text = :text, created_at = "'.$created_at.'"  WHERE id = :id';
			$stmt = $dbh->prepare($sql);
			$stmt->bindValue(':title', $title, PDO::PARAM_STR);
			$stmt->bindValue(':text', $text, PDO::PARAM_STR);
			$stmt->bindValue(':id', $id, PDO::PARAM_INT);
			$stmt->execute();
			$msg = '編集完了';
		} else {
			header('Location:post_list.php');
			exit();
		}
	} else {
		header('Location:post_list.php');
		exit();
	}
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>課題18</title>
</head>
<body>
<?php echo $msg; ?>
<br>
<a href="post_list.php">投稿一覧へ</a>
</body>
</html>
