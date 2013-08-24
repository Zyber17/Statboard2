<?php
	function install_db() {
		require 'db.php';
		$con = mysql_connect($database['server'], $database['username'], $database['password']) or die(mysql_error());
		$db = mysql_select_db($database['database'], $con) or die(mysql_error());
		
		$pane = "CREATE TABLE IF NOT EXISTS `panes` (
		`id` int(11) NOT NULL auto_increment,
		`name` varchar(128) NOT NULL,
		`author` varchar(128) NOT NULL,
		`type` int(1) NOT NULL,
		`has_install` int(1) NOT NULL,
		`has_username` int(1) NOT NULL,
		`has_password` int(1) NOT NULL,
		`has_title` int(1) NOT NULL,
		PRIMARY KEY (`id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";
		
		$logins = "CREATE TABLE IF NOT EXISTS `logins` (
		`id` int(11) NOT NULL auto_increment,
		`pane_id` int(11) NOT NULL,
		`username` varchar(128),
		`password` varchar(128),
		`install` varchar(128),
		PRIMARY KEY (`id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";
		
		mysql_query($pane);
		mysql_query($logins);
		mysql_close();
	}
	
?>