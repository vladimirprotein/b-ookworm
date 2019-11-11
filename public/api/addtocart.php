<?php
	error_reporting(0);
	require_once '../../lib/rememberme.php';
	if ($_SESSION['user_type_id'] != 2) {
		$obj->responsecode = 100;
	}
	else{
		$bsid=$_GET['a'];
		require_once "../../lib/databasedial.php";
		$stmt = $conn->prepare("SELECT * FROM cart WHERE user_id = ? AND book_seller_id = ? AND order_uid IS NULL");
		$stmt->bind_param("ii", $_SESSION['id'], $bsid);
		$stmt->execute();
		$result = $stmt->get_result();
		if($result->num_rows != 0){
			$row = $result->fetch_assoc();
			if($row['if_wishlist'] == 0){
				$stmt= $conn->prepare("UPDATE cart SET quantity= quantity+1 , updated_at=? WHERE user_id=? and book_seller_id=? and order_uid IS NULL and if_wishlist = 0");
				$stmt->bind_param("sss", $created_at, $_SESSION['id'], $bsid);
				if($stmt->execute()) {
					$obj->message= "Quantity Updated for an Item in Cart";
					$obj->responsecode = 200;
				}
			}
		}
		else{
			$created_at=date("Y-m-d",time());
			$stmt= $conn->prepare("INSERT INTO cart (user_id, book_seller_id, created_at) VALUES (?,?,?)");
			$stmt->bind_param("sss",$_SESSION['id'], $bsid, $created_at);
			if ($stmt->execute()) {
				$obj->message= "New Item added to Cart";
				$obj->responsecode = 200;
			}
		}
	}
	$return = json_encode($obj);
	echo $return;
?>