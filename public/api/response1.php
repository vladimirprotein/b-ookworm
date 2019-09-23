<?php
	$isbn=$_GET['a'];
	require_once "../../lib/databasedial.php";
	$stmt= $conn->prepare("SELECT * from book where book_isbn=?");
	$stmt->bind_param("s",$isbn);
	$stmt->execute();
	$result=$stmt->get_result();
	$row=$result->fetch_assoc();
	$row=json_encode($row);
	echo $row;
?>