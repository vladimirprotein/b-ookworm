<!DOCTYPE html>
<?php
	require_once '../lib/noseller.php'; //no entry for a seller session
    $isbn=$_GET['isbn'];
?>    
<html>
<head>
    <title>BOOKWORM | Home</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="css/fontawesome.css">
    <link rel="stylesheet" type="text/css" href="css/style.css?v=1.0">
</head>
<body> 
    <header>
        <?php require_once '../view/header.php'; ?> 
        <?php require_once '../view/navbar.php'; ?>
    </header>

    <div class="container-fluid row mt-4">
        <div class="col-sm-9 row">
            <div class="col-sm-6">
                <img id="bookimage" src="" class="rounded ml-5" alt="book-image" width="300px" height="300px">
            </div>

            <div class="col-sm-6">
                <h3 id="booktitle" class="text-secondary">BOOK NAME</h3>
                <h4 id="bookisbn" class="text-center mb-3 ">ISBN</h4>
                <h5>Sellers:</h5>

            </div>
        </div>
        
    </div>



    <script type="text/javascript" src="js/js1.js"></script>
    <script>getbookdetails(<?php echo "getbookimage" ; ?>)</script>
</body>
</html>