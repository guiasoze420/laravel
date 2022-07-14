<?php
session_start();
if (empty($_POST['mail']) || empty($_POST['pass'])) {
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
	$mail = $_POST['mail'];
	$pass = $_POST['pass'];
	$sql = 'SELECT * FROM members WHERE mail = :mail AND pass = :pass';
	$stmt = $dbh->prepare($sql);
	$stmt->bindValue(':mail', $mail, PDO::PARAM_STR);
	$stmt->bindValue(':pass', $pass, PDO::PARAM_STR);
	$stmt->execute();
	$member = $stmt->fetch(PDO::FETCH_ASSOC);
	if ($member) {
		$_SESSION['login'] = 1;
		$_SESSION['id'] = 'ID:' . $member['id'];
		$_SESSION['name'] = '名前:' . $member['name'];
		$msg = 'ログイン完了<br>' . $_SESSION['id'] . '<br>' . $_SESSION['name'];
	} else {
		$msg = 'メンバーが存在しません';
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
<a href="login.php">戻る</a>
</body>
</html>
