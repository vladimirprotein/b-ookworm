<!DOCTYPE html>
<?php
	require_once '../lib/noseller.php'; // no entry for a seller session
?>    
<html>
<head>
    <title>BOOKWORM | Home</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="css/fontawesome.css">
    <link rel="stylesheet" type="text/css" href="css/style.css?v=1.0">
</head>
<body> 
    <header>
        <?php require_once '../view/header.php'; ?> 
        <?php require_once '../view/navbar.php'; ?>             
    </header>
    <section id="showcase">
        <div class="container-fluid pb-5">
            <div class="row">
                <div class="col-md-4">
                    <aside class=" pl-1 pr-1">
                        <ul class="list-group">
                            <li class="mb-4 mt-4">
                            	<div class="btn-group dropright">
		                            <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		                            Books
		                            </button>
		                            <div class="dropdown-menu">
		                                <ul class="list-group">       <!-- Dropdown menu links -->
			                                <li class="list-group-item list-group-item-secondary"><a href="categories.php?genre=fiction"><button type="button" class="btn">Fiction</button></a></li>
			                                <li class="list-group-item list-group-item-secondary "><a href="categories.php?genre=literature"><button type="button" class="btn">Literature</button></a></li>
			                                <li class="list-group-item list-group-item-secondary"><a href="categories.php?genre=engineering "><button type="button" class="btn">Engineering</button></a></li>
			                                <li class="list-group-item list-group-item-secondary"><a href="categories.php?genre=biography"><button type="button" class="btn">Biography</button></a></li>
			                                <li class="list-group-item list-group-item-secondary"><a href="categories.php?genre=sports"><button type="button" class="btn">Sports</button></a></li>
			                                <li class="list-group-item list-group-item-secondary"><a href="categories.php?genre=language"><button type="button" class="btn">Language</button></a></li>
			                                <li class="list-group-item list-group-item-secondary"><a href="categories.php?genre=art"><button type="button" class="btn">Art</button></a></li>
		                                </ul>
		                            </div>
	                            </div>
                        	</li>
                            <li class="mb-4"><a href=""><button type="button" class="btn btn-secondary op10">New Arrivals</button></a></li>
                            <li class="mb-4"><a href=""><button type="button" class="btn btn-secondary op10">Pre-order</button></a></li>
                            <li class="mb-4"><a href="categories.php?tag=textbook"><button type="button" class="btn btn-secondary op10">Text-Book</button></a></li>
                            <li class="mb-4"><a href="categories.php?tag=best+seller"><button type="button" class="btn btn-secondary op10">Best Sellers</button></a></li>
                            <li class="mb-4"><a href=""><button type="button" class="btn btn-secondary op10">Award Winners</button></a></li>
                            <li class="mb-4"><a href=""><button type="button" class="btn btn-secondary op10">Featured Authors</button></a></li>
                            <li class="mb-4"><a href=""><button type="button" class="btn btn-secondary op10">Book of the Day</button></a></li>
                        </ul> 
                    </aside>
                </div>
                <div class="col-md-8">
                    <div class="container">
                        <h1 class="pt-3 text-center"><div class="spinner-grow text-muted"></div>This is where you get'em all!<div class="spinner-grow text-muted"></div></h1><br>
                        <p class="text-center para ">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam eu luctus ipsum, rhoncus semper magna. Nulla nec magna sit amet sem interdum condimentum. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                        tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                        quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                        consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                        cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                        proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php require_once '../view/footer.php'; ?>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>