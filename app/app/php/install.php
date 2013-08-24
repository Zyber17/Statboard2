<?php
	function checkinstall() {
		if($_POST['author'] && $_POST['function']) {
			$func = $_POST['function'];
			$author = $_POST['author'];
			$secure = $_POST['security'];
			installnew($func,$author,$secure);
		}else if ($_GET['author'] && $_GET['function']) {
			$func = $_GET['function'];
			$author = $_GET['author'];
			$secure = $_GET['security'];
			installnew($func,$author,$secure);
		}else if($_POST['install'] || $_POST['username'] || $_POST['password'] && $_POST['submit'] && $_POST['name'] && $_POST['author']) {
			require_once '../../config/db.php';
			$con = mysql_connect($database['server'], $database['username'], $database['password']) or die(mysql_error());
			$db = mysql_select_db($database['database'], $con) or die(mysql_error());
			
			$search = mysql_query("SELECT * FROM `panes` WHERE `author` = '".$_POST['author']."'AND `name`= '".$_POST['name']."'");
			$idfinder = mysql_fetch_assoc($search);
			$query = "INSERT INTO `logins` (`id`, `pane_id`, `username`, `password`, `install`) VALUES (NULL, '$idfinder[id]', '$_POST[username]', '$_POST[password]', '$_POST[install]');";
			mysql_query($query);
			echo '<h2>New instance is a go.</h2>';
			$string = "<a href='install.php' class='linkbutton'>Install another?</a><a href='../../../' class='linkbutton'>Go Home?</a>";
			echo($string);
		}else if($_POST['submit']){
			echo '<h2>You forgot something.</h2>';
		}
	}
	
	function installnew($func,$author,$secure) {
		if (secure($func,$author) == $secure) {
			require_once '../../config/db.php';
				$con = mysql_connect($database['server'], $database['username'], $database['password']) or die(mysql_error());
				$db = mysql_select_db($database['database'], $con) or die(mysql_error());
				
				$search = mysql_query("SELECT * FROM `panes` WHERE `author` = '".$author."'AND `name`= '".$func."'");
				require_once '../../plugins/'.$author.'/'.$func.'/function.php';
				if(mysql_num_rows($search) == 0){
					$query = "INSERT INTO `panes` (`id`, `name`, `author`, `type`, `has_install`, `has_username`, `has_password`, `has_title`) VALUES (NULL, '$install[name]', '$install[author]', '$install[type]', '$install[has_install]', '$install[has_username]', '$install[has_password]', '$install[has_title]');";
					mysql_query($query);
					echo '<h2>Houston, we have success.</h2>';
				}else{
					echo '<h2>New instance created.</h2>';
				}
				if(!$install['has_install'] && !$install['has_username'] && !$install['has_password']) {
					$search2 = mysql_query("SELECT * FROM `panes` WHERE `author` = '".$author."'AND `name`= '".$func."'");
					$idfinder = mysql_fetch_assoc($search2);
					$query2 = "INSERT INTO `logins` (`id`, `pane_id`) VALUES (NULL, '$idfinder[id]');";
					mysql_query($query2);
					$string = "<a href='install.php' class='linkbutton'>Install another?</a><a href='../../../' class='linkbutton'>Go Home?</a>";
					echo($string);
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
					echo '<form method="post" action="install.php">'.$in.$user.$pass.'<input type="hidden" name="author" value="'.$install['author'].'" /><input type="hidden" name="name" value="'.$install['name'].'" /><input type="hidden" name="step2" value="true" /><input type="submit" name="submit" value="Submit" />
					</form>';
				}
			}
	}
	
	function plugins() {
		$directory = "../../plugins";
		$authors = scandir($directory);
		if($authors != null) {
			echo('<h2>Available Plugins</h2>');
			echo('<ul>');
			foreach ($authors as $value) {
				if (is_dir($directory.'/'.$value) && $value != '.' && $value != '..') {
					$plugins = scandir($directory.'/'.$value);
						foreach ($plugins as $plugin) {
							if (is_dir($directory.'/'.$value.'/'.$plugin) && $plugin != '.' && $plugin != '..') {
								$secure = secure($plugin,$value);
								echo('<li><a href="?function='.$plugin.'&author='.$value.'&security='.$secure.'">'.$plugin.' by '.$value.'</a></li>');
								unset($secure);
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
	
	function secure($plugin,$author) {
		require '../../config/hash.php';
		$secure = md5($plguin.':'.$author);
		$secured = md5($secure.$hash);
		return $secured;
	}
	
	function echostuff() {
		echo($message);
		echo($forms);
	}
?>
<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
	<head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<link rel="stylesheet" type="text/css" href="../../styles/default/reset.css" />
		<link rel="stylesheet" type="text/css" href="../../styles/default/otherui.css" />
		<link rel="stylesheet" type="text/css" href="../../styles/default/dark.css" />
		<title>Install new panes</title>
		
	</head>
	<body>
		<div id="wrapper" class="plugins">
			<h1><a href="../../../" class="statboard">Statboard</a></h1>
			<?php ($_POST['author'] || $_GET['author'] || $_POST['step2']) ? checkinstall() : plugins();?>
		</div>
	</body>
</html>