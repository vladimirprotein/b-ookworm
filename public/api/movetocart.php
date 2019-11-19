<?php
	error_reporting(0);
	require_once '../../lib/rememberme.php';
	if ($_SESSION['user_type_id'] != 2) {
		$obj->responsecode = 100;
	}
	else{
		$bsid=$_GET['a'];
		require_once "../../lib/databasedial.php";
		$stmt = $conn->prepare("SELECT * FROM cart WHERE user_id = ? AND book_seller_id = ? AND order_uid IS NULL and if_wishlist = 0");
		$stmt->bind_param("ii", $_SESSION['id'], $bsid);
		$stmt->execute();
		$result = $stmt->get_result();
		if($result->num_rows == 0){
			$row = $result->fetch_assoc();
			$stmt = $conn->prepare("UPDATE cart SET if_wishlist = 0, updated_at = ? WHERE user_id=? and book_seller_id=? and order_uid IS NULL and if_wishlist = 1");
			$stmt->bind_param("sss", $created_at, $_SESSION['id'], $bsid);
			if($stmt->execute()) {
				$obj->message= "Item Moved to Cart";
				$obj->responsecode = 200;
			}
		}
		else{
			$stmt = $conn->prepare("DELETE FROM cart WHERE user_id = ? AND book_seller_id = ? AND order_uid IS NULL AND if_wishlist = 1");
			$stmt->bind_param("ii", $_SESSION['id'], $bsid);
			if($stmt->execute()) {
				$obj->message= "Item already in cart";
				$obj->responsecode = 200;
			}
		}
	}
	$return = json_encode($obj);
	echo $return;
?>