<?php
/* pseudo DB connection */
class UserDB{
	public static function GetUser($params){
		$id = $params[0];
		
		switch($id){
			case 1;
				$user = new User(1, 'John', 34);
				break;
			case 2;
				$user = new User(2, 'Jill', 28);
				break;
			default:
				$user = null;
				break;
		}
		return $user;
	}
}
?>