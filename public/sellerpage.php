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
        <?php require_once '../view/header.php';
              require_once '../view/navbar.php'; ?>
    </header>
    <?php
        $title = $isbn = $qty = $price = $author= $genre= $tag= $image= $titleErr= $isbnErr= $qtyErr= $priceErr= $authorErr= $genreErr= $imageErr= $return_data= "";
        $is_error=false;
        if (isset($_POST["submit"])) { //will enter this block if the form is submitted with method POST
            
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
            if(empty($_POST['author'])){
                $authorErr= "Author Name(s) required";
                $is_error= true;
            }
            else{
                $author= test_input($_POST['author']);
                $authors= explode(",", $author);
            }
            if(empty($_POST['genre'])){
                $genreErr= "Genre(s) required";
                $is_error= true;
            }
            else{
                $genre= test_input($_POST['genre']);
                $genres= explode(",", $genre);
            }
            if(empty($_POST['tag'])){
                ;
            }
            else{
                $tag= test_input($_POST['tag']);
                $tags= explode(",", $tag);
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
                    for($i=0; $i<sizeof($authors); $i++){
                        $stmt3= $conn->prepare("INSERT INTO author(name, created_at) VALUES(?,?)");
                        $stmt3->bind_param("ss", $authors[$i], $created_at);
                        if($stmt3->execute()){
                            $last = $conn->insert_id;
                            $stmt4 = $conn->prepare("INSERT INTO book_author(author_id, book_id, created_at) VALUES(?,?,?)");
                            $stmt4->bind_param("iis", $last, $last_id, $created_at);
                            $stmt4->execute();
                        }
                        else{
                            $stmt5= $conn->prepare("SELECT id from author where name=?");
                            $stmt5->bind_param("s", $authors[$i]);
                            $stmt5->execute();
                            $row= $stmt5->get_result()->fetch_assoc();
                            $stmt6 = $conn->prepare("INSERT INTO book_author(author_id, book_id, created_at) VALUES(?,?,?)");
                            $stmt6->bind_param("iis", $row['id'], $last_id, $created_at);
                            $stmt6->execute();
                        }
                    }
                    for($i=0; $i<sizeof($genres); $i++){
                        $stmt3= $conn->prepare("INSERT INTO genre(name, created_at) VALUES(?,?)");
                        $stmt3->bind_param("ss", $genres[$i], $created_at);
                        if($stmt3->execute()){
                            $last = $conn->insert_id;
                            $stmt4 = $conn->prepare("INSERT INTO book_genre(genre_id, book_id, created_at) VALUES(?,?,?)");
                            $stmt4->bind_param("iis", $last, $last_id, $created_at);
                            $stmt4->execute();
                        }
                        else{
                            $stmt5= $conn->prepare("SELECT id from genre where name=?");
                            $stmt5->bind_param("s", $genres[$i]);
                            $stmt5->execute();
                            $row= $stmt5->get_result()->fetch_assoc();
                            $stmt6 = $conn->prepare("INSERT INTO book_genre(genre_id, book_id, created_at) VALUES(?,?,?)");
                            $stmt6->bind_param("iis", $row['id'], $last_id, $created_at);
                            $stmt6->execute();
                        }
                    }
                    if(!empty($_POST['tag'])){
                        for($i=0; $i<sizeof($tags); $i++){
                            $stmt3= $conn->prepare("INSERT INTO tag(name, created_at) VALUES(?,?)");
                            $stmt3->bind_param("ss", $tags[$i], $created_at);
                            if($stmt3->execute()){
                                $last = $conn->insert_id;
                                $stmt4 = $conn->prepare("INSERT INTO book_tag(tag_id, book_id, created_at) VALUES(?,?,?)");
                                $stmt4->bind_param("iis", $last, $last_id, $created_at);
                                $stmt4->execute();
                            }
                            else{
                                $stmt5= $conn->prepare("SELECT id from tag where name=?");
                                $stmt5->bind_param("s", $tags[$i]);
                                $stmt5->execute();
                                $row= $stmt5->get_result()->fetch_assoc();
                                $stmt6 = $conn->prepare("INSERT INTO book_tag(tag_id, book_id, created_at) VALUES(?,?,?)");
                                $stmt6->bind_param("iis", $row['id'], $last_id, $created_at);
                                $stmt6->execute();
                            }
                        }
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
    <div class="container-fluid bookdetails1">
        <div class="row mb-4 pl-3 pt-3">
            <div class="col-sm-4 mt-4">
                <button class=" btn-success mb-5"><a href="orderdashboard.php" style="text-decoration: none" class="text-dark">ORDER DASHBOARD</a></button><br>
                <button class=" btn-success mb-5"><a href="orderdashboard.php" style="text-decoration: none" class="text-dark">ORDER DASHBOARD</a></button><br>
                <button class=" btn-success mb-5"><a href="orderdashboard.php" style="text-decoration: none" class="text-dark">ORDER DASHBOARD</a></button><br>
                <button class=" btn-success mb-5"><a href="orderdashboard.php" style="text-decoration: none" class="text-dark">ORDER DASHBOARD</a></button><br>
                <h4 class="text-success font-weight-bold">Add to your stock:</h4>
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data" class=" bg-light pl-4 pr-4 pb-2 pt-4 rounded">
                    <div class="form-group">
                        ISBN:<small class="text-danger">     * <?php echo $isbnErr;?></small>
                        <input type="text" name="isbn" placeholder="Enter ISBN" class="form-control">
                    </div>
                    <div class="form-group">
                        Book Title:<small class="text-danger">     * <?php echo $titleErr;?></small>
                        <input type="text" name="title" placeholder="Enter title" class="form-control">
                    </div>
                    <div class="form-group">
                        Author(s):<small class="text-danger">     * <?php echo $authorErr;?></small>
                        <input type="text" name="author" placeholder="Enter Author(s) -separated by comma" class="form-control">
                    </div>
                    <div class="form-group">
                        Genre(s):<small class="text-danger">     * <?php echo $genreErr;?></small>
                        <input type="text" name="genre" placeholder="Enter Genre(s) -separated by comma" class="form-control">
                    </div>
                    <div class="form-group">
                        Tag(s):<small class="text-danger"></small>
                        <input type="text" name="tag" placeholder="Enter Tag(s) -separated by comma" class="form-control">
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
            </div>
            <div class="col-sm-8 pl-4 mt-4">
                <h4 class="text-success font-weight-bold">Your Stock:</h4>
                <table class="table table-striped table-hover">
                    <thead>
                        <tr class="bg-success h5">
                            <th></th>
                            <th class="text-center">Name</th>
                            <th class="text-center">ISBN</th>
                            <th class="text-center">Quantity</th>
                            <th class="text-center">Price(&#8377)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            require '../lib/databasedial.php';
                            $stmt=$conn->prepare("SELECT title, pic, book_isbn, quantity, price from book INNER JOIN book_seller on `book`.id=book_seller.book_id AND user_id=?");//showing the stock of the seller
                            $stmt->bind_param("s", $_SESSION['id']);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            if ($result->num_rows != 0) {
                                while ($row=$result->fetch_assoc()) {
                                    $pic = "uploads/".$row['pic'];
                                    echo "<tr><td class='bg-light text-center'><img src='".$pic."' width='40px' height='55px'></td>  <td class='font-weight-bold text-center '><a href='book.php?isbn=".$row['book_isbn']."' style='text-decoration:none;' class='text-dark'>".ucwords($row['title'])."</a></td><td class='text-center'>".$row['book_isbn']."</td><td class='text-center'>".$row['quantity']."</td><td class='text-center bg-light'>".$row['price']."</td></tr>" ;
                                }        
                            }    
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?php require_once '../view/footer.php'; ?>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>