<?php include 'php/ifsession.php';?>
<!DOCTYPE html>
<!-- saved from url=(0069)http://his.huimei.com/view/clinicRegisterInfo/clinicRegisterInfo.html -->
<html lang="zh"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <link rel="icon" href="images/favicon.ico" type="image/x-icon">
    <title id="CC-title">诊所注册信息</title>
    <link rel="stylesheet" href="css/base.css">
    <link rel="stylesheet" href="css/overlay.css">
    <!--STYLESTART-->
    <link rel="stylesheet" href="css/clinicRegisterInfo.css">
    <!--STYLEEND-->
</head>
<body id="J-main-body">

<div class="cloudClinic-body" superadmin="0">
    <?php include 'php/head.php';?>
	<script> 
var para = document.getElementById("h7").className = "nav-list nav-registration nav-check";  
</script>
    <div class="cloudClinic-main flt" id="cloudClinic-main" style="height: 556px;">
        <div class="cc-left-nav flt" id="page-left-nav"><a href="clinicRegisterInfo.php" class="left-nav-clinicRegisterInfo cc-left-mark"><span class="ln-i-clinicRegisterInfo"></span>诊所注册信息</a><a href="personManage.php" class="left-nav-personManage "><span class="ln-i-personManage"></span>人员管理</a>
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
                <div class="info">
                    <div class="info-block">
                        <div class="info-title">注册人信息</div>
                        <div class="info-content">
                            <p class="info-con-p">
                                注册人姓名：<span class="J_infoItem" data-item-name="realName"></span>
                            </p>
                            <p class="info-con-p">
                                注册人手机：<span class="J_infoItem" data-item-name="phone"></span>
                            </p>
                        </div>
                    </div>

                    <div class="info-block">
                        <div class="info-title"><div class="title-inner"><span class="title-name">诊所信息</span><span class="edit-btn">修改诊所信息</span></div></div>
                        <div class="info-content">
                            <p class="info-con-p">
                                诊所名称：<span class="J_infoItem J_hospitalName" data-item-name="hospitalName"></span>
                            </p>
                            <p class="info-con-p">
                                诊所地址：<span class="J_infoItem J_address" data-item-name="address"></span>
                            </p>
                            <p class="info-con-p">
                                诊所编号：<span class="J_infoItem" data-item-name="hospitalNumber"></span>
                            </p>
                            <p class="info-con-p">
                                注册时间：<span class="J_infoItem" data-item-name="createDate"></span>
                            </p>
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