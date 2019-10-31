<?php
    include_once 'rememberme.php';
    if($_SESSION['user_type_id']!=3){
        header('Location: index.php');
        exit();
    }
?>    