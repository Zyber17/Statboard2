<?php
		$install = array(
			'name' => 'weather',
			'author' => 'zackarycorbett',
			'type' => 0,
			'has_install' => 0,
			'has_username' => 1,
			'has_password' => 1,
			'has_title' => 0
		);
		
		function weather_function($zip, $unit = 'f') {
			$weather = file_get_contents('http://xml.weather.yahoo.com/forecastrss?p='.$zip.'&u='.$unit);
			$parse = xml_parser_create();
			$parsestruct = xml_parse_into_struct($parse, $weather, $vals, $index);
			xml_parser_free($parse);
			if($unit == 'f') {$whats = 'fahrenheit'; }else{$whats = 'celsius';}
			$return = array(
				'name' => 'Weather',
				'kind' => $whats,
				'type' => 0,
				'data' => $vals[48]['attributes']['TEMP']
			);
			return $return;
			}
?>