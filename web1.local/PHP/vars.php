<?php
header('Content-type: text/html');
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
	</head>  
	<body>
		<h1><?php echo $_POST['fName']; ?></h1>
		<pre>
			<?php
				var_dump($_GET);
				var_dump($_POST);
				var_dump($_SERVER);
			?>
		</pre>
		<p>Create new user</p>
		<form name="test" method="get">
			First name:<input type="text" name="fName"/>
			Last name: <input type="text" name="lName"/>
			<input type="submit" value="Create"/>
		</form>
	</body>
</html>