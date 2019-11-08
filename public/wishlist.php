<!DOCTYPE html>
<?php
	require_once '../lib/onlycustomer.php'; // no entry for a seller session
?>    
<html>
<head>
    <title>BOOKWORM | Wishlist</title>
    <?php require_once "../lib/resource.php"; ?>
</head>
<body> 
    <header>
        <?php require_once '../view/header.php'; ?> 
        <?php require_once '../view/navbar.php'; ?>             
    </header>
    <div class=" container-fluid bookdetails1">
        <h2 class="pt-5 ml-4 mb-4 h2 text-secondary font-italic font-weight-bold">MY WISHLIST:</h2>
    </div>

    <?php require_once "../view/footer.php" ?>
</body>
</html>