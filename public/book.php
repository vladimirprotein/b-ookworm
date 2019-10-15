<!DOCTYPE html>
<?php
	require_once '../lib/noseller.php'; //no entry for a seller session
    if (!isset($_GET['isbn'])) {
        header('Location: index.php');
        exit();
    }
    else {
        if(empty($_GET["isbn"])){
            header('Location: index.php');
            exit();
        }
        else {
            $isbn=$_GET['isbn'];
        }
    }
?>  
<html>
<head>
    <title>BOOKWORM | Book</title>
    <?php require_once "../lib/resource.php"; ?>
</head>
<body> 
    <header>
        <?php require_once '../view/header.php'; ?> 
        <?php require_once '../view/navbar.php'; ?>
    </header>
    <div class=" row bookdetails1">
        <div class="col-sm-11 row">
            <div class="col-sm-4">
                <img id="bookimage" src="" class="rounded ml-4 mt-4 mb-4" alt="book-image" width="300px" height="380px">
            </div>
            <div class="col-sm-8">
                <h3 id="booktitle" class="text-secondary border-bottom pl-2 mt-4 border-success">BOOK NAME</h3>
                <h5 id="bookisbn" class="btn-success btn border-top border-success pt-2 float-right mb-3 ">ISBN</h5>
                <h5 class="mb-4 mt-5 text-primary" id="sellers"><b>Sellers:</b></h5>
                <div class="col-sm-11" id=" ">
                    <table class="table table-striped table-dark table-hover" id="sellertable">
                        <tr class="table-success text-dark">
                            <th>Name</th>
                            <th>Email</th>
                            <th>Listed on</th>
                            <th>Price</th>
                            <th></th>
                        </tr>
                    </table>

                    <h6 class="text-danger mt-5 text-center" id='added_to_cart_message'></h6>
                </div>
            </div>
        </div>
    </div>
    <?php require_once '../view/footer.php'; ?>



    <script type="text/javascript" src="js/js1.js?v=3.0"></script>
    <script>
        var isbn = "<?php echo $isbn ; ?>";
        getbookdetails(isbn);
    </script>
</body>
</html>