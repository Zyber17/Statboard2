<?php
	$install = array(
		'name' => 'ember',
		'author' => 'zackarycorbett',
		'type' => 0,
		'has_install' => 0,
		'has_username' => 1,
		'has_password' => 0,
		'has_title' => 0
	);
	
	function ember_function($username) {
		$followers = file_get_contents('https://api.twitter.com/1/followers/ids.json?screen_name='.$username);
		$vals = json_decode($followers);
		$return = array(
			'name' => 'Ember',
			'kind' => 'followers',
			'type' => 0
		);
		$followers = file_get_contents('https://api.emberapp.com/users/view/'.$username.'.json');
				$vals = json_decode($followers);
				if($vals->response->status->string == 'FAIL') {
					$return['data'] = 'Incorrect login';
					return $return;
				}else{
					$return['data'] = $vals->response->user->total_followers;
					return $return;
				}
		if($vals->error) {
			$return['data'] = 'User '.$vals->error;
			return $return;
		}else{
			$return['data'] = count($vals);
			return $return;
		}
	}
?>