<?php
$test_arr = array('str1','str2');
$test_arr[] = 'str3';

?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
	</head>  
	<body>
		<ul>
			<?php
				foreach($test_arr as $str){
					echo '<li>'.$str.'</li>';
				}
			?>
		</ul>
	</body>
</html>