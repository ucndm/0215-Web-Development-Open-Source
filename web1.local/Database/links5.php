<?php
	/*
	/ querystring, id: int
	*/
	//HTTP headers
	header('Content-type: text/html');

	//variables
	$message = new stdClass();
	$message->alert = '';
	$links = array();

	try {
		//db connection
		$conn = new PDO('mysql:host=localhost;dbname=links', 'test_user', 'test_user_pw');

		//delete links
		if ($_SERVER['REQUEST_METHOD'] == 'POST' && array_key_exists('links', $_POST)) {
			foreach ($_POST['links'] as $id) {
				$id = intval($id);
				$delete = $conn->prepare("DELETE FROM link WHERE id=:id");
				$delete->bindParam(":id", $id, PDO::PARAM_INT);

				if($delete->execute()){
					$message->alert .= "deleted $id, ";
				}
			}
		}

		//collecting links from db
		$select = $conn->prepare("SELECT * FROM link");
		$select->execute();
		$links = $select->fetchAll(PDO::FETCH_CLASS, "Link");


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
		<h2>Delete links</h2>
		<form name="deletelinks" method="post">
			<?php foreach ($links as $link) {
				echo "<label><input type=\"checkbox\" name=\"links[]\" value=\"$link->id\"/> $link->title ($link->url)</label><br/>";
			}?>
			<input type="submit" value="Delete"/>
		</form>
		<pre><?php var_dump($_POST); ?></pre>
	</body>
</html>