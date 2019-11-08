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
	$stmt = $conn->prepare("INSERT INTO orders (order_uid, user_id, address_id) VALUES (?, ?, ?)");
	$stmt->bind_param("sii", $orderuid, $_SESSION['id'], $_POST['address']);
	if ($stmt->execute()){
		$stmt2 = $conn->prepare("UPDATE cart SET order_uid = ?, updated_at = ? WHERE user_id = ? AND order_uid IS NULL");
		$stmt2->bind_param("ssi", $orderuid, $updated_at, $_SESSION['id']);
		if ($stmt2->execute()) {
			$message = "successful";
			$stmt4 = $conn->prepare("UPDATE book_seller INNER JOIN cart ON book_seller.id = cart.book_seller_id SET book_seller.quantity = book_seller.quantity - cart.quantity WHERE cart.order_uid = '$orderuid'");
			$stmt4->execute();
			$stmt3 = $conn->prepare("SELECT cart.user_id as customer_id, cart.order_uid, book.book_isbn as book_isbn, book.title as title, book_seller.price as price, cart.quantity as quantity, user.name as seller, user.email as email, address.name as name, address.contact as contact, address.addr1 as addr1, address.addr2 as addr2, address.addr3 as addr3, address.pin as pin, pincode.city as city, pincode.district as district, pincode.state as state FROM (((((cart INNER JOIN book_seller ON cart.book_seller_id = book_seller.id) INNER JOIN `user` ON book_seller.user_id = `user`.id) INNER JOIN book ON book_seller.book_id = book.id) INNER JOIN orders ON orders.order_uid = cart.order_uid) INNER JOIN address ON address.id = orders.address_id) INNER JOIN pincode ON address.pin = pincode.pin  where cart.order_uid = '$orderuid'");
			$stmt3->execute();
			$result = $stmt3->get_result();

			/* Mailing to Customer */
			$to = $_SESSION['email'];
			$subject = "BOOKWORM New Order Successfully Placed!";
			$headers = "From: Ani";
			$text = "Hello ".$_SESSION['name'].",\n\nYou have placed a new order with us, details of which are as mentioned below:\n\n"."Order ID: ".$orderuid."\n";
			$total = 0;
			while($row = $result->fetch_assoc()){
				$text .= "* ".$row['title']." (".$row['book_isbn'].") "."  X ".$row['quantity']. "  = ".$row['quantity']*$row['price'].".  Seller:".$row['seller']." (".$row['email'].")\n";
				$total += $row['quantity']*$row['price'];
				$name = $row['name'];
				$addr1 = $row['addr1'];
				$addr2 = $row['addr2'];
				$addr3 = $row['addr3'];
				$city = $row['city'];
				$district = $row['district'];
				$state = $row['state'];
				$pin = $row['pin'];
				$contact = $row['contact'];
			}
			$text .= "\nOrder Total: ".$total."\nDelivery Address: ".$name.", ".$addr1." ".$addr2." ".$addr3.", ".$city.", ".$district.", ".$state.". PIN: ".$pin.". Contact: ".$contact."."."\n\nWe are on it to deliver it to you ASAP.\nLooking forward to be your Book destination again soon.\n\nThanks,\nTeam Bookworm\nbookworm.mindfire@gmail.com";
			mail($to, $subject, $text, $headers);

			/* Mailing to Seller(s) */

			$stmt = $conn->prepare("SELECT DISTINCT email, `user`.name as name FROM (cart INNER JOIN book_seller ON cart.book_seller_id = book_seller.id) INNER JOIN `user` ON book_seller.user_id = `user`.id where cart.order_uid = '$orderuid'");
			$stmt->execute();
			$result = $stmt->get_result();
			while($row = $result->fetch_assoc()){
				$to = $row['email'];
				$subject = "BOOKWORM Seller. New Order received";
				$headers = "From: Ani";
				$text = "Hey ".$row['name'].",\nYou have received a new Order.\n\nORDER DETAILS:\n";
				$stmt2 = $conn->prepare("SELECT cart.user_id as customer_id, cart.order_uid as order_uid, book.book_isbn as book_isbn, book.title as title, book_seller.price as price, cart.quantity as quantity, user.email as email FROM (((cart INNER JOIN book_seller ON cart.book_seller_id = book_seller.id) INNER JOIN `user` ON book_seller.user_id = `user`.id) INNER JOIN book ON book_seller.book_id = book.id) where cart.order_uid = '$orderuid' and email ='$to'");
				$stmt2->execute();
				$result2 = $stmt2->get_result();
				$total = 0;
				while($row2 = $result2->fetch_assoc()){
					$text .= "* ".$row2['title']." (".$row2['book_isbn'].") "."  X ".$row2['quantity']. "  = ".$row2['quantity']*$row2['price']."\n";
					$total += $row2['quantity']*$row2['price'];
				}
				$text .= "\nOrder Total: ".$total."\nDelivery Address: ".$name.", ".$addr1." ".$addr2." ".$addr3.", ".$city.", ".$district.", ".$state.". Contact: ".$contact."."."\n\nYou are requested to ship the order ASAP and update the shipping details.\n\nThanks,\nTeam Bookworm\nbookworm.mindfire@gmail.com";
				mail($to, $subject, $text, $headers);

				/*Adjusting Seller Stock*/

			}
		}
		else{
			$message = "unsuccessful";
		}
	}
	else{
		$message = "unsuccessful";
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
		<div class="row mb-4 pb-4">
			<div class="col-sm-12">
				<h1 class="text-center pt-4 <?php if ($message == 'successful') {
					echo "text-success";
				}
				else{
					echo "text-danger";
				} ?>"><?php if ($message == 'successful') {
					echo "Order Placed!";
				}
				else{
					echo "Order Failed";
				} ?></h1>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-6 pb-4">
				<h3 class=" pl-4 text-center"><a style="text-decoration: none;" class="text-light pl-2 pr-2 pt-2 pb-2 bg-secondary rounded" href="index.php">Continue Shopping</a></h3>
			</div>
			<div class="col-sm-6">
				<h3 class=" pl-4 text-center"><a style="text-decoration: none;" class="text-light pl-2 pr-2 pt-2 pb-2 bg-secondary rounded" href="index.php">Best Sellers</a></h3>
			</div>
		</div>
	</div>


	<footer>
    	<?php require_once "../view/footer.php"; ?>
    </footer>
    <script type="text/javascript" src="js/js1.js"></script>
</body>
</html>