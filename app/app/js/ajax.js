$(document).ready(function() {
	load();
});
function init() {
		for(pane in panes) {
			$.post('app/app/php/fetch.php', {
				start:true,
				id:panes[pane].id,
				pane_id:panes[pane].pane_id
			},
			function(response) {
				format(response);
			});
			}
}
function load() {
	$('#data').empty();
	init();
	setTimeout('load()', 900000);
}

function rename_name(str) {
	return str.split(' ').join('');
}
function debug(result) {
	$('#data').append(result);
}
function format(result) {
	if(result) {
		var parsed = JSON.parse(result);
		var title;
		var name = rename_name(parsed.name);
		if(parsed.title) {parsed.name = parsed.name+': '+parsed.title;}
			 var html = "<div class='pane "+name+"'><h2>"+parsed.name+"</h2>";
				if ($.isArray(parsed.data)) {
					var num = Math.floor(Math.random()*9999999);
					
					for (x in parsed.data) {
					
						html = html + "<div id='"+num+x+"' class='"+num+"'><h3>"+parsed.data[x].data+"<span class='whats'>"+parsed.data[x].kind+"</span></h3></div>";
						
	
					}
					html = html + "<script type='text/javascript'>rotate("+num+",0,"+x+");</script>";	
				}
				else {
					html = html + "<h3>"+parsed.data
						if(parsed.kind) {
							html = html +"<span class='whats'>"+parsed.kind+"</span>"
						}
					html = html + "</h3>";
				}
		html = html + "</div>";
			
		$('#data').append(html);
	}
}
function a(arr,level) {
	var dumped_text = "";
	if(!level) level = 0;
	
	//The padding given at the beginning of the line.
	var level_padding = "";
	for(var j=0;j<level+1;j++) level_padding += "    ";
	
	if(typeof(arr) == 'object') { //Array/Hashes/Objects 
		for(var item in arr) {
			var value = arr[item];
			
			if(typeof(value) == 'object') { //If it is an array,
				dumped_text += level_padding + "'" + item + "' ...\n";
				dumped_text += a(value,level+1);
			} else {
				dumped_text += level_padding + "'" + item + "' => \"" + value + "\"\n";
			}
		}
	} else { //Stings/Chars/Numbers etc.
		dumped_text = "===>"+arr+"<===("+typeof(arr)+")";
	}
	return dumped_text;
}
function is_array(input){
    return typeof(input)=='object'&&(input instanceof Array);
}
function rotate(id,number,num) {
	$('.'+id).removeClass('s');
	$('#'+id+number).addClass('s');
	number++;
	number = number%(num+1);
	setTimeout('rotate('+id+','+number+','+num+')',5000);
}