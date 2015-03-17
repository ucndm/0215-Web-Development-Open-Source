<?php
class UserPage extends Page{
	var $user;
	function __construct($user){
		$this->user = $user;
		$obj = $user;
		$file = file_get_contents($GLOBALS['lib']['view'].'UserPage.html');
		ob_start();
			eval('?>'.$file.'<?php ');
			$this->content = ob_get_contents();
		ob_end_clean();
	}
}
?>