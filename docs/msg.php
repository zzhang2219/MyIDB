<?php
require 'connect.php';
session_start();

$sender = $_SESSION['username'];
$receiver = $_POST['receiver'];
$topic = $_POST['topic'];
$content = $_POST['content'];
//echo $sender;
//echo $receiver;
//echo $topic;
//echo $content;
$time = date("dmy");


$check = oci_parse($conn, "select * from users U where U.username ='$receiver'");
oci_execute($check);
oci_fetch_all($check, $res);
if ($res)
{
	$msg_query = "INSERT INTO Message(SENDER, RECEIVER, TOPIC, CONTENT, MTIME) 
			  VALUES('$sender', '$receiver', '$topic', '$content', to_date('$time','dd-mm-yy'))";
	echo $msg_query;
	$result = oci_parse($conn, $msg_query);
	oci_execute($result);
	oci_close($conn);
	//Header("Location: member.php");
}
else 
{
	oci_close($conn);
	//Header("Location: index.php");
}

?>