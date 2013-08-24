<?php
	$install = array(
		'name' => 'pinboard',
		'author' => 'zackarycorbett',
		'type' => 0,
		'has_install' => 0,
		'has_username' => 1,
		'has_password' => 1,
		'has_title' => 0
	);
	function pinboard_function($username, $password) {
		$bookmarks = file_get_contents('https://feedburner.google.com/api/awareness/1.0/GetFeedData?uri=http://feeds.feedburner.com/'.$feed_uri);
		$vals = json_decode($bookmarks);
		$return = array(
			'name' => 'Pinboard',
			'kind' => 'bookmarks',
			'type' => 0
		);
		$count = count($vals);
		if ($count) {
			$return->data = $count;
		}
	}