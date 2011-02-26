<?php
function format_result($result) {
	if($result['type'] == 0) {pane($result);} else if($result['type'] == 1) { ticker($result); } else { die(); }
}

function pane($result) {
		if($result['title']) {$title = ': '.$result['title'];}
	$html = "<div class='pane $result[name]'>
		<h2>$result[name]$title</h2>
		<h3>
			$result[data]<span class='whats'>$result[kind]</span>
		</h3>
	</div>";
	echo $html;
}

function ticker($result) {
		if($result['title']) {$title = ': '.$result['title'];}
	$html = "<div class='ticker $result[name]'>
		<h2>$result[name]$title</h2>
		<ul>"; echo $html;
			foreach($result['data'] as $data) {
				if($data['img']) {
				$img = "<img src='$data[img]' alt='$data[username] img' />";
				echo "<li>$img $data[data]</li>";
				}
			}
	$html2 = "</ul>
	</div>"; echo $html2;
}

?>