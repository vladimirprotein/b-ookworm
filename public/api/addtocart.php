<?php
	error_reporting(0);
	require_once '../../lib/rememberme.php';
	if (!isset($_SESSION['id'])) {
		$obj->responsecode = 100;
	}
	else{
		$bsid=$_GET['a'];
		require_once "../../lib/databasedial.php";
		$created_at=date("Y-m-d",time());
		$stmt= $conn->prepare("INSERT INTO cart (user_id, book_seller_id, created_at) VALUES (?,?,?)");
		$stmt->bind_param("sss",$_SESSION['id'], $bsid, $created_at);
		if ($stmt->execute()) {
			$obj->message= "New Item added to Cart";
			$obj->responsecode = 200;
		}
		else{
			$stmt= $conn->prepare("UPDATE cart SET quantity= quantity+1 , updated_at=? WHERE user_id=? and book_seller_id=?");
			$stmt->bind_param("sss", $created_at, $_SESSION['id'], $bsid);
			if($stmt->execute()) {
				$obj->message= "Quantity Updated for an Item in Cart";
				$obj->responsecode = 200;
			}
		}
		
	}
	$return = json_encode($obj);
	echo $return;
?>