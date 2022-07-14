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
$sql = 'SELECT posts.id, posts.user_id, users.name, posts.title, posts.text, posts.created_at FROM users INNER JOIN posts ON users.id = posts.user_id WHERE enabled = 1';
$posts = $dbh->query($sql);
?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>課題19</title>
</head>
<body>
<p>投稿一覧</p>
<?php if (isset($_SESSION['id'])) : ?>
<p><?php echo $_SESSION['name']; ?>さんログイン中</p>
<a href="logout.php">ログアウトする</a>
<?php else : ?>
<a href="login.php">ログインする</a>
<?php endif; ?>
<br>
<a href="newpost.php">新規投稿へ</a>
<table border="1">
<tr>
<th>投稿ID</th>
<th>投稿者名</th>
<th>タイトル</th>
<th>本文</th>
<th>記入年月時分</th>
</tr>
<?php foreach ($posts as $post) : ?>
<tr>
<td><?php echo $post['id']; ?></td>
<td><a href="userinfo.php?id=<?php echo $post['user_id']; ?>"><?php echo $post['name']; ?></a></td>
<td>
<?php echo $post['title'];
if (isset($_SESSION['id']) && $_SESSION['id'] == $post['user_id']) : ?>
<a href="post_edit.php?id=<?php echo $post['id']; ?>">編集</a>
<a href="post_delete.php?id=<?php echo $post['id']; ?>">削除</a>
<?php endif; ?>
</td>
<td><?php echo $post['text']; ?></td>
<td><?php echo $post['created_at']; ?></td>
</tr>
<?php endforeach; ?>
</table>
</body>
</html>
