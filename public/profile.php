<!DOCTYPE html>
<?php
	error_reporting(0);
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
            $_SESSION['name']= $name;
            $_SESSION['email']= $email;
				    $to= $email;
            $subject= "Bookworm Profile Changes";
            $text= "Hey There.\nYour Profile details were changed just now. New credentials are as followed.\nName: ".$name."\nEmail: ".$email."\nPhone: ".$phone."\nUpdated on: ".$created_at."\n\nIf it weren't you, write us immediately to bookworm.mindfire@gmail.com\n\nTeam Bookworm\nbookworm.com";
            $headers= "From: Ani";
            mail($to, $subject, $text, $headers);
				  } 
          else {
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
    		<div class="col-sm-6 pl-4">
    			<!-- Button to Open the Modal -->
  				<li class="mb-3 "><button type="button" class="btn-sm btn-success" data-toggle="modal" data-target="#myModal">
    				Change Password
  				</button></li>
  				<li><button type="button" class="btn-sm">
    				My Orders
  				</button></li>

  				<!-- The Modal -->
  				<div class="modal fade" id="myModal">
    				<div class="modal-dialog">
      					<div class="modal-content" style="background: linear-gradient(rgba(255,255,255,.5), rgba(255,255,255,.5)), url('img/passbg.png');">
      
        					<!-- Modal Header -->
        					<div class="modal-header">
          						<h4 class="modal-title text-italic text-success">Change Your Password:</h4>
          						<button type="button" class="close" data-dismiss="modal">&times;</button>
        					</div>
        
        					<!-- Modal body -->
        					<div class="modal-body">
          						<form>
          							<div class="form-group">
          								Old Password:<small class="text-danger" id="oldpassErr">*</small>
          								<input type="Password" id="oldpassword" class="form-control bg-warning" required>
          							</div>
                        <div class="form-group">
                          New Password:<small class="text-danger" id="newpassErr">*</small>
                          <input type="Password" id="newpassword" class="form-control bg-light" required>
                        </div>
                        <div class="form-group">
                          Re-Enter New Password:<small class="text-danger" id="newpass2Err">*</small>
                          <input type="Password" id="newpassword2" class="form-control bg-light" onkeyup='match_field(this.id, "newpassword", "newpass2Err", "submit5")' required>
                        </div>
                        <div class="form-group">
                          <input type="button" name="submit" id="submit5" value="Update" class="form-control btn-sm btn-primary">
                        </div>
          						</form>
        					</div>
        
        					<!-- Modal footer -->
        					<div class="modal-footer">
          						<p class="text-success font-weight-bold" id="passwordmessage"></p>
        					</div>
        
      					</div>
    				</div>
  				</div>
    		</div>

    		<div class="col-sm-6">
    			<h3 class="lead mb-4 font-weight-bold font-italic border-bottom border-warning border-dashed">Update Details:</h3>
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
    <script type="text/javascript" src="js/js1.js?v=2.0"></script>
</body>
</html>