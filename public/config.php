<?php
	$servername = "localhost";
	$user = "root";
	$pass = "";
	$dbname = "qldoan";
	// Create connection
	$conn = new mysqli($servername, $user, $pass, $dbname);
	// Check connection
	if ($conn->connect_error) 
	{
		die("Lỗi kết nối: " . $conn->connect_error);
	}
?>