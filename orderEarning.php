
<?php include 'php/ifsession.php';?>
<!DOCTYPE html>
<!-- saved from url=(0061)http://his.huimei.com/view/drugList/drugList.html?localPage=1 -->
<html lang="zh"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <link rel="icon" href="http://his.huimei.com/images/favicon.ico?v=ceabd01deb" type="image/x-icon">
    <title id="CC-title">库存预警</title>
    <link rel="stylesheet" href="css/base.css">
    <link rel="stylesheet" href="css/overlay.css">
    <!--STYLESTART-->
    <link rel="stylesheet" href="css/ui-select.css">
    <link rel="stylesheet" href="css/drugList.css">
	<link rel="stylesheet" href="css/ui-select.css">
    <!--STYLEEND-->
<script type="text/JavaScript">
   function Change(){
   var a=document.getElementsByName('drugType')[0].value ;
   alert('正在查找:'+a);
   location.href="orderEarning.php?a="+a;
	   }
	
</script>
</head>
<body id="J-main-body">
<div class="cloudClinic-body" superadmin="0">
    <?php include 'php/head.php';?>
	<script> 
var para = document.getElementById("h6").className = "nav-list nav-registration nav-check";  
</script>
    <div class="cloudClinic-main flt" id="cloudClinic-main" style="height: 531px;">
        <div class="cc-left-nav flt" id="page-left-nav">
		<a href="drugList.php" class="left-nav-drugList "><span class="ln-i-drugList"></span>药品信息管理</a>
		<a href="drugHosing.php" class="left-nav-drugHousing "><span class="ln-i-drugHousing"></span>药品入库</a>
		<a href="orderEarning.php" class="left-nav-orderEarning cc-left-mark"><span class="ln-i-orderEarning"></span>库存预警</a>
		<a href="dateEarning.php" class="left-nav-dateEarning "><span class="ln-i-dateEarning"></span>效期提醒</a>
	</div>
        <div class="page-main-content flt" id="page-main-content" style="width: 1211px;">
            <!--PAGESTART-->
            <!--页面顶部固定条start-->
            <div class="fixed-panel top-fixed" id="top-fixed-panel">
                <div class="header f-clrfix">
                    
                    <span class="f-left">药品分类：</span>
                    <div  tabindex="0"class="header-drugtype" >
					<select class=" ui-select" name="drugType" id="drugType" onchange="Change()">
						<option value=""></option>
						<option value="全部">全部</option>
                        <option value="西药">西药</option>
                        <option value="中成药">中成药</option>
                        <option value="中草药">中草药</option>
                        <option value="卫生材料">卫生材料</option>
                        <option value="其他">其他</option>
                    </select>
					</div> 
                </div>  
            </div>
<?php 
error_reporting(E_ALL || ~E_NOTICE);
mysql_connect("localhost","root",'root') ;
mysql_select_db("hospital");
mysql_query("set names utf8");
//分页所需
//获取数据的行数
$lb="";
$lb=$_GET['a'];
if($lb==""||$lb=='全部'){
$all=mysql_num_rows(mysql_query("select * from drugs where Yp_KC<10"));	
}else{
$all=mysql_num_rows(mysql_query("select * from drugs where Yp_KC<10 and Yp_LB='$lb'"));
}  
if($all==0){?>
				<div class="main-content-inner flt">
                <!--页面主体start-->
                <div class="main J_drugListDialog">
                    <h1 >未找到符合条件的药品</h1>
				</div>
				</div>
<?php }else{	?>					
						
            <!--页面顶部固定条end-->
             <div class="main-content-inner flt">
                <!--页面主体start-->
                <div class="main J_drugListDialog">
                    <div class="main-druglist J_drugtable">
                        <table width="100%" class="main-mdlist-table table-list">
                            <tbody>
							<tr>
                               
                                <th class="table-title">药品名称</th>
                                <th class="table-title">药品分类</th>
                                <th class="table-title">规格</th>
                                <th class="table-title">生产厂家</th>

                                
                               
                                <th class="table-title">总库存</th>

                                <th class="table-title">库存阈值</th>
                                <th class="table-title">药品状态</th>
                                
                            </tr>
                            </tbody>
							
							<tbody class="main-table-tbody J_drugList">
<?php
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
if($lb==""||$lb=='全部'){
$sql="select * from drugs where Yp_KC<10 order by Yp_KC limit {$offset},{$lenght}";

}else{
$sql="select * from drugs where Yp_KC<10 and Yp_LB='$lb' order by Yp_KC limit {$offset},{$lenght}";
}  
$rest=mysql_query($sql);

while($row=mysql_fetch_assoc($rest)){?>
<div>
								<tr data-drug-id="231433">
								<td class="little-width"><?php echo $row["Yp_Name"];?> </td>
								<td><?php echo $row["Yp_LB"];?></td>
								<td class="little-width"><?php echo $row["Yp_BZGG"];?></td>
								<td class="long-width"><?php echo $row["Yp_SCCJ"];?></td>
								
								<td style="color:red;"><?php echo $row["Yp_KC"];?><?php echo $row["Yp_BZDW"];?></td>
								<td><?php echo $row["Yp_KCFZ"];?><?php echo $row["Yp_BZDW"];?></td>
								<td class="classify" title=""><?php echo $row["Yp_ZT"];?></td>
								</tr>
								</tbody>
																
<?php }?>
                        </table>
                       <div  style="font-size:16px;margin-top:30px;">
<center><a href='orderEarning.php?page=1&&a=<?php echo $lb;?>'>首页</a>|
<a href='orderEarning.php?page=<?php echo $prepage;?>&&a=<?php echo $lb;?>'>上一页</a>|
第 <?php echo $page;?> 页&nbsp;
共 <?php echo $allpage;?> 页|
<a href='orderEarning.php?page=<?php echo $nextpage;?>&&a=<?php echo $lb;?>'>下一页</a>|
<a href='orderEarning.php?page=<?php echo $allpage;?>&&a=<?php echo $lb;?>'>末页</a></center>
</div>
                    </div>
                </div>
               
                <!--页面主体end-->
            </div>
            <!--页面底部固定条start-->
            <!--页面底部固定条end-->
            <!--PAGEEND-->
        </div>
<?php }?>
    </div>
   
    <!--JSEND-->
</div>

</body></html>