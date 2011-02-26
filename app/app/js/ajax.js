function init() {
	$.get('app/app/php/fetch.php', {
		start:true
		},
		function(responce) {
			$('#data').append(responce);
		}
	);
}
$(document).ready(function() {
	load();
});
function load() {
	$('#data').empty();
	init();
	setTimeout('load()', 900000);
}