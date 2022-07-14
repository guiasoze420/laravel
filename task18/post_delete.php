<?php
session_start();
$dsn = 'mysql:host=localhost;dbname=procir_itou406;charset=utf8';
$user = 'itou406';
$password = 'd8fxmiuu9l';
try {
	$dbh = new PDO($dsn, $user, $password);
} catch (PDOException $e) {
	$msg = 'データベースに接続できませんでした' . $e->getMessage();
	exit();
}
$id = $_GET['id'];
$sql = 'SELECT user_id FROM posts WHERE id = :id';
$stmt = $dbh->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$stmt->execute();
$user_id = $stmt->fetch(PDO::FETCH_ASSOC);
if ($user_id['user_id'] == $_SESSION['id']) {
	$sql = 'UPDATE posts SET enabled = 0 WHERE id = :id';
	$stmt = $dbh->prepare($sql);
	$stmt->bindValue(':id', $id, PDO::PARAM_INT);
	$stmt->execute();
	$msg = '削除完了';
} else {
	header('Location:post_list.php');
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
