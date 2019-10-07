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
		$stmt= $conn->prepare("DELETE from cart where user_id = ? and book_seller_id = ?");
		$stmt->bind_param("ss",$_SESSION['id'], $bsid);
		if($stmt->execute()){
			$obj->message="Item Removed";
		}
	}
	$return = json_encode($obj);
	echo $return;
?>