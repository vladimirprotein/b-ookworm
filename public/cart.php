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
    <link rel="stylesheet" type="text/css" href="css/style.css?v=1.0">
</head>
<body> 
    <header>
        <?php require_once '../lib/header.php'; ?> 
        <?php require_once '../lib/navbar.php'; ?>             
    </header>

    <h3 class="text-success h2 pl-5 mt-1 mb-5 border-success border bg-secondary">Your Cart:</h3>
        <?php
            require '../lib/databasedial.php';
            $stmt=$conn->prepare("SELECT book.pic as pic, book.title as title, book.book_isbn as isbn, `user`.name as seller, book_seller.price as price, cart.quantity as quantity from ((book_seller INNER JOIN book ON book_seller.book_id = book.id) INNER JOIN `user` ON book_seller.user_id = `user`.id) INNER JOIN cart ON cart.book_seller_id = book_seller.id WHERE cart.user_id = ? ");
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
                    echo "<tr class='mb-5'><td>"."<img src='".$pic."' width=66 height=80   >"."</td> <td class='h5 text-success'>".$row['title']."</td><td>".$row['isbn']."</td><td>".$row['seller']."</td><td>".$row['price']."</td><td>".$row['quantity']."</td><td>".$subtotal."</td></tr>" ;
                }
                echo "
                    <tr><td></td><td></td><td></td><td></td><td class='text-success' id='coupon'></td><th class='h5 bg-success border-warning' id='totaltext'>Total:</th><td class='h5 bg-success border-warning' id='totalprice'>".$total."</td>
                    </tbody>
                    </table>";     
            }
            else {
                echo "<h3 class='pl-3 text-secondary'>What!! You still have nothing in your cart!</h3>" ;
            }    
        ?>
                

</body>
</html>    