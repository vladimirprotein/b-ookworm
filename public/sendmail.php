<?php
	$to= "beingannni@gmail.com";
	$subject= "Aye";
	$text= "using php to mail you";
	$headers= "From: Animesh Sharma";

	mail($to, $subject, $text, $headers); 
?>