<?php
    session_start();
    if(isset($_COOKIE["unique_id"])){
        require 'databasedial.php';
        $stmt=$conn->prepare("select * from `user` where unique_id=?");
        $stmt->bind_param("s",$_COOKIE["unique_id"]);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows != 0) {
            $row = $result->fetch_assoc();
            $_SESSION["id"]=$row['id'];
            $_SESSION["email"]=$row['email'];
            $_SESSION["name"]=$row['name'];
            $_SESSION["unique_id"]=$row['unique_id'];
            $_SESSION["user_type_id"]=$row['user_type_id'];
        }
    }
?>