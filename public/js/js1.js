function bookpopup(str1) {
	ajaxcall("api/response1.php", str1, showalert);
}
function showalert(obj1) {
	alert("Title: "+obj1.title+" ISBN: "+obj1.book_isbn+" Selling Since: "+obj1.created_at);
}
function getbookdetails(arg1) {
	document.getElementById(arg1).src="img/bcg.jpg";
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

/** 
   * Function to validate a field for alphabets only
   * @param input field id and error result id
   * @returns nothing.
 */
function validate_alpha(id1, id2, id3) {
	element=document.getElementById(id1);
	value=element.value;
	var letters = /^[A-Za-z\s]*$/;
   	if (!value.match(letters)) {
		element.classList.add("border-danger");
		element.classList.add("text-danger");
		document.getElementById(id2).innerHTML='* Only Alphabets allowed';
		document.getElementById(id3).disabled= true;
	}
	else {
		element.classList.remove("border-danger");
		element.classList.remove("text-danger");
		document.getElementById(id2).innerHTML='';
		document.getElementById(id3).disabled= false;
	}
}



/** 
   * Function to validate a field for numerics only and can begin with only 1 '+'
   * @param input field id and error result id
   * @returns nothing.
 */
function validate_numeric(id1, id2, id3) {
	element=document.getElementById(id1);
	value=element.value;
	var number1 = /^\+[0-9]{12,13}$/;
	var number2 = /^[0-9]{10}$/;
   	if (!value.match(number1) && !value.match(number2)) {
		element.classList.add("border-danger");
		element.classList.add("text-danger");
		document.getElementById(id2).innerHTML='* Only Numbers allowed';
		document.getElementById(id3).disabled= true;
	}
	else {
		element.classList.remove("border-danger");
		element.classList.remove("text-danger");
		document.getElementById(id2).innerHTML= '';
		document.getElementById(id3).disabled= false;
	}
}


/** 
   * Function to validate a field for email
   * @param input field id and error result id
   * @returns nothing.
 */
function validate_email(id1, id2, id3) {
	element=document.getElementById(id1);
	value=element.value;
	var email = /^[A-Za-z][A-Za-z0-9_]*@[A-Za-z0-9]+\.[A-Za-z]+(\.[A-Za-z]+)?$/;
   	if (!value.match(email)) {
		element.classList.add("border-danger");
		element.classList.add("text-danger");
		document.getElementById(id2).innerHTML='* Enter valid email';
		document.getElementById(id3).disabled= true;
	}
	else {
		element.classList.remove("border-danger");
		element.classList.remove("text-danger");
		document.getElementById(id2).innerHTML= '';
		document.getElementById(id3).disabled= false;
	}
}





	    