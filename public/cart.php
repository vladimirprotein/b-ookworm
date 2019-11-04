<!DOCTYPE html>
<?php
	require_once '../lib/onlycustomer.php'; // no entry for a seller session
?>    
<html>
<head>
    <title>BOOKWORM | CART</title>
    <?php require_once "../lib/resource.php"; ?>
</head>
<body> 
    <header>
        <?php require_once '../view/header.php'; ?> 
        <?php require_once '../view/navbar.php'; ?>             
    </header>
    <div class=" container-fluid bookdetails1">
        <h2 class="pt-5 ml-4 mb-4 h2 text-secondary font-italic font-weight-bold">Your Cart:</h2>
        <?php
            require '../lib/databasedial.php';
            $stmt=$conn->prepare("SELECT book.pic as pic, book.title as title, book_seller.id as bsid, book.book_isbn as isbn, `user`.name as seller, book_seller.price as price, cart.quantity as quantity from ((book_seller INNER JOIN book ON book_seller.book_id = book.id) INNER JOIN `user` ON book_seller.user_id = `user`.id) INNER JOIN cart ON cart.book_seller_id = book_seller.id WHERE cart.user_id = ? and cart.order_uid is null ");
            $stmt->bind_param("s", $_SESSION['id'] );
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows != 0) {
                $total=0;
                echo " <table class='table table-striped'>
                    <thead>
                        <tr class='text-light h5 bg-secondary'>
                            <th></th>
                            <th>Title</th>
                            <th>ISBN</th>
                            <th>Seller</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Sub-Total</th>
                        </tr>
                    </thead>
                    <tbody>";
                while ($row=$result->fetch_assoc()) {
                    $pic="uploads/".$row['pic'];
                    $subtotal= $row['quantity']*$row['price'];
                    $total+=$subtotal;
                    echo "<tr class='mb-5' ><td>"."<img src='".$pic."' width=66 height=80   >"."</td> <td class='h5 text-success'>"."<a href='book.php?isbn=".$row['isbn'].  "' "." style='text-decoration:none' class='text-success font-weight-bold' >".ucwords($row['title'])."</a>"."</td><td onclick='bookpopup(this.innerHTML)'>".$row['isbn']."</td><td>".$row['seller']."</td><td class='h5 price'>".$row['price']."</td><td class='h5'><button name=".$row['bsid']." id=' ' oonclick='decrease_qty(this.name)' class=' mr-1 btn btn-light decrease_qty'>-</button><span>".$row['quantity']."</span><button name=".$row['bsid']." id=' ' oonclick='increase_qty(this.name)' class='ml-1 btn btn-light increase_qty'>+</button></td><td class='h5 text-success font-weight-bold subtotal'>".$subtotal."</td><td><button name=".$row['bsid']." class='ml-2 btn btn-light removeitem' id=' ' oonclick='removeitem(this.name)'>Remove</button></td></tr>" ;
                }
                echo "
                    <tr><td></td><td></td><td></td><td></td><td class='text-success' id='coupon'></td><th class='h5 bg-light' id='totaltext'>Total:</th><td class='h4 bg-light' id='totalprice'>".$total."</td>
                    </tbody>
                    </table>";
                echo "
                    <div class='container-fluid pr-5'><a class='float-right mb-5' href='checkout.php'><button class='btn-sm btn-info'>CheckOut</button><i class='fa fa-shopping-bag text-info'></i></a></div>";     
            }
            else {
                echo "<h3 class='pl-3 text-secondary'>What!! You still have nothing in your cart!</h3>" ;
            }    
        ?>
    </div>
    <footer>
        <?php require_once '../view/footer.php'; ?>
    </footer>

    <script type="text/javascript" src="js/js1.js?v=3.4"></script>
                

</body>
</html>    