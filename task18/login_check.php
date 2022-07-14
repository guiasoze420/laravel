<?php
session_start();
if (empty($_POST['mail']) || empty($_POST['pass'])) {
	$msg = '空欄があります<br><a href="login.php">戻る</a>';
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
	$mail = $_POST['mail'];
	$pass = $_POST['pass'];
	$sql = 'SELECT * FROM users WHERE mail = :mail AND pass = :pass';
	$stmt = $dbh->prepare($sql);
	$stmt->bindValue(':mail', $mail, PDO::PARAM_STR);
	$stmt->bindValue(':pass', $pass, PDO::PARAM_STR);
	$stmt->execute();
	$user = $stmt->fetch(PDO::FETCH_ASSOC);
	if ($user) {
		$_SESSION['id'] = $user['id'];
		$_SESSION['name'] = $user['name'];
		$msg = 'ログイン完了<br>ID:' . $_SESSION['id'] . '<br>名前:' . $_SESSION['name'] . '<br><a href="post_list.php">投稿一覧へ</a><br><a href="newpost.php">新規投稿へ</a>';
	} else {
		$msg = 'このユーザーは登録されていません<br><a href="login.php">戻る</a><br><a href="signup.php">新規会員登録へ</a>';
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
</body>
</html>
