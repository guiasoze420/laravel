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
$sql = 'SELECT id, name, image, mail, comment FROM users WHERE id = :id';
$stmt = $dbh->prepare($sql);
$params = array(
	':id' => $_GET['id'],
);
$stmt->execute($params);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
if (empty($_GET['id']) || $_GET['id'] !== $user['id']) {
	header('Location:post_list.php');
	exit();
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>課題19</title>
</head>
<body>
<p>ユーザー情報</p>
<p>・ユーザー名</p>
<?php echo $user['name']; ?>
<p>・ユーザー画像</p>
<?php if ($user['image'] == null) : ?>
<p>未登録</p>
<?php else : ?>
<img src="images/<?php echo $user['image']; ?>">
<?php endif ?>
<p>・メールアドレス</p>
<p><?php echo $user['mail']; ?></p>
<p>・一言コメント</p>
<p><?php echo $user['comment']; ?></p>
<?php if (isset($_SESSION['id']) && $_SESSION['id'] == $_GET['id']) : ?>
<a href="userinfo_edit.php?id=<?php echo $_GET['id']; ?>">編集する</a>
<?php endif; ?>
<a href="post_list.php">投稿一覧へ</a>
</body>
</html>
