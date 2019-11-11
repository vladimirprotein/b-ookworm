<?php
	error_reporting(0);
	require_once '../../lib/rememberme.php';
	if ($_SESSION['user_type_id'] != 2) {
		$obj->responsecode = 100;
	}
	else{
		$bsid=$_GET['a'];
		require_once "../../lib/databasedial.php";
		$stmt = $conn->prepare("SELECT * FROM cart WHERE user_id = ? AND book_seller_id = ? AND order_uid IS NULL AND if_wishlist = 1");
		$stmt->bind_param("ii", $_SESSION['id'], $bsid);
		$stmt->execute();
		$result = $stmt->get_result();
		if($result->num_rows != 0){
			$obj->message= "Already in Wishlist";
			$obj->responsecode = 200;
		}
		else{
			$created_at=date("Y-m-d",time());
			$stmt= $conn->prepare("INSERT INTO cart (user_id, book_seller_id, created_at, if_wishlist) VALUES (?,?,?,1)");
			$stmt->bind_param("sss",$_SESSION['id'], $bsid, $created_at);
			if ($stmt->execute()) {
				$obj->message= "Added to Wishlist";
				$obj->responsecode = 200;
			}
		}
	}
	$return = json_encode($obj);
	echo $return;
?>