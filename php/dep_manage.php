<?php
	header("content-type=text/html;charset=utf-8");
	session_start();
	mysql_connect("localhost","root","root");   //�������ݿ�  
	mysql_select_db("hospital");  //ѡ�����ݿ�  
	mysql_query("set names utf-8"); //�趨�ַ��� 
	if (!empty( $_POST['changedep'] ) ) {
		if($_POST['depname']==""){
			echo "<script type='text/javascript'>alert('��ȷ����Ϣ�����ԣ�');window.location.href = document.referrer; </script>";  
			
		}
		else {
			$sql = "select depname from department where depname = '$_POST[depname]'"; //SQL���  
					$result = mysql_query($sql);    //ִ��SQL���  
					$num = mysql_num_rows($result); //ͳ��ִ�н��Ӱ�������  
					if($num)    //����Ѿ����ڸ��û�  
					{  
						echo "<script type='text/javascript'>alert('�ÿ����Ѵ��ڣ�');window.location.href = document.referrer; </script>";  
						
			
					}
else{
	$sql_insert="insert into department (depname) values('$_POST[depname]')";
		$res_insert = mysql_query($sql_insert); 
		if($res_insert){
			echo "<script type='text/javascript'>alert('�½����ҳɹ���'); </script>";  
			echo "<script>url='../departmentManage.php';window.location.href=url;</script> ";
		}
}					
		}
		
		
	}
	
	
	
	if (!empty( $_POST['delete'] ) ) {	
		$id=$_GET['id'];
		//���ҽ���б�Ϊ�գ�ɾ��������¼
		$sql="select docname from department where id=$id";
		$result1=mysql_query($sql);
		$row=mysql_fetch_assoc($result1);
		if(!empty($row['docname'])){
			echo "<script type='text/javascript'>alert('�ÿ�����ҽ����ְ���޷�ɾ����');window.location.href = document.referrer; </script>";  
		}else{
			$sql_delete="delete from department where id=$id";
			$res_delete = mysql_query($sql_delete); 
		if($res_delete){
			echo "<script type='text/javascript'>alert('ɾ�����ҳɹ���'); </script>";  
			echo "<script>url='../departmentManage.php';window.location.href=url;</script> ";
		}

		}
	}
	
	if(!empty( $_POST['change'] )){
		//�޸Ŀ��ҵ�����
		$id=$_GET['id'];
		$sql="update department set depname='$_POST[depname1]' where id=$id";

		$result1=mysql_query($sql);
		if($result1){
			echo "<script type='text/javascript'>alert('�޸Ŀ������Ƴɹ���'); </script>";  
			echo "<script>url='../departmentManage.php';window.location.href=url;</script> ";
		}
	}
	
	?>