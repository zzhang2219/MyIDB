<?php
require 'connect.php';
session_start();

$tutorname = $_SESSION['username'];
$address = $_POST['address'];
$zip = $_POST['zip'];
$description = $_POST['description'];
$price = $_POST['price'];
$specialties = $_POST['options'];

echo $tutorname;

foreach ($_POST['options'] as $option)
{
	echo $option;
}

	//if ($price)
	//{
		//insert new record into table_tutor
	//	$stat = "INSERT INTO TUTOR(TUTORNAME, ADDRESS, ZIP, DESCRIPTION, PRICE) 
	//	VALUES('$tutorname', '$address', '$zip', '$description', '$price')";
	//	$result = oci_parse($conn, $stat);
	//	oci_execute($result);
	//	oci_close($conn);
	//	Header("Location: index.php");
	//}
	//else 
	//{
	//	oci_close($conn);
	//	Header("Location: index.php");
	//}

?>