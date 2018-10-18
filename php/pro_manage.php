<?php
	header("content-type=text/html;charset=utf-8");
	session_start();
	mysql_connect("localhost","root","root");   //连接数据库  
	mysql_select_db("hospital");  //选择数据库  
	mysql_query("set names utf-8"); //设定字符集 
	if (!empty( $_POST['changepro'] ) ) {
		if($_POST['proname']==""||$_POST['pro_unit']==""||$_POST['pro_price']==""){
			echo "<script type='text/javascript'>alert('请确认信息完整性！');window.location.href = document.referrer; </script>";  
			
		}else {
			$sql = "select proname from project where proname = '$_POST[proname]'"; //SQL语句  
					$result = mysql_query($sql);    //执行SQL语句  
					$num = mysql_num_rows($result); //统计执行结果影响的行数  
					if($num)    //如果已经存在该用户  
					{  
						echo "<script type='text/javascript'>alert('该项目已存在！');window.location.href = document.referrer; </script>";  
					}
			else{
				$sql_insert="insert into project (proname,pro_unit,pro_price) values('$_POST[proname]','$_POST[pro_unit]','$_POST[pro_price]')";
				$res_insert = mysql_query($sql_insert); 
				if($res_insert){
					echo "<script type='text/javascript'>alert('新建项目成功！'); </script>";  
					echo "<script>url='../treatmentSet.php';window.location.href=url;</script> ";
				}
			}					
		}
		
	}	
	
	
	
	
	if (!empty( $_POST['delete'] ) ) {	
		
		$id=$_GET['id'];
		//删除项目
			$sql_delete="delete from project where pro_id=$id";
			$res_delete = mysql_query($sql_delete); 
		if($res_delete){
			echo "<script type='text/javascript'>alert('删除项目成功！'); </script>";  
			echo "<script>url='../treatmentSet.php';window.location.href=url;</script> ";
		}

		
	}
	
	if(!empty( $_POST['change'] )){
		//修改项目
		$id=$_GET['id'];
		$sql="update project set proname='$_POST[proname1]',pro_price= '$_POST[pro_price1]', pro_unit='$_POST[pro_unit1]' where pro_id=$id";

		$result1=mysql_query($sql);
		if($result1){
			echo "<script type='text/javascript'>alert('修改成功！'); </script>";  
			echo "<script>url='../treatmentSet.php';window.location.href=url;</script> ";
		}
	}
	
	?>