<!DOCTYPE html>
<?php
	$genre = $_GET['genre'];
	$tag = $_GET['tag'];
 ?>
<html>
<head>
	<title></title>
	<?php require_once "../lib/resource.php" ?>
</head>
<body>
	<header>
        <?php require_once '../view/header.php'; ?>
        <?php require_once '../view/navbar.php'; ?>  
    </header>
    <div class="bookdetails1 container-fluid pl-4 pt-4 pb-4">
    	<h2 class=" text-center mb-5"><?php echo ucwords($genre); ?></h2>
    	<div class="row">
    		<div class="col-sm-2 pl-1 pr-1 bg-info pr-2">
    			Sidebar
    		</div>
    		<div class="col-sm-10 row pl-4">
    			<?php
    				require_once "../lib/databasedial.php";
    				$stmt = $conn->prepare("SELECT book.pic, book.title, book.book_isbn as isbn, min( book_seller.price) as price, GROUP_CONCAT(DISTINCT author.name) as author, GROUP_CONCAT(distinct user.name) as seller, GROUP_CONCAT(DISTINCT genre.name) as genre from book_author join book ON book_author.book_id = book.id
	                    JOIN author on book_author.author_id = author.id
	                    JOIN book_seller on book_seller.book_id = book.id
	                    JOIN `user` on user.id = book_seller.user_id
	                    JOIN book_genre on book_genre.book_id = book.id
	                    JOIN genre on book_genre.genre_id = genre.id
	                    WHERE genre.name = '$genre'
	                    GROUP BY book.book_isbn
	                    ORDER BY title");
                    $stmt->execute();
                    $result = $stmt->get_result();
                    if($result->num_rows > 0){
                    	while ($row = $result->fetch_assoc()) {
                    		echo 
                    		"<div class='col-sm-3 pl-1 pr-1 mb-2 mt-2 text-center pt-2 pb-2'>
                    			<img src='uploads/".$row['pic']."' width=150 height=190>
                    			<div class='bg-success mt-1 pt-1 pb-1 font-weight-bold'><a href='book.php?isbn=".$row['isbn']."' style='text-decoration: none' class='text-light'>".ucwords($row['title'])."</a></div>
                    			<div class='bg-light mt-1' style='margin-top:0'>ISBN: ".$row['isbn']."</div>
                    			<div class='bg-light mt-1' style='margin-top:0'>Seller: ".$row['seller']."</div>
                    			<div class='bg-light font-weight-bold h5 text-success mt-1' style='margin-top:0'><span>&#8377</span>".$row['price']."</div>
                    		</div>";
                    	}
                    }
    			?>
    		</div>
    	</div>
    </div>
    <?php require_once '../view/footer.php'; ?>
</body>
</html>