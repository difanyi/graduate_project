<?php include 'php/ifsession.php';?>
<!DOCTYPE html>
<!-- saved from url=(0065)http://his.huimei.com/view/departmentManage/departmentManage.html -->
<html lang="zh"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <link rel="icon" href="http://his.huimei.com/images/favicon.ico?v=ceabd01deb" type="image/x-icon">
    <title id="CC-title">科室管理</title>
    <link rel="stylesheet" href="css/base.css">
    <link rel="stylesheet" href="css/overlay.css">
    <!--STYLESTART-->
    <link rel="stylesheet" href="css/departmentManage.css">
    <!--STYLEEND-->
   <script language="JavaScript"> 
function check(){
document.form1.action="php/dep_manage.php"
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
		<a href="departmentManage.php" class="left-nav-departmentManage cc-left-mark"><span class="ln-i-departmentManage"></span>科室管理</a>
		<a href="treatmentSet.php" class="left-nav-treatmentSet "><span class="ln-i-treatmentSet"></span>检查治疗项设置</a>
	</div>
        <div class="page-main-content flt" id="page-main-content" style="width: 1211px;">
            <!--PAGESTART-->
            <!--页面顶部固定条start-->
	<form name="form1" method="post" action="" >
            <div class="fixed-panel top-fixed" id="top-fixed-panel">
                <div class="float-floor">
                    <div class="float-main">
						<a   onclick = "document.getElementById('light').style.display='block';" class="short-btn J_new_department"><u>新建科室</u></a>
                    </div>
					
                    <div class="pop-mark error-mark"></div>
                    <div class="pop-mark success-mark" style="display: none;"></div>
                </div>
            </div>
			
			<div id="light" style="display: none; position: absolute; top: 25%; left: 25%; width:30%; height: 25%; padding: 20px; border: 1px solid #3d77b9; background-color: white; z-index:1002; overflow: auto;" >				
	<div class="newRegister-content" style="font-size:16px;">
							 
                            
							<p class="register-name" style="margin-top:30px">
                                <span class="newRegister-desc" >科室名称：</span>
                                <input type="text" class="register-name-input" name="depname" >
                            </p>
                            
                 <div style="text-align:center;height:50px;line-height:30px;margin-top:30px;">
           <p><button type="submit" name="changedep" id="changedep" style=" width:50px; height:30px; border:#0ss00 1px solid;vertical-align:middle;margin-right:20px;" value="修改" onclick =check() >修改</button>
<button   name="close" style=" width:50px; height:30px; border:#0ss00 1px solid;vertical-align:middle;margin-left:20px;" value="关闭" onclick ="document.getElementById('light').style.display='none';
document.getElementById('fade').style.display='none';" >关闭</button></p>
           </div>     
                                
                          </div>
			</div>
			
		</form>
			
            <!--页面顶部固定条end-->
            <div class="main-content-inner flt">
                <!--页面主体start-->
                <div class="scroll-floor">
                    <table class="department-list table-list J_department_list">
					<tbody>
					<tr>
					<th class="table-title"style='text-align:center;'>科室名称</th>
					<th class="table-title" style="text-indent: 0;text-align:center;">科室成员</th>
					<th class="table-title" style="padding-left:20px;">操作</th>
					</tr>
					 <?php
mysql_connect("localhost","root","root");   //连接数据库  
mysql_select_db("hospital");  //选择数据库  
mysql_query("set names utf-8"); //设定字符集 
$sql="select * from department order by id";//设置查询指令
$result=mysql_query($sql);//执行查询

while($row=mysql_fetch_assoc($result))//将result结果集中查询结果取出一条
{?>


					<tr class="J_list_item" data-id="976">
					<td class="laboratoryName"style='text-align:center;'><?php echo $row["depname"];?></td>
					<td class="laboratoryMember"style='text-align:center;'><?php echo substr($row["docname"],1,strlen($row["docname"])-1);?></td>
					<td class="button">
		<form method='post' action='php/dep_manage.php?id=<?php echo $row['id'];?>'>
					<input class="J_to_delete link-edit" name="delete" type="submit" value="删除" >
					
						<span class="J_to_delete link-edit">|</span>
						<input class="J_to_delete link-edit"  type="button" onclick = "
						document.getElementById('light1').style.display='block';
						document.form2.action='php/dep_manage.php?id=<?php echo $row['id'];?>';
						document.getElementById('depname1').value = '<?php echo $row['depname'];?>';
						"
						value="编辑">
					</td>
					</form>
					</tr>
					<?php }?>
							</tbody>
					</table>
					  <form name="form2" method="post" action="" >
					<div id="light1" style="display: none; position: absolute; top: 25%; left: 25%; width:30%; height: 25%; padding: 20px; border: 1px solid #3d77b9; background-color: white; z-index:1002; overflow: auto;" >				
	<div class="newRegister-content" style="font-size:16px;">
							 
                            
							<p class="register-name" style="margin-top:30px">
                                <span class="newRegister-desc" >科室名称：</span>
                                <input type="text" name="depname1" id="depname1" class="register-name-input" value=""   >
                            </p>
                            
                 <div style="text-align:center;height:50px;line-height:30px;margin-top:30px;">
           <p><button type="submit" name="change" id="changeinfo" style=" width:50px; height:30px; border:#0ss00 1px solid;vertical-align:middle;margin-right:20px;" value="确定" >确定</button>
		   
<button  type="button" name="close" style=" width:50px; height:30px; border:#0ss00 1px solid;vertical-align:middle;margin-left:20px;" value="关闭" onclick ="document.getElementById('light1').style.display='none';
" >关闭</button></p>
           </div>       
</div>
			</div>
		</form>	
                                
                          
			
                    <div class="paging-page-box paging-page" style="position: relative;"></div>
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