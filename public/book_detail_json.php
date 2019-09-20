<?php
	
	$isbn=$_GET['isbn'];
	require_once "../lib/databasedial.php";
	$stmt= $conn->prepare("SELECT book.id as id, book.book_isbn as isbn, book.title as title, book.pic as pic, book.created_at as created_at, book_seller.user_id as seller_id, book_seller.price as price FROM book INNER JOIN book_seller ON book.id = book_seller.book_id WHERE book.book_isbn= ? ");
	$stmt->bind_param("s",$isbn);
	$stmt->execute();
	$result=$stmt->get_result();
	//echo $result.num_rows;
	while($row=$result->fetch_assoc()) {
		var_dump($result);
		echo "<br><br>";
		var_dump($row);
		$row1=json_encode($result);
	}
?>