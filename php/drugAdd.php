<?php
	header("content-type=text/html;charset=utf-8");
	session_start();
	mysql_connect("localhost","root","root");   //连接数据库  
	mysql_select_db("hospital");  //选择数据库  
	mysql_query("set names utf-8"); //设定字符集 
	
	$id=$_GET['id'];
	$Yp_RKSL=$_POST['Yp_RKSL'];
	$Yp_JHJ=$_POST['Yp_JHJ'];
	$Yp_CFJ=$_POST['Yp_CFJ'];
	
	if($Yp_RKSL != "" && $Yp_JHJ != ""&&$Yp_CFJ!=""){
		mysql_connect("localhost","root","root");   //连接数据库  
		mysql_select_db("hospital");  //选择数据库  
		mysql_query("set names utf-8"); //设定字符集
		$sql="select * from drugs where Yp_id=$id";
		$a=mysql_fetch_array(mysql_query($sql));
		$NKC=$a['Yp_KC']+$Yp_RKSL;
		if($NKC<=$a['Yp_KCFZ']){
			$sql_insert="update drugs set Yp_KC=$NKC,Yp_SCJ=$Yp_CFJ,Yp_JHJ=$Yp_JHJ where Yp_id=$id; ";
			mysql_query($sql_insert);
			echo "<script>alert('药品入库成功！'); window.location.href = document.referrer;</script>";
		}else{
			echo "<script>alert('药品超过库存，请更改数量'); window.location.href = document.referrer;</script>";
		}
	} 
	else{
		echo "<script>alert('请确认信息完整性！'); window.location.href = document.referrer;</script>";
	}
	
	echo "<script type='text/javascript'>alert('查询成功！'); </script>";  
	echo "<script type='text/javascript'>";
	echo "window.location.href ='../drugList.php?drugname=".$drugname."&drugtype=".$drugtype."&zhuangtai=".$zhuangtai."';";
	echo "</script>";
	?>