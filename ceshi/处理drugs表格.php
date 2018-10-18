<?php
header("content-type=text/html;charset=utf-8");
mysql_connect("localhost","root",'root') ;
mysql_select_db("hospital");
mysql_query("set names utf8");

$sql="select * from drugs";
$rest=mysql_query($sql);
while($row=mysql_fetch_assoc($rest)){
	$id=$row['Yp_id'];
	$name=$row['Yp_Name'];
	$sccj=$row['Yp_SCCJ'];
	$ypgg=$row['Yp_BZGG'];
	$sql="select * from distinct_ where Yp_name='$name' and Yp_SCCJ='$sccj' and Yp_BZGG='$ypgg'";
	echo $sql."<br>";
	$result=mysql_query($sql);
	while($a=mysql_fetch_assoc($result)){
		$jhj=$a['Yp_JHJ'];
		$chj=$a['Yp_SCJ'];
		$xq=$a['Yp_XQ'];
		$sql_update="update drugs set Yp_JHJ='$jhj',Yp_SCJ='$chj',Yp_XQ='$xq' where Yp_id=$id";
		mysql_query($sql_update);
		echo $sql_update."<br>";
	}
}


?>
