<?php
	$install = array(
		'name' => 'feedburner',
		'author' => 'zackarycorbett',
		'type' => 0,
		'has_install' => 0,
		'has_username' => 1,
		'has_password' => 0,
		'has_title' => 0
	);
	function feedburner_function($feed_uri) {
		$feed = file_get_contents('https://feedburner.google.com/api/awareness/1.0/GetFeedData?uri=http://feeds.feedburner.com/'.$feed_uri);
		$parse = xml_parser_create();
		$parsestruct = xml_parse_into_struct($parse, $feed, $vals, $index);
		xml_parser_free($parse);
		$return = array(
			'name' => 'Feedburner',
			'kind' => 'subscribers',
			'type' => 0
		);
		if($vals[2]['attributes']['CIRCULATION']) {
			$return['data'] = $vals[2]['attributes']['CIRCULATION'];
			return $return;
		}else if($vals[1]['attributes']['MSG']){
			$return['data'] = $vals[1]['attributes']['MSG'];
			$return['kind'] = '';
			return $return;
		}else if($vals[2]['value']){
			$return['data'] = 'Awareness API is Off';
			$return['kind'] = '';
			return $return;
		}else {
			$return['data'] = 'Error';
			$return['kind'] = '';
			return $return;
		}
	}