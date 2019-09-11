<?php
    if(isset($_SESSION['id'])){  
        echo ("<li><h6 class='text-light mt-4 '>"."Welcome, ".$_SESSION['name']."</h6></li>"); //showing the name of logged in user
        echo ("<li class='ml-5 mt-3'><a class='badge badge-danger' href='/userlogout.php'>Logout</a></li>");
        if ($_SESSION['user_type_id']==2) {
        	echo "<li class='ml-3'><a class='badge text-warning' href='/cart.php'>Cart<i class='fa fa-shopping-cart'></i></a></li>";
        }
    }

    else{
    	echo ("<li class='mt-4'><a class='badge badge-danger' href='/userlogin.php'>Login</a></li>");
    	echo ("<li class='ml-3 mt-4'><a class='badge badge-success' href='/usersignup.php'>Signup</a></li>");

    }
?>    