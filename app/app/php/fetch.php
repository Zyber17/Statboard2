<?php
	function start() {
		require 'retrieve.php';
//		require '../../config/db.php';
//		
//		$con = mysql_connect($database['server'], $database['username'], $database['password']) or die(mysql_error());
//		$db = mysql_select_db($database['database'], $con) or die(mysql_error());
		return retrieve();
	}
	if($_POST['start'] == true) finishup();
	function finishup() {
		require '../../config/db.php';
		$con = mysql_connect($database['server'], $database['username'], $database['password']) or die(mysql_error());
		$db = mysql_select_db($database['database'], $con) or die(mysql_error());
		
		$paneloader = mysql_query("SELECT * FROM `panes` WHERE `id` = ".$_POST['pane_id']);
		$panearrays = mysql_fetch_array($paneloader);
		if($panearrays['has_password'] == 1 || $panearrays['has_username'] == 1 || $panearrays['has_install'] == 1) {
			$loginloader = mysql_query("SELECT *  FROM  `logins`  WHERE  `id` =".$_POST['id']." AND  `pane_id` =".$_POST['pane_id']);
			$loginarray = mysql_fetch_array($loginloader);
			
			if($panearrays['has_password'] == 1) {
				$password = $loginarray['password'];
			}
			if($panearrays['has_username'] == 1) {
				$username = $loginarray['username'];
			}
			if($panearrays['has_install'] == 1) {
				$pane_install = $loginarray['install'];
			}
		}
		$pane_function = $panearrays['name'].'_function';
		require '../../plugins/'.$panearrays['author'].'/'.$panearrays['name'].'/function.php';
		$pane_result = $pane_function($username, $password, $pane_install);
		if($pane_result == 'kill') {
			die();
		}
		else {
			echo json_encode($pane_result);
		}
	}
?>