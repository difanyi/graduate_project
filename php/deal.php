<?php
header("content-type=text/html;charset=utf-8");
include("sqlresult.php");
session_start();
//获取所有的有效值   目前截至体格检查
$patname = $_POST['patient-name'];
$sex = $_POST['Sex'];
$age_number = $_POST['patient-age'];
$age_unit = $_POST['age-unit'];
$pattel = $_POST['patient-tel'];
$zhusu = $_POST['zhusu'];
$jiwang = $_POST['jiwang'];
$geren=$_POST['geren'];
$guomin = $_POST['guomin'];
$jiazu = $_POST['jiazu'];
$patient_tem=$_POST['patient-tem'];//判断是否发热   发热 体温正常
$patient_weight=$_POST['patient-weight'];//记录  体重+$patient-weight
$patient_rate=$_POST['patient-rate']; //判断是否心律过快  心律正常 心律失常
$patient_blood=$_POST['patient-blood'];//判断是否高血压   高血压 血压正常 低血压
$other=$_POST['other'];
$tigejiancha=$other;
$zhenduan=$_POST['zhenduan'];

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

$str=$zhusu.$geren.$jiazu.$tigejiancha;
//echo $str;
getdisease($str);
echo "<script  type='text/javascript'>alert('分析成功！'); </script>";  
echo "<script>url='../newrecord1.php';window.location.href=url;</script> ";
?>