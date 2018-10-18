<?php include 'php/ifsession.php';?>
<!DOCTYPE html>
<!-- saved from url=(0057)http://his.huimei.com/view/personManage/personManage.html -->
<html lang="zh"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <link rel="icon" href="http://his.huimei.com/images/favicon.ico?v=ceabd01deb" type="image/x-icon">
    <title id="CC-title">人员管理</title>
    <link rel="stylesheet" href="css/base.css">
    <link rel="stylesheet" href="css/overlay.css">
    <!--STYLESTART-->
    <link rel="stylesheet" href="css/personManage.css">
    <!--STYLEEND-->
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
		<a href="userInfo.php" class="left-nav-clinicRegisterInfo "><span class="ln-i-clinicRegisterInfo"></span>用户信息</a>
		<a href="personManage.php" class="left-nav-personManage cc-left-mark"><span class="ln-i-personManage"></span>人员管理</a>
		<a href="departmentManage.php" class="left-nav-departmentManage "><span class="ln-i-departmentManage"></span>科室管理</a>
		<a href="treatmentSet.php" class="left-nav-treatmentSet "><span class="ln-i-treatmentSet"></span>检查治疗项设置</a>
	</div>
        <div class="page-main-content flt" id="page-main-content" style="width: 1211px;">
            <!--PAGESTART-->
            <!--页面顶部固定条start-->
            <div class="fixed-panel top-fixed" id="top-fixed-panel">
                <h2 class="treatmentSet-top">
                    <a href="javascript:void(0);" target="_self" class="treatmentSet-new long-btn j_add_exam">新建账号</a>
                </h2>
            </div>
            <!--页面顶部固定条end-->
            <div class="main-content-inner flt">
                <!--页面主体start-->
                <div class="treatment-list table-list ">
                    <table width="100%" border="0">
                        <colgroup><col width="10%"><col width="10%"><col width="5%"><col width="10%"><col width="6%"><col width="9%"><col width="5%"><col width="8%"><col width="8%"><col width="5%"><col width="6%"><col width="8%"><col></colgroup>
                        <thead>
                        <tr>
                            <th>登录账号</th> <th>真实姓名</th> <th>性别</th> <th>科室</th><th class="Com_900">挂号</th><th class="Com_1000">门诊</th><th class="Com_2000">收费/发药</th><th class="Com_3000">药品管理</th><th class="Com_4000">模板</th><th class="Com_5000">统计</th><th class="Com_6000">诊所管理</th>
                            <th class="doIt">操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                <div class="paging-page">
                    <div class="paging-page-box"></div>
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