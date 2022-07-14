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
				echo '画像ファイルではありません<br><a href="post_list.php">投稿一覧へ</a>';
				exit();
		}
		$sql = 'SELECT image, comment FROM users WHERE id = :id';
		$stmt = $dbh->prepare($sql);
		$params = array(
			':id' => $_SESSION['id'],
		);
		$stmt->execute($params);
		$user = $stmt->fetch(PDO::FETCH_ASSOC);
		$delete_image = $user['image'];
		if (!empty($delete_image)) {
			unlink('./images/' . $delete_image);
		}
		$existing_comment = $user['comment'];
	}
	$sql = 'UPDATE users SET image = :image, comment = :comment WHERE id = :id';
	$stmt = $dbh->prepare($sql);
	if (empty($_FILES['image']['name'])) {
		if (empty($_POST['comment'])) {
			$_POST['comment'] = null;
		}
		$params = array(
			':image' => $existing_image,
			':comment' => $_POST['comment'],
			':id' => $_SESSION['id'],
		);
		$stmt->execute($params);
		$msg = '一言コメントのみ更新<br><a href="post_list.php">投稿一覧へ</a>';
	} elseif (!empty($_FILES['image']['name']) && $existing_comment == $_POST['comment']) {
		$params = array(
			':image' => $upload_image,
			':comment' => $_POST['comment'],
			':id' => $_SESSION['id'],
		);
		$filemove = './images/' . $upload_image;
		if (move_uploaded_file($tempfile, $filemove)) {
			$stmt->execute($params);
			$msg = '画像のみ更新<br><a href="post_list.php">投稿一覧へ</a>';
		} else {
			$msg = '更新失敗<br><a href="post_list.php">投稿一覧へ</a>';
		}
	} else {
		$params = array(
			':image' => $upload_image,
			':comment' => $_POST['comment'],
			':id' => $_SESSION['id'],
		);
		$filemove = './images/' . $upload_image;
		if (move_uploaded_file($tempfile, $filemove)) {
			$stmt->execute($params);
			$msg = '両方更新<br><a href="post_list.php">投稿一覧へ</a>';
		} else {
			$msg = '更新失敗<br><a href="post_list.php">投稿一覧へ</a>';
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
