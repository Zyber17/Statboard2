<?php
function format_result($result) {
	if($result['type'] == 0) {pane($result);} /*else if($result['type'] == 1) { ticker($result); }*/ else { die(); }
}
function rename_name($name) {
	return str_replace(' ', '', $name);
}
function pane($result) {
	if($result['title']) {$title = ': '.$result['title'];}
	$name = rename_name($result[name]);
		echo "<div class='pane $name'>
			<h2>$result[name]$title</h2>";
			if (is_array($result['data'])) {
				$num = rand(0, 9999);
				foreach($result['data'] as $option) {
				
					$i++;
					if($i == 1) $display = 'block'; else $display = 'none';
					echo "<div id='$num$i' class='$num' style='display: $display;'><h3>$option[data]<span class='whats'>$option[kind]</span></h3></div>";

				}
				//The below will echo when script is changed to div, why should it matter?
				$javascript = 
				"<script type='text/javascript'> function rotate_$num(number) { num = number%$i;
				    $('.$num').fadeOut('normal');
				    $('#'+(num+1)).fadeIn('normal');
				    number++;
				    setTimeout('rotate_$num('+number+')',300);
				}
				</script>";
				    echo $javascript;				//The above will echo when script is changed to div, why should it matter?
			}
			else {
				echo "<h3>".$result['data']."<span class='whats'>$result[kind]</span></h3>";
			}
		echo "</div>";
}

/*function ticker($result) {
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
}*/

?>