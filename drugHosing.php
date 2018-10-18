<?php include 'php/ifsession.php';?>
<!DOCTYPE html>
<!-- saved from url=(0061)http://his.huimei.com/view/drugList/drugList.html?localPage=1 -->
<html lang="zh"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <link rel="icon" href="http://his.huimei.com/images/favicon.ico?v=ceabd01deb" type="image/x-icon">
    <title id="CC-title">药品入库</title>
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
var para = document.getElementById("h6").className = "nav-list nav-registration nav-check";  
</script>
    <div class="cloudClinic-main flt" id="cloudClinic-main" style="height: 531px;">
      <div class="cloudClinic-main flt" id="cloudClinic-main" style="height: 531px;">
        <div class="cc-left-nav flt" id="page-left-nav">
		<a href="drugList.php" class="left-nav-drugList "><span class="ln-i-drugList"></span>药品信息管理</a>
		<a href="drugHosing.php" class="left-nav-drugHousing cc-left-mark"><span class="ln-i-drugHousing"></span>药品入库</a>
		<a href="orderEarning.php" class="left-nav-orderEarning "><span class="ln-i-orderEarning"></span>库存预警</a>
		<a href="dateEarning.php" class="left-nav-dateEarning "><span class="ln-i-dateEarning"></span>效期提醒</a>
	</div>
        <div class="page-main-content flt" id="page-main-content" style="width: 1211px;">
            <!--PAGESTART-->
            <!--页面顶部固定条start-->
			<form action="php/searchdrug.php" method="post"> 
            <div class="fixed-panel top-fixed" id="top-fixed-panel">
                <div class="header f-clrfix">
                    <span class="f-left">药品检索：</span>
                    <div class="header-drugname sub-wrap f-left">
                        <input class="J_drugName" type="text" placeholder="名称" issug="1" name="drugname"><ul class="sug-ul-dom " style="border: 1px solid rgb(223, 223, 223); width: 107.567px; display: none; height: auto; overflow-x: hidden; overflow-y: scroll;"></ul>
                    </div>
                    <span class="f-left">药品分类：</span>
                    <div  tabindex="0"class="header-drugtype" >
					<select class=" ui-select" name="drugtype" >
						<option value="" selected="selected">全部</option>
                        <option value="西药">西药</option>
                        <option value="中成药">中成药</option>
                        <option value="中草药">中草药</option>
                        <option value="卫生材料">卫生材料</option>
                        <option value="其他">其他</option>
                    </select>
					</div>
                    <span class="f-left" style="margin-left:25px;">状态：</span>
                    <div tabindex="0" class=" header-drugstatus">
					<select class=" ui-select" name="zhuangtai">
                        <option value="" selected="selected">全部</option>
                        <option value="启用">启用</option>
                        <option value="停用">停用</option>
                    </select>
				    </div>
                   
                    <input style="margin-left:25px;"class="short-btn" type="submit" name="drugHosing"value="查询" >
					<input style="margin-left:25px;margin-top:10px;"class="short-btn  f-right" type="button" value="新增" onclick="self.location='addDrug.php'; ">
                </div>  
            </div>
			</form>
            <!--页面顶部固定条end-->
            <div class="main-content-inner flt">
                <!--页面主体start-->
                <div class="main J_drugListDialog">
                    
                    <div class="main-notfound hide J_drugnotfound" style="display: none;">未找到符合条件的药品</div>
                    <div class="main-druglist J_drugtable">
                        <table width="100%" class="main-mdlist-table table-list">
                            <tbody>
							<tr>
                                <!--<th class="table-title"><i class="select-icon J_select J_selectAll"></i>全选</th>-->
                                <th class="table-title">药品名称</th>
                                <th class="table-title">药品分类</th>
                                <th class="table-title">规格</th>
                                <th class="table-title">生产厂家</th>

                                
                                <th class="table-title noUseBatchs" style="display: table-cell;">进货价</th>
                                <th class="table-title">处方价</th>
                                <th class="table-title">总库存</th>

                                <th class="table-title">库存阈值</th>
                                <th class="table-title">药品状态</th>
                                <th class="table-title">操作</th>
                            </tr>
                            </tbody>
							
							<tbody class="main-table-tbody J_drugList">
							<?php 
							error_reporting(E_ALL || ~E_NOTICE);
mysql_connect("localhost","root",'root') ;
mysql_select_db("hospital");
mysql_query("set names utf8");
//get参数
$drugname="";
$drugtype="";
$zhuangtai="";
$drugname=$_GET['drugname'];
$drugtype=$_GET['drugtype'];
$zhuangtai=$_GET['zhuangtai'];
//echo $drugname;
//echo $drugtype;
//echo $zhuangtai;
if($drugname==""){//无名称
	if($drugtype==""||$drugtype=="全部"){//无类别
		if($zhuangtai==""||$zhuangtai=="全部"){//无状态
		$allsql="select * from drugs ";  //sanwu
		}else{
		$allsql="select * from drugs where Yp_status='$zhuangtai'";  //无名称无类别有状态
		}
	}else{
		if($zhuangtai==""||$zhuangtai=="全部"){
		$allsql="select * from drugs where Yp_LB='$drugtype' ";  //无名称有类别无状态
		}else{
		$allsql="select * from drugs where Yp_LB='$drugtype' and Yp_status='$zhuangtai'";  //无名称有类别有状态
		}
	}
}
else{
	if($drugtype==""||$drugtype=="全部"){
		if($zhuangtai==""||$zhuangtai=="全部"){
		$allsql="select * from drugs where Yp_Name='$drugname'  ";  //有名称
		}else{
		$allsql="select * from drugs where Yp_Name='$drugname' and Yp_status='$zhuangtai' ";  //有名称有状态
		}
	}else{
		if($zhuangtai==""||$zhuangtai=="全部"){
		$allsql="select * from drugs where Yp_Name='$drugname' and Yp_LB='$drugtype'";  //有名称有类别
		}else{
		$allsql="select * from drugs where Yp_Name='$drugname' and Yp_status='$zhuangtai' and Yp_LB='$drugtype'";  //三有
		}
	}
}
$all=mysql_num_rows(mysql_query($allsql));
//分页所需

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
//$sql="select * from drugs where Yp_Name='$drugname' and Yp_ZT='$zhuangtai' and Yp_LB='$drugtype' limit {$offset},{$lenght}";
$sql=$allsql."limit {$offset},{$lenght}";
$rest=mysql_query($sql);

while($row=mysql_fetch_assoc($rest)){?>
<div>
								<tr data-drug-id="231433">
								<td class="little-width"><?php echo $row["Yp_Name"];?> </td>
								<td><?php echo $row["Yp_LB"];?></td>
								<td class="little-width"><?php echo $row["Yp_BZGG"];?></td>
								<td class="long-width"><?php echo $row["Yp_SCCJ"];?></td>
								<td>¥<?php echo $row["Yp_JHJ"];?></td>
								<td>¥<?php echo $row["Yp_SCJ"];?></td>
								<td><?php echo $row["Yp_KC"];?><?php echo $row["Yp_BZDW"];?></td>
								<td><?php echo $row["Yp_KCFZ"];?><?php echo $row["Yp_BZDW"];?></td>
								<td class="classify" title=""><?php echo $row["Yp_ZT"];?></td>
								<td class="short-width"><a class="link-edit" href="drugAdd.php?id=<?php echo $row['Yp_id'];?>">药品入库</a></td></tr>

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