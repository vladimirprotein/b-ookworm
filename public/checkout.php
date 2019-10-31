<!DOCTYPE html>
<?php
	require_once '../lib/onlycustomer.php'; // no entry for a seller session
?>    
<html>
<head>
    <title>BOOKWORM||CHECKOUT</title>
    <?php require_once "../lib/resource.php"; ?>
    
</head>
<body> 
    <header>
        <?php require_once '../view/header.php'; ?> 
        <?php require_once '../view/navbar.php'; ?>             
    </header>
    <div class="bookdetails1 container-fluid  pl-4 row pt-4">
    	<div class="pl-4 col-sm-7">
            <form method="POST" action="orderpage.php">
                <div class="form-group">
                    <h4>Select Address:</h4>
                    <?php
                        require_once "../lib/databasedial.php";
                        $stmt = $conn->prepare("SELECT * FROM address INNER JOIN pincode ON address.pin = pincode.pin WHERE address.user_id =".$_SESSION['id']);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        if($result->num_rows != 0){
                            while($row = $result->fetch_assoc()){
                                echo "<label class='bg-info rounded pl-3 pt-3 pb-3 pr-3 mb-1'><input type='radio' class='' name='address' value='".$row['id']."' checked>"."<div class='ml-3'>".$row['name']."<br>".$row['addr1'].", ".$row['addr2']." ".$row['addr3']."<br>".$row['city'].", ".$row['district'].", ".$row['state'].", PIN: ".$row['pin']."<br>"."Contact: ".$row['contact']."</div></label><br>";
                            }
                        }
                        else{
                            echo "no address";
                        }
                    ?>
                </div>
                <div class="form-group">
                    PAYMENT MODE: Cash on Delivery
                </div>
                <div class="form-group">
                    <input type="submit" name="placeorder" id="placeorder" value="Place Order" class="btn btn-secondary mt-5">
                </div>
            </form>   
        </div>
        <div class="col-sm-5">
            <h4>Order Summary:</h4>
            <?php
                $stmt=$conn->prepare("SELECT book.pic as pic, book.title as title, book_seller.id as bsid, book.book_isbn as isbn, `user`.name as seller, book_seller.price as price, cart.quantity as quantity from ((book_seller INNER JOIN book ON book_seller.book_id = book.id) INNER JOIN `user` ON book_seller.user_id = `user`.id) INNER JOIN cart ON cart.book_seller_id = book_seller.id WHERE cart.user_id = ? and cart.order_uid is null ");
                $stmt->bind_param("s", $_SESSION['id'] );
                $stmt->execute();
                $result = $stmt->get_result();
                if ($result->num_rows != 0) {
                    $total=0;
                    echo " <table class='table table-striped'>
                        
                        <tbody>";
                    while ($row=$result->fetch_assoc()) {
                        $pic="uploads/".$row['pic'];
                        $subtotal= $row['quantity']*$row['price'];
                        $total+=$subtotal;
                        echo "<tr class='mb-5 bg-light' style=''><td>"."<img src='".$pic."' width=66 height=80   >"."</td> <td class='h5 text-success'>"."<a href='book.php?isbn=".$row['isbn'].  "' "." style='text-decoration:none' class='text-secondary font-weight-bold' >".ucwords($row['title'])."</a>"."<td>X ".$row['quantity']."</td><td class='h5 text-secondary subtotal'>".$subtotal."</td></tr>" ;
                    }
                    if($total > 500){
                        $delivery = 0;
                    }
                    else{
                        $delivery = 40;
                        $total += 40;
                    }
                    echo "
                        <tr><td></td><td class='text-success'></td><th class=' bg-light' id='totaltext'>Delivery:</th><td class='h4 bg-light'>".$delivery."</td></tr>
                        <tr><td></td><td class='text-success' id='coupon'></td><th class=' bg-light' id='totaltext'>Amount:</th><td class='h4 bg-light text-success font-weight-bold' id='totalprice'>".$total."</td></tr>
                        </tbody>
                        </table>";  
                }
                else {
                    echo "<h3 class='pl-3 text-secondary'>What!! You still have nothing in your cart!</h3>" ;
                }    
            ?>


        </div>
    </div>
    <footer>
    	<?php require_once "../view/footer.php"; ?>
    </footer>
</body>
</html>