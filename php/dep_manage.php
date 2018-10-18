<?php
	header("content-type=text/html;charset=utf-8");
	session_start();
	mysql_connect("localhost","root","root");   //连接数据库  
	mysql_select_db("hospital");  //选择数据库  
	mysql_query("set names utf-8"); //设定字符集 
	if (!empty( $_POST['changedep'] ) ) {
		if($_POST['depname']==""){
			echo "<script type='text/javascript'>alert('请确认信息完整性！');window.location.href = document.referrer; </script>";  
			
		}
		else {
			$sql = "select depname from department where depname = '$_POST[depname]'"; //SQL语句  
					$result = mysql_query($sql);    //执行SQL语句  
					$num = mysql_num_rows($result); //统计执行结果影响的行数  
					if($num)    //如果已经存在该用户  
					{  
						echo "<script type='text/javascript'>alert('该科室已存在！');window.location.href = document.referrer; </script>";  
						
			
					}
else{
	$sql_insert="insert into department (depname) values('$_POST[depname]')";
		$res_insert = mysql_query($sql_insert); 
		if($res_insert){
			echo "<script type='text/javascript'>alert('新建科室成功！'); </script>";  
			echo "<script>url='../departmentManage.php';window.location.href=url;</script> ";
		}
}					
		}
		
		
	}
	
	
	
	if (!empty( $_POST['delete'] ) ) {	
		$id=$_GET['id'];
		//如果医生列表为空，删除该条记录
		$sql="select docname from department where id=$id";
		$result1=mysql_query($sql);
		$row=mysql_fetch_assoc($result1);
		if(!empty($row['docname'])){
			echo "<script type='text/javascript'>alert('该科室有医生任职，无法删除！');window.location.href = document.referrer; </script>";  
		}else{
			$sql_delete="delete from department where id=$id";
			$res_delete = mysql_query($sql_delete); 
		if($res_delete){
			echo "<script type='text/javascript'>alert('删除科室成功！'); </script>";  
			echo "<script>url='../departmentManage.php';window.location.href=url;</script> ";
		}

		}
	}
	
	if(!empty( $_POST['change'] )){
		//修改科室的名字
		$id=$_GET['id'];
		$sql="update department set depname='$_POST[depname1]' where id=$id";

		$result1=mysql_query($sql);
		if($result1){
			echo "<script type='text/javascript'>alert('修改科室名称成功！'); </script>";  
			echo "<script>url='../departmentManage.php';window.location.href=url;</script> ";
		}
	}
	
	?>