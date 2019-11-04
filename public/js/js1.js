function bookpopup(str1) {
	ajaxcall("api/response1.php", str1, showalert);
}
function showalert(obj1) {
	alert("Title: "+obj1.title+" ISBN: "+obj1.book_isbn+" Selling Since: "+obj1.created_at);
}
function getbookdetails(arg1) {
	ajaxcall("api/book_detail_json.php", arg1, loadpage);
}
function loadpage(arg1) {
	document.getElementById('bookimage').src='uploads/'+arg1.pic ;
	idHTML('booktitle', 'w', arg1.title.toUpperCase() );
	idHTML('bookisbn', 'w',  'ISBN: '+arg1.isbn.toUpperCase() );
	var i;
	for(i=0; i<arg1.sellerno; i++) {
		var row= document.createElement('TR');
		var cell1= document.createElement('TH');
		var cell2= document.createElement('TH');
		var cell3= document.createElement('TH');
		var cell4= document.createElement('TH');
		var cell5= document.createElement('BUTTON');
		//cell1.classList.add('btn-sm');
		//cell1.classList.add('btn-success');
		cell4.classList.add('btn');
		cell4.classList.add('btn-success');
		cell5.addEventListener("click", function(){addtocart(this.name)});
		cell5.classList.add('btn-sm');
		cell5.classList.add('btn-warning');
		cell5.classList.add('float-right');
		cell5.classList.add('mt-2');
		cell1.innerHTML=arg1.seller[i];
		cell2.innerHTML=arg1.email[i];
		cell3.innerHTML=arg1.created_at[i];
		cell4.innerHTML="&#8377 "+arg1.price[i];
		cell5.innerHTML="Add to Cart";
		cell5.name=arg1.bsid[i];
		row.appendChild(cell1);
		row.appendChild(cell2);
		row.appendChild(cell3);
		row.appendChild(cell4);
		row.appendChild(cell5);
		row.classList.add('mt-5');
		document.getElementById('sellertable').appendChild(row);
	}
	for(i=0;i<arg1.authorno;i++){
		cell= document.createElement("LI");
		cell.innerHTML=arg1.authors[i].toUpperCase();
		document.getElementById('authors').appendChild(cell);
	}
	for(i=0;i<arg1.genreno;i++){
		cell= document.createElement("LI");
		cell.innerHTML=arg1.genres[i].toUpperCase();
		document.getElementById('genres').appendChild(cell);
	}
	for(i=0;i<arg1.tagno;i++){
		cell= document.createElement("LI");
		cell.innerHTML=arg1.tags[i].toUpperCase();
		document.getElementById('tags').appendChild(cell);
	}
}

function addtocart(bsid) {
	ajaxcall("api/addtocart.php", bsid , addedtocart);
}
function addedtocart(arg){
	if(arg.responsecode ==100){
		window.open("userlogin.php", "_blank");
	}
	else{
		document.getElementById('added_to_cart_message').innerHTML=arg.message;
	}
}

function increase_qty(bsid) {
	ajaxcall("api/addtocart.php", bsid, updatecartpage);
}

function decrease_qty(bsid) {
	ajaxcall("api/removefromcart.php", bsid, updatecartpage);
}

function updatecartpage(obj){
	window.open("cart.php", "_self");
}

function removeitem(bsid){
	ajaxcall("api/deleteitem.php", bsid, updatecartpage);
}


$(document).ready(function(){
	$(".decrease_qty").click(function(){
		var decrease = $(this);
		$.get("api/removefromcart.php?a="+($(this).attr("name")), function(data, status){
			if (status === 'success') {
				if(decrease.next().html()>0){
					decrease.next().html(decrease.next().html() - 1);
					decrease.parent().next().html(decrease.parent().next().html() - decrease.parent().prev().html());
					$("#totalprice").html($("#totalprice").html() - decrease.parent().prev().html());
				}
			}
		});
	});
	$(".increase_qty").click(function(){
		var increase = $(this);
		$.get("api/addtocart.php?a="+($(this).attr("name")), function(data, status){
			if (status === 'success') {
				increase.prev().html(parseInt(increase.prev().html()) + 1);
				increase.parent().next().html(parseInt(increase.parent().next().html()) + parseInt(increase.parent().prev().html()));
				$("#totalprice").html(parseInt($("#totalprice").html()) + parseInt(increase.parent().prev().html()));	
			}
		});
	});
	$(".removeitem").click(function(){
		var remove = $(this);
		$.get("api/deleteitem.php?a="+($(this).attr("name")), function(data, status){
			if (status === 'success') {
				$("#totalprice").html($("#totalprice").html() - remove.parent().prev().html());
				remove.parents('tr').remove();
			}
		});
	});


});

$("#submit5").click(function() {
	var old1= $("#oldpassword").val();
	var new1= $("#newpassword").val();
	var xyz= $(this);
	$.post("api/changepassword.php", {old: old1, new: new1}, function(data, status){
		obj= JSON.parse(data);
		if(status === 'success'){
			$("#passwordmessage").html(obj.message);
			if(obj.code== 0){
				$("#passwordmessage").removeClass("text-success");
				$("#passwordmessage").addClass("text-danger");
			}
			if(obj.code== 1){
				$("#passwordmessage").removeClass("text-danger");
				$("#passwordmessage").addClass("text-success");
			}
		}
	});
});

$("#pincode").focusout(function() {
	var pin = $("#pincode").val();
	$.get("api/pincode.php?a="+pin, function(data, status) {
		obj = JSON.parse(data);
		if(status === 'success'){
			$("#city").val(obj.city);
			$("#district").val(obj.district);
			$("#state").val(obj.state);
		}
	});
});

$("#submit6").click(function() {
	$.post("api/addaddress.php", {name: $("#name1").val(), contact: $("#contact").val(), addr1: $("#addline1").val(), addr2: $("#addline2").val(), addr3: $("#addline3").val(), pin: $("#pincode").val()}, function(data, status) {
		obj = JSON.parse(data);
		if (status === 'success') {
			$("#addressmessage").html(obj.message);
		}
	});
});

































/* LIBRARY METHODS    */


/* request the 'url' with attached value 'val' and a function 'callback' to call with the responseText as parameter.  */
function ajaxcall(url, val, callback) {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			var response = JSON.parse(this.responseText);
			callback(response);
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
   * @param input field id, error result id and submit button id
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
		document.getElementById(id2).innerHTML='*';
		document.getElementById(id3).disabled= false;
	}
}



/** 
   * Function to validate a field for numerics only and can begin with only 1 '+'
   * @param input field id, error result id, submit button id
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
		document.getElementById(id2).innerHTML='* Invalid';
		document.getElementById(id3).disabled= true;
	}
	else {
		element.classList.remove("border-danger");
		element.classList.remove("text-danger");
		document.getElementById(id2).innerHTML= '*';
		document.getElementById(id3).disabled= false;
	}
}


/** 
   * Function to validate a field for email
   * @param input field id, error result id, submit button id
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
		document.getElementById(id2).innerHTML= '*';
		document.getElementById(id3).disabled= false;
	}
}
/** 
   * Function to validate  field match to another field
   * @param input field id, reference field id, error result id, submit button id
   * @returns nothing.
 */
function match_field(id1,id2,id3,id4){
	element=document.getElementById(id1);
	value= element.value;
	val= document.getElementById(id2).value;
	if(value!=val){
		element.classList.add("border-danger");
		document.getElementById(id3).innerHTML="* Mismatch";
		document.getElementById(id3).classList.remove("text-success");
		document.getElementById(id3).classList.add("text-danger");
		document.getElementById(id4).disabled= true;
	}
	else{
		element.classList.remove("border-danger");
		document.getElementById(id3).innerHTML="Perfect!";
		document.getElementById(id3).classList.remove("text-danger");
		document.getElementById(id3).classList.add("text-success")
		document.getElementById(id4).disabled= false;
	}
}





	    