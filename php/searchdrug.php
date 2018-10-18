<?php
	header("content-type=text/html;charset=utf-8");
	session_start();
	mysql_connect("localhost","root","root");   //连接数据库  
	mysql_select_db("hospital");  //选择数据库  
	mysql_query("set names utf-8"); //设定字符集 
	
	$drugname=$_POST['drugname'];
	$drugtype=$_POST['drugtype'];
	$zhuangtai=$_POST['zhuangtai'];
	if(!empty( $_POST['drugList'] )){
	echo "<script type='text/javascript'>alert('查询成功！'); </script>";  
	echo "<script type='text/javascript'>";
	echo "window.location.href ='../drugList.php?drugname=".$drugname."&drugtype=".$drugtype."&zhuangtai=".$zhuangtai."';";
	echo "</script>";
	}
	
	if(!empty( $_POST['drugHosing'] )){
	echo "<script type='text/javascript'>alert('查询成功！'); </script>";  
	echo "<script type='text/javascript'>";
	echo "window.location.href ='../drugHosing.php?drugname=".$drugname."&drugtype=".$drugtype."&zhuangtai=".$zhuangtai."';";
	echo "</script>";
	}
	?>