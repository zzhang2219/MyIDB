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
$file_path="";
echo "Upload: " . $_FILES["pic"]["name"] . "<br />";
if ((($_FILES["pic"]["type"] == "image/gif")
		|| ($_FILES["pic"]["type"] == "image/jpeg")
		|| ($_FILES["pic"]["type"] == "image/pjpeg"))
		&& ($_FILES["pic"]["size"] < 20000)){
	if ($_FILES["pic"]["error"] > 0)
	{
		echo "Return Code: " . $_FILES["pic"]["error"] . "<br />";
	}
	else
	{
		echo "Upload: " . $_FILES["pic"]["name"] . "<br />";
		echo "Type: " . $_FILES["pic"]["type"] . "<br />";
		echo "Size: " . ($_FILES["pic"]["size"] / 1024) . " Kb<br />";
		echo "Temp file: " . $_FILES["pic"]["tmp_name"] . "<br />";
		$file_path="upload/".$username."pic.jpg";
		$file_path="upload/".$username."pic.jpg";
		move_uploaded_file($_FILES["pic"]["tmp_name"],"upload/".$username."pic.jpg");
		echo "Stored in: "."upload/".$_FILES["pic"]["name"];
		
	}
}
else
{
	echo $_FILES["pic"]["type"];
	echo "Invalid file";
}
if($file_path!=""){
$update_user = "UPDATE USERS 
		SET FIRSTNAME='$firstname', LASTNAME='$lastname', PASSWORD='$password', PHONE='$phone' ,PHOTO='$file_path'
		WHERE USERNAME='$username'";}
else{
	$update_user = "UPDATE USERS
	SET FIRSTNAME='$firstname', LASTNAME='$lastname', PASSWORD='$password', PHONE='$phone'
	WHERE USERNAME='$username'";
}
//echo $update_query;

$result = oci_parse($conn, $update_user);

oci_execute($result);
$update_tutor = "UPDATE TUTOR 
		SET ADDRESS='$address', ZIP='$zip', PRICE=$price
		WHERE TUTORNAME='$username'";

$result = oci_parse($conn, $update_tutor);

oci_execute($result);

oci_close($conn);
Header("Location: member.php");

?>