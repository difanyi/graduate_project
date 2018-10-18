<!DOCTYPE html>
<!-- saved from url=(0054)http://his.huimei.com/view/register/quickRegister.html -->
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    
    <title>惠每云诊所_注册</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="chrome=1">
    <link rel="stylesheet" href="css/global.css">
    <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" href="css/login2.css">
    <link rel="stylesheet" href="css/overlay.css">
    <link rel="stylesheet" href="css/quickRegister.css">
<link rel="icon" href="images/favicon.ico" type="image/x-icon"><link rel="shortcut icon" href="favicon.ico" type="image/x-icon">





</head>
<body>

<form action="php/regcheck.php" method="post">

<div class="g-doc">
    <div class="u-mark"></div>
    <div class="m-hd">
        <div class="m-bd">
            <a class="j_logo_pos" href="login.php"><img src="images/header_logo.png" class="content-logo-pic" height="44"> 诊所系统</a>
        </div>
    </div>
    <div class="m-main">
        <div class="m-bd">
        
            <!-- 注册 -->
            <div class="m-register">
                <div class="m-regrMain f-cb">
                    <div class="m-fmRegr">
                        <div class="m-regr-top">
                            <p>注册</p>
                        </div>
                        <p class="m-fmRegr-desc"></p>
                        <div class="m-ipt f-cb">
                   
                            <input class="j-user" type="text" name="username" placeholder="登录名" autocomplete="off">
                            <span></span>
                        </div>
                       
                       <div class="m-ipt f-cb">
                   
                            <input class="j-user" type="text" name="truename" placeholder="真实姓名" autocomplete="off">
                            <span></span>
                        </div>
                       
                        <div class="password-box">
                            
                             <div class="m-ipt f-cb">
                            <input class="j-password1 j-password" type="password" name="password" placeholder="密码" autocomplete="off">
                        </div>
                        <div class="m-ipt f-cb">
                                <input class="j-password1 j-password" type="password" name="c-password" placeholder="重复密码" autocomplete="off">
                                <span></span>
                            </div>
                            
                        </div>
                         <div>
                      <p class="single-information sex " style="padding: 10px 20px 10px 20px; font-size: 16px;line-height: 50px;width: 290px!important;height: 30px!important;">
                              
                <input name="Sex" checked="true" id="Radio1" class="sex-radio-q sex-radio"  type="radio" value="男"/>男<input name="Sex" id="Radio2" style="margin:0 0 0 70px"  type="radio"value="女">女
                            </p>
						</div>
                       <?php include 'php/sqllink.php';?>
                        <div style="padding: 10px 20px 20px 20px; font-size: 16px;line-height: 50px;width: 290px!important;height: 30px!important;">
    <p class="register-name">
    <span style="color:black; size:14px">科室：</span>            <input type="hidden" id="select_content" name="select_content" />

    <select id="depname" name="depname" class=" ui-select">
                                    <option  value="不指定" selected="selected">不指定</option>
                                    <?php  
									$result1=mysql_query("select depname from department");
									while($row1=mysql_fetch_assoc($result1)){  
									?>
	                                <option   value="<?php echo $row1['depname'];  ?>" ><?php echo $row1['depname'];  ?></option>
	                                <?php }?>
                                </select>
    </p>
</div>
                        <div class="m-ipt f-cb">
                            <input class="j-phoneVy" type="text" name="codeT" placeholder="验证码">
                            
                             <img class="phone-vy" id="codeP" src="php/picture.php"  onclick="javascript:this.src='php/picture.php?tm='+Math.random()" />
                            <span></span>
                        </div>
                        
                        <div class="m-ipt f-cb marginTop100">
                            <p class="u-yhxz"><i class="j-register-check" data-read="1"></i>我已阅读并同意&nbsp;  
                            <a href = "javascript:void(0)" onclick = "document.getElementById('light').style.display='block';document.getElementById('fade').style.display='block'">"用户须知"</a></p> 
        <div id="light" class="white_content">
        
        <div>
        <div>
            
            <h2  align="center">用户须知</h2>
            <div ></div>
            <h3>一、患者信息保密</h3>
            <div >
                <p>惠每将根据行业标准严格对患者信息保密，未经同意我们不会将患者信息及与惠每系统进行数据交互的非公开内容提供给第三方（公司或个人），但以下情况除外：</p>
                <p>1、相关法律法规或监管机构、司法机构要求提供用户的个人资料；</p>
                <p>2、国家司法机关符合法律规定并经法定程序的检查及其他操作；</p>
                <p>3、任何第三方盗用、冒用或未经许可擅自披露、使用或对外公开的情况；</p>
            </div>
            <h3>二、免责申明</h3>
            <div >
                <p >1、用户同意使用惠每辅助诊疗系统及其相关服务，是出于用户个人的意愿，并愿意承担因自身意愿而产生的任何风险，包括但不限于其因不当执行惠每辅助诊疗建议而导致的任何资料的损失等；</p>
                <p>2、惠每辅助诊疗系统基于医生提供的真实准确信息为依据，为医生诊断提供建议；特此声明，惠每辅助诊疗系统所提供的一切建议仅供医生在诊疗过程中参考使用，诊疗过程中最终决定权属于医生，因此惠每对惠每辅助诊疗系统提出的任何建议导致的包括但不限于误诊、错诊、医疗事故等不承担任何法律责任。</p>
            </div>
            <h3>三、商业秘密及知识产权保密</h3>
            <div >
                <p >惠每辅助诊疗系统提供的服务中包含的任何文本、图片、图形、音频、视频资料和其他知识产权以及商业秘密，均受版权、商标及中国法律法规之保护。未经惠每相关权利人同意，用户不得将上述资料在任何媒介（包括但不限于媒体、网络、报纸、杂志等）直接或间接发布、播放或被用于其它任何商业目的。</p>
                <p>违反者必须销毁任何已经取得的上述信息、资料、软件或产品，同时，惠每保留采用技术、行政及法律手段挽回损失的权利，并可依照有关法律规定和惠每相关规定，追究其行政或民事责任，情节严重的，还将提请司法机关追究刑事责任。无论甲方采取何种方式追究乙方责任，惠每均有权要求违反者赔偿惠每所受到的实际损失。</p>
            </div>
            <h3>特别提示：</h3>
            <div >
                <p>用户在使用惠每辅助诊疗系统之前，请确保本人已经完全理解并接受本须知所有条款（尤其免责条款）。一旦用户正式使用，则表明用户已经完全理解并接受本须知所有条款。</p>
            </div>
        </div>
    </div>
    <!-- 预览框 -->
    <div class="m-pop"></div>
           <br>
           
           <div style="text-align:center;height:50px;line-height:30px">
           <button type="button" style=" width:50px; height:30px; border:#0ss00 1px solid;vertical-align:middle"  onclick = "document.getElementById('light').style.display='none';document.getElementById('fade').style.display='none'">关闭</button></div>

           
         	
       
          </div> 
        <div id="fade" class="black_overlay"></div> 
                            
                        </div>
                        
                        
                        
                        
                        <!-- 照片上传 -->
                        <!--<div class="m-posImg" id="upImage">-->
                            <!--<form name="form1" dynsrc="" method="post" action="http://upload.media.aliyun.com/api/proxy/upload?opt=n" enctype="multipart/form-data" target="edui_iframe" class="m-upLoad" id="uploadImage" >请上传“医疗机构执业许可证”或“执业医师证”的照片-->
                                <!--<span id="tempimg" class="u-upImg" href="javaScript:void(0);">选择并上传照片</span>-->
                                <!--<input id="upImgs" class="j-upImg" type="file" name="content" />-->
                                <!--<input type="text" name="size" value="3145728" style="display:none"/>-->
                                <!--<input type="text" name="name" value="2016012114235400000" style="display:none" id="ipcName"/>-->
                                <!--<input type="text" name="dir" value="/idPhoto" style="display:none"/>-->
                                <!--<input type="text" name="Authorization" value="<%=TOKEN %>" style="display:none" id="ipcToken"/>-->
                                <!--<iframe style="display:none;" name="edui_iframe" id="edui_iframe"></iframe>-->
                            <!--</form>-->
                        <!--</div>-->
                        
 <input class="u-registerBtn" name="submit" type="submit" value="注册"  >
                       
                        
                    </div>
                    
                    <!-- 我有账号 -->
                    <div class="m-regeSide">
                        <p>我有账号</p>
                        <a class="u-goLogin" href="login.php">立即登录</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    
</div>
</form>
</body></html>