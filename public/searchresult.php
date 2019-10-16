<!DOCTYPE html>
<?php
    session_start();
    if (!isset($_GET['search'])){
        header('Location: index.php');
        exit();
    }
    else{
        $search = $searchErr = "";
        if(empty($_GET["search"])){
            $searchErr='Enter Something';
            header('Location: index.php');
            exit();
        }
        else{
            $search=strtolower(test_input($_GET["search"]));
            $searchfinal="%$search%";
        }
    }
    function test_input($data) { // custom function for refining user input string
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
?>    
<html>
<head>
    <title>BOOKWORM | Search</title>
    <?php require_once "../lib/resource.php" ?>
</head>
<body> 
    <header>
        <?php require_once '../view/header.php'; ?>
        <?php require_once '../view/navbar.php'; ?>  
    </header>
    <div class="row bookdetails1">
        <div class="container-fluid mt-4 col-sm-11">
            <h3 class=" pl-3 mb-5 border border-dark">Here's what we have:</h3>
            <h6 class="pl-3 mb-3">Search result for: <?php echo $search ; ?></h6>
            <?php
                require '../lib/databasedial.php';
                $stmt=$conn->prepare("SELECT book.pic as pic, book.title as title, book.book_isbn as isbn, `user`.name as seller, book_seller.price as price from (book_seller INNER JOIN book ON book_seller.book_id = book.id) INNER JOIN `user` ON book_seller.user_id = `user`.id where title LIKE ? order by title ");
                $stmt->bind_param("s", $searchfinal );
                $stmt->execute();
                $result = $stmt->get_result();
                if ($result->num_rows != 0) {
                    echo "
                    <table class='table table-striped table-hover'>
                        <thead>
                            <tr class='text-warning h5 bg-dark border-warning'>
                                <th></th>
                                <th>Title</th>
                                <th>ISBN</th>
                                <th>Price<span class='h6'>(INR)</span></th>
                                <th>Seller</th>
                            </tr>
                        </thead>
                        <tbody> ";
                            while ($row=$result->fetch_assoc()) {
                                $pic="uploads/".$row['pic'];
                                echo "<tr class='mb-5'><td>"."<img src='".$pic."' width=66 height=80>"."</td> <td class='h5 text-success'>"."<a href='book.php?isbn=".$row['isbn'].  "' "." style='text-decoration:none' class='text-success' >".ucwords($row['title'])."</a>"."</td><td onclick='bookpopup(this.innerHTML)'>".$row['isbn']."</td><td>".$row['price']."</td><td>".$row['seller']."</td></tr>" ;
                            }
                        echo "
                        </tbody>
                    </table>";  
                }
                else{
                    echo "<h3 class='pl-3 text-secondary'>Sorry :(  <br> <br>    Looks like your taste in book is better than ours..</h3>" ;
                }  
            ?>      
        </div>
    </div>
    <?php require_once '../view/footer.php'; ?>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script type="text/javascript" src="js/js1.js?v=2.2"></script>
</body>     
</html>