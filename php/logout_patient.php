<?php
header("content-type=text/html;charset=utf-8");
session_start();

$id=$_GET['id'];
$status=$_GET['status'];

mysql_connect("localhost","root","root");   //连接数据库  
mysql_select_db("hospital");  //选择数据库  
mysql_query("set names utf-8"); //设定字符集 

$sql_select="select status from patient where id='$id'";
$a=mysql_fetch_assoc(mysql_query($sql_select)); 
//0待诊 1已接诊 2已退号

if($a['status']==2){
	echo "<script  type='text/javascript'>alert('该挂号已退号，请勿重复操作！'); </script>";  
	echo "<script>url='../registration.php';window.location.href=url;</script> ";
}
else if($a['status']==1){
   	echo "<script  type='text/javascript'>alert('该挂号已接诊，无法退号！'); </script>";  
	echo "<script>url='../registration.php';window.location.href=url;</script> ";
}
else{
$sql="update patient set status=2 where id='$id';";
$result=mysql_query($sql);
if($result){  
	echo "<script  type='text/javascript'>alert('退号成功！'); </script>";  
	echo "<script>url='../registration.php';window.location.href=url;</script> ";
}  
else{  
	echo "<script>alert('系统繁忙，请稍候！'); window.location.href = document.referrer;</script>";  
}
}  
?>
