<?php
require 'connect.php';
session_start();

$tutorname = $_SESSION['username'];
$school = $_POST['school'];
$start_date = $_POST['start_date'];
$end_date = $_POST['end_date'];

$query = "insert into tutor_edu(eduid,school,start_date,end_date,tutorname)
		values(sch_seq.nextval,'$school',to_date('$start_date','dd-mm-yy'),to_date('$end_date', 'dd-mm-yy'),'$tutorname')";
	echo $query;
	$s=oci_parse($conn, $query);
	oci_execute($s);
	
	header("Location: member.php");
	
?>