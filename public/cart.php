<!DOCTYPE html>
<?php
	require_once '../lib/onlycustomer.php'; // no entry for a seller session
?>    
<html>
<head>
    <title>BOOKWORM | CART</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="css/fontawesome.css">
    <link rel="stylesheet" type="text/css" href="css/style.css?v=2.2">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.js" integrity = "sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>
</head>
<body> 
    <header>
        <?php require_once '../view/header.php'; ?> 
        <?php require_once '../view/navbar.php'; ?>             
    </header>
    <div class=" container-fluid">
        <marquee class=" mt-3 ml-4 mb-4 border-bottom h2 border text-secondary">Your Cart</marquee>
        <?php
            require '../lib/databasedial.php';
            $stmt=$conn->prepare("SELECT book.pic as pic, book.title as title, book_seller.id as bsid, book.book_isbn as isbn, `user`.name as seller, book_seller.price as price, cart.quantity as quantity from ((book_seller INNER JOIN book ON book_seller.book_id = book.id) INNER JOIN `user` ON book_seller.user_id = `user`.id) INNER JOIN cart ON cart.book_seller_id = book_seller.id WHERE cart.user_id = ? ");
            $stmt->bind_param("s", $_SESSION['id'] );
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows != 0) {
                $total=0;
                echo " <table class='table table-striped'>
                    <thead>
                        <tr class='text-warning h5 bg-dark border-warning'>
                            <th></th>
                            <th>Title</th>
                            <th>ISBN</th>
                            <th>Seller</th>
                            <th>Price<span class='h6'>(INR)</span></th>
                            <th>Quantity</th>
                            <th>Sub-Total<span class='h6'>(INR)</span></th>
                        </tr>
                    </thead>
                    <tbody>";
                while ($row=$result->fetch_assoc()) {
                    $pic="uploads/".$row['pic'];
                    $subtotal= $row['quantity']*$row['price'];
                    $total+=$subtotal;
                    echo "<tr class='mb-5'><td>"."<img src='".$pic."' width=66 height=80   >"."</td> <td class='h5 text-success'>"."<a href='book.php?isbn=".$row['isbn'].  "' "." style='text-decoration:none' class='text-success' >".ucwords($row['title'])."</a>"."</td><td onclick='bookpopup(this.innerHTML)'>".$row['isbn']."</td><td>".$row['seller']."</td><td class='h5 price'>".$row['price']."</td><td class='h5'><button name=".$row['bsid']." id=' ' oonclick='decrease_qty(this.name)' class=' mr-1 btn decrease_qty'>-</button><span>".$row['quantity']."</span><button name=".$row['bsid']." id=' ' oonclick='increase_qty(this.name)' class='ml-1 btn  increase_qty'>+</button></td><td class='h5 text-success subtotal'>".$subtotal."</td><td><button name=".$row['bsid']." class='ml-2 btn btn-warning removeitem' id=' ' oonclick='removeitem(this.name)'>Remove</button></td></tr>" ;
                }
                echo "
                    <tr><td></td><td></td><td></td><td></td><td class='text-success' id='coupon'></td><th class='h5 bg-success border-warning' id='totaltext'>Total:</th><td class='h4 bg-success border-warning' id='totalprice'>".$total."</td>
                    </tbody>
                    </table>";     
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