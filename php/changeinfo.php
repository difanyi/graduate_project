<?php
	header("content-type=text/html;charset=utf-8");
	session_start();
	$user=$_SESSION['name'];
	mysql_connect("localhost","root","root");   //连接数据库  
	mysql_select_db("hospital");  //选择数据库  
	mysql_query("set names utf-8"); //设定字符集 

if (!empty( $_POST['changeinfo'] ) ) {	
		$new_truename=$_POST['truename'];
		$new_depname=$_POST['depname'];
		$new_sex=$_POST['Sex'];
		if($new_truename == "" || $new_depname == "" || $new_sex == "")  
        {  
            echo "<script>alert('请确认信息完整性！'); window.location.href = document.referrer;</script>";  
        }  
        else {
			$sql="update user set truename='$new_truename',depname='$new_depname',sex='$new_sex' where username='$user';";//设置查询指令
			$result=mysql_query($sql);
			if($result){  
				echo "<script  type='text/javascript'>alert('修改成功！'); </script>";  
				echo "<script>url='../userinfo.php';window.location.href=url;</script> ";
			}  
			else{  
				echo "<script>alert('系统繁忙，请稍候！'); window.location.href = document.referrer;</script>";  
			}  
		}
	}
	
	if (!empty( $_POST['changepass'] ) ) {
		
		$old_password=$_POST['old_password'];
		$new_password=$_POST['new_password'];
		$c_password=$_POST['c-password'];
		echo $old_password,$new_password,$c_password;
		if($old_password == "" || $new_password == "" || $c_password == "")  
        {  
            echo "<script>alert('请确认信息完整性！'); window.location.href = document.referrer;</script>";  
        }  
        else {
			if($old_password==$_SESSION['old_password']){
				if($new_password==$c_password){
				$sql="update user set password='$new_password' where username='$user';";//设置查询指令
				$result=mysql_query($sql);
				if($result){  
					echo "<script  type='text/javascript'>alert('修改密码成功！'); </script>";  
					//echo "<script>url='../userinfo.php';window.location.href=url;</script> ";
				}  
				else{  
					echo "<script>alert('系统繁忙，请稍候！'); window.location.href = document.referrer;</script>";  
				}  
			
			}
			else{
				echo "<script>alert('密码不一致！'); window.location.href = document.referrer;</script>"; 
			}
			}
			else{
				echo "<script>alert('密码错误！'); window.location.href = document.referrer;</script>"; 
			}
	}
	}
	
?>	




