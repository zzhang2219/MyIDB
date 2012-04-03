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

	if ($price)
	{
		//insert new record into table_tutor
		$t_stat = "INSERT INTO TUTOR(TUTORNAME, ADDRESS, ZIP, DESCRIPTION, PRICE) 
		VALUES('$tutorname', '$address', '$zip', '$description', '$price')";
		$result = oci_parse($conn, $stat);
		oci_execute($result);
		
		$user_update = "UPDATE USERS 
		SET ISTUTOR=1
		WHERE USERNAME='$tutorname'";
		$result = oci_parse($conn, $user_update);
		oci_execute($result);

		foreach ($_POST['options'] as $option)
		{
			$ts_stat = "INSERT INTO TUTOR_SPEC(TUTORNAME, SNAME) 
			VALUES('$tutorname', '$option')";
			$result = oci_parse($conn, $ts_stat);
			oci_execute($result);
		}
		
		oci_close($conn);
		
		Header("Location: member.php");
	}
	else 
	{
		oci_close($conn);
		Header("Location: index.php");
	}

?>