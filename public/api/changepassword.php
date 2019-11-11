<?php
	error_reporting(0);
	require_once "../../lib/rememberme.php";
	$old= md5($_POST['old']."!book#worm");
	$new= md5($_POST['new']."!book#worm");
	require_once "../../lib/databasedial.php";
	$updated_at=date("Y-m-d",time());
	$stmt= $conn->prepare("SELECT pass FROM `user` WHERE id=?");
	$stmt->bind_param("i", $_SESSION['id']);
	$stmt->execute();
	$row= $stmt->get_result()->fetch_assoc();
	if ($row['pass'] == $old) {
		$stmt= $conn->prepare("UPDATE `user` SET pass=?, updated_at=? WHERE id=? AND pass=?");
		$stmt->bind_param("ssis", $new, $updated_at, $_SESSION['id'], $old);
		if ($stmt->execute()) {
	  		$obj->message= "Password Updated";
	  		$obj->code= 1;
	  		$to= $_SESSION['email'];
	  		$subject= "Bookworm Password Update";
	  		$text= "Password Successfully Updated";
	  		$headers="From: Ani";
	  		mail($to, $subject, $text, $headers);
	  	}
	  	else{
	  		$obj->message= "Update failed";
	  	}
	}
	else{
		$obj->message= "Wrong Password";
		$obj->code=0;
		$to= $_SESSION['email'];
	  	$subject= "Bookworm Password Update";
	  	$text= "Someone tried to update your password";
	  	$headers="From: Ani";
	  	mail($to, $subject, $text, $headers);
	}

	echo json_encode($obj);

	
?>