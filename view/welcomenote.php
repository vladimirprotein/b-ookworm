<?php
    if(isset($_SESSION['id'])){  
        echo ("<span><h6 class='text-light mt-3 mr-5 float-left '>"."Welcome, ".$_SESSION['name']."</h6></span>"); //showing the name of logged in user
        echo ("<span class='mt-4'><a class='' href='userlogout.php'><abbr title='Logout'><i class='fa fa-sign-in ml-0 text-danger'></i></abbr></a></span>");
        if ($_SESSION['user_type_id']==2) {
        	echo "<span class='ml-3'><a class='badge text-warning' href='cart.php'><abbr title='Cart'><i class='fa fa-shopping-cart'></i></abbr></a></span>";
        }
        echo "<span class='ml-3'><a class='text-primary' href='profile.php'><abbr title='My Profile'><i class='fa fa-user'></i></abbr></a></span>";
    }

    else{
    	echo ("<span class='mt-4 float-left mr-4'><a class='' href='userlogin.php'><span class='badge badge-success'>LOGIN</span><i class='fa fa-sign-in text-success'></i></a></span>");
    	echo ("<span class='mt-4 float-left'><a class='' href='usersignup.php'><span class='badge badge-primary'>SIGN UP</span><i class='fa fa-sign-in text-primary'></i></a></span>");
    }
?>    