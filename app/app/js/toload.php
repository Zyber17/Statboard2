<?php
	header("Content-type: text/javascript");
	
	require '../php/fetch.php';
	
	$array = start();
	echo "
	$(document).ready(function() {
		load();
	});
	function init() {
		var panes = ".json_encode($array).";
			for(pane in panes) {
				$.post('app/app/php/fetch.php', {
					start:true,
					id:panes[pane].id,
					author:panes[pane].author,
					name:panes[pane].name,
					has_install:panes[pane].install,
					has_username:panes[pane].username,
					has_password:panes[pane].password
				},
				function(response) {
					$('#data').append(response);
				});
				}
	}
	function load() {
		$('#data').empty();
		init();
		setTimeout('load()', 900000);
	}"
?>