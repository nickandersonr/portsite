console.log("I'm here!");
var i = 1;
$('div.sections section').each(function(){
	console.log("I work!");
    $(this).addClass('section_'+i);
    i++;
});