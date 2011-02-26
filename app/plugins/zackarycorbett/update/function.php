<?php
	$install = array(
		'name' => 'update',
		'author' => 'zackarycorbett',
		'type' => 0,
		'has_install' => 0,
		'has_username' => 0,
		'has_password' => 0,
		'has_title' => 0
	);
	
	function update_function() {
		$update = file_get_contents('http://statboard.me/version.txt');
		if($update > 01) {
			$return = array(
				'name' => 'Update',
				'kind' => '',
				'data' => '<a href="http://statboard.me/update.zip">Update Available</a>',
				'type' => 0
			);
			return $return;
		}
		else {
			return 'kill';
		}
	}
?>