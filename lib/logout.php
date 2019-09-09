<?php
	session_destroy();
	if(isset($_COOKIE["unique_id"])){
		setcookie("unique_id","",time()-1000,"/");
	}
?>