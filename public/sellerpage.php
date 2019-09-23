<!DOCTYPE html>
<?php
    require_once '../lib/onlyseller.php'; // no entry without a seller session
?>    
<html>
<head>
    <title>BOOKWORM | SELLER</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="css/fontawesome.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
    <header>
        <?php require_once '../view/header.php'; ?>
    </header>
    <?php
        if (isset($_POST["submit"])) { //will enter this block if the form is submitted with method POST
            $title = $isbn = $qty = $price = $image= $titleErr= $isbnErr= $qtyErr= $priceErr= $imageErr= $return_data= "";
            $is_error=false;
            $imagename= $_FILES['image']['name'];
            $imagetmpname= $_FILES['image']['tmp_name'];
            $imagenamenew= uniqid()."-".$imagename;
            $imagedestination= "uploads/".$imagenamenew;
            $allowed = array('jpg','jpeg', 'gif', 'png');
            $imagetype= strtolower(pathinfo($imagedestination,PATHINFO_EXTENSION));
            if (empty($_POST["title"])) { // if title is left empty
                $titleErr= " Title Required";
                $is_error=true;
            }
            else{
                $title=strtolower(test_input($_POST['title']));
            }
            if (empty($_POST["isbn"])) { // if isbn is left empty
                $isbnErr= " ISBN Required";
                $is_error=true;
            }
            else{
                $isbn=strtolower(test_input($_POST['isbn']));
            }
            if (empty($_POST["qty"])) { // if quantity is left empty
                $qtyErr= " Quantity Required";
                $is_error=true;
            }
            else{
                $qty=test_input($_POST['qty']);
            }
            if (empty($_POST["price"])) { // if price is left empty
                $priceErr= " Price Required";
                $is_error=true;
            }
            else{
                $price=test_input($_POST['price']);
            }
            if (!empty($_FILES["image"]["name"])) { 
                if(!in_array($imagetype, $allowed)){
                    $imageErr = 'Only JPG, JPEG, PNG, GIF files are allowed.';
                    $is_error=true;
                }
                else{
                    if ($_FILES["image"]["size"] > 500000) {
                        $imageErr= "Sorry, your file is too large.";
                        $is_error=true;
                    }
                    else{
                        if (!move_uploaded_file($imagetmpname, $imagedestination)) {
                            $imageErr= "Upload Error.";
                            $is_error=true;
                        }
                    }     
                }
            }
            else{
                $imagenamenew= NULL;
            }
            if (!$is_error) { // if all entries are alright
                require "../lib/databasedial.php"; // establishing database connection
                $created_at=date("Y-m-d",time());
                $stmt=$conn->prepare(" INSERT INTO book(book_isbn, title, pic, created_at) values(?,?,?,?)");//inserting data into book table
                $stmt->bind_param("ssss",$isbn, $title, $imagenamenew , $created_at); 
                if ($stmt->execute()) { // if data was successfully inserted into book table 
                    $last_id = $conn->insert_id; // getting the book id which was inserted just now
                    $stmt2=$conn->prepare(" INSERT INTO book_seller(book_id, user_id, quantity, price, created_at) values(?,?,?,?,?)");// inserting data into book-seller table
                    $stmt2->bind_param("iiiis",$last_id, $_SESSION['id'], $qty, $price, $created_at);
                    if ($stmt2->execute()) { //if the data is successfully inserted into book-seller table
                        $return_data= 'Successful New Entry';
                    }
                    else{
                        $return_data= "Daaaaaaaaaaa" ;
                    }
                }
                else { // if data couldn't enter the book table coz it was already present in there
                    $stmt3=$conn->prepare(" SELECT id from `book` where book_isbn=?"); //getting the id of that existing book
                    $stmt3->bind_param("s",$isbn);
                    $stmt3->execute();
                    $result = $stmt3->get_result();
                    $row=$result->fetch_assoc();
                    $id1=$row['id']; // storing the book id

                    $stmt4=$conn->prepare(" INSERT INTO book_seller(book_id, user_id, quantity, price, created_at) values(?,?,?,?,?)"); // inserting data into book-seller table
                    $stmt4->bind_param("iiiis",$id1, $_SESSION['id'], $qty, $price, $created_at);
                    if ($stmt4->execute()) {// if data is successfully entered
                        $return_data= 'Successful Entry';
                    }
                    else{// if entry wasn't successful coz it was already present in there
                        $stmt5=$conn->prepare(" UPDATE `book_seller` SET quantity=quantity+?, updated_at=? WHERE book_id=? and user_id=? and price=?  ");// adding the quantity to the existing qty available with seller
                        $stmt5->bind_param("isiii",$qty, $created_at, $id1, $_SESSION['id'], $price);
                        if ($stmt5->execute()) {
                            $return_data= "Quantity Updated";
                        }
                    }      
                }
                $conn->close();
            }    
        }
        function test_input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }   
    ?>
    <div class="row">
        <div class="col-sm-6 pl-4 mt-4 border">
            <h4 class="text-success border-bottom">Your Stock:</h4>
            <table class="table table-dark table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>ISBN</th>
                        <th>qty</th>
                        <th>price</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        require '../lib/databasedial.php';
                        $stmt=$conn->prepare("SELECT title, book_isbn, quantity, price from book INNER JOIN book_seller on `book`.id=book_seller.book_id AND user_id=?");//showing the stock of the seller
                        $stmt->bind_param("s", $_SESSION['id']);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        if ($result->num_rows != 0) {
                            while ($row=$result->fetch_assoc()) {
                                echo "<tr><td></td>  <td>".$row['title']."</td><td>".$row['book_isbn']."</td><td>".$row['quantity']."</td><td>".$row['price']."</td></tr>" ;
                            }        
                        }    
                    ?>
                </tbody>
            </table>
        </div>
        <div class="col-sm-6 pl-4 mt-4 border">
            <h4 class="text-primary border-bottom">Add to your stock:</h4>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data" class="col-sm-8 float-right bg-light">
                <div class="form-group">
                    Book Title:<small class="text-danger">     * <?php echo $titleErr;?></small>
                    <input type="text" name="title" placeholder="Enter title" class="form-control">
                </div>
                <div class="form-group">
                    ISBN:<small class="text-danger">     * <?php echo $isbnErr;?></small>
                    <input type="text" name="isbn" placeholder="Enter ISBN" class="form-control">
                </div>
                <div class="form-group">
                    Quantity:<small class="text-danger">     * <?php echo $qtyErr;?></small>
                    <input type="number" name="qty" placeholder="Enter quantity" class="form-control">
                </div>
                <div class="form-group">
                    Price:<small class="text-danger">     * <?php echo $priceErr;?></small>
                    <input type="number" name="price" placeholder="Enter price" class="form-control">
                </div>
                <div class="form-group">
                    Add Image:<small class="text-danger">   <?php echo $imageErr;?></small>
                    <input class="" type="file" name="image">
                </div>
                <div class="form-group">
                    <input type="submit" name="submit" value="Update" class="text-success">
                </div>
            </form> 
            <?php
                echo "<h6 class='text-danger'>$return_data</h6>";
            ?>    
        </div>
    </div>
    <?php require_once '../view/footer.php'; ?>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>