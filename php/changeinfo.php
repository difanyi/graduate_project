<?php
	header("content-type=text/html;charset=utf-8");
	session_start();
	$user=$_SESSION['name'];
	mysql_connect("localhost","root","root");   //�������ݿ�  
	mysql_select_db("hospital");  //ѡ�����ݿ�  
	mysql_query("set names utf-8"); //�趨�ַ��� 

if (!empty( $_POST['changeinfo'] ) ) {	
		$new_truename=$_POST['truename'];
		$new_depname=$_POST['depname'];
		$new_sex=$_POST['Sex'];
		if($new_truename == "" || $new_depname == "" || $new_sex == "")  
        {  
            echo "<script>alert('��ȷ����Ϣ�����ԣ�'); window.location.href = document.referrer;</script>";  
        }  
        else {
			$sql="update user set truename='$new_truename',depname='$new_depname',sex='$new_sex' where username='$user';";//���ò�ѯָ��
			$result=mysql_query($sql);
			if($result){  
				echo "<script  type='text/javascript'>alert('�޸ĳɹ���'); </script>";  
				echo "<script>url='../userinfo.php';window.location.href=url;</script> ";
			}  
			else{  
				echo "<script>alert('ϵͳ��æ�����Ժ�'); window.location.href = document.referrer;</script>";  
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
            echo "<script>alert('��ȷ����Ϣ�����ԣ�'); window.location.href = document.referrer;</script>";  
        }  
        else {
			if($old_password==$_SESSION['old_password']){
				if($new_password==$c_password){
				$sql="update user set password='$new_password' where username='$user';";//���ò�ѯָ��
				$result=mysql_query($sql);
				if($result){  
					echo "<script  type='text/javascript'>alert('�޸�����ɹ���'); </script>";  
					//echo "<script>url='../userinfo.php';window.location.href=url;</script> ";
				}  
				else{  
					echo "<script>alert('ϵͳ��æ�����Ժ�'); window.location.href = document.referrer;</script>";  
				}  
			
			}
			else{
				echo "<script>alert('���벻һ�£�'); window.location.href = document.referrer;</script>"; 
			}
			}
			else{
				echo "<script>alert('�������'); window.location.href = document.referrer;</script>"; 
			}
	}
	}
	
?>	




