<!DOCTYPE html>
<html>
<head>
  <title>admin panel</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" type="text/css" href="../css/fontawesome.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" type="text/css" href="../css/style.css">
  <style>
    .error {color: #FF0000;}
  </style>
</head>
<body>
  <div class=" ">
    <section id="contacts">
      <h2 class="float-left ml-4 mt-3 mr-4 text-success"><a class="badge badge-pill badge-secondary" href="../index.php"> bookworm<span class="hov text-success">.com</span> </a><small class="text-muted h6 ml-3 font-weight-light font-italic">for the worms of the books</small></h2> 

      <div class="user">
        <ul class="list-group list-group-horizontal float-right mt-3 mr-5">
          <li class=""><a class="badge badge-danger" href="userlogin.php">Login</a></li>
          <li class="ml-3"><a class="badge badge-success" href="usersignup.php">Sign up</a></li>
        </ul>
      </div>
    </section>    
  </div>

  <?php
    
    $nameErr = $emailErr = $unique_idErr = $phoneErr = $user_typeErr = "";
    $name = $email = $unique_id = $phone = $user_type = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      if (empty($_POST["name"])) {
        $nameErr="Name is required";
      }
      else{
        $name=test_input($_POST["name"]);
        if (!preg_match("/^[a-zA-Z ]*$/",$name)) {
          $nameErr="Only letters and white spaces allowed";
        }
      }

      if (empty($_POST["unique_id"])) {
        $unique_idErr="Unique ID is required";
      }
      else{
        $unique_id=test_input($_POST["unique_id"]);
      }

      if (empty($_POST["email"])) {
        $emailErr="Email is required";
      }
      else{
        $email=test_input($_POST["email"]);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailErr = "Invalid email format";
        }
      }

      if (empty($_POST["phone"])) {
        $phoneErr="Phone number is required";
      }
      else{
        $phone=test_input($_POST["phone"]);
        if (!preg_match("/^[0-9 ]*$/",$phone)) {
          $phoneErr="Invalid number format";
        }
      }

      if (empty($_POST["user_type"])) {
        $user_typeErr="User type is required";
      }
      else{
        $user_type=test_input($_POST["user_type"]);
      }

      


    }

    function test_input($data) {
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      return $data;
    }
  ?>

  <div class="container-fluid mt-5">
    <h2 class="mb-5">Add user:</h2>
    <p><span class="error">* required field</span></p>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" >
      <div class="form-group">
        User Name:
        <input type="text" name="name" placeholder="name" class="form-control" value="<?php echo $name; ?>">
        <span class="error">* <?php echo $nameErr;?></span>
      </div>
      <div class="form-group">
        Unique ID:
        <input type="text" name="unique_id" placeholder="Unique ID" class="form-control" value="<?php echo $unique_id; ?>">
        <span class="error">* <?php echo $unique_idErr;?></span>
      </div>
      <div class="form-group">
        Email:
        <input type="Email" name="email" placeholder="email" class="form-control" value="<?php echo $email; ?>">
        <span class="error">* <?php echo $emailErr;?></span>
      </div>
      <div class="form-group">
        Phone:
        <input type="text" name="phone" placeholder="Phone" class="form-control" value="<?php echo $phone; ?>">
        <span class="error">* <?php echo $phoneErr;?></span>
      </div>
      <div class="form-group">
        User type:
        <input type="radio" name="user_type" <?php if (isset($user_type) && $user_type=="1") echo "checked";?> value="1"> Administrator
        <input type="radio" name="user_type" <?php if (isset($user_type) && $user_type=="2") echo "checked";?> value="2"> Customer
        <input type="radio" name="user_type" <?php if (isset($user_type) && $user_type=="3") echo "checked";?> value="3"> Seller
        <span class="error">* <?php echo $user_typeErr;?></span>
      </div>
      <div class="form-group">
        <input type="submit" name="submit" value="Insert">
      </div>

    </form>

    <?php

      if (!empty($name || $unique_id || $email || $phone || $user_type) && empty($nameErr || $unique_idErr || $emailErr || $phoneErr || $user_typeErr)) {
          
          require 'databasedial.php';
          $sql = "INSERT INTO user (unique_id, name, email, phone, user_type_id)
          VALUES ('$unique_id', '$name', '$email', '$phone', '$user_type')";

          if ($conn->query($sql) === TRUE) {
            echo "New record created successfully"."<br>";
          } 
          else {
            echo "Error: " . $sql . "<br>" . $conn->error;
          }

          $conn->close();
      }
      $servername = "localhost:3306";
      $username = "root";
      $password = "mindfire";
      $dbname = "bookworm";

      $conn = new mysqli($servername, $username, $password, $dbname);

      if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
      }
      $sql = "SELECT * from user";
      $result = $conn->query($sql);

      if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
          echo "  -id: " . $row["id"]. "    -Unique ID: " . $row["unique_id"]. "     -Name: " . $row["name"]. " -Email: " . $row["email"]."   -Phone: " . $row["phone"] . "    -User type: ". $row["user_type_id"]."<br>";
        }
      } 
      else {
        echo "0 results";
      }
      $conn->close();
    ?>



  </div>
</body>
</html>