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
    <div class=" container-fluid bookdetails1 pl-3">
        <h2 class="pt-5 ml-4 mb-5 h2 text-secondary text-center font-italic font-weight-bold">MY WISHLIST</h2>

        <?php
            require '../lib/databasedial.php';
            $stmt=$conn->prepare("SELECT book.pic as pic, book.title as title, book_seller.id as bsid, book.book_isbn as isbn, `user`.name as seller, book_seller.price as price, cart.quantity as quantity from ((book_seller INNER JOIN book ON book_seller.book_id = book.id) INNER JOIN `user` ON book_seller.user_id = `user`.id) INNER JOIN cart ON cart.book_seller_id = book_seller.id WHERE cart.user_id = ? and cart.order_uid is null and if_wishlist = 1 ");
            $stmt->bind_param("s", $_SESSION['id'] );
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows != 0) {
                $total=0;
                echo " <table class='table table-striped ml-5 text-center' style='width: 80%'>
                    <thead>
                        <tr class='text-light h5 bg-secondary'>
                            <th></th>
                            <th class='text-center'>Title</th>
                            <th class='text-center'>ISBN</th>
                            <th class='text-center'>Seller</th>
                            <th class='text-center'>Price(&#8377)</th>
                        </tr>
                    </thead>
                    <tbody>";
                while ($row=$result->fetch_assoc()) {
                    $pic="uploads/".$row['pic'];
                    $subtotal= $row['quantity']*$row['price'];
                    $total+=$subtotal;
                    echo "<tr class='mb-5' ><td class='pl-4'>"."<img src='".$pic."' width=66 height=80   >"."</td> <td class='h5 text-success text-center'>"."<a href='book.php?isbn=".$row['isbn'].  "' "." style='text-decoration:none' class='text-success font-weight-bold' >".ucwords($row['title'])."</a>"."</td><td class='text-center' onclick='bookpopup(this.innerHTML)'>".$row['isbn']."</td><td class='text-center'>".$row['seller']."</td><td class='h5 price text-center bg-light'>".$row['price']."</td><td><button name=".$row['bsid']." class='ml-2 btn btn-light movetocart' id=' '>Move to Cart</button><button name=".$row['bsid']." class='ml-2 btn btn-light removeitemwish' id=' '>Remove</button></td></tr>" ;
                }
                echo "
                    
                    </tbody>
                    </table>";
            }
            else {
                echo "<h3 class='pl-3 text-secondary text-center'>Wishlist Empty. Find yours now!</h3>" ;
            }    
        ?>
    </div>

    <?php require_once "../view/footer.php" ?>
    <script type="text/javascript" src="js/js1.js?v=3.9"></script>
</body>
</html>