<?php
    include_once 'rememberme.php';
    if($_SESSION['user_type_id']!=2){
        header('Location: index.php');
        exit();
    }
?>    