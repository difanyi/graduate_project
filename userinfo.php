<?php include 'php/ifsession.php';?>
<!DOCTYPE html>
<!-- saved from url=(0049)http://his.huimei.com/view/userInfo/userInfo.html -->
<html lang="zh"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <link rel="icon" href="images/favicon.ico" type="image/x-icon">
    <title id="CC-title">账号信息</title>
    <link rel="icon" href="images/favicon.ico" type="image/x-icon">
    
    <link rel="stylesheet" href="css/base.css">
    <link rel="stylesheet" href="css/overlay.css">
    <!--STYLESTART-->
    <link rel="stylesheet" href="css/userInfo.css">
	<link rel="stylesheet" href="css/global.css">
    <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" href="css/login2.css">
	

    <link rel="stylesheet" href="css/quickRegister.css">
    <!--STYLEEND-->
   
    <script language="JavaScript"> 
function change() { 
document.getElementById('light').style.display='block';
document.getElementById('fade').style.display='block';

}
function check(){
document.form1.action="php/changeinfo.php"
}
</script>
</head>
<body id="J-main-body">
<form name="form1" method="post" action="php/changeinfo.php" >
<?php include 'php/head.php';@include 'php/sqllink.php';?>
	<script> 
var para = document.getElementById("h7").className = "nav-list nav-registration nav-check";  
</script>
 <?php 
				
				$user=$_SESSION['name'];
				
				$sql = "select * from user where username ='$user' ";
				$result = mysql_query($sql);
				$row=mysql_fetch_assoc($result);
				
				$_SESSION['old_password']=$row['password'];
				?>
				
    <div class="cloudClinic-main flt" id="cloudClinic-main" style="height: 556px;">
        <div class="cc-left-nav flt" id="page-left-nav">
		<!--<a href="clinicRegisterInfo.php" class="left-nav-clinicRegisterInfo"><span class="ln-i-clinicRegisterInfo"></span>诊所注册信息</a>-->
		<a href="userInfo.php" class="left-nav-clinicRegisterInfo cc-left-mark"><span class="ln-i-clinicRegisterInfo"></span>用户信息</a>
		<a href="personManage.php" class="left-nav-personManage "><span class="ln-i-personManage"></span>人员管理</a>
		<a href="departmentManage.php" class="left-nav-departmentManage "><span class="ln-i-departmentManage"></span>科室管理</a>
		<a href="treatmentSet.php" class="left-nav-treatmentSet "><span class="ln-i-treatmentSet"></span>检查治疗项设置</a>
	</div>
        <div class="page-main-content flt" id="page-main-content" style="width: 1211px;">
            <!--PAGESTART-->
            <!--页面顶部固定条start-->
            <div class="fixed-panel top-fixed" id="top-fixed-panel">
            </div>
            <!--页面顶部固定条end-->
            <div class="main-content-inner flt">
                <!--页面主体start-->
                
                <div class="main-content-title-box">
                    <p class="con-title"><b>账号资料</b>
                    <a  href = "javascript:void(0)" onclick = "change()" style="float:right;"><u>修改资料</u></a>
                 </div>   
	<div id="light" class="div1" >				
	<div class="newRegister-content" style="font-size:16px;">
							 <p class="register-name" style="margin-top:30px">
                                <span style="float:left;" >账号：</span><?php echo $user;  ?>
                               
                            </p>
                            
							<p class="register-name" style="margin-top:30px">
                                <span class="newRegister-desc" >真实姓名：</span>
                                <input type="text" class="register-name-input" name="truename"  value="<?php echo $row['truename'];?>"  onfocus="if (value =='<?php echo $row['truename'];?>'){value =''}" onblur="if (value ==''){value='<?php echo $row['truename'];?>'}"">
                            </p>
                            
                            <div class="register-sex-age "  >
                                
                                    <p style="margin-top:30px; ">
                                性别:&nbsp;
                                 
								<?php if($row['sex']=='男'){ ?> 
								 <input name="Sex" checked="true" id="Radio1" type="radio" class="sex-radio-q sex-radio sex-cur" value="男"/>男&nbsp;
								 <input name="Sex" id="Radio2" class="sex-radio-q sex-radio" type="radio"value="女">女
								<?php }else{ ?>
								 <input name="Sex" id="Radio1" type="radio" class="sex-radio-q sex-radio sex-cur" value="男"/>男&nbsp;
								 <input name="Sex" checked="true" id="Radio2" class="sex-radio-q sex-radio" type="radio"value="女">女
								<?php }?>
                            </p>
                                
                          </div>
							
							<?php 
							 $a=mysql_query("select depname from user where username='$user';");
							 $dep=mysql_fetch_assoc($a);
							 $depname=$dep['depname'];
							 $b=mysql_query("select id from department where depname='$depname'");
							 $idd=mysql_fetch_assoc($b);
							 $id=$idd['id'];
							 $result=mysql_query("select depname from department");
							?>
							
                            <p class="register-name" style="margin-top:30px; ">
                                <span class="f-left newRegister-desc" >科室</span>
                                
                                <select name="depname" id="depname" class=" ui-select" id="select">
                                    <option id="option" value="不指定" select="selected">不指定</option>
                                    <?php while($row=mysql_fetch_assoc($result)){ 
										if($i==($id-1)){
										echo '<option id="option" selected="selected" value="'.$row['depname'].'">'.$row['depname'].'</option>';
										}
									else{
	                                echo '<option id="option"  value="'.$row['depname'].'">'.$row['depname'].'</option>';
	                                }
									$i++;
									
									}?>
                                </select>
                                
                          </p>
                                
							
						    
							<div style="text-align:center;height:50px;line-height:30px;margin-top:30px;">
           <p><button type="submit" name="changeinfo" id="changeinfo" style=" width:50px; height:30px; border:#0ss00 1px solid;vertical-align:middle;margin-right:20px;" value="修改"  >修改</button>
<button   type="button"  name="close" style=" width:50px; height:30px; border:#0ss00 1px solid;vertical-align:middle;margin-left:20px;" value="关闭" onclick ="document.getElementById('light').style.display='none';
document.getElementById('fade').style.display='none';" >关闭</button></p>
           </div>
						</div>
					
				</div>
       
      
<?php 
				
				
				
				$sql = "select * from user where username ='$user' ";
				$result = mysql_query($sql);
				$row=mysql_fetch_assoc($result);
				
				?>
  
    
          
   
                <div class="content">
                    <p class="con-item"><span class="con-item-title">账号：</span><i class="con-item-value J_infoItem j_userName doctorName" data-item-name="doctorName"><?php echo $row['username'];?></i></p>
                    <p class="con-item"><span class="con-item-title">姓名：</span><i class="con-item-value J_infoItem realName" data-item-name="realName"><?php echo $row['truename'];?></i></p>
                    <p class="con-item"><span class="con-item-title">性别：</span><i class="con-item-value J_infoItem mail" data-item-name="mail"><?php echo $row['sex'];?></i></p>
                    <p class="con-item"><span class="con-item-title">科室：</span><i class="con-item-value J_infoItem hospitalName" data-item-name="hospitalName"><?php echo $row['depname'];?></i></p>
                    
                </div>
			<form>	
			<div>	
                <div class="main-content-title-box content2">
                    <p class="con-title"><b>账号安全</b><a  href = "javascript:void(0)" onclick = "document.getElementById('light1').style.display='block';document.getElementById('fade').style.display='block'" style="float:right;"><u>修改密码</u></a></p>
                  </div>  
	<div id="light1" class="div1" >	
	<div class="newRegister-content" style="font-size:16px;">	
	<div class="password-box">
                            
                             <div class="m-ipt f-cb" style="margin-top:30px">原密码：
                            <input class="j-password1 j-password" type="password" name="old_password"  autocomplete="off">
                        </div>
						<div class="m-ipt f-cb" style="margin-top:30px">新密码：
                            <input class="j-password1 j-password" type="password" name="new_password"  autocomplete="off">
                        </div>
                        <div class="m-ipt f-cb" style="margin-top:30px">重复密码：
                                <input class="j-password1 j-password" type="password" name="c-password"  autocomplete="off">
                                <span></span>
                            </div>
							
				</div>
				<div style="text-align:center;height:50px;line-height:30px;margin-top:30px;">
           <p><button type="submit" name="changepass" id="changepass" style=" width:50px; height:30px; border:#0ss00 1px solid;vertical-align:middle;margin-right:20px;" value="修改"  >修改</button>
<button type="button" name="close" style=" width:50px; height:30px; border:#0ss00 1px solid;vertical-align:middle;margin-left:20px;" value="关闭" onclick ="document.getElementById('light1').style.display='none';
document.getElementById('fade').style.display='none';" >关闭</button></p>
           </div>
				</div>
				</div>
				
				
                <div class=" content">
                    <p class="con-item"><span class="con-item-title">密码：</span><i class="con-item-value">*********</i></p>
                    
                </div>
			</div>
</form>
		<form  name="form2" method="post" action="php/loginout.php">
		<div>
		<button type="submit" style=" width:100px; height:30px; border:#0ss00 1px solid;vertical-align:middle;margin-left:25%;margin-top:50px;" >退出登录</button>
		</div>
		</form>			
            <!--页面主体end-->
        </div>
		
        <!--页面底部固定条start-->
        <!--页面底部固定条end-->
        <!--PAGEEND-->
    </div>

<!--JSEND-->
</div>
</div>


</body></html>