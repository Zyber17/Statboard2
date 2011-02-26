<?php
	function retrieve() {
			require '../../config/db.php';
			$con = mysql_connect($database['server'], $database['username'], $database['password']) or die(mysql_error());
			$db = mysql_select_db($database['database'], $con) or die(mysql_error());
			
			$search = mysql_query("SELECT * FROM `panes`");
			while($row = mysql_fetch_array($search)) {
				$panes[] = array('id' => $row['id'], 'name' => $row['name'], 'author' => $row['author'], 'username' => $row['has_username'], 'password' => $row['has_password'], 'install' => $row['has_install']);
			}
			return $panes;
		}
?>