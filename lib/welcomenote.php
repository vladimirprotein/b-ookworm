<?php
    if(isset($_SESSION['id'])){  
        echo ("<li><h6 class='text-primary mt-1'>"."welcome ".$_SESSION['name']."</h6></li>"); //showing the name of logged in user
        echo ("<li class='ml-3'><a class='badge badge-danger' href='/userlogout.php'>Logout</a></li>");
    }

    else{
    	echo ("<li class=''><a class='badge badge-danger' href='/userlogin.php'>Login</a></li>");
    	echo ("<li class='ml-3'><a class='badge badge-success' href='/usersignup.php'>Signup</a></li>");

    }
?>    