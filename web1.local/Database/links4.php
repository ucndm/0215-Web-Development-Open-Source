<?php
	/*
	/ querystring, id: int
	*/
	//HTTP headers
	header('Content-type: text/html');

	//variables
	$message = new stdClass();
	$message->alert = '';
	$link = new Link();

	try {
		//db connection
		$conn = new PDO('mysql:host=localhost;dbname=links', 'test_user', 'test_user_pw');

		//update a link
		if ($_SERVER['REQUEST_METHOD'] == 'POST' && array_key_exists('id', $_POST)) {
			# update and existing note
			$id = intval($_POST['id']);
			$update = $conn->prepare("UPDATE link SET url=:url, title=:title WHERE id=:id");
			$update->bindParam(":url", $_POST['url'], PDO::PARAM_STR, 265);
			$update->bindParam(":title", $_POST['title'], PDO::PARAM_STR, 256);
			$update->bindParam(":id", $id, PDO::PARAM_INT);
			
			if($update->execute()){
				$message->alert = 'Link updated';
			}
		}

		//get a link
		if(array_key_exists('id', $_GET) && $_GET['id'] != ''){
			$id = intval($_GET['id']);
			$select = $conn->prepare("SELECT * FROM link WHERE id=:id");
			$select->bindParam(":id", $id, PDO::PARAM_INT);

			if($select->execute()){
				$link = $select->fetchObject("Link");
			}
		}

	} catch (PDOException $e) {
		echo 'Connection failed: ' . $e->getMessage();
	}

	class Link
	{
		public $id;
		public $url;
		public $title;
	}
	
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Links</title>
	</head>
	<body>
		<div class="message"><?php echo $message->alert; ?></div>
		<h2>Edit link</h2>
		<form name="postlink" method="post">
			<label>URL <input type="url" name="url" value="<?php echo $link->url; ?>"/></label>
			<label>Title <input type="text" name="title" value="<?php echo $link->title; ?>"/></label>
			<input type="hidden" name="id" value="<?php echo $link->id; ?>"/>
			<input type="submit" value="Update"/>
		</form>
	</body>
</html>