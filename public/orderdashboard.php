<!DOCTYPE html>
<?php
	require_once "../lib/onlyseller.php";
?>
<html>
<head>
	<title>Order Dashboard</title>
	<?php require_once "../lib/resource.php"; ?>
</head>
<body>
	<header>
		<?php
			require_once "../view/header.php";
			require_once "../view/navbar.php";
		?>
	</header>
	<div class="bookdetails1 container-fluid pl-3 pt-4 pb-4">
		<div class="mb-4 container" style="width: 90%">
			<h2 class="text-success text-center font-weight-bold font-italic mb-5">Customer Orders</h2>
			<?php
				require_once "../lib/databasedial.php";
				$stmt = $conn->prepare("SELECT cart.order_uid as order_uid, book.pic as pic, book.title as title, book.book_isbn as isbn, book_seller.price as price, cart.quantity as quantity, orders.order_date as order_date, cart.tracking_id as tracking_id, address.name as name, address.contact as contact, address.addr1 as addr1, address.addr2 as addr2, address.addr3 as addr3, address.pin as pin, pincode.city as city, pincode.district as district, pincode.state as state FROM ((((cart INNER JOIN book_seller ON cart.book_seller_id = book_seller.id) INNER JOIN book ON book_seller.book_id = book.id) INNER JOIN orders ON cart.order_uid = orders.order_uid) INNER JOIN address ON orders.address_id = address.id) INNER JOIN pincode ON address.pin = pincode.pin WHERE book_seller.user_id =".$_SESSION['id']." ORDER BY order_date desc");
				$stmt->execute();
				$result = $stmt->get_result();
				// var_dump($result->fetch_all(MYSQLI_ASSOC)[0]['order_uid']);
				if ($result->num_rows > 0) {
					$numrow = $result->num_rows;
					$array = $result->fetch_all(MYSQLI_ASSOC);
					for ($i = 0; $i < $numrow; $i = $i + 1){
						$row = $array[$i];
						if($row['order_uid'] != $array[$i-1]['order_uid'] ){
							$total = $row['quantity']*$row['price'];
							echo
							"
							<div class='rounded mt-2 pt-2 bg-light pl-2 pb-3 pr-4 pt-3 mb-4'>
								<div class='row border-bottom pb-2 '>
									<div class='col-sm-4'>
										<button class='text-dark pr-1 pl-1'><span class='font-weight-bold font-italic h5'>Order ID-</span> "." ".$row['order_uid']."</button>
									</div>
									<div class='col-sm-2'>
										<button class=' text-dark pl-1 pr-1 mr-0 h6'>".$row['order_date']."</button>
									</div>
									<div class='col-sm-6 btn btn-light pl-1 pb-0 pt-0'>
										<h6 class='' style='font-style:oblique'>Delivery To:</h6>
										<p style='font-size:12px'>".$row['name'].", ".$row['addr1']." ".$row['addr2']." ".$row['addr3'].", ".$row['city'].", ".$row['district'].", ".$row['state'].". PIN: ".$row['pin'].", Contact: ".$row['contact']."</p>
									</div>
								</div>";

							echo 
								"<div class='col-sm-12 row pb-3 pt-3 pl-4'>
									<div class='col-sm-2'>
										<img src='uploads/".$row['pic']."' width='60px' height='85px' alt='Image'>
									</div>
									<div class='col-sm-3 pl-2 pt-1'>
										<h5 class= 'pb-2'><a href='book.php?isbn=".$row['isbn']."'"." style='text-decoration:none;' class='text-success'>".ucwords($row['title'])."</a><span class='pl-1 h6'>(".$row['quantity'].")</span></h5>
										<h6>ISBN: ".ucwords($row['isbn'])."</h6>
										<h6>&#8377 ".$row['price']."</h6>
									</div>
									<div class= 'col-sm-2 pt-1 pl-1'>
										<h5 class='color1'>&#8377 ".$row['quantity']*$row['price']."</h5>
									</div>
									<div class= 'col-sm-2 pt-1 pl-1'>
										<h6>".$row['tracking_id']."</h6>
									</div>
									<div class= 'col-sm-3'>
							
									</div>
								</div>";
						}
						else{
							$total += $row['quantity']*$row['price'];
							echo 
								"<div class='col-sm-12 row pb-3 pt-3 pl-4'>
									<div class='col-sm-2'>
										<img src='uploads/".$row['pic']."' width='60px' height='85px' alt='Image'>
									</div>
									<div class='col-sm-3 pl-2 pt-1'>
										<h5 class= 'pb-2'><a href='book.php?isbn=".$row['isbn']."'"." style='text-decoration:none;' class='text-success'>".ucwords($row['title'])."</a><span class='pl-1 h6'>(".$row['quantity'].")</span></h5>
										<h6>ISBN: ".ucwords($row['isbn'])."</h6>
										<h6>&#8377 ".$row['price']."</h6>
									</div>
									<div class= 'col-sm-2 pt-1 pl-1'>
										<h5 class='color1'>&#8377 ".$row['quantity']*$row['price']."</h5>
									</div>
									<div class= 'col-sm-2 pt-1 pl-1'>
										<h6>".$row['tracking_id']."</h6>
									</div>
									<div class= 'col-sm-3'>
							
									</div>
								</div>";
							// if($row['order_uid'] != $result->fetch_all(MYSQLI_ASSOC)[$i+1]['order_uid'] )
						}
						if($row['order_uid'] != $array[$i+1]['order_uid'] ){
							echo 
							"<div class='col-sm-12 row border-top pt-3'>
								<div class='col-7'>
									
								</div>
								<div class='col-5 pr-4'>
									<h5 class='float-right btn btn-light text-dark'><span class='h5 font-italic'>Order Total: </span><span class='h5 pl-3 font-weight-bold color1'>&#8377 ".$total."</span></h5>
								</div>
							</div>
						</div>";
						}
					}
				}
			?>
		</div>
	</div>

	<?php require_once "../view/footer.php"; ?>

</body>
</html>