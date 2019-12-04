<!DOCTYPE html>
<?php
	error_reporting(0);
	require_once '../lib/no_entry_with_session.php';
?>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php require_once "../lib/resource.php"; ?>
</head>
<body>
	<?php require_once '../view/header.php'; ?>
	<?php require_once '../view/navbar.php'; ?>
  	<?php
	    $emailErr = $passErr= ""; // initializing error variables to empty strings
	    $email = $pass= $remember= ""; // initializing empty string variables to store form input data
	    $is_error = false; // initializing error variable with false
	    $return_data = ''; // variable to store output string
	    if ($_SERVER["REQUEST_METHOD"] == "POST") { //will enter this block if the form is submitted with method POST
	      	if (empty($_POST["email"])) { // if email field is left empty
	        	$emailErr="Email is required";
	        	$is_error = true;
	      	}
	      	else{ // if email field has some input
	        	$email=test_input($_POST["email"]);
	        	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) { // for ensuring the input is an email format
	        		$emailErr = "Invalid email format";
	        		$is_error = true;
	        	}
	      	}
	      	if (empty($_POST["pass"])) { // if password field is left empty
	        	$passErr="Password is required";
	        	$is_error = true;
	      	}
	      	else{
	        	$pass=test_input($_POST["pass"]);
	      	}
	      	if ($_POST["remember"]=='yes') // noting if user wants to remain logged in
	      	{
	      		$remember=test_input($_POST["remember"]);
	      	}
	      	if (!$is_error){ // if error variable remains false and form input is all okay
	          	require_once '../lib/databasedial.php'; // establishing connection with the database
	          	$stmt=$conn->prepare("SELECT * from user where email=? and pass=?"); // finding the record from user table
	          	$stmt->bind_param("ss", $email, md5($pass."!book#worm"));
	      		$stmt->execute();
	      		$result = $stmt->get_result();

	      		if ($result->num_rows != 0) { // if credential matches, storing the attributes in session
	        		$row = $result->fetch_assoc();
	        		$_SESSION["id"]=$row['id'];
	        		$_SESSION["email"]=$row['email'];
	        		$_SESSION["name"]=$row['name'];
	        		$_SESSION["unique_id"]=$row['unique_id'];
	        		$_SESSION["user_type_id"]=$row['user_type_id'];
	        		if ($remember=='yes') { // if user wants to remain logged in, storing the session in cookie for 30 days
	        			setcookie("unique_id",$_SESSION['unique_id'],  time()+60*60*24*30 ,"/");
	        			setcookie("currentusername",$_SESSION['name'],  time()+60*60*24*30,"/");
	        		}
	        		if ($row['user_type_id']=='2') { // if credential is for customer, redirect to homepage
	        			header('Location: index.php');
	     				exit();
	        		}
	        		if ($row['user_type_id']=='3') { // if credential is for seller, redirecct to seller homepage
	        			header('Location: sellerpage.php');
	     				exit();
	        		}	
	      		} 
	      		else { // if no match is found in the user table
	        		$return_data = "Invalid Credentials";
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
  	<div class=" row bookdetails1">
	  	<div class=" col-sm-6 float-left mt-5 ml-5">
	  		<h2 class="bg-success border pl-4 rounded">Log in:</h2>
	  		<p><small class="text-danger">* required field</small></p>
	  		<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" >
	      		<div class="form-group">
	        		Email:<small class='text-danger' id='emailErr'>* <?php echo $emailErr;?> </small><!--Displaying the error in email if present-->
	        		<input type="Email" id='email' onkeyup='validate_email(this.id, "emailErr", "submit")' name="email" placeholder="email" class="form-control" value="<?php echo $email; ?>">
	      		</div>		
	      		<div class="form-group">
	        		Password:<small class="text-danger">* <?php echo $passErr;?></small><!--Displaying the error in pswd if present-->
	        		<input type="Password" name="pass" placeholder="Password" class="form-control">
	      		</div>
	      		<div class="form-group btn-secondary btn">
	      			<input type="checkbox" name="remember" value="yes" class=""> Remember me
	      		</div>
	      		<div class="form-group">
	        		<input type="submit" id="submit" name="submit" value="Log In" class="btn btn-success">
	      		</div>
	    	</form>
	      	<?php echo $return_data; ?>
	  	</div>
	</div>
    <?php require_once '../view/footer.php'; ?>
    <script type="text/javascript" src="js/js1.js?v=2.0"></script>
</body>
</html>