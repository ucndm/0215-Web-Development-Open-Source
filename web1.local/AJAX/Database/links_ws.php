<?php
	header('Content-type: application/json; charset=UTF-8');
	#get the content of a request (used in case of POST and PUT)
	$input = file_get_contents("php://input");

	#variables
	$link = json_decode($input);
	$obj = new stdClass();
	$obj->action = 'error';

	#db connection
	$conn = new PDO('mysql:host=localhost;dbname=links;charset=utf8', 'test_user', 'test_user_pw');

	/*
		Request methods: GET, POST, PUT and DELETE
		querystring: id, id of a link
		request content: in case of POST and PUT id (only PUT), url and title are needed

		if GET and id -> get a single link
		elseif GET -> get all links
		elseif POST -> create a new link
		elseif PUT and id -> update a link
		elseif DELETE and id -> delete a link
	*/
	if($_SERVER['REQUEST_METHOD'] == 'GET' && array_key_exists('id', $_GET)){
		# requesting a single link by id
		$select = $conn->prepare("SELECT * FROM link WHERE id=:id");
		$select->bindParam(":id", $_GET['id'], PDO::PARAM_INT);

		if($select->execute()){
			$obj->link = $select->fetchObject("Link");
			$obj->action = 'get';
		}

	} elseif ($_SERVER['REQUEST_METHOD'] == 'GET') {
		# requesting all links
		$select = $conn->prepare("SELECT * FROM link");
		
		if($select->execute()){
			$obj->links = $select->fetchAll(PDO::FETCH_CLASS, "Link");
			$obj->action = 'get';
		}

	} elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
		# create a new link
		$insert = $conn->prepare("INSERT INTO link (url, title) VALUES (:url, :title)");
		$insert->bindParam(":url", $link->url, PDO::PARAM_STR, 265);
		$insert->bindParam(":title", $link->title, PDO::PARAM_STR, 265);

		if($insert->execute()){
			$obj->alert = "link created!";
		}
		$select = $conn->prepare("SELECT * FROM link WHERE id=:id");
		$select->bindParam(":id", $conn->lastInsertId(), PDO::PARAM_INT);

		if($select->execute()){
			$obj->link = $select->fetchObject("Link");
			$obj->action = 'post';
		}

	} elseif ($_SERVER['REQUEST_METHOD'] == 'PUT' && array_key_exists('id', $_GET)) {
		# update an existing link
		$id = intval($_GET['id']);
		$update = $conn->prepare("UPDATE link SET url=:url, title=:title WHERE id=:id");
		$update->bindParam(":url", $link->url, PDO::PARAM_STR, 256);
		$update->bindParam(":title", $link->title, PDO::PARAM_STR, 256);
		$update->bindParam(":id", $id, PDO::PARAM_INT);
		
		if($update->execute()){
			$select = $conn->prepare("SELECT * FROM link WHERE id=:id");
			$select->bindParam(":id", $id, PDO::PARAM_INT);

			if($select->execute()){
				$obj->link = $select->fetchObject("Link");
			}
			$obj->action = 'put';
		}

	} elseif ($_SERVER['REQUEST_METHOD'] == 'DELETE' && array_key_exists('id', $_GET)) {
		#deleting a link
		$id = intval($_GET['id']);
		$delete = $conn->prepare("DELETE FROM link WHERE id=:id");
		$delete->bindParam(":id", $id, PDO::PARAM_INT);

		if($delete->execute()){
			$obj->id = $id;
			$obj->action = 'delete';
		}
	}

	#print out the JSON string
	echo json_encode($obj);

	#class definiton
	class Link
	{
		public $id;
		public $url;
		public $title;
	}
?>