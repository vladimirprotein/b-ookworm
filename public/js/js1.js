function ajaxcall(url, val, callback) {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			callback(this.responseText);
				console.log('5');

		}
	}
	xmlhttp.open("GET" , url+"?a="+val, true);
		console.log('6');

	xmlhttp.send();
		console.log('7');

}

function bookpopup(str1) {
	console.log('1');
	ajaxcall("response1.php", str1, showalert);
	console.log('2');
}

console.log('3');

function showalert($obj1) {
	console.log('4');
	$obj1 = JSON.parse($obj1);
	alert("Title: "+$obj1.title+" ISBN: "+$obj1.book_isbn+" Selling Since: "+$obj1.created_at);
}
	console.log('8');



	    