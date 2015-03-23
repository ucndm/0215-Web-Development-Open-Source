<?php
	//HTTP headers
	header('Content-type: application/json');

	//variables
	$content = new stdClass();
	$content->alert = '';
	$content->action = '';

	try {
		//db connection
		$conn = new PDO('mysql:host=localhost;dbname=links', 'test_user', 'test_user_pw');

		//inserting new or updating links
		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			if(array_key_exists('url',$_POST) && array_key_exists('title',$_POST)){
				if($_POST['title'] != '' && $_POST['url'] != ''){
					//if id exist this is an update
					if(array_key_exists('id',$_POST)){
						$update = $conn->prepare("UPDATE link SET url=:url, title=:title WHERE id=:id");
						$update->bindParam(":url", $_POST['url'], PDO::PARAM_STR, 265);
						$update->bindParam(":title", $_POST['title'], PDO::PARAM_STR, 256);
						$update->bindParam(":id", $_POST['id'], PDO::PARAM_INT);
						
						if($update->execute()){
							$content->alert = 'Link updated!';
							$content->action = 'update';

							$select = $conn->prepare("SELECT * FROM link WHERE id=:id");
							$select->bindParam(":id", $_POST['id'], PDO::PARAM_INT);

							if($select->execute()){
								$content->link = $select->fetch(PDO::FETCH_OBJ);
							}
						}
					// else this is a new link
					} else { 
						$insert = $conn->prepare("INSERT INTO link (url, title) VALUES(:url, :title)");
						$insert->bindParam(":url", $_POST['url'], PDO::PARAM_STR, 265);
						$insert->bindParam(":title", $_POST['title'], PDO::PARAM_STR, 256);

						if($insert->execute()){
							$content->alert = 'Link created!';
							$content->action = 'create';

							$select = $conn->prepare("SELECT * FROM link WHERE id=:id");
							$select->bindParam(":id", $conn->lastInsertId(), PDO::PARAM_INT);

							if($select->execute()){
								$content->link = $select->fetch(PDO::FETCH_OBJ);
							}
						}
					}
				}else{
					$content->alert = 'You need both title and url';
				}
				
			}
		}
	} catch (PDOException $e) {
		echo 'Connection failed: ' . $e->getMessage();
	}

	echo json_encode($content);
?>