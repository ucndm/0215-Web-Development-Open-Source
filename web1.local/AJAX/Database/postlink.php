<?php
	//HTTP headers
	header('Content-type: application/json');

	//variables
	$content = new stdClass();
	$content->alert = '';
	$content->action = '';

	//db connection
	$conn = new mysqli("localhost", "test_user", "test_user_pw", "links");
	if ($conn->connect_error){
		$content->alert = 'Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error;
		exit;
	}

	//inserting new or updating links
	if($_SERVER['REQUEST_METHOD'] == 'POST'){
		if(array_key_exists('url',$_POST) && array_key_exists('title',$_POST)){
			if($_POST['title'] != '' && $_POST['url'] != ''){
				//if id exist this is an update
				if(array_key_exists('id',$_POST)){
					if($conn->query("UPDATE link SET url='".$_POST['url']."', title='".$_POST['title']."' WHERE id=".$_POST['id'])){
						$content->alert = 'Link updated!';
						$content->action = 'update';
						
						if($result = $conn->query("SELECT * FROM link WHERE id = ".$_POST['id'])){
							$content->link = $result->fetch_object();
						}
					}
				// else this is a new link
				} else { 
					if($conn->query("INSERT INTO link (url, title) VALUES ('".$_POST['url']."', '".$_POST['title']."')")){
						$content->alert = 'Link created!';
						$content->action = 'create';
						
						if($result = $conn->query("SELECT * FROM link WHERE id = ".$conn->insert_id)){
							$content->link = $result->fetch_object();
						}
					}
				}
			}else{
				$content->alert = 'You need both title and url';
			}
			
		}
	}

	//closing db connection
	$conn->close();

	echo json_encode($content);
?>