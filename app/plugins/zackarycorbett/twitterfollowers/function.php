<?php
	$install = array(
		'name' => 'twitterfollowers',
		'author' => 'zackarycorbett',
		'type' => 0,
		'has_install' => 0,
		'has_username' => 1,
		'has_password' => 0,
		'has_title' => 1
	);
	
	function twitterfollowers_function($username) {
		$followers = file_get_contents('https://api.twitter.com/1/followers/ids.json?screen_name='.$username);
		$vals = json_decode($followers);
		$return = array(
			'name' => 'Twitter Followers',
			'title' => '@'.$username,
			'kind' => 'followers',
			'type' => 0
		);
		if($vals->error) {
			$return['data'] = 'User '.$vals->error;
			return $return;
		}else{
			$return['data'] = count($vals);
			return $return;
		}
	}
?>