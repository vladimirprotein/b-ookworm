<?php
	include_once 'rememberme.php'; //restoring the session if it was saved in cookie
	if(isset($_SESSION['id'])){ //if session already exists
        if($_SESSION['user_type_id']==2){  //if user is customer, redirect to homepage
            header('Location: index.php');
            exit();
        }
        if($_SESSION['user_type_id']==3){ // if user is seller, redirect to seller homepage
            header('Location: sellerpage.php');
            exit();
        }
    }
?>