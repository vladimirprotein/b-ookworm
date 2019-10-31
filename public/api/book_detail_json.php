<?php
	error_reporting(0);
	$isbn=$_GET['a'];
	require_once "../../lib/databasedial.php";
	$stmt = $conn->prepare("UPDATE book SET popularity = popularity + 1 where book_isbn = ?");
	$stmt->bind_param("s", $isbn);
	$stmt->execute();
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
	$obj->sellerno=$i;

	$stmt2= $conn->prepare("SELECT author.name as author from book_author INNER JOIN author on book_author.author_id = author.id where book_author.book_id = '$obj->id'");
	$stmt2->execute();
	$result= $stmt2->get_result();
	$i=0;
	while($row= $result->fetch_assoc()){
		$obj->authors[$i]= $row['author'];
		$i++;
	}
	$obj->authorno= $i;

	$stmt3= $conn->prepare("SELECT genre.name as genre from book_genre INNER JOIN genre on book_genre.genre_id = genre.id where book_genre.book_id = '$obj->id'");
	$stmt3->execute();
	$result= $stmt3->get_result();
	$i=0;
	while($row= $result->fetch_assoc()){
		$obj->genres[$i]= $row['genre'];
		$i++;
	}
	$obj->genreno= $i;

	$stmt4= $conn->prepare("SELECT tag.name as tag from book_tag INNER JOIN tag on book_tag.tag_id = tag.id where book_tag.book_id = '$obj->id'");
	$stmt4->execute();
	$result= $stmt4->get_result();
	$i=0;
	while($row= $result->fetch_assoc()){
		$obj->tags[$i]= $row['tag'];
		$i++;
	}
	$obj->tagno= $i;
	$return=json_encode($obj);
	echo $return;
?>