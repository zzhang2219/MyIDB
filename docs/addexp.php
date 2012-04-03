<?php
require 'connect.php';
session_start();

$tutorname = $_SESSION['username'];
$company = $_POST['company'];
$start_date = $_POST['start_date'];
$end_date = $_POST['end_date'];
$description = $_POST['description'];

$query = "insert into tutor_exp(expid,company,startdate,enddate,description,tutorname)
		values(sch_seq.nextval,'$company',to_date('$start_date','dd-mm-yy'),to_date('$end_date', 'dd-mm-yy'),'$description','$tutorname')";
	echo $query;
	$s=oci_parse($conn, $query);
	oci_execute($s);
	header("Location: member.php");
?>