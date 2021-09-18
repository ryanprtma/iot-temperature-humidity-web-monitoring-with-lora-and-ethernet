<?php
   	include("connect.php");
   	
   	$link=Connection();

	$suhu=$_POST["suhu"];
	// $hum1=$_POST["hum1"];

	$query = "INSERT INTO `datasensor` (`temperature`, `humidity`) 
		VALUES ('".$temp1."','".$hum1."')"; 
   	
   	mysql_query($query,$link);
	mysql_close($link);

   	header("Location: index.php");
?>
