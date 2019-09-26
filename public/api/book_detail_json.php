<?php
	error_reporting(0);
	$isbn=$_GET['a'];
	require_once "../../lib/databasedial.php";
	$stmt= $conn->prepare("SELECT book.id as id, book.book_isbn as isbn, book.title as title, book.pic as pic, book_seller.created_at as created_at, book_seller.user_id as seller_id, book_seller.id as bsid, `user`.name as seller, `user`.email as email, `user`.phone as phone, book_seller.price as price FROM (book INNER JOIN book_seller ON book.id = book_seller.book_id) INNER JOIN `user` on book_seller.user_id = user.id WHERE book.book_isbn= ? ");
	$stmt->bind_param("s",$isbn);
	$stmt->execute();
	$result=$stmt->get_result();
	$i=0;
	while($row=$result->fetch_assoc()) {
		$obj->id=$row['id'];
		$obj->isbn=$row['isbn'];
		$obj->title=$row['title'];
		$obj->pic=$row['pic'];
		$obj->created_at[$i]=$row['created_at'];
		$obj->seller_id[$i]=$row['seller_id'];
		$obj->seller[$i]=$row['seller'];
		$obj->email[$i]=$row['email'];
		$obj->phone[$i]=$row['phone'];
		$obj->price[$i]=$row['price'];
		$obj->bsid[$i]=$row['bsid'];
		$i++;	
	}
	$obj->num=$i;
	$return=json_encode($obj);
	echo $return;
?>