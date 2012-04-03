<?php
require 'connect.php';
session_start();
$username = $_SESSION["username"];
$password = $_POST["password"];
$firstname = $_POST["firstname"];
$lastname = $_POST["lastname"];
$phone = $_POST["phone"];

$update_query = "UPDATE USERS 
		SET FIRSTNAME='$firstname', LASTNAME='$lastname', PASSWORD='$password', PHONE='$phone'
		WHERE USERNAME='$username'";
//echo $update_query;

$result = oci_parse($conn, $update_query);

oci_execute($result);
								
oci_close($conn);
Header("Location: member.php");

?>