<?php
	error_reporting(0);
	require_once "../../lib/rememberme.php";
	if(!isset($_SESSION['id'])){
		$obj->responsecode = 100;
	}
	else{
		$pin = $_GET['a'];
		require_once "../../lib/databasedial.php";
		$stmt= $conn->prepare("SELECT city, district, state FROM pincode where pin = ?");
		$stmt->bind_param("i", $pin);
		if ($stmt->execute()) {
			$obj->responsecode = 200;
			$result = $stmt->get_result();
			if($result->num_rows != 0){
				$row = $result->fetch_assoc();
				$obj->city = $row['city'];
				$obj->district = $row['district'];
				$obj->state = $row['state'];
			}
			else{
				$str = file_get_contents('https://api.postalpincode.in/pincode/'.$pin);
				$response = json_decode($str);
				$obj->city = $response[0]->PostOffice[0]->Block;
				$obj->district = $response[0]->PostOffice[0]->District;
				$obj->state = $response[0]->PostOffice[0]->State;
				$stmt = $conn->prepare("INSERT INTO pincode VALUES('$pin', '$obj->city', '$obj->district', '$obj->state')");
				$stmt->execute();
			}
		}
	}
	$out = json_encode($obj);
	echo $out;
?>