function ajaxcall(url, val) {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			return this.responseText;
		}
	}
	xmlhttp.open("GET" , "response1.php?a="+val, true);
	xmlhttp.send();
}








function bookpopup(str1) {
	var obj1= ajaxcall("response1.php", str1);
	alert(obj1);
	alert("ccccccc");
	alert("Title: "+$obj1.title+" ISBN: "+$obj1.book_isbn+" Selling Since: "+$obj1.created_at);
}


	    