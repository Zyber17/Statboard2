<?php
	$install = array(
		'name' => 'mint',
		'author' => 'zackarycorbett',
		'type' => 0,
		'has_install' => 1,
		'has_username' => 1,
		'has_password' => 1,
		'has_title' => 1
	);
	
	function mint_function($user, $pass, $install) {
		$url = 'http://'.$install.'/pepper/garrettmurray/ego_helper/stats.php?email='.$user.'&password='.$pass;
		$mint = file_get_contents($url);
		$parse = xml_parser_create();
		$parsestruct = xml_parse_into_struct($parse, $mint, $vals, $index);
		xml_parser_free($parse);
		//[2] = total mint hits since it was installed, ['attributes'] = sthe stuff inside a tag (<tag attrbute1="blah">, ['HITS'] = all (['UNIQUE'] will give unique hits)
		$title = url($url);
		$return = array(
			'name' => 'Mint',
			'title' => $title,
			'type' => 0
		);
		if($vals[6]['attributes']['HITS']){
			$return['data'] = array(array('data' => $vals[6]['attributes']['HITS'], 'kind' => 'hits today'),
			array('data' => $vals[6]['attributes']['UNIQUE'], 'kind' => 'unique hits today'),
			array('data' => $vals[2]['attributes']['HITS'], 'kind' => 'hits total'),
			array('data' => $vals[2]['attributes']['UNIQUE'], 'kind' => 'unique hits total'));
		}
		else {
			$return['data'] = 'Incorrect Login';
			$return['kind'] = '';
		}
		return $return;
	}
	function url($url) {
		$arr =  parse_url($url);
		preg_match('/([a-z]*\.)?([\d\w-]+)\.[a-z]+/', strtolower($arr['host']),$answer);
		return ucfirst($answer[2]);
	}
?>