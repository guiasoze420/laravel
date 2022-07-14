<?php
if (empty($_GET['token'])) {
	header('Location:login.php');
	exit();
} elseif (empty($_POST['new_pass'])) {
	$msg = 'パスワードを入力してください';
} else {
	$dsn = 'mysql:host=localhost;dbname=procir_itou406;charset=utf8';
	$user = 'itou406';
	$password = 'd8fxmiuu9l';
	try {
		$dbh = new PDO($dsn, $user, $password);
	} catch (PDOException $e) {
		echo 'データベースに接続できませんでした' . $e->getMessage();
		exit();
	}
	$sql = 'SELECT pass_reset_token, pass_reset_date FROM users WHERE pass_reset_token = :pass_reset_token';
	$stmt = $dbh->prepare($sql);
	$params = array(
		':pass_reset_token' => $_GET['token'],
	);
	$stmt->execute($params);
	$user = $stmt->fetch(PDO::FETCH_ASSOC);
	$limit_time = date('Y-m-d H:i:s', strtotime(' - 30minute'));
	if ($user && $limit_time < $user['pass_reset_date']) {
		$sql = 'UPDATE users SET pass = :new_pass, pass_reset_token = null, pass_reset_date = null WHERE pass_reset_token = :token';
		$stmt = $dbh->prepare($sql);
		$params = array(
			':new_pass' => $_POST['new_pass'],
			':token' => $_GET['token'],
		);
		$stmt->execute($params);
		$msg = 'パスワード更新完了<br><a href="login.php">ログイン画面へ</a>';
	} else {
		$msg = '不正なアクセスです。再度お試しください。<br><a href="login.php">ログイン画面へ</a>';
	}
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>課題19</title>
</head>
<body>
<?php echo $msg; ?>
</body>
</html>
