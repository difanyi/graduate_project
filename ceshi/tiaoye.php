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



<div class="cloudClinic-box" style="height: 492px; width: 884px;">
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
//获取数据的行数
$a=mysql_fetch_assoc(mysql_query("select * from patient"));  
$all= count($a);  
//定义分页所需的参数
$lenght=5;                             //每页显示的数量
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
$sql="select * from patient order by id limit {$offset},{$lenght}";
$rest=mysql_query($sql);
while($row=mysql_fetch_assoc($rest)){?>
<form method='post' action='php/logout_patient.php?id=<?php echo $row['id'];?>&&status=已退号'>
<div>
<tr>
			<td class='table-list' style='text-align:center;' ><?php echo $row["status"];?></td>
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



</body>
</html>