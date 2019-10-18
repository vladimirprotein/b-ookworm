<!DOCTYPE html>
<?php
	error_reporting(0);
	require_once "../lib/onlysession.php";
?>
<html>
<head>
	<title>PROFILE</title>
	<?php require_once "../lib/resource.php"; ?>
</head>
<body>
	<header class="">
    	<?php require_once '../view/header.php'; ?> 
    	<?php require_once '../view/navbar.php'; ?>
  	</header>
  	<div class="container-fluid bookdetails1">
  		<div class="row pt-4">
  			<div class="col-sm-6 pl-4">
  				<li class="mb-3 "><button type="button" class="btn-sm btn-success" data-toggle="modal" data-target="#myModal">
  				Change Password
				</button></li>

				<!-- The Modal -->
				<div class="modal fade" id="myModal">
  					<div class="modal-dialog">
						<div class="modal-content" style="background: linear-gradient(rgba(255,255,255,.5), rgba(255,255,255,.5)), url('img/passbg.png');">

  							<!-- Modal Header -->
  							<div class="modal-header">
    							<h4 class="modal-title text-italic text-success">Change Your Password:</h4>
    							<button type="button" class="close" data-dismiss="modal">&times;</button>
  							</div>
  
  							<!-- Modal body -->
  							<div class="modal-body">
    							<form>
    								<div class="form-group">
    									Old Password:<small class="text-danger" id="oldpassErr">*</small>
    									<input type="Password" id="oldpassword" class="form-control bg-warning" required>
    								</div>
                  					<div class="form-group">
                    					New Password:<small class="text-danger" id="newpassErr">*</small>
                    					<input type="Password" id="newpassword" class="form-control bg-light" required>
                  					</div>
                  					<div class="form-group">
                    					Re-Enter New Password:<small class="text-danger" id="newpass2Err">*</small>
                    					<input type="Password" id="newpassword2" class="form-control bg-light" onkeyup='match_field(this.id, "newpassword", "newpass2Err", "submit5")' required>
                  					</div>
                  					<div class="form-group">
                    					<input type="button" name="submit" id="submit5" value="Update" class="form-control btn-sm btn-primary">
                  					</div>
    							</form>
  							</div>
  
  							<!-- Modal footer -->
  							<div class="modal-footer">
    							<p class="text-success font-weight-bold" id="passwordmessage"></p>
  							</div>
  
						</div>
  					</div>
				</div>
  			</div>
  			<div class="col-sm-6">
  				
  				
  			</div>
  		</div>
  	</div>
  	<footer>
  		<?php require_once "../view/footer.php"; ?>
  	</footer>