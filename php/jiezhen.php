<?php
header("content-type=text/html;charset=utf-8");
$patient_id = $_POST['patientID'];
mysql_connect("localhost","root","root");   //连接数据库  
mysql_select_db("hospital");  //选择数据库  
mysql_query("set names utf-8"); //设定字符集

$sql="select * from patient where id=$patient_id";
$result=mysql_query($sql);
while($a=mysql_fetch_array($result)){
	
?>

<div id="jzdiv">
    <div class="first-line">
    <p class="single-information name">
    <b class="info-must">*</b><b>姓名:</b><?php  echo " ".$a['patname'];?>
    </p>
    <p class="single-information sex">
    <b class="info-must">*</b><b>性别:</b>
	<?php  echo $a['sex'];?>
    </p>
    </div>
    <div class="second-line">
    <p class="single-information">
    <b class="info-must">*</b><b>年龄:</b>
    <?php echo $a['age_number']."  ".$a['age_unit'];?>
    </p>
							
    <p class="single-information sex" style="margin-left:350px;">
    <b class="info-must">*</b><b>电话:</b>
	<?php  echo $a['pattel'];?>
    </p>
    </div>
</div>
</div>  
<?php }?>          