$(document).ready(function () {
	console.log("Doc is ready");
	$("b").hover(function(){
		$(this).css("color", "red");
	});
});

$(window).Onload(function () {
	console.log("Doc has loaded");
});