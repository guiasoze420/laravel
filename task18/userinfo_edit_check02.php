<?php
session_start();
if (isset($_POST['upload']) && isset($_FILES['image']) && isset($_SESSION['id']) && isset($_POST['user_id']) && $_SESSION['id'] == $_POST['user_id']) {
	$dsn = 'mysql:host=localhost;dbname=procir_itou406;charset=utf8';
	$user = 'itou406';
	$password = 'd8fxmiuu9l';
	try {
		$dbh = new PDO($dsn, $user, $password);
	} catch (PDOException $e) {
		echo 'データベースに接続できませんでした' . $e->getMessage();
		exit();
	}
	if (!empty($_POST['comment'])) {
		$comment = $_POST['comment'];
	} else {
		$comment = $_POST['comment'];
	}
	if (empty($_FILES['image']['name'])) {
		$sql = 'SELECT image FROM users WHERE id = :id';
		$stmt = $dbh->prepare($sql);
		$params = array(
			':id' => $_SESSION['id'],
		);
		$stmt->execute($params);
		$existing_image = $stmt->fetch(PDO::FETCH_ASSOC);
		$existing_image = $existing_image['image'];
	} else {
		$sql = 'SELECT image FROM users WHERE id = :id';
		$stmt = $dbh->prepare($sql);
		$params = array(
			':id' => $_SESSION['id'],
		);
		$stmt->execute($params);
		$delete_image = $stmt->fetch(PDO::FETCH_ASSOC);
		$delete_image = $delete_image['image'];
		if (!empty($delete_image)) {
			unlink('./images/' . $delete_image);
		}
		$upload_image = date('Ymdhis');
		$upload_image .= uniqid(mt_rand(), true);
		$tempfile = $_FILES['image']['tmp_name'];
		switch (@exif_imagetype($tempfile)) {
			case 1:
				$upload_image .= '.gif';
				break;
			case 2:
				$upload_image .= '.jpg';
				break;
			case 3:
				$upload_image .= '.png';
				break;
			default:
				header('Location:userinfo_edit.php');
				exit();
		}
	}
	$id = $_SESSION['id'];
	$sql = 'UPDATE users SET image = :image comment = :comment WHERE id = :id';
	$stmt = $dbh->prepare($sql);
	if (empty($_FILES['image']['name'])) {
	/*	$params = array(
			':image' => $existing_image,
			':id' => $_SESSION['id'],
		); */
		$stmt->bindValue(':image', $existing_image, PDO::PARAM_STR);
		$stmt->bindValue(':comment', $comment, PDO::PARAM_STR);
		$stmt->bindValue(':id', $id, PDO::PARAM_INT);
		$stmt->execute();
		$msg = '現状維持<br><a href="post_list.php">投稿一覧へ</a>';
	} else {
	/*	$params = array(
			':image' => $upload_image,
			':id' => $_SESSION['id'],
		); */
		$stmt->bindValue(':image', $upload_image, PDO::PARAM_STR);
		$stmt->bindValue(':comment', $comment, PDO::PARAM_STR);
		$stmt->bindValue(':id', $id, PDO::PARAM_INT);

		$filemove = './images/' . $upload_image;
		$stmt->execute();
		if (move_uploaded_file($tempfile, $filemove)) {
			$msg = 'アップロード完了<br><a href="post_list.php">投稿一覧へ</a>';
		} else {
			$msg = 'アップロード完了<br><a href="post_list.php">投稿一覧へ</a>';
		}
	}
} else {
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
</body>
</html>
