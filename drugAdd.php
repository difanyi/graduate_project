<?php include 'php/ifsession.php';?>
<!DOCTYPE html>
<!-- saved from url=(0061)http://his.huimei.com/view/drugList/drugList.html?localPage=1 -->
<html lang="zh"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <link rel="icon" href="http://his.huimei.com/images/favicon.ico?v=ceabd01deb" type="image/x-icon">
    <title id="CC-title">药品信息管理</title>
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
			
            <!--页面顶部固定条end-->
         
                    <div class="main-druglist J_drugtable">
                        <table width="100%" class="main-mdlist-table table-list">
                            <tbody>
							<tr>
                                <!--<th class="table-title"><i class="select-icon J_select J_selectAll"></i>全选</th>-->
                                <th class="table-title">药品名称</th>
                                <th class="table-title">规格</th>
                                <th class="table-title">生产厂家</th>
								<th class="table-title"><i>*</i>入库数量</th>
                                
                                <th class="table-title noUseBatchs" style="display: table-cell;">进货价</th>
                                <th class="table-title">处方价</th>
                                <th class="table-title">总库存</th>

                                
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
$id=$_GET['id'];
$sql="select * from drugs where Yp_id=$id";
$rest=mysql_query($sql);

while($row=mysql_fetch_assoc($rest)){?>
<div>							
								<form action="php/drugAdd.php?id=<?php echo $row['Yp_id'];?>" method="post">
								<tr data-drug-id="231433">
								<td class="little-width"><b><?php echo $row["Yp_Name"];?></b></td>
								<td class="little-width"><?php echo $row["Yp_BZGG"];?></td>
								<td class="long-width"><?php echo $row["Yp_SCCJ"];?></td>
								<td><input type="text" name="Yp_RKSL" value="" style="width:90px;height:30px;"><?php echo $row["Yp_BZDW"];?></td>
								<td>￥<input type="text" name="Yp_JHJ" value="<?php echo $row['Yp_JHJ'];?>"  onfocus="if (value =='<?php echo $row['Yp_JHJ'];?>'){value =''}" onblur="if (value ==''){value='<?php echo $row['Yp_JHJ'];?>'}"" maxlength="6" style="width:90px;height:30px;" ></td>
								<td>￥<input type="text" name="Yp_CFJ" value="<?php echo $row['Yp_SCJ'];?>"  onfocus="if (value =='<?php echo $row['Yp_SCJ'];?>'){value =''}" onblur="if (value ==''){value='<?php echo $row['Yp_SCJ'];?>'}"" maxlength="6" style="width:90px;height:30px;" ></td>
								<td><?php echo $row["Yp_KC"];?><?php echo $row["Yp_BZDW"];?></td>
					
								<td><?php echo $row["Yp_status"];?></td>
								<td class="short-width"><button class="link-edit" type="submit">确定</button></td>
								</tr>
								</form
>								</tbody>
																
<?php }?>
                        </table>
                     <p style="padding:30px;"><font color="red">注：</font>改变进货价和出货价会改变该药品所有批次的数据。</p>
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