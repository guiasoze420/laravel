<?php
if (empty($_POST['name']) || empty($_POST['mail']) || empty($_POST['pass'])) {
	$msg = '空欄があります<br><a href="signup.php">戻る</a>';
} elseif (filter_var($_POST['mail]', FILTER_VARIDATE_EMAIL)) {
	$msg = 'このメールアドレスは使用できません';
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
	$mail = $_POST['mail'];
	$sql = 'SELECT mail FROM users WHERE mail = :mail';
	$stmt = $dbh->prepare($sql);
	$stmt->bindValue(':mail', $mail, PDO::PARAM_STR);
	$stmt->execute();
	$mails = $stmt->fetch(PDO::FETCH_ASSOC);
	if ($mails) {
		$msg = '入力されたメールアドレスは登録されています<br><a href="signup.php">戻る</a>';
	} else {
		$name = $_POST['name'];
		$mail = $_POST['mail'];
		$pass = $_POST['pass'];
		$sql = 'INSERT INTO users (name, mail, pass) VALUES (:name, :mail, :pass)';
		$stmt = $dbh->prepare($sql);
		$stmt->bindValue(':name', $name, PDO::PARAM_STR);
		$stmt->bindValue(':mail', $mail, PDO::PARAM_STR);
		$stmt->bindValue(':pass', $pass, PDO::PARAM_STR);
		$stmt->execute();
		$msg = '会員登録完了<br><a href="login.php">ログイン画面へ</a>';
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
