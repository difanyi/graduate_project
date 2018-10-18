<?php
	header("content-type=text/html;charset=utf-8");
	session_start();
	$patname = $_POST['patname'];
	$sex = $_POST['Sex'];
	$age_number = $_POST['age'];
	$age_unit = $_POST['age-unit'];
	$depname = $_POST['depname'];
	$docname = $_POST['docname'];
	#$proname = $_POST['proname'];
	$patpay = $_POST['patpay'];
	$pattel = $_POST['pattel'];
	$user=$_SESSION['name'];
	
	date_default_timezone_set('PRC');
	$pattime=date('y-m-d H:i:s');
	if($patname == "" || $age_number == ""||$depname==""||$docname==""||$pattel==""||$patpay==""){  
       echo "<script>alert('请确认信息完整性！'); window.location.href = document.referrer;</script>"; 
    }  
    else {
	    mysql_connect("localhost","root","root");   //连接数据库  
	    mysql_select_db("hospital");  //选择数据库  
	    mysql_query("set names utf-8"); //设定字符集  
		$sql = "select truename from user where username = '$user'";
		$result = mysql_query($sql);
		$activeuser=mysql_fetch_assoc($result);    //将表中数据作为数组取出
		
	    $sql_insert = "insert into patient (patname,sex,age_number,age_unit,depname,docname,pattel,patpay,pattime,activeuser)values('$patname','$sex','$age_number','$age_unit','$depname','$docname','$pattel','$patpay','$pattime','$activeuser[truename]')";  
	    $res_insert = mysql_query($sql_insert);  
	    if($res_insert){  
			echo "<script  type='text/javascript'>alert('挂号成功！'); </script>"; 
			echo "<script>url='../registration.php';window.location.href=url;</script> ";
		}  
	    else{  
			echo "<script>alert('系统繁忙，请稍候！'); window.location.href = document.referrer;</script>";  
		}  
	}

	
?>