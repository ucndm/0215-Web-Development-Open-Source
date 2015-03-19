<?php
	//HTTP headers
	header('Content-type: text/html');

	//variables
	$message = new stdClass();
	$message->alert = '';
	$links = array();

	//db connection
	$conn = new mysqli("localhost", "test_user", "test_user_pw", "links");
	if ($conn->connect_error){
		die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
	}

	//inserting new links
	if($_SERVER['REQUEST_METHOD'] == 'POST'){
		if(array_key_exists('url',$_POST) && array_key_exists('title',$_POST)){
			if($_POST['title'] != '' && $_POST['url'] != ''){
				if($conn->query("INSERT INTO link (url, title) VALUES ('".$_POST['url']."', '".$_POST['title']."')")){
					$message->alert = "Link created! $conn->insert_id";
				}
			}else{
				$message->alert = 'You need both title and url';
			}
			
		}
	}

	//collecting links from db
	if($linksReq = $conn->query("SELECT * FROM link")){
		while($link = $linksReq->fetch_object()){
			$links[] = $link;
		}
	}

	//closing db connection
	$conn->close();
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Links</title>
	</head>
	<body>
		<div class="message"><?php echo $message->alert; ?></div>
		<h1>Links</h1>
		<ul>
		<?php
			foreach($links as $link){
				echo "<li><a data-id=\"$link->id\" href=\"$link->url\">$link->title</a></li>";
			}
		?>
		</ul>
		<h2>New link</h2>
		<form name="postlink" method="post">
			<label>URL <input type="url" name="url"/></label>
			<label>Title <input type="text" name="title"/></label>
			<input type="submit"/>
		</form>
	</body>
</html>