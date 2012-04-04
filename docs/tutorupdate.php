<?php
require 'connect.php';
session_start();
$username = $_SESSION["username"];
$password = $_POST["password"];
$firstname = $_POST["firstname"];
$lastname = $_POST["lastname"];
$phone = $_POST["phone"];
$address = $_POST["address"];
$zip = $_POST["zip"];
$price = $_POST["price"];
$file = $_POST["pic"];
echo "tup".$file;
$update_user = "UPDATE USERS 
		SET FIRSTNAME='$firstname', LASTNAME='$lastname', PASSWORD='$password', PHONE='$phone'
		WHERE USERNAME='$username'";
//echo $update_query;

//$result = oci_parse($conn, $update_user);

//oci_execute($result);

$update_tutor = "UPDATE TUTOR 
		SET ADDRESS='$address', ZIP='$zip', PRICE=$price
		WHERE TUTORNAME='$username'";

//$result = oci_parse($conn, $update_tutor);

//oci_execute($result);

//oci_close($conn);
//Header("Location: member.php");

?>