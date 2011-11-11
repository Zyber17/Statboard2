<?php
	if ($_POST['server'] != null && $_POST['database'] != null && $_POST['username'] != null && $_POST['password'] != null) {
		require 'app/config/install.php';
		$file = '<?php
$database = array(
	"server" => "'.$_POST["server"].'",
	"username" => "'.$_POST["username"].'",
	"password" => "'.$_POST["password"].'",
	"database" => "'.$_POST["database"].'"
);
?>';
		file_put_contents('app/config/db.php', $file);
		install_db();
		rename('index_saftey.html', 'index.html');
		header('Location: index.html');
	}else if ($_POST['submit']) {
		if($_POST['server'] == null || $_POST['database'] == null || $_POST['username'] == null || $_POST['password'] == null) {
			echo('Oops, looks like you forgot something.');
		}
	}else {
		include 'app/config/db.php';
	}
?>

<!DOCTYPE html>

<html lang="en">
	<head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>Install Statboard</title>
		
	</head>
	<body>
		<div id="wrapper">
			<form method="post" action="install.php">
			<label for="server">Server:</label><br />
			<input type="text" name="server" placeholder="localhost" value="<?php echo($database['server']) ?>" />
			<br /><br />
			<label for="database">Database:</label><br />
			<input type="text" name="database" value="<?php echo($database['database']) ?>" />
			<br /><br />
			<label for="username">Database Userame:</label><br />
			<input type="text" name="username" value="<?php echo($database['username']) ?>" />
			<br /><br />
			<label for="password">Database Password:</label><br />
			<input type="text" name="password" value="<?php echo($database['password']) ?>" />
			<br /><br />
			<input type="submit" name="submit" value="Install" />
			</form>
		</div>
	</body>
</html>