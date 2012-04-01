<?php
require "connect.php";

$username = $_POST["username"];
$password = $_POST["password"];

if ($username&&$password)
{
    $query = "select * from users U where U.username='$username' and U.password=$password";
    $s=oci_parse($conn, $query);
    oci_execute($s);
    oci_fetch_all($s, $res);

    if ($res)
       echo "Hello, $username";
    else
       echo "Invaild username/password."; 
}
else
   echo "invaild username or password";

?>
