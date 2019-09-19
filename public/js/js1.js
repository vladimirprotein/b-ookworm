function bookpopup(str1) {
	ajaxcall("response1.php", str1, showalert);
}
function showalert(obj1) {
	alert("Title: "+obj1.title+" ISBN: "+obj1.book_isbn+" Selling Since: "+obj1.created_at);
}








/* LIBRARY METHODS    */


/* request the 'url' with attached value 'val' and a function 'callback' to call with the responseText as parameter.  */
function ajaxcall(url, val, callback) {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			var parsed = JSON.parse(this.responseText);
			callback(parsed);
		}
	}
	xmlhttp.open("GET" , url+"?a="+val, true);
	xmlhttp.send();
}

/* Finds element with ID = 'id'. Returns false if id not present. Returns innerHTML if 'method'!='w' or even skipped. 
   Write innerHTML='towrite' if 'method'='w' and returns true if write successful. Returns false if no content provided for write*/
function idHTML(id, method, towrite) {
	if (document.getElementById(id)==null) {
		return false;
	}
	var element= document.getElementById(id);
	if (method=='w' || method=='W') {
		if (towrite!= undefined) {
			element.innerHTML= towrite;
			return true;
		}
		return false;
	}
	return element.innerHTML;
}


/* Finds elements with class = 'clas'. Returns false if class not present. Returns number of elements of that class present
   if 'pos' not given. If 'pos' given, Returns innerHTML if 'method'!='w' or even skipped. Write innerHTML='towrite' if 
   'method'='w' and returns true if write successful. Returns false if no content provided for write*/
function classHTML(clas, pos, method, towrite) {
	if (document.getElementsByClassName(clas)==null) {
		return false;
	}
	var elements=document.getElementsByClassName(clas);
	if (pos!= undefined) {
		var element=elements[pos];
		if (method=='w' || method=='W') {
			if (towrite!= undefined) {
				element.innerHTML= towrite;
				return true;
			}
			return false;
		}
		return element.innerHTML;
	}
	else {
		length = document.getElementsByClassName(clas).length;
		return length;
	}
}


/* Finds elements with tag = 'tag'. Returns false if tag not present. Returns number of elements of that tag present
   if 'pos' not given. If 'pos' given, Returns innerHTML if 'method'!='w' or even skipped. Write innerHTML='towrite' if 
   'method'='w' and returns true if write successful. Returns false if no content provided for write*/
function tagHTML(tag, pos, method, towrite) {
	if (document.getElementsByTagName(tag)==null) {
		return false;
	}
	var elements=document.getElementsByTagName(tag);
	if (pos!= undefined) {
		var element=elements[pos];
		if (method=='w' || method=='W') {
			if (towrite!= undefined) {
				element.innerHTML= towrite;
				return true;
			}
			return false;
		}
		return element.innerHTML;
	}
	else {
		length = document.getElementsByTagName(tag).length;
		return length;
	}
}


function validate_alpha(str) {
	var letters = /^[A-Za-z\s]+$/;
   	if (!str.match(letters)) {
		alert("error");
	}
}





	    