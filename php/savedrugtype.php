<?php
//分析数据
header("content-type=text/html;charset=utf-8");
session_start();
$id=$_GET['id'];
//获取所有的有效值   目前截至体格检查
$Yp_Name = $_POST['Yp_Name'];   //药品名称
$Yp_LB = $_POST['Yp_LB'];       //药品类别
$IsOTC = $_POST['IsOTC'];       //~处方药
$Yp_BZGG=$_POST['Yp_BZGG'];     //包装规格
$Yp_BZDW = $_POST['Yp_BZDW'];   //药品单位
$Yp_ZT = $_POST['Yp_ZT'];       //~药品状态
$Yp_status=$_POST['Yp_status']; //~状态
$Yp_SCCJ=$_POST['Yp_SCCJ'];     //生产厂家
$Yp_PZWH=$_POST['Yp_PZWH'];     //~批准文号
$Yp_PZWH=str_replace('国药准字','',$Yp_PZWH);
$Yp_KC=$_POST['Yp_KC'];         //库存
$Yp_KC=str_replace($Yp_BZDW,'',$Yp_KC);
$Yp_JHJ=$_POST['Yp_JHJ'];       //进货价
$Yp_SCJ=$_POST['Yp_SCJ'];       //出货价
$Yp_KCFZ=$_POST['Yp_KCFZ'];     //库存阈值
$Yp_KCFZ=str_replace($Yp_BZDW,'',$Yp_KCFZ);
$Yp_XQ=$_POST['Yp_XQ'];         //效期
/*
echo $id;
echo $Yp_Name;echo "<br>";
echo $Yp_LB;echo "<br>";
echo $IsOTC;echo "<br>";
echo $Yp_BZGG;echo "<br>";
echo $Yp_BZDW;echo "<br>";
echo $Yp_ZT;echo "<br>";
echo $Yp_status;echo "<br>";
echo $Yp_SCCJ;echo "<br>";
echo $Yp_PZWH;echo "<br>";
echo $Yp_KC;echo "<br>";
echo $Yp_JHJ;echo "<br>";
echo $Yp_SCJ;echo "<br>";
echo $Yp_KCFZ;echo "<br>";
echo $Yp_XQ;echo "<br>";
*/


//将值保存进数据库
if($id!=0){
	if($Yp_Name == "" || $Yp_LB == ""||$Yp_BZGG==""||$Yp_BZDW==""||$Yp_SCCJ==""||$Yp_KC==""||$Yp_JHJ==""||$Yp_SCJ==""||$Yp_KCFZ==""||$Yp_XQ==""){  
		echo "<script>alert('请确认信息完整性！'); window.location.href = document.referrer;</script>"; 
		}  
	else {
		mysql_connect("localhost","root",'root') ;
		mysql_select_db("hospital");
		mysql_query("set names utf8");
		$sql_update="update drugs set Yp_Name='$Yp_Name', Yp_LB='$Yp_LB',IsOTC='$IsOTC',Yp_BZGG='$Yp_BZGG',Yp_BZDW='$Yp_BZDW',Yp_ZT='$Yp_ZT',Yp_status='$Yp_status',Yp_SCCJ='$Yp_SCCJ',Yp_PZWH='$Yp_PZWH',Yp_KC='$Yp_KC',Yp_JHJ='$Yp_JHJ',Yp_SCJ='$Yp_SCJ',Yp_KCFZ='$Yp_KCFZ',Yp_XQ='$Yp_XQ' where Yp_id='$id';";
		//echo $sql_update;
		$res_insert = mysql_query($sql_update);  
		if($res_insert){  
			echo "<script  type='text/javascript'>alert('编辑成功！'); </script>"; 
			echo "<script>url='../drugList.php';window.location.href=url;</script> ";
			
		}  
		else{  
			//echo "<script>alert('系统繁忙，请稍候！'); window.location.href = document.referrer;</script>";  
		}  
	}
}
else{
	//保存
	if($Yp_Name == "" || $Yp_LB == ""||$Yp_BZGG==""||$Yp_BZDW==""||$Yp_SCCJ==""||$Yp_KC==""||$Yp_JHJ==""||$Yp_SCJ==""||$Yp_KCFZ==""||$Yp_XQ==""){  
		echo "<script>alert('请确认信息完整性！'); window.location.href = document.referrer;</script>"; 
		}  
	else {
		mysql_connect("localhost","root",'root') ;
		mysql_select_db("hospital");
		mysql_query("set names utf8");
		$sql_insert = "insert into drugs (Yp_Name,Yp_LB,IsOTC,Yp_BZGG,Yp_BZDW,Yp_ZT,Yp_status,Yp_SCCJ,Yp_PZWH,Yp_KC,Yp_JHJ,Yp_SCJ,Yp_KCFZ,Yp_XQ)values('$Yp_Name','$Yp_LB','$IsOTC','$Yp_BZGG','$Yp_BZDW','$Yp_ZT','$Yp_status','$Yp_SCCJ','$Yp_PZWH','$Yp_KC','$Yp_JHJ','$Yp_SCJ','$Yp_KCFZ','$Yp_XQ')";  
		$res_insert = mysql_query($sql_insert);  
		if($res_insert){  
			echo "<script  type='text/javascript'>alert('保存成功！'); </script>"; 
			echo "<script>url='../drugList.php';window.location.href=url;</script> ";
			
		}  
		else{  
			//echo "<script>alert('系统繁忙，请稍候！'); window.location.href = document.referrer;</script>";  
		}  
	}
}

	

?>