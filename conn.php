<?php
$host = "localhost";
$user = "root";
$password = "";
$dbname = "mom";

$conn = mysqli_connect($host, $user, $password, $dbname);

if (!$conn) {
	die("error in connection");
}
?>