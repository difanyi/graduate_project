<?php
header("content-type=text/html;charset=utf-8");
session_start();

$id=$_GET['id'];
$status=$_GET['status'];

mysql_connect("localhost","root","root");   //�������ݿ�  
mysql_select_db("hospital");  //ѡ�����ݿ�  
mysql_query("set names utf-8"); //�趨�ַ��� 

$sql_select="select status from patient where id='$id'";
$a=mysql_fetch_assoc(mysql_query($sql_select)); 
//0���� 1�ѽ��� 2���˺�

if($a['status']==2){
	echo "<script  type='text/javascript'>alert('�ùҺ����˺ţ������ظ�������'); </script>";  
	echo "<script>url='../registration.php';window.location.href=url;</script> ";
}
else if($a['status']==1){
   	echo "<script  type='text/javascript'>alert('�ùҺ��ѽ���޷��˺ţ�'); </script>";  
	echo "<script>url='../registration.php';window.location.href=url;</script> ";
}
else{
$sql="update patient set status=2 where id='$id';";
$result=mysql_query($sql);
if($result){  
	echo "<script  type='text/javascript'>alert('�˺ųɹ���'); </script>";  
	echo "<script>url='../registration.php';window.location.href=url;</script> ";
}  
else{  
	echo "<script>alert('ϵͳ��æ�����Ժ�'); window.location.href = document.referrer;</script>";  
}
}  
?>
