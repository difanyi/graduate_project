<?php include 'php/ifsession.php';?>
<!DOCTYPE html>
<!-- saved from url=(0057)http://his.huimei.com/view/treatmentSet/treatmentSet.html -->
<html lang="zh"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <link rel="icon" href="http://his.huimei.com/images/favicon.ico?v=ceabd01deb" type="image/x-icon">
    <title id="CC-title">检查治疗项设置</title>
    <link rel="stylesheet" href="css/base.css">
    <link rel="stylesheet" href="css/overlay.css">
    <!--STYLESTART-->
    <link rel="stylesheet" href="css/treatmentSet.css">
    <!--STYLEEND-->
	 <script language="JavaScript"> 
function check(){
document.form2.action="php/pro_manage.php"
}
</script>
</head>
<body id="J-main-body">
<div class="cloudClinic-body" superadmin="0">
    <?php include 'php/head.php';?>
	<script> 
var para = document.getElementById("h7").className = "nav-list nav-registration nav-check";  
</script>
    <div class="cloudClinic-main flt" id="cloudClinic-main" style="height: 556px;">
        <div class="cc-left-nav flt" id="page-left-nav">
		<!--<a href="clinicRegisterInfo.php" class="left-nav-clinicRegisterInfo"><span class="ln-i-clinicRegisterInfo"></span>诊所注册信息</a>-->
		<a href="userInfo.php" class="left-nav-clinicRegisterInfo"><span class="ln-i-clinicRegisterInfo"></span>用户信息</a>
		<a href="personManage.php" class="left-nav-personManage "><span class="ln-i-personManage"></span>人员管理</a>
		<a href="departmentManage.php" class="left-nav-departmentManage "><span class="ln-i-departmentManage"></span>科室管理</a>
		<a href="treatmentSet.php" class="left-nav-treatmentSet cc-left-mark"><span class="ln-i-treatmentSet"></span>检查治疗项设置</a>
	</div>
        <div class="page-main-content flt" id="page-main-content" style="width: 1211px;">
            <!--PAGESTART-->
            <!--页面顶部固定条start-->
			<form name="form1" method="post" action="" >
            <div class="fixed-panel top-fixed" id="top-fixed-panel">
                <h2 class="treatmentSet-top">
                    <p class="top-main">
                        <a   onclick = "document.getElementById('light').style.display='block';" style="display: inline-block;line-height: 30px;text-align: center;cursor: pointer;color:#3d77b9;font-size: 14px;}"><u>新建检查治疗项</u></a>
                    </p>
                </h2>
            </div>
			<div id="light" style="display: none; position: absolute; top: 25%; left: 25%; width:30%; height: 45%; padding: 20px; border: 1px solid #3d77b9; background-color: white; z-index:1002; overflow: auto;" >				
	<div class="newRegister-content" style="font-size:16px;">
							 
                            
							<p class="register-name" style="margin-top:30px">
                                <span class="newRegister-desc" >检查治疗名称：</span>
                                <input type="text" class="register-name-input" name="proname" >
                            </p>
							<p class="register-name" style="margin-top:30px">
                                <span class="newRegister-desc" >单位：</span>
                                <input type="text" name="pro_unit"class="register-name-input" name="depname"  >
                            </p>
							</p>
							<p class="register-name" style="margin-top:30px">
                                <span class="newRegister-desc" >销售价￥：</span>
                                <input type="text" name="pro_price"class="register-name-input" name="depname" value="0.00"  onfocus="if (value =='0.00'){value =''}" onblur="if (value ==''){value='0.00'}">
                            </p>
                            
                 <div style="text-align:center;height:50px;line-height:30px;margin-top:30px;">
           <p><button type="submit" name="changepro" id="changepro" style=" width:50px; height:30px; border:#0ss00 1px solid;vertical-align:middle;margin-right:20px;" value="确认" onclick ="document.form1.action='php/pro_manage.php'" >确认</button>
<button   name="close" style=" width:50px; height:30px; border:#0ss00 1px solid;vertical-align:middle;margin-left:20px;" value="关闭" onclick ="document.getElementById('light').style.display='none';
document.getElementById('fade').style.display='none';" >关闭</button></p>
           </div>             
                                
                          </div>
			</div>
			
		</form>	
            <!--页面顶部固定条end-->
            <div class="main-content-inner flt">
                <!--页面主体start-->
                <div class="treatment-list table-list"><table width="100%" border="0">
				<tbody>
				<tr class="j_list_top">
				<td valign="middle" class="table-title" style='text-align:center;'>检查治疗项名称</td>
				<td class="table-title" style='text-align:center;'>单位</td>
				<td class="table-title" style='text-align:center;'>销售价</td>
				<td class="table-title" style='text-align:center;'>操作</td>
				</tr>
<?php 
mysql_connect("localhost","root",'root') ;
mysql_select_db("hospital");
mysql_query("set names utf8");
//分页所需
//获取数据的行数
$all=mysql_num_rows(mysql_query("select * from project"));  
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
$sql="select * from project limit {$offset},{$lenght}";
$rest=mysql_query($sql);

while($row=mysql_fetch_assoc($rest)){?>
<div>


					<tr class="J_list_item" data-id="976">
					<td class="laboratoryName"style='text-align:center;'><?php echo $row["proname"];?></td>
					<td class="laboratoryMember"style='text-align:center;'><?php echo $row["pro_unit"];?></td>
					<td class="laboratoryMember"style='text-align:center;'>￥<?php echo $row["pro_price"];?></td>
					<td class="button" style='text-align:center;'>
<form method='post' action='php/pro_manage.php?id=<?php echo $row['pro_id'];?>'>

					<input class="J_to_delete link-edit" name="delete" type="submit" value="删除">	
						<span class="J_to_delete link-edit">|</span>
						<input class="J_to_delete link-edit"  type="button" onclick = "
						document.getElementById('light1').style.display='block';
						document.form2.action='php/pro_manage.php?id=<?php echo $row['pro_id'];?>';
						document.getElementById('proname1').value = '<?php echo $row['proname'];?>';
						document.getElementById('pro_unit1').value = '<?php echo $row['pro_unit'];?>';
						document.getElementById('pro_price1').value = '<?php echo $row['pro_price'];?>';
						"
						value="编辑">
					</td>
					</form>
					</tr>		
					
<?php }?>

				</tbody>
				</table>
			                       <div  style="font-size:16px;margin-top:30px;">
<center><a href='treatmentSet.php?page=1'>首页</a>|
<a href='treatmentSet.php?page=<?php echo $prepage;?>'>上一页</a>|
第 <?php echo $page;?> 页&nbsp;
共 <?php echo $allpage;?> 页|
<a href='treatmentSet.php?page=<?php echo $nextpage;?>'>下一页</a>|
<a href='treatmentSet.php?page=<?php echo $allpage;?>'>末页</a></center>
</div>	
				<form name="form2" method="post" action="" >
				<div id="light1" style="display: none; position: absolute; top: 25%; left: 25%; width:30%; height: 45%; padding: 20px; border: 1px solid #3d77b9; background-color: white; z-index:1002; overflow: auto;" >				
	<div class="newRegister-content" style="font-size:16px;">
							 
                           
							<p class="register-name" style="margin-top:30px">
                                <span class="newRegister-desc" >检查治疗名称：</span>
                                <input type="text"  class="register-name-input" name="proname1" id="proname1" value="" >
                            </p>
							<p class="register-name" style="margin-top:30px">
                                <span class="newRegister-desc" >单位：</span>
                                <input type="text" id="pro_unit1" name="pro_unit1"  class="register-name-input"  value=""  >
                            </p>
							</p>
							<p class="register-name" style="margin-top:30px">
                                <span class="newRegister-desc" >销售价：￥</span>
                                <input type="text" id="pro_price1" name="pro_price1"  class="register-name-input" value=""  >
                            </p>
                            
                 <div style="text-align:center;height:50px;line-height:30px;margin-top:30px;">
			 	 
           <p><button type="submit" name="change" id="change" style=" width:50px; height:30px; border:#0ss00 1px solid;vertical-align:middle;margin-right:20px;" value="修改"  >修改</button>
		   <button  type="button" name="close" style=" width:50px; height:30px; border:#0ss00 1px solid;vertical-align:middle;margin-left:20px;" value="关闭" onclick ="document.getElementById('light1').style.display='none';" >关闭</button></p>
           </div>             
				</div>
				</div>
				
</form>
				
				
				
                <div class="paging-page">
                    <div class="paging-page-box" style="position: relative;"></div>
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