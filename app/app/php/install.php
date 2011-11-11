<?php
	if($_POST['author'] && $_POST['function']) {
		$func = $_POST['function'];
		$author = $_POST['author'];
		installnew($func,$author);
	}else if ($_GET['author'] && $_GET['function']) {
		$func = $_GET['function'];
		$author = $_GET['author'];
		installnew($func,$author);
	}else if($_POST['install'] || $_POST['username'] || $_POST['password'] && $_POST['submit']) {
		require_once '../../config/db.php';
		$con = mysql_connect($database['server'], $database['username'], $database['password']) or die(mysql_error());
		$db = mysql_select_db($database['database'], $con) or die(mysql_error());
		
		preg_match('/([a-z]+)\/([a-z]+)/', $_POST['submit'], $stuff);
		$search = mysql_query("SELECT * FROM `panes` WHERE `author` = '".$stuff[1]."'AND `name`= '".$stuff[2]."'");
		$idfinder = mysql_fetch_assoc($search);
		$query = "INSERT INTO `logins` (`id`, `pane_id`, `username`, `password`, `install`) VALUES (NULL, '$idfinder[id]', '$_POST[username]', '$_POST[password]', '$_POST[install]');";
		mysql_query($query);
		echo '<h1>That should have worked</h1>';
	}else if($_POST['submit']){
		echo '<h1>You forgot something</h1>';
	}
	
	function installnew($func,$author) {
		require_once '../../config/db.php';
			$con = mysql_connect($database['server'], $database['username'], $database['password']) or die(mysql_error());
			$db = mysql_select_db($database['database'], $con) or die(mysql_error());
			
			$search = mysql_query("SELECT * FROM `panes` WHERE `author` = '".$author."'AND `name`= '".$func."'");
			require_once '../../plugins/'.$author.'/'.$func.'/function.php';
			if(mysql_num_rows($search) == 0){
				$query = "INSERT INTO `panes` (`id`, `name`, `author`, `type`, `has_install`, `has_username`, `has_password`, `has_title`) VALUES (NULL, '$install[name]', '$install[author]', '$install[type]', '$install[has_install]', '$install[has_username]', '$install[has_password]', '$install[has_title]');";
				mysql_query($query);
				echo '<h1>Houston, we have success.</h1>';	
			}else{
				echo '<h1>New instance created.</h1>';
			}
			if(!$install['has_install'] && !$install['has_username'] && !$install['has_password']) {
				$search2 = mysql_query("SELECT * FROM `panes` WHERE `author` = '".$author."'AND `name`= '".$func."'");
				$idfinder = mysql_fetch_assoc($search2);
				$query2 = "INSERT INTO `logins` (`id`, `pane_id`) VALUES (NULL, '$idfinder[id]');";
				mysql_query($query2);
			}
			if($install['has_install']) {
				$in = '<label for="author">The pane\'s install\'s location.</label><br />
				<input type="text" name="install" value="" />
				<br /><br />';
			}
			if($install['has_username']) {
				$user = '<label for="author">The pane\'s accounts\'s username.</label><br />
				<input type="text" name="username" value="" />
				<br /><br />';
			}
			if($install['has_password']) {
				$pass = '<label for="author">The pane\'s accounts\'s password.</label><br />
				<input type="text" name="password" value="" />
				<br /><br />';
			}
			if($install['has_install'] || $install['has_username'] || $install['has_password']) {
				echo '<form method="post" action="install.php">'.$in.$user.$pass.'<h3>The below button is a submit button, FYI</h3><input type="submit" name="submit" value="'.$install[author].'/'.$install[name].'" />
				</form><h2>PS: Ignore the stuff below</h2>';
			}
	}
	
	function plugins() {
		$directory = "../../plugins";
		$authors = scandir($directory);
		if($authors != null) {
			echo('<ul>');
			foreach ($authors as $value) {
				if (is_dir($directory.'/'.$value) && $value != '.' && $value != '..') {
					$plugins = scandir($directory.'/'.$value);
						foreach ($plugins as $plugin) {
							if (is_dir($directory.'/'.$value.'/'.$plugin) && $plugin != '.' && $plugin != '..') {
								echo('<li><a href="?function='.$plugin.'&author='.$value.'">'.$plugin.' by '.$value.'</a></li>');
							}
						}
				}
			}
			echo('</ul>');
			unset($plugins);
			unset($value);
			unset($plugin);
		}else {
			echo('No plugins here, Go get some!');
		}
	}
?>
<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
	<head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>Install new panes</title>
		
	</head>
	<body>
		<div id="wrapper">
			<form method="post" action="install.php">
			<label for="author">The pane's author's name. No spaces all lowercase</label><br />
			<input type="text" name="author" value="" />
			<br /><br />
			<label for="author">The pane's function's name. No spaces all lowercase</label><br />
			<input type="text" name="function" value="" />
			<br /><br />
			<input type="submit" name="submit" value="Install" />
			</form>
		</div>
		<?php plugins(); ?>
	</body>
</html>