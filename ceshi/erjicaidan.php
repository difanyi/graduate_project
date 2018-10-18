<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <link rel="icon" href="images/favicon.ico" type="image/x-icon">
    <title id="CC-title">挂号</title>
    <link rel="stylesheet" href="css/base.css">
    <link rel="stylesheet" href="css/overlay.css">
    <!--STYLESTART-->
    <link rel="stylesheet" href="css/laydate.css">
    <link rel="stylesheet" href="css/print-prescr.css">
    <link rel="stylesheet" href="css/ui-select.css">
    <link rel="stylesheet" href="css/registration.css">
    <link rel="stylesheet" href="css/moreInfo.css">

 </head>
 <body>
 
 
 
 
 
 <form action="somepage.asp" name=theForm">
 <?php 
mysql_connect("localhost","root",'root') ;
mysql_select_db("hospital");
mysql_query("set names utf8");
$result4=mysql_query("select docname from department ");
while($row3=mysql_fetch_assoc($result4)){
	$a[]=$row3['docname'];
	@$i++;
}
for($k=0;$k<$i;$k++){
$str[$k]=substr($a[$k],1,(strlen($a[$k])));
}
?>






<p class="register-name">
<span class="f-left newRegister-desc">科室：</span>
<select id="depname" name="depname" class=" ui-select" onchange=getDoc()>
<option  value="不指定" selected="selected">不指定</option>
<?php  
$result1=mysql_query("select depname from department");
while($row1=mysql_fetch_assoc($result1)){  
?>
<option   value="<?php echo $row1['depname'];  ?>" ><?php echo $row1['depname'];  ?></option>
<?php }?>
</select>
</p>
                    
                            
                            
                            <p class="register-name">
                             <?php 
							 $result2=mysql_query("select truename from user");?>
                            
                                <span class="f-left newRegister-desc">医生：</span>
                                <select name="docname" id="docname" class="J_doctor ui-select">
                                    <option value="不指定" >不指定</option>
                                     
                                </select>
                          </p>














 

 </form>
 <script language="JavaScript" type="text/javascript">
var i="<?php echo $i;?>";
var obj=eval('<?php echo json_encode($str);?>');

var arr=new Array();     
for(var j=0;j<i;j++){   
 arr[j] = obj[j].split(",");
}
var city=arr;
var str = "<?php echo $str[0];?>"; 
 document.writeln(str);
function getDoc(){
 var sltProvince=document.getElementById("depname");
 var sltCity=document.getElementById("docname");
 var provinceCity=city[sltProvince.selectedIndex-1];
 sltCity.length=1;
 for(var i=0;i<provinceCity.length;i++){
 sltCity[i+1]=new Option(provinceCity[i],provinceCity[i]);
 }
 
}
 </script>
 </body>
 </html>