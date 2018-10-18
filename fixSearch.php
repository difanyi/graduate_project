<?php include 'php/ifsession.php';?>
<!DOCTYPE html>
<!-- saved from url=(0061)http://his.huimei.com/view/drugList/drugList.html?localPage=1 -->
<html lang="zh"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <link rel="icon" href="http://his.huimei.com/images/favicon.ico?v=ceabd01deb" type="image/x-icon">
    <title id="CC-title">患者列表</title>
    <link rel="stylesheet" href="css/base.css">
    <link rel="stylesheet" href="css/overlay.css">
    <!--STYLESTART-->
    <link rel="stylesheet" href="css/ui-select.css">
    <link rel="stylesheet" href="css/drugList.css">
	<link rel="stylesheet" href="css/ui-select.css">
    <!--STYLEEND-->
</head>
<body id="J-main-body">
<div class="cloudClinic-body" superadmin="0">
    <?php include 'php/head.php';?>
	<script> 
var para = document.getElementById("h2").className = "nav-list nav-registration nav-check";  
</script>
    <div class="cloudClinic-main flt" id="cloudClinic-main" style="height: 531px;">
      <div class="cc-left-nav flt" id="page-left-nav"><a href="newRecord.php" class="left-nav-newRecord "><span class="ln-i-newRecord"></span>门诊病历</a><a href="newPrescription.php" class="left-nav-newPrescription "><span class="ln-i-newPrescription"></span>门诊处方</a><a href="fixSearch.php" class="left-nav-fixSearch cc-left-mark"><span class="ln-i-fixSearch"></span>患者列表</a><div class="nav-today-list"><p class="today-list-title">今日就诊</p><div class="today-list-load" style="display: none;"></div><div class="today-list-data j_today_list" style="height: 365px;"><p class="today-list-none">暂无今日就诊</p></div></div></div>
        <div class="page-main-content flt" id="page-main-content" style="width: 1211px;">
            <!--PAGESTART-->
            <!--页面顶部固定条start-->
            <div class="fixed-panel top-fixed" id="top-fixed-panel">
                <div class="header f-clrfix">
                    
                    <div class="header-drugname sub-wrap f-left">
                        <input class="J_drugName" type="text" placeholder="患者姓名/电话" issug="1" >
                    </div>

                    <input style="margin-left:25px;" class="short-btn" type="button" value="查询" onclick="">
					
                </div>  
            </div>
			
            <!--页面顶部固定条end-->
            <div class="main-content-inner flt">
                <!--页面主体start-->
                <div class="main J_drugListDialog">
                    
                    <div class="main-druglist J_drugtable">
                        <table width="100%" class="main-mdlist-table table-list">
                            <tbody>
							<tr>
                                <!--<th class="table-title"><i class="select-icon J_select J_selectAll"></i>全选</th>-->
                                <th class="table-title">患者姓名</th>
                                <th class="table-title">性别</th>
                                <th class="table-title">年龄</th>
                                <th class="table-title">电话</th>
                                <th class="table-title">就诊日期</th>
                                <th class="table-title">诊断</th>
								<th class="table-title">操作</th>
                            </tr>
                            </tbody>
							
							<tbody class="main-table-tbody J_drugList">
							<?php 
mysql_connect("localhost","root",'root') ;
mysql_select_db("hospital");
mysql_query("set names utf8");
//二级框所需


//分页所需
//获取数据的行数
$all=mysql_num_rows(mysql_query("select * from patient,record where patient.id=record.patient_id"));  
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
$sql="select * from patient,record where patient.id=record.patient_id limit {$offset},{$lenght}";
$rest=mysql_query($sql);

while($row=mysql_fetch_assoc($rest)){?>
<div>
								<tr data-drug-id="231433">
								<td class="little-width"><?php echo $row['patname'];?> </td>
								<td><?php echo $row["sex"];?></td>
								<td class="little-width"><?php echo $row['age_number'].$row['age_unit'];?></td>
								<td class="long-width"><?php echo $row['pattel'];?></td>
								<td><?php echo $row['time'];?></td>
								<td><?php echo $row['zhenduan'];?></td>
								
								<td class="short-width"><a class="link-edit" href="fixRecord.php?id=<?php echo $row['patient_id'];?>">编辑</a>

								</tbody>
																
<?php }?>
                        </table>
                       <div  style="font-size:16px;margin-top:30px;">
<center><a href='drugList.php?page=1'>首页</a>|
<a href='drugList.php?page=<?php echo $prepage;?>'>上一页</a>|
第 <?php echo $page;?> 页&nbsp;
共 <?php echo $allpage;?> 页|
<a href='drugList.php?page=<?php echo $nextpage;?>'>下一页</a>|
<a href='drugList.php?page=<?php echo $allpage;?>'>末页</a></center>
</div>
                    </div>
                </div>
               
                <!--页面主体end-->
            </div>
            <!--页面底部固定条start-->
            <!--页面底部固定条end-->
            <!--PAGEEND-->
        </div>
    </div>
   
    <!--JSEND-->
</div>

</body></html>