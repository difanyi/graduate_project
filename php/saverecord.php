<?php
//分析数据
header("content-type=text/html;charset=utf-8");
include("sqlresult.php");
session_start();
//获取所有的有效值   目前截至体格检查
//$pattel = $_POST['patient-tel'];
$zhusu = $_POST['zhusu'];
$jiwang = $_POST['jiwang'];
$geren=$_POST['geren'];
$guomin = $_POST['guomin'];
$jiazu = $_POST['jiazu'];
$patient_tem=$_POST['patient-tem'];//判断是否发热   发热 体温正常
$patient_weight=$_POST['patient-weight'];//记录  体重+$patient-weight
$patient_rate=$_POST['patient-rate']; //判断是否心律过快  心律正常 心律失常
$patient_blood1=$_POST['patient-blood1'];//判断是否高血压   高血压 血压正常 低血压
$patient_blood2=$_POST['patient-blood2'];//判断是否高血压   高血压 血压正常 低血压
$other=$_POST['other'];

$tigejiancha="";
if($patient_tem){//如果温度不为空
	$tigejiancha=$tigejiancha."T".$patient_tem."℃,";
}
if($patient_weight){//如果体重不为空
	$tigejiancha=$tigejiancha.$patient_weight."kg,";
}
if($patient_weight){//如果心率不为空
	$tigejiancha=$tigejiancha.$patient_rate."bpm,";
}
if($patient_blood1&&$patient_blood2){//如果血压不为空
	$tigejiancha=$tigejiancha."BP ".$patient_blood1."/".$patient_blood2."mmHg,";
}
$tigejiancha=$tigejiancha.$other;
$zhenduan=$_POST['zhenduan'];
$yizhu=$_POST['yizhu'];
$patname="";
$sex="";
$age_number="";
$age_unit="";
mysql_connect("localhost","root","root");   //连接数据库  
mysql_select_db("hospital");  //选择数据库  
mysql_query("set names utf-8"); //设定字符集 
 
$patient_id=$_GET['patientID'];
if($patient_id=='undefined'){
	echo "<script>alert('请从接诊处选择病人！'); window.location.href = document.referrer;</script>"; 
}
else{
	
	$sql="select * from patient where id=$patient_id";
	$result=mysql_query($sql);
	while($a=mysql_fetch_array($result)){
		$patname = $a['patname'];
		$sex = $a['sex'];
		$age_number = $a['age_number'];
		$age_unit = $a['age_unit'];
		$pattel=$a['pattel'];
	}
}
date_default_timezone_set('PRC');
$time=date('y-m-d H:i:s');
/*
echo $patname;echo "<br>";
echo $sex;;echo "<br>";
echo $age_number;
echo $age_unit;;echo "<br>";
echo $pattel;echo "<br>";
echo $zhusu;echo "<br>";
echo $jiwang;echo "<br>";
echo $geren;echo "<br>";
echo $guomin;echo "<br>";
echo $jiazu;echo "<br>";
echo $patient_tem;echo "<br>";
echo $patient_weight;echo "<br>";
echo $patient_rate;echo "<br>";
echo $patient_blood;echo "<br>";
echo $other;echo "<br>";
echo $zhenduan;echo "<br>";
*/

//将值保存进数据库

if($zhusu == "" || $zhenduan == ""||$patname==""||$pattel==""){  
    echo "<script>alert('请确认信息完整性！'); window.location.href = document.referrer;</script>"; 
    }  
else {
	$sql="select * from record where patname='$patname' and pattel='$pattel'";
	$result=mysql_query($sql);
	if(mysql_num_rows($result)!=0){
		$sql_insert = "update record set sex='$sex',age_number='$age_number',age_unit='$age_unit',pattel='$pattel',zhusu='$zhusu',jiwang='$jiwang',geren='$geren',guomin='$guomin',jiazu='$jiazu',pattem='$patient_tem',patweight='$patient_weight',patrate='$patient_rate',patblood1='$patient_blood1',patblood2='$patient_blood2',tigejiancha='$other',zhenduan='$zhenduan',yizhu='$yizhu',time='$time' where patname='$patname' "; 
	}else{
		$sql_insert = "insert into record (patient_id,patname,sex,age_number,age_unit,pattel,zhusu,jiwang,geren,guomin,jiazu,pattem,patweight,patrate,patblood1,patblood2,tigejiancha,zhenduan,yizhu,time)values('$patient_id','$patname','$sex','$age_number','$age_unit','$pattel','$zhusu','$jiwang','$geren','$guomin','$jiazu','$patient_tem','$patient_weight','$patient_rate','$patient_blood1','$patient_blood2','$other','$zhenduan','$yizhu','$time')"; 
	}	
	$res_insert = mysql_query($sql_insert);  
	if($res_insert){  
		echo "<script  type='text/javascript'>alert('保存成功！'); </script>"; 
		echo "<script>url='../newRecord.php';window.location.href=url;</script> ";
		$sql_update="update patient set status=1 where id=$patient_id;";
		mysql_query($sql_update);
	}  
    else{  
	    //echo "<script>alert('系统繁忙，请稍候！'); window.location.href = document.referrer;</script>";  
    }  
}

	

?>