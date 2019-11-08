<?php
	error_reporting(0);
	require_once "../../lib/rememberme.php";
	$uid = $_POST['uid'];
	$value = $_POST['value'];
	require_once "../../lib/databasedial.php";
	$updated_at=date("Y-m-d",time());
	$stmt= $conn->prepare("UPDATE cart INNER JOIN book_seller ON cart.book_seller_id = book_seller.id SET cart.tracking_id = ? WHERE book_seller.user_id = ? AND cart.order_uid = ?");
	$stmt->bind_param("sis", $value, $_SESSION['id'], $uid);
	if($stmt->execute()){
		$obj->message = "Tracking ID updated";

		$stmt2 = $conn->prepare("SELECT book.title as title, book.book_isbn as isbn, book_seller.price as price, cart.quantity as quantity, `user`.name as name, `user`.email as email FROM cart INNER JOIN book_seller ON cart.book_seller_id = book_seller.id INNER JOIN book on book_seller.book_id = book.id INNER JOIN `user` ON cart.user_id = `user`.id WHERE cart.order_uid = '$uid'");
		$stmt2->execute();
		$result = $stmt2->get_result();
		$numrow = $result->num_rows;
		$array = $result->fetch_all(MYSQLI_ASSOC);
		$to = $array[0]['email'];
		$subject = "BOOKWORM. Order Shipped";
		$headers = "From: Ani";
		$text = "Hello ".$array[0]['name'].".\n\nYour Order ".$uid." From Seller ".$_SESSION['name']. " has been shipped.\n\nTracking Details: ".$value."\n\nThanks,\nTeam Bookworm.\nbookworm.mindfire@gmail.com";
		mail($to, $subject, $text, $headers);
	}
	else{
		$obj->message = "Update Failed";
	}

	echo json_encode($obj);
?>