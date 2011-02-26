<?php
		$install = array(
			'name' => 'currentdate',
			'author' => 'zackarycorbett',
			'type' => 0,
			'has_install' => 0,
			'has_username' => 0,
			'has_password' => 0,
			'has_title' => 0
		);
		
		function currentdate_function() {
			return array(
				'name' => 'Current Date',
				'type' => 0,
				'data' => date('n-j')
			);
		}
?>