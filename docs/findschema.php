<?php
require 'connect.php';

$query = "select * from schedule";
$result = oci_parse($conn, $query);
oci_execute($result);

$row = oci_fetch_array($result, OCI_ASSOC);
var_dump($row);

?>