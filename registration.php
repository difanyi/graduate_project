<?php include 'php/ifsession.php';?>

<!DOCTYPE html>
<html lang="zh"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    
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
    <!--STYLEEND-->
</head>
<body id="J-main-body">

<?php include 'php/head.php';?>
<script> 
var para = document.getElementById("h1").className = "nav-list nav-registration nav-check";  
</script> 
    <div class="cloudClinic-main flt" id="cloudClinic-main" style="height: 556px;">
        <div class="cc-left-nav flt" id="page-left-nav"><a href="registration.php" class="left-nav-registration cc-left-mark"><span class="ln-i-registration"></span>挂号</a></div>
        <div class="page-main-content flt" id="page-main-content" style="width: 1211px;">
            <!--PAGESTART-->
            <!--主题部分start-->
            <div class="main-content-inner flt">
                <div class="first">
                    <!--页面顶部固定条start-->
                    
                  
                    <!--页面顶部固定条end-->
                  <div class="cloudClinic-box" style="height: 600px; width: 884px;">
                    <table width="100%" class="main-mdlist-table table-list J_drugtable">
                            <tbody class="main-table-tbody J_registerList"><tr>
                                
                                <th class="table-title"style='text-align:center;'>状态</th>
                                <th class="table-title"style='text-align:center;'>姓名</th>
                                <th class="table-title"style='text-align:center;'>性别</th>
                                <th class="table-title"style='text-align:center;'>年龄</th>
                                <th class="table-title"style='text-align:center;'>科室</th>
                                <th class="table-title"style='text-align:center;'>医生</th>
                                <th class="table-title"style='text-align:center;'>挂号员</th>
                                <th class="table-title"style='text-align:center;'>挂号时间</th>
                                <th class="table-title"></th>
                            </tr>
                            </tbody>
                            <tbody class="main-table-tbody J_registerList">
<?php 
mysql_connect("localhost","root",'root') ;
mysql_select_db("hospital");
mysql_query("set names utf8");

//分页所需
//获取数据的行数
$all=mysql_num_rows(mysql_query("select * from patient"));  
//定义分页所需的参数
$lenght=9;                             //每页显示的数量
@$page=$_GET['page']?$_GET['page']:1;    //当前页
$offset=($page-1)*$lenght;              //每页起始行编号
$allpage=ceil($all/$lenght);            //所有的页数-总数页
                         
if($page==1){
    $prepage=1;                         //特殊的是当前页是1时上一页就是1
}else{
   $prepage=$page-1;                    //上一页    
}

if($page==$allpage){
    $nextpage=$allpage;                //特殊的是最后页是总数页时下一页就是总数页
}else{
    $nextpage=$page+1;                 //下一页
}
$sql="select * from patient order by pattime desc limit {$offset},{$lenght}";
$rest=mysql_query($sql);

while($row=mysql_fetch_assoc($rest)){?>
<form method='post' action='php/logout_patient.php?id=<?php echo $row['id'];?>&&status=已退号'>
<div>
<tr>
			
		    <?php if($row["status"]==0){?>
			<td class='table-list' style='text-align:center;' ><font color="#3d77b9">待诊</font></td>
			<?php }else if($row["status"]==1){?>
			<td class='table-list' style='text-align:center;' ><font color="green">已接诊</font></td>
			<?php }else{?>
			<td class='table-list' style='text-align:center;' ><font color="red">已退号</font></td>
			<?php }?>
			<td class='table-list' style='text-align:center;'><?php echo $row["patname"];?></td>
			<td class='table-list' style='text-align:center;'><?php echo $row["sex"];?></td>
			<td class='table-list' style='text-align:center;'><?php echo $row["age_number"].$row["age_unit"];?></td>
			<td class='table-list' style='text-align:center;'><?php echo $row["depname"];?></td>
			<td class='table-list' style='text-align:center;'><?php echo $row["docname"];?></td>
			<td class='table-list'style='text-align:center;'><?php echo $row["activeuser"];?></td>
			<td class='table-list'style='text-align:center;' ><?php echo $row["pattime"];?></td>
			<td><input class='btn-style' name='submit' type='submit' 
			value='退号'></td>
	 <tr>
	 </div>
</form>
<?php }?>
</tbody>
</table>

<div  style="font-size:16px;margin-top:30px;">
<center><a href='registration.php?page=1'>首页</a>|
<a href='registration.php?page=<?php echo $prepage;?>'>上一页</a>|
第 <?php echo $page;?> 页&nbsp;
共 <?php echo $allpage;?> 页|
<a href='registration.php?page=<?php echo $nextpage;?>'>下一页</a>|
<a href='registration.php?page=<?php echo $allpage;?>'>末页</a></center>
</div>

                    </div>
					<form  method="post" name="form" action="php/patregistration.php" >
                    <div class="newRegister" style="left: 883px; display: block;">
                        <div class="newRegister-top">
                            <div class="newRegister-btn"><div class="newRegister-title">新增挂号</div></div>
                        </div>
                        <div class="newRegister-content" style="height: 442px;">
                            <p class="register-name" style="margin:0px">
                                <span class="newRegister-desc" >姓名：</span>
                                <input type="text" class="register-name-input" name="patname">
                            </p>
                            
                            
                            <div class="register-sex-age ">
                                
                                    <p style="margin:15px 0 15px 13px;">
                                <b>性别:</b>
                                 &nbsp;<input name="Sex" checked="true" id="Radio1" type="radio" class="sex-radio-q sex-radio sex-cur" value="男"/>男&nbsp;<input name="Sex" id="Radio2" class="sex-radio-q sex-radio" type="radio"value="女">女
              
                            </p>
                                
                          </div>
                            
                            
                            <div class="register-age">
                                <div class="age" >
                                    <span class="newRegister-desc">年龄：</span><input name='age' type="text" class="register-age-input">
                                    <span class="age-unit">
                                        <div tabindex="0" class="border-left=10px"><select name="age-unit" class="J_ageUnit ui-select">
                                            <option value="岁" selected="selected" title="岁">岁</option>
                                            <option value="月" title="月">月</option>
                                            <option value="天" title="天">天</option>
                                        </select>
                                        </div>
                                    </span>
                                </div>
                                
                            </div>
                            
							 <p class="register-name" style="margin-top:10px">
                                <span class="newRegister-desc" >电话：</span>
                                <input type="text" class="register-name-input" name="pattel">
                            </p>
                            
                            
							
                            <p class="register-name">
<span class="f-left newRegister-desc">科室：</span>
<select id="depname" name="depname" class=" ui-select" onchange="getD();">
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
                                
                               
                           
                            
                            
                            
                            
                            
                             <p class="register-name">
                                <span class="newRegister-desc">应收：</span>
                            <span class="discount-pay-input-box">
                                <input name="patpay" type="text" value="5.00" onfocus="if (value =='5.00'){value =''}" onblur="if (value ==''){value='5.00'}" class="discount-pay-input J_inputFloatZero" ><span class="unit">元</span>
                            </span>
                          </p>

                           
                            
                            
                            <div class="register-btn-print" style="border:5px #3e78ba;">
                      <input class="J_register_charge btn-style register_charge" name="submit" type="submit" value="挂号"  >
                                
                            </div>
                        </div>
                    </div>
                </div>
                                              
                            </div>
    

                        </div>
                    </div>
                    <!--更多信息start-->
                </div>
            </div>
            <!--页面主体end-->
        </div>
        <!--PAGEEND-->
    </div>
<div class="improve-outer" id="improve-outer"><span class="closeBtn" id="closeBtn"></span></div></div>
</form>
<?php 

//二级框所需

$str=array();
$result4=mysql_query("select docname from department ");
while($row3=mysql_fetch_assoc($result4)){
	$a[]=$row3['docname'];
	@$num++;
}
for($k=0;$k<$num;$k++){
$q=substr($a[$k],1,(strlen($a[$k])));
$str[$k]=explode(',',$q);
$yihang="";
foreach ($str[$k] as $val){
	$yihang=$yihang."\"".$val."\",";
}
$str[$k]=substr($yihang,0,-1);
#$str[$k]=substr($a[$k],1,(strlen($a[$k])));
}

?>

 <script language="JavaScript" type="text/javascript">

function getD(){
 var num="<?php echo $num;?>";
 var city=[
 <?php for($k=0;$k<$num-1;$k++){
	 echo "[".$str[$k]."],";
 }
 echo "[".$str[$k]."]";
	 ?>
 ];
 var sltProvince=document.getElementById("depname");
 var sltCity=document.getElementById("docname");
 var provinceCity=city[sltProvince.selectedIndex-1];
 sltCity.length=1;
 for(var i=0;i<provinceCity.length;i++){
 sltCity[i+1]=new Option(provinceCity[i],provinceCity[i]);
 }
 
}
 </script>
</body></html>