<?php

require 'connect.php';
$sid = $_GET['sid'];

$query = "UPDATE SCHEDULE 
		SET STATE=1
		WHERE SID='$sid'";
echo $query;

$result = oci_parse($conn, $query);
oci_execute($result);
oci_close($conn);

header("Location:  member.php");

?>