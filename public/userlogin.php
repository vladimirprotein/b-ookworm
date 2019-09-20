<!DOCTYPE html>
<?php
	require_once '../lib/no_entry_with_session.php';
?>
<html>
<head>
	<title>Log In</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  	<link rel="stylesheet" type="text/css" href="css/fontawesome.css">
  	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
	<?php require_once '../lib/header.php'; ?>
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
	          	$stmt->bind_param("ss", $email,$pass);
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
	        			header('Location: /index.php');
	     				exit();
	        		}
	        		if ($row['user_type_id']=='3') { // if credential is for seller, redirecct to seller homepage
	        			header('Location: /sellerpage.php');
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
  	<div class="container-fluid col-sm-6 float-left mt-5 border">
  		<h2 class="bg-success border">Log in:</h2>
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
      		<div class="form-group">
      			<input type="checkbox" name="remember" value="yes" class=""> Remember me
      		</div>
      		<div class="form-group">
        		<input type="submit" id="submit" name="submit" value="Log In" class="bg-success">
      		</div>
    	</form>
      	<?php echo $return_data; ?>
  	</div>
    <?php require_once '../lib/footer.php'; ?>
    <script type="text/javascript" src="js/js1.js"></script>
</body>
</html>