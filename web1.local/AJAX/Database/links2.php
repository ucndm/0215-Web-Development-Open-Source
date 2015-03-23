<?php
	//HTTP headers
	header('Content-type: text/html');

	//variables
	//$message = '';
	$message = new stdClass();
	$message->alert = '';
	$links = array();
	
	//db connection
	$conn = new mysqli("localhost", "test_user", "test_user_pw", "links");
	if ($conn->connect_error){
		die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
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
		<style type="text/css">
			button.editBtn {
				border: medium none;
				cursor: pointer;
				display: inline;
				font-size: x-small;
				margin: 0 5px;
			}
		</style>
		<script type="text/javascript">
			var links;

			var postnewhandler = function(e) {
				var xhr = e.target;
				if(xhr.readyState == 4 && xhr.status == 200){
					var xhrObj = JSON.parse(xhr.response);
					if (xhrObj.link) {
						var link = xhrObj.link;
						if(xhrObj.action == 'create'){
							var li = document.createElement('li');
							var a = document.createElement('a');
							a.setAttribute('href', link.url);
							a.setAttribute('data-id', link.id);
							a.innerHTML = link.title;
							var btn = document.createElement('button');
							btn.className = 'editBtn';
							btn.innerHTML = 'Edit';
							li.appendChild(a);
							li.appendChild(btn);
							links.appendChild(li);
						} else if(xhrObj.action == 'update'){
							for (var i = 0; i < links.children.length; i++) {
								var a = links.children[i].firstChild;
								if(a.getAttribute('data-id') == link.id){
									a.setAttribute('href', link.url);
									a.innerHTML = link.title;
									break;
								}
							}
						}
						document.forms.postlink.reset();
					}
				}
			};

			var submitpostlink = function(e){
				e.preventDefault();
				var form = e.target;
				if(form.url.value && form.title.value){
					var postContent = 'url='+form.url.value+'&title='+form.title.value;
					if(form.id.value){
						postContent += '&id='+form.id.value;
					}
					var request = new XMLHttpRequest();
					request.addEventListener('readystatechange', postnewhandler, false);
					request.open('POST', 'postlink.php');
					request.setRequestHeader("Content-type","application/x-www-form-urlencoded");
					request.send(postContent);
				}
			};

			var linkslistclick = function(e){
				console.debug(e);
				switch(e.target.className){
					case 'editBtn':
						var link = e.target.parentElement.firstChild;
						document.forms.postlink.id.value = link.getAttribute('data-id');
						document.forms.postlink.url.value = link.href;
						document.forms.postlink.title.value = link.text;
						break;
				}
			};

			var resetpostlink = function(e){
				//the reset button does not remove the value from hidden input elements
				//this is a hack
				e.target.id.value = '';
			};

			window.addEventListener('load', function(){
				links = document.getElementById('links');
				//editBtns = document.getElementsByClassName('editBtn');
				links.addEventListener('click', linkslistclick, false);
				document.forms.postlink.addEventListener('submit', submitpostlink, false);
				document.forms.postlink.addEventListener('reset', resetpostlink, false);
			}, false);

		</script>
	</head>
	<body>
		<div class="message"><?php echo $message->alert; ?></div>
		<h1>Links</h1>
		<ul id="links">
		<?php
			foreach($links as $link){
				echo "<li><a data-id=\"$link->id\" href=\"$link->url\">$link->title</a><button class=\"editBtn\">Edit</button></li>";
			}
		?>
		</ul>
		<h2>New link</h2>
		<form name="postlink" method="post">
			<input type="hidden" name="id" value=""/>
			<label>URL <input type="url" name="url"/></label>
			<label>Title <input type="text" name="title"/></label>
			<input type="submit"/>
			<input type="reset"/>
		</form>
	</body>
</html>