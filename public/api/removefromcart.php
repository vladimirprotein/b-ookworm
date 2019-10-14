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
		$stmt= $conn->prepare("DELETE from cart where user_id = ? and book_seller_id = ? and quantity = 1");
		$stmt->bind_param("ss",$_SESSION['id'], $bsid);
		$stmt->execute();

		$stmt= $conn->prepare("UPDATE cart SET quantity= quantity-1 , updated_at=? WHERE user_id=? and book_seller_id=?");
		$stmt->bind_param("sss", $created_at, $_SESSION['id'], $bsid);
		$stmt->execute();
		$obj->message= "Cart Updated";
		$obj->responsecode = 200;
	}
	$return = json_encode($obj);
	echo $return;
?>