<?php

session_start();
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
    {
       $_SESSION["username"]=$_POST["username"];
       header("Location: member.php");
    }
    else
    {
       echo "Invaild username/password."; 
       header("Location: index.php");
    }
}
else
   echo "invaild username or password";

?>
