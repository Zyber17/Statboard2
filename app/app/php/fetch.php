<?php
	function start() {
		require 'retrieve.php';
		require 'format.php';
		require '../../config/db.php';
		
		$con = mysql_connect($database['server'], $database['username'], $database['password']) or die(mysql_error());
		$db = mysql_select_db($database['database'], $con) or die(mysql_error());
		return retrieve();
	}
	if($_POST['start'] == true) finishup();
	function finishup() {
			require '../../config/db.php';
			$con = mysql_connect($database['server'], $database['username'], $database['password']) or die(mysql_error());
			$db = mysql_select_db($database['database'], $con) or die(mysql_error());
			
			if($_POST['has_password'] == 1) {
				$pass = mysql_query("SELECT * FROM `logins` WHERE `pane_id` = ".$_POST['id']);
				$assoc = mysql_fetch_assoc($pass);
				$password = $assoc['password'];
			}
			if($_POST['has_username'] == 1) {
				$user = mysql_query("SELECT * FROM `logins` WHERE `pane_id` = ".$_POST['id']);
				$assoc = mysql_fetch_assoc($user);
				$username = $assoc['username'];
			}
			if($_POST['has_install'] == 1) {
				$install = mysql_query("SELECT * FROM `logins` WHERE `pane_id` = ".$_POST['id'] );
				$assoc = mysql_fetch_assoc($install);
				$pane_install = $assoc['install'];
			}
			
			$pane_function = $_POST['name'].'_function';
			require '../../plugins/'.$_POST['author'].'/'.$_POST['name'].'/function.php';
			$pane_result = $pane_function($username, $password, $pane_install);
			if($pane_result == 'kill') {
				die();
			}
			else {
				require 'format.php';
				format_result($pane_result);
			}
	}
?>