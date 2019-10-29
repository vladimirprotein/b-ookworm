<!DOCTYPE html>
<?php
	require_once "../lib/onlycustomer.php";
	if($_SERVER['REQUEST_METHOD'] != "POST"){
		header('Location: checkout.php');
		exit();
	}

	require_once "../lib/databasedial.php";
	$orderuid = "OD-".date("Y-m-d",time())."-".uniqid();
	$updated_at = date("Y-m-d",time());
	$stmt = $conn->prepare("INSERT INTO orders(order_uid, user_id, address_id) VALUES (?, ?, ?)");
	$stmt->bind_param("sii", $orderuid, $_SESSION['id'], $_POST['address']);
	if($stmt->execute()){
		$stmt2 = $conn->prepare("UPDATE cart SET order_uid = ?, updated_at = ? WHERE user_id = ? AND order_uid IS NULL");
		$stmt2->bind_param("ssi", $orderuid, $updated_at, $_SESSION['id']);
		if ($stmt2->execute()) {
			$message = "Order Successful";
			$stmt3 = $conn->prepare("SELECT cart.user_id as customer_id, cart.order_uid, book.book_isbn as book_isbn, book.title as title, book_seller.price as price, cart.quantity as quantity, user.name as seller, user.email as email, address.name as name, address.contact as contact, address.addr1 as addr1, address.addr2 as addr2, address.addr3 as addr3, address.pin as pin, pincode.city as city, pincode.district as district, pincode.state as state FROM (((((cart INNER JOIN book_seller ON cart.book_seller_id = book_seller.id) INNER JOIN `user` ON book_seller.user_id = `user`.id) INNER JOIN book ON book_seller.book_id = book.id) INNER JOIN orders ON orders.order_uid = cart.order_uid) INNER JOIN address ON address.id = orders.address_id) INNER JOIN pincode ON address.pin = pincode.pin  where cart.order_uid = '$orderuid'");
			$stmt3->execute();
			$result = $result2 = $stmt3->get_result();
			/* Mailing to Customer */
			$to = $_SESSION['email'];
			$subject = "BOOKWORM New Order Successfully Placed!";
			$headers = "From: Ani";
			$text = "Hello ".$_SESSION['name'].",\n\nYou have placed a new order with us, details of which are as mentioned below:\n\n"."Order ID: ".$orderuid."\n";
			$total = 0;
			while($row = $result->fetch_assoc()){
				$text .= "* ".$row['title']." (".$row['book_isbn'].") "."  X ".$row['quantity']. "  = ".$row['quantity']*$row['price'].".  Seller:".$row['seller']." (".$row['email'].")\n";
				$total += $row['quantity']*$row['price'];
			}
			$row = $result2->fetch_assoc();
			$text .= "\nOrder Total: ".$total."\nDelivery Address: ".$row['name'].", ".$row['addr1']." ".$row['addr2']." ".$row['addr3'].", ".$row['city'].", ".$row['district'].", ".$row['state'].". Contact: ".$row['contact']."."."\n\nWe are on it to deliver it to you ASAP.\nLooking forward to be your Book destination again soon.\n\nThanks,\nTeam Bookworm\nbookworm.mindfire@gmail.com";
			mail($to, $subject, $text, $headers);

		}
		else{
			$message = "Order Unsuccessful";
		}
	}
	else{
		$message = "Order Unsuccessful";
	}

	

 ?>
<html>
<head>
	<title>BOOKWORM||ORDER</title>
	<?php require_once "../lib/resource.php"; ?>
</head>
<body>
	<header>
	<?php
		require_once "../view/header.php";
		require_once "../view/navbar.php";
	?>
	</header>

	<div class="bookdetails1 container-fluid">
		<?php echo $message."<br>".$_SESSION['id']; ?>
	</div>


	<footer>
    	<?php require_once "../view/footer.php"; ?>
    </footer>
    <script type="text/javascript" src="js/js1.js"></script>
</body>
</html>