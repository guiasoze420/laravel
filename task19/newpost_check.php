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
	$title = $_POST['title'];
	$text = $_POST['text'];
	$created_at = date('Y-m-d H:i');
	$sql = 'INSERT INTO posts (id, user_id, title, text, created_at, enabled) VALUES (null, "'.$_SESSION['id'].'", :title, :text, "'.$created_at.'", 1)';
	$stmt = $dbh->prepare($sql);
	$stmt->bindValue(':title', $title, PDO::PARAM_STR);
	$stmt->bindValue(':text', $text, PDO::PARAM_STR);
	$stmt->execute();
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
<?php echo $msg; ?>
<br>
<a href="post_list.php">投稿一覧へ</a>
</body>
</html>
