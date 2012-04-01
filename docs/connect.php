<?php
$db = "(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)(HOST=w4111g.cs.columbia.edu)(PORT=1521))(CONNECT_DATA=(SERVER=DEDICATED)(SERVICE_NAME=ADB)))";
$conn = oci_connect("sy2414", "sy2414zz2219", $db);
if (!$conn)
   echo "connection failed!";
?>

