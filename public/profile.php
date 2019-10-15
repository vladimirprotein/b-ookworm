<!DOCTYPE html>
<?php 
	require_once "../lib/onlysession.php";

?>
<html>
<head>
	<title>PROFILE</title>
	<?php require_once "../lib/resource.php"; ?>
</head>
<body>
	<header class="">
        <?php require_once '../view/header.php'; ?> 
        <?php require_once '../view/navbar.php'; ?>
    </header>
    <?php
    	require_once "../lib/databasedial.php";
    	if ($_SERVER["REQUEST_METHOD"] == "POST") { //will enter this block if the form is submitted with method POST
    		$nameErr = $emailErr = $phoneErr = $passErr= $typeErr= ""; // initializing error variables to empty strings
	    	$name = $email = $unique_id = $phone = $pass= $type= "";// initializing empty string variables to store form input data
	    	$return_data= ""; // variable to store output string
	    	$error=false; // initializing error variable with false

	      	if (empty($_POST["name"])) { // if name field is left empty
	        $nameErr="Name is required";
	        $error=true;
	      	}
	      	else{ // if name field has some input
	        	$name=test_input($_POST["name"]);
	        	if (!preg_match("/^[a-zA-Z ]*$/",$name)) { // for ensuring the input is a name format
	          		$nameErr="Only letters and white spaces allowed";
	          		$error=true;
	        	}
	      	}
	      	if (empty($_POST["email"])) { // if email field is left empty
	        	$emailErr="Email is required";
	        	$error=true;
	      	}
	      	else{ // if email field has some input
	        	$email=test_input($_POST["email"]);
	        	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) { // for ensuring the input is an email format
	        		$emailErr = "Invalid email format";
	        		$error=true;
	        	}
	      	}
	      	if (empty($_POST["phone"])) {
	        	$phoneErr="Phone number is required";
	        	$error=true;
	      	}
	      	else{
	        	$phone=test_input($_POST["phone"]);
	        	if (!preg_match("/^\+?[0-9]{6,12}$/", $phone)) {
	        		$phoneErr= "Incorrect Phone Number";
	        		$error=true;
	        	}
	      	}

	      	
	      	if (!$error){ // if error variable remains false and form input is all okay
	          	$created_at=date("Y-m-d",time());
	          	$stmt = $conn->prepare("UPDATE `user` SET name=?, email=?, phone=?, updated_at='$created_at' WHERE id=".$_SESSION['id']);
	          	$stmt->bind_param("ssd",$name, $email, $phone);
	   			if ($stmt->execute()) {
				    $return_data= "Update successful";
				} else {
					$return_data= "Update failed." ;
				}
      		}
	    }
	    function test_input($data) { // custom function for refining user input string
	      	$data = trim($data);
	      	$data = stripslashes($data);
	      	$data = htmlspecialchars($data);
	      	return $data;
	    }



    	$stmt = $conn->prepare("SELECT name, email, phone, created_at, updated_at FROM `user` WHERE id=".$_SESSION['id']);
    	$stmt->execute();
    	$row = $stmt->get_result()->fetch_assoc();
    	$name = $row['name'];
    	$email = $row['email'];
    	$phone = $row['phone'];
    	$updated_at = $row['updated_at'];
    	$created_at = $row['created_at']; 
    ?>
    <div class="container-fluid bookdetails1">
    	<div class="row pt-4">
    		<div class="col-sm-6">
    			
    		</div>
    		<div class="col-sm-6">
    			<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method='POST'>
    				<div class="form-group">
    					Name:<small class="text-danger" id="nameErr2">* <?php echo $nameErr;?></small>
    					<input type="text" name="name" id="name2" class="form-control" placeholder="NAME" value="<?php echo $name; ?>" onkeyup='validate_alpha(this.id, "nameErr2" , "submit2")' required>
    				</div>
    				<div class="form-group">
    					Phone:<small class="text-danger" id="phoneErr2">* <?php echo $phoneErr;?></small>
    					<input type="text" name="phone" id="phone2" class="form-control bg-warning" placeholder="PHONE" value="<?php echo $phone; ?>" onkeyup='validate_numeric(this.id, "phoneErr2", "submit2")' required>
    				</div>
    				<div class="form-group">
    					Email:<small class="text-danger" id="emailErr2">* <?php echo $emailErr;?></small>
    					<input type="Email" id="email2" name="email" class="form-control" placeholder="EMAIL" value="<?php echo $email; ?>" onkeyup='validate_email(this.id, "emailErr2" , "submit2")'>
    				</div>
    				<div class="form-group">
    					Address:
    					<input type="text" name="address" class="form-control bg-warning" placeholder="ADDRESS" value="<?php echo $address; ?>">
    				</div>
    				<div class="form-group">
	        		<input type="submit" name="submit" id="submit2" value="UPDATE" class="btn btn-secondary">
	      		</div>
    			</form>

    			<?php 
    				echo $return_data."<br>";
    				echo "Last Update: ";
    				echo ($updated_at==null? $created_at : $updated_at);
    			?>	
    		</div>
    	</div>
    </div>
    <?php require_once "../view/footer.php" ?>
    <script type="text/javascript" src="js/js1.js"></script>
</body>
</html>