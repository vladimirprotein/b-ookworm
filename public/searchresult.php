<!DOCTYPE html>
<?php
    session_start();
    if (!isset($_GET['search'])){
        header('Location: index.php');
        exit();
    }
    else{
        $search = $searchErr = "";
        $search = trim($_GET['search']);
        if(strlen($search) < 3){
            $searchErr='Enter 3+ characters';
            header('Location: index.php');
            exit();
        }
        else{
            $search=strtolower(test_input($search));
            $searchfinal="%$search%";
        }
    }
    require_once "../lib/databasedial.php";
    if(strlen($search) >= 3){
        $stmt = $conn->prepare("INSERT INTO searches(user_id, search) values (?, ?)");
        $stmt->bind_param("is", $_SESSION['id'], $search);
        $stmt->execute();
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
            <h3 class=" pl-3 mb-5 font-italic">Here's what we have:</h3>
            <h6 class="pl-3 mb-3">Search result for: <?php echo $search ; ?></h6>
            <?php
                $stmt=$conn->prepare("SELECT book.pic, book.title, book.book_isbn as isbn, min( book_seller.price) as price, GROUP_CONCAT(DISTINCT author.name) as author, GROUP_CONCAT(distinct user.name) as seller from book_author join book ON book_author.book_id = book.id
                    JOIN author on book_author.author_id = author.id
                    JOIN book_seller on book_seller.book_id = book.id
                    JOIN `user` on user.id = book_seller.user_id
                    WHERE book.title LIKE ? OR author.name LIKE ?
                    GROUP BY book.book_isbn
                    ORDER BY title");
                $stmt->bind_param("ss", $searchfinal, $searchfinal);
                $stmt->execute();
                $result = $stmt->get_result();
                if ($result->num_rows != 0) {
                    echo "
                    <table class='table table-striped table-hover'>
                        <thead>
                            <tr class='text-light h5 bg-secondary'>
                                <th class='text-center'></th>
                                <th class='text-center'>Title</th>
                                <th class='text-center'>Author(s)</th>
                                <th class='text-center'>ISBN</th>
                                <th class='text-center'>Price</th>
                                <th class='text-center'>Seller</th>
                            </tr>
                        </thead>
                        <tbody> ";
                    while ($row=$result->fetch_assoc()) {
                        $pic="uploads/".$row['pic'];
                        echo "<tr class='mb-5'><td class='text-center'>"."<img src='".$pic."' width=66 height=80>"."</td> <td class='h5 text-success text-center'>"."<a href='book.php?isbn=".$row['isbn'].  "' "." style='text-decoration:none' class='text-success' >".ucwords($row['title'])."</a>"."</td><td class='text-center'>".ucwords(str_replace(",","<br>",$row['author']))."</td><td class='text-center' onclick='bookpopup(this.innerHTML)'>".$row['isbn']."</td><td class='text-center font-weight-bold bg-secondary'>&#8377 ".$row['price']."</td><td class='bg-light text-center'>".str_replace(",","<br>",$row['seller'])."</td></tr>" ;
                    }
                    echo "
                    </tbody>
                    </table>";  
                }
                else{
                    echo "<h3 class='pl-3 text-secondary'>Sorry :(  <br> <br>    Looks like your taste in book is better than ours..</h3>";
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



<!-- SELECT book.pic, book.title, book.book_isbn, min( book_seller.price), GROUP_CONCAT(DISTINCT author.name) as author_name, GROUP_CONCAT(distinct user.name) from book_author join book ON book_author.book_id = book.id
JOIN author on book_author.author_id = author.id
JOIN book_seller on book_seller.book_id = book.id
JOIN `user` on user.id = book_seller.user_id
WHERE book.title LIKE '%eng%' OR author.name LIKE '%eng%'
GROUP BY book.book_isbn -->