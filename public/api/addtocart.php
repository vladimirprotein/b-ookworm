<?php
	require_once '../../lib/rememberme.php';
	if (!isset($_SESSION['id'])) {
		header('location: ../userlogin.php');
		exit();
	}
	$bsid=$_GET['a'];
	require_once "../../lib/databasedial.php";
	$created_at=date("Y-m-d",time());
	$stmt= $conn->prepare("INSERT INTO cart (user_id, book_seller_id, created_at) VALUES (?,?,?)");
	$stmt->bind_param("sss",$_SESSION['id'], $bsid, $created_at);
	if ($stmt->execute()) {
		echo "New Item added to Cart";
	}
	else{
		$stmt= $conn->prepare("UPDATE cart SET quantity= quantity+1 , updated_at=? WHERE user_id=? and book_seller_id=?");
		$stmt->bind_param("sss", $created_at, $_SESSION['id'], $bsid);
		if($stmt->execute()) {
			echo "Quantity Updated for an Item in Cart";
		}
	}
?>