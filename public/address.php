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
  				<li class="mb-3 "><button type="button" class="btn-sm btn-success" data-toggle="modal" data-target="#myAddress">
  				Add New Address
				</button></li>

				<!-- The Modal -->
				<div class="modal fade" id="myAddress">
  					<div class="modal-dialog">
						<div class="modal-content" style="background: linear-gradient(rgba(255,255,255,.5), rgba(255,255,255,.5)), url('img/passbg.png');">

  							<!-- Modal Header -->
  							<div class="modal-header">
    							<h4 class="modal-title text-italic text-success">Add new Address:</h4>
    							<button type="button" class="close" data-dismiss="modal">&times;</button>
  							</div>
  
  							<!-- Modal body -->
  							<div class="modal-body">
    							<form>
    								<div class="form-group">
    									Name:<small class="text-danger" id="name1Err">*</small>
    									<input type="text" id="name1" class="form-control" required>
    								</div>
    								<div class="form-group">
    									Address Line 1:<small class="text-danger" id="addline1Err">*</small>
    									<input type="text" id="addline1" class="form-control" required>
    								</div>
                  					<div class="form-group">
                    					Address Line 2:<small class="text-danger" id="addline2Err"></small>
                    					<input type="text" id="addline2" class="form-control bg-light">
                  					</div>
                  					<div class="form-group">
                    					Address Line 3:<small class="text-danger" id="addline3Err"></small>
                    					<input type="text" id="addline3" class="form-control bg-light">
                  					</div>
                  					<div class="form-group">
    									Contact Number:<small class="text-danger" id="contactErr">*</small>
    									<input type="number" id="contact" class="form-control" required onkeyup="validate_numeric(this.id, 'contactErr', 'submit6')">
    								</div>
                  					<div class="form-group">
                    					Pin Code:<small class="text-danger" id="pincodeErr">*</small>
                    					<input type="number" id="pincode" class="form-control bg-light" required>
                  					</div>
                  					<div class="form-group">
                    					City:<small class="text-danger" id="cityErr">*</small>
                    					<input type="text" id="city" class="form-control bg-light" disabled  required>
                  					</div>
                  					<div class="form-group">
                    					District:<small class="text-danger" id="districtErr">*</small>
                    					<input type="text" id="district" class="form-control bg-light" disabled required>
                  					</div>
                  					<div class="form-group">
                    					State:<small class="text-danger" id="stateErr">*</small>
                    					<input type="text" id="state" class="form-control bg-light" disabled required>
                  					</div>
                  					<div class="form-group">
                    					<input type="button" name="submit" id="submit6" value="ADD" class="form-control btn-sm btn-primary">
                  					</div>
    							</form>
  							</div>
  
  							<!-- Modal footer -->
  							<div class="modal-footer">
    							<p class="text-success font-weight-bold" id="addressmessage"></p>
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

  	<script type="text/javascript" src="js/js1.js?v=1.5"></script>
</body>
</html>