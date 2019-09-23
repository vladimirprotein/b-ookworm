<?php
    include_once 'rememberme.php';
    if (isset($_SESSION)) {
	    if($_SESSION['user_type_id']==3){
	        header('Location: sellerpage.php');
	        exit();
	    }
	}
?>    