<?php

$servername = "localhost";
$username = "root";
$password = "kongxiaotian";

try {
	$conn = new PDO("mysql:host=$servername;port=3306;dbname=km-orderfood", $username, $password);
	$conn->query("set names utf8");
	
} catch(PDOException $e) {
	echo $e->getMessage();
}

?>