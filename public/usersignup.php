<!DOCTYPE html>
<?php
	require_once '../lib/no_entry_with_session.php';
?>
<html>
<head>
	<title>Sign Up</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  	<link rel="stylesheet" type="text/css" href="../css/fontawesome.css">
  	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  	<link rel="stylesheet" type="text/css" href="../css/style.css">
</head>
<body>
	<?php require_once '../lib/header.php'; ?>
  	<?php
	    $nameErr = $emailErr = $phoneErr = $passErr= $typeErr= ""; // initializing error variables to empty strings
	    $name = $email = $unique_id = $phone = $pass= $type= "";// initializing empty string variables to store form input data
	    $return_data= ""; // variable to store output string
	    $error=false; // initializing error variable with false
	    if ($_SERVER["REQUEST_METHOD"] == "POST") { //will enter this block if the form is submitted with method POST
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
	      	}
	      	if (empty($_POST["pass"])) { // if password field is left empty
	        	$passErr="Password is required";
	        	$error=true;
	      	}
	      	else{
	        	$pass=test_input($_POST["pass"]);
	      	}

	      	if (empty($_POST["type"])) {
	        	$passErr="Usertype is required";
	        	$error = true;
	      	}
	      	else{
	        	$type=test_input($_POST["type"]);
	      	}
	      	if (!$error){ // if error variable remains false and form input is all okay
	          	require_once 'databasedial.php'; // establishing connection with the database
	          	$unique_id=uniqid();
	          	$created_at=date("Y-m-d",time());
	          	$hash= hash(sha1, $pass);
	          	$stmt = $conn->prepare( "INSERT INTO user (name, user_type_id, unique_id, email, phone, pass, created_at)
	          	VALUES (?, ?, '$unique_id', ?, ?, ?, '$created_at')"); // inserting record to the user table
	          	$stmt->bind_param("sssss",$name, $type, $email, $phone, $hash) ;
	          	if ($stmt->execute()) { // if entry is successful
				    $return_data= "User added successfully.";
				} else {
					$return_data= "User already Exists." ;
				}
	          	$conn->close();
      		}
	    }
	    function test_input($data) { // custom function for refining user input string
	      	$data = trim($data);
	      	$data = stripslashes($data);
	      	$data = htmlspecialchars($data);
	      	return $data;
	    }
  	?>
  	<div class="container-fluid float-left col-sm-6 mt-5 border">
  		<h2 class="text-success border-bottom">Sign Up:</h2>
  		<p><small class="text-danger">* required field</small></p>
  		<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" >
      		<div class="form-group">
        		Name:<small class="text-danger">* <?php echo $nameErr;?></small> <!--Displaying the error in name if present-->
        		<input type="text" name="name" placeholder="name" class="form-control" value="<?php echo $name; ?>">
      		</div>
      		<div class="form-group">
        		Email:<small class="text-danger">* <?php echo $emailErr;?></small> <!--Displaying the error in email if present-->
        		<input type="Email" name="email" placeholder="email" class="form-control" value="<?php echo $email; ?>">		
      		</div>
      		<div class="form-group">
        		Phone:<small class="text-danger">* <?php echo $phoneErr;?></small> <!--Displaying the error in phone if present-->
        		<input type="number" name="phone" placeholder="Phone" class="form-control" value="<?php echo $phone; ?>">
      		</div>
      		<div class="form-group">
        		Password:<small class="text-danger">* <?php echo $passErr;?></small> <!--Displaying the error in pswd if present-->
        		<input type="Password" name="pass" placeholder="Password" class="form-control">
      		</div>
      		<div class="form-group">
      			I am:<small class="text-danger">* <?php echo $typeErr;?></small><!--Displaying the error in user type if present-->
      			<input type="radio" name="type" value="2">Customer
      			<input type="radio" name="type" value="3">Seller
      		</div>
      		<div class="form-group">
        		<input type="submit" name="submit" value="Sign up" class="bg-primary">
      		</div>
    	</form>
    	<?php echo "<h5 class='text-danger'>$return_data</h5>"; ?> 
  	</div>
  	<?php require_once '../lib/footer.php'; ?>
</body>
</html>