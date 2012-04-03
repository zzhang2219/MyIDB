<?php
require "connect.php";

echo $tname=$_POST['tname'];
echo $uname=$_POST['uname'];
echo $spec=$_POST['spec'];
echo $tp=$_POST['tptime'];
echo $price=$_POST['price'];
echo $date=$_POST['date'];


if ($uname&&$tname)
{
	$query = "insert into schedule(sid,username,tutorname,sname,timeperiod,price,sdate)
	values(sch_seq.nextval,'$uname','$tname','$spec',$tp,$price,to_date('$date','yyyy-mm-dd'))";
	echo $query;
	$s=oci_parse($conn, $query);
	oci_execute($s);
	

	if (oci_execute($s))
	{
		header("Location: member.php");
	}
	else
	{
		echo "Request fail, try later";
		echo $query;
		
		//header("Location: index.php");
	}
}
else
	echo "invaild username or password";

?>