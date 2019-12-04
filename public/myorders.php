<!DOCTYPE html>
<?php
	require_once "../lib/onlycustomer.php";
?>
<html>
<head>
	<title>BOOKWORM||MyOrders</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php require_once "../lib/resource.php"; ?>
</head>
<body>
	<header>
	<?php
		require_once "../view/header.php";
		require_once "../view/navbar.php";
	?>
	</header>

	<div class="bookdetails1 container-fluid pt-4 pb-4">
		<div class="container" style="width: 85%;">
			<h2 class="text-center font-weight-bold font-italic mb-5">My Orders</h2>
			
			<?php
				require_once "../lib/databasedial.php";
				$stmt = $conn->prepare("SELECT orders.order_uid as order_uid, orders.order_date as order_date, orders.address_id as address_id, address.name as name, address.contact as contact, address.addr1 as addr1, address.addr2 as addr2, address.addr3 as addr3, address.pin as pin, pincode.city as city, pincode.district as district, pincode.state as state FROM (orders INNER JOIN address ON orders.address_id = address.id) INNER JOIN pincode ON address.pin = pincode.pin where orders.user_id =".$_SESSION['id']." order by order_date desc");
				$stmt->execute();
				$result = $stmt->get_result();
				if($result->num_rows > 0){
					while($row = $result->fetch_assoc()){
						$order_uid = $row['order_uid'];
						$order_date = $row['order_date'];
						$address_id = $row['address_id'];
						$total = 0;

						echo
						"<div class='rounded mt-2 pt-2 bg-light pl-3 pb-3 pr-3 pt-3 mb-4'>
							<div class='row border-bottom pb-2 pr-3'>
								<div class='col-sm-5'>
									<button class='btn bg-color1 text-dark'><span class='font-weight-bold font-italic h5'>Order ID-</span> "." ".$order_uid."</button>
								</div>
								<div class='col-sm-7 btn btn-light'>
									<h5 style='font-style:oblique'>Delivery To:</h5>
									<p style='font-size:15px'>".$row['name'].", ".$row['addr1']." ".$row['addr2']." ".$row['addr3'].", ".$row['city'].", ".$row['district'].", ".$row['state'].". PIN: ".$row['pin'].  "</p>
								</div>
							</div>";

						$stmt2 = $conn->prepare("SELECT cart.order_uid as order_uid, book.pic as pic, book.title as title, book.book_isbn as isbn, `user`.`name` as seller, book_seller.price as price, cart.quantity as quantity, cart.tracking_id as tracking_id FROM ((cart INNER JOIN book_seller ON cart.book_seller_id = book_seller.id) INNER JOIN `user` ON book_seller.user_id = `user`.id) INNER JOIN book ON book_seller.book_id = book.id where order_uid = '$order_uid'");
						$stmt2->execute();
						$result2 = $stmt2->get_result();
						while($row2 = $result2->fetch_assoc()){
							$total += $row2['quantity'] * $row2['price'];
							echo 
							"<div class='col-sm-12 row pb-3 pt-3 pl-4'>
								<div class='col-sm-2'>
									<img src='uploads/".$row2['pic']."' width='60px' height='85px' alt='Image'>
								</div>
								<div class='col-sm-3 pl-2 pt-1'>
									<h5 class= 'pb-2'><a href='book.php?isbn=".$row2['isbn']."'"." style='text-decoration:none;' class='text-success'>".ucwords($row2['title'])."</a><span class='pl-1 h6'>(".$row2['quantity'].")</span></h5>
									<h6>ISBN: ".ucwords($row2['isbn'])."</h6>
									<h6>Seller: ".ucwords($row2['seller'])."</h6>
								</div>
								<div class= 'col-sm-2 pt-1 pl-1'>
									<h5 class='color1'>&#8377 ".$row2['quantity']*$row2['price']."</h5>
								</div>
								<div class= 'col-sm-2 pt-1 pl-1'>
									<h6>".$row2['tracking_id']."</h6>
								</div>
								<div class= 'col-sm-3'>
						
								</div>
							</div>";
						}
						echo 
							"<div class='col-sm-12 row border-top pt-3'>
								<div class='col-6'>
									<h5 class='btn btn-light text-dark'><span class='h5 font-italic'>Ordered on: </span>".$order_date."</h5>
								</div>
								<div class='col-6 pr-4'>
									<h5 class='float-right btn btn-light text-dark'><span class='h5 font-italic'>Order Total: </span><span class='h5 pl-3 font-weight-bold color1'>&#8377 ".$total."</span></h5>
								</div>
							</div>
						</div>";
					}
				}
				else{
					echo "<h3 class='text-center mb-5'>No Orders yet :(</h3>";
				}
			?>
		</div>
	</div>


	<footer>
    	<?php require_once "../view/footer.php"; ?>
    </footer>
    <script type="text/javascript" src="js/js1.js"></script>
</body>
</html>