<?php
	error_reporting(0);
	require_once "../../lib/rememberme.php";
	if(!isset($_SESSION['id'])){
		$obj->responsecode = 100;
	}
	else{
		require_once "../../lib/databasedial.php";
		$created_at=date("Y-m-d",time());
		$stmt = $conn->prepare("INSERT INTO address(user_id, name, contact, addr1, addr2, addr3, pin, created_at) VALUES(?,?,?,?,?,?,?,?)");
		$stmt->bind_param("isisssis", $_SESSION['id'], $_POST['name'], $_POST['contact'], $_POST['addr1'], $_POST['addr2'], $_POST['addr3'], $_POST['pin'], $created_at);
		if ($stmt->execute()) {
			$last = $conn->insert_id;
			$obj->responsecode = 200;
			$obj->message = "Inserted";
			$stmt2 = $conn->prepare("SELECT * FROM address INNER JOIN pincode on address.pin = pincode.pin where id = '$last'");
			$stmt2->execute();
			$row = $stmt2->get_result()->fetch_assoc();
			$to= $_SESSION['email'];
	  		$subject= "Bookworm New Profile Address";
	  		$text= "You have added a new address to your profile.\n\n".$row['name'].",\n".$row['addr1'].",\n".$row['addr2']."\n".$row['addr3']."\nCITY: ".$row['city']."\nDISTRICT: ".$row['district']."\n".$row['state']."\nPIN: ".$row['pin']."\nContact: ".$row['contact']."\n\n If it weren't you, write us immediately to bookworm.mindfire@gmail.com\n\nTeam Bookworm,\nbookworm.com";
	  		$headers="From: Ani";
	  		mail($to, $subject, $text, $headers);
		}
		else{
			$obj->message = "Failed";
		}
	}
	echo json_encode($obj);
?>