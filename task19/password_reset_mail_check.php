<?php
if (empty($_POST['mail'])) {
	$msg = 'メールアドレスを入力してください<br><a href="password_reset_mail.php">戻る</a>';
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
	$sql = 'SELECT id, mail FROM users WHERE mail = :mail';
	$stmt = $dbh->prepare($sql);
	$stmt->bindValue(':mail', $mail, PDO::PARAM_STR);
	$stmt->execute();
	$user = $stmt->fetch(PDO::FETCH_ASSOC);
	if ($user) {
		$pass_reset_token = md5(uniqid(rand(), true));
		$pass_reset_date = date("Y-m-d H:i:s");

		$sql = 'UPDATE users SET pass_reset_token = :pass_reset_token, pass_reset_date = :pass_reset_date WHERE id = :id';
		$stmt = $dbh->prepare($sql);
		$params = array(
			':pass_reset_token' => $pass_reset_token,
			':pass_reset_date' => $pass_reset_date,
			':id' => $user['id'],
		);
		$stmt->execute($params);

		mb_language("Japanese");
		mb_internal_encoding("UTF-8");
		$to = $user['mail'];
		$subject = 'パスワード再発行用URLです';
		$message = '下記のURLより新しく設定するパスワードを入力してください' . "\r\n" . '有効期限:30分以内' . "\r\n" . 'https://procir-study.site/itou406/main/task19/password_reset_form.php?token=' . $pass_reset_token;
		$headers = 'FROM:draddd2000@yahoo.co.jp';
		mb_send_mail($to, $subject, $message, $headers);
	}
	$msg = '再発行用URLを送信しました';
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
