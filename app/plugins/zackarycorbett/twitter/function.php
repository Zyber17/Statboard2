<?php
	$install = array(
		'name' => 'twitter',
		'author' => 'zackarycorbett',
		'type' => 0,
		'has_install' => 0,
		'has_username' => 1,
		'has_password' => 0,
		'has_title' => 1
	);
	
	function twitter_function($username) {
		$followers = file_get_contents('https://api.twitter.com/1/users/show.json?screen_name='.$username);
		$vals = json_decode($followers);
		$return = array(
			'name' => 'Twitter',
			'title' => '@'.$username,
			'type' => 0
		);
		if($vals->error) {
			$return['data'] = 'User '.$vals->error;
			$return['kind'] = '';
		}else{
			$timeon = offset($vals->created_at);
			$return['data'] = array(
				array('data' => $vals->followers_count, 'kind' => 'followers'),
				array('data' => $vals->friends_count, 'kind' => 'following'),
				array('data' => $vals->statuses_count, 'kind' => 'tweets'),
				array('data' => $vals->favourites_count, 'kind' => 'favorites'),
				array('data' => $vals->listed_count, 'kind' => 'listed'),
				array('data' => $timeon, 'kind' => 'days old')
			);
		}
		return $return;
	}
	function offset($time) {
		$format = 'D M d H:i:s O Y';
			$date = DateTime::createFromFormat($format, $time);
				$start = date('Y-m-d H:i:s', $date->format('Y-m-d H:i:s')); 
			    $end = date('Y-m-d H:i:s'); 
			    $d_start = new DateTime($start); 
			    $d_end = new DateTime($end);
			    $diff = $d_start->diff($d_end);
			    $difference = $diff->format('%a');
		return $difference;
	}
?>