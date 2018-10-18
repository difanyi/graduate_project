<?php include 'php/ifsession.php';?>
<!DOCTYPE html>
<!--匹配数据-->
<html lang="zh"><style type="text/css" id="833427046269"></style><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="UTF-8">
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title id="CC-title">门诊病历</title>
    <link rel="stylesheet" href="css/base.css">
    <link rel="stylesheet" href="css/ui-select.css">
    <link rel="stylesheet" href="css/newRecord.css">
    <link rel="stylesheet" type="text/css" href="css/app.min.css">
    
	<link rel="stylesheet" href="css/print-prescr.css">
	<link rel="stylesheet" href="css/overlay.css">
	<script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>

<script type="text/javascript">
var ref =1;
var delete_num=1;
function addNewDiv(){
  $("#t").append("<div style='background:#F5F5F5;padding:10px;margin-bottom:20px;'><p class='precord-module'>成药处方:</p><table style='border-collapse:separate; border-spacing:15px;'><tbody><tr><th >药品名称</th><th >规格</th><th >频率</th><th >单次剂量</th><th >用法</th><th >数量</th></tr><tr><th><input name='drugName1' style='width:110px;border:2px solid #DCDCDC;'></th><th><input name='standard1' style='width:65px;border:2px solid #DCDCDC;'></th><th><input name='frequency1'style='width:60px;border:2px solid #DCDCDC;'></th><th><input name='dosage_name1'style='width:30px;border:2px solid #DCDCDC;'><input name='dosage_suit1'style='width:30px;margin-left:5px;border:2px solid #DCDCDC;'></th><th><input name='usage1'style='width:60px;border:2px solid #DCDCDC;'></th><th><input name='amount1'style='width:60px;border:2px solid #DCDCDC;'></th><th><button id='delete_tr"+(delete_num)+"' style='margin:0px 0px 0px 15px;background:#3d77b9;color:#fff;width:20px;'class='short-btn'onclick='delete_tr(this)'></button></th></tr></tbody></table><button id='add_tr"+(ref)+"' style='margin:20px 0px 0px 10px;background:#3d77b9;color:#fff;' class='short-btn' onclick='add_tr(this)'>增加药品</button><button id='delete"+(ref)+"' style='margin:20px 0px 0px 430px;background:#3d77b9;color:#fff;width:40px;'  onclick='delete_div(this)' class='short-btn'>删除</button></div>");
  ref++;
            }	
function delete_div(obj){
  $('#'+obj.id).parent().remove();
  }
function delete_tr(obj)  {
  $('#'+obj.id).parent().parent().remove();
  }
function add_tr(obj){
	$('#'+obj.id).parent().find('table').append("<tr><th><input name='drugName1' style='width:110px;border:2px solid #DCDCDC;'></th><th><input name='standard1' style='width:65px;border:2px solid #DCDCDC;'></th><th><input name='frequency1'style='width:60px;border:2px solid #DCDCDC;'></th><th><input name='dosage_name1'style='width:30px;border:2px solid #DCDCDC;'><input name='dosage_suit1'style='width:30px;margin-left:5px;border:2px solid #DCDCDC;'></th><th><input name='usage1'style='width:60px;border:2px solid #DCDCDC;'></th><th><input name='amount1'style='width:60px;border:2px solid #DCDCDC;'></th><th><button id='delete_tr"+(delete_num)+"' style='margin:0px 0px 0px 15px;background:#3d77b9;color:#fff;width:20px;'class='short-btn'onclick='delete_tr(this)'></button></th></tr>");
	delete_num++;
}

</script>
<script type="text/javascript">
var ref =1;
var delete_num=1;	
function addNewDiv2(){
  $("#t").append("<div style='background:#F5F5F5;padding:10px;margin-bottom:20px;'  ><div id='div'><p class='precord-module'>饮片处方:</p><li style='margin-top:15px;list-style-type:none;padding-left:10px;'>剂数：<input name='' style='width:20%;border:2px solid #DCDCDC;'/>每日剂量：<input name='' style='width:20%;border:2px solid #DCDCDC;'/>用药频率：<input name='' style='width:20%;border:2px solid #DCDCDC;'/></li><li style='margin-top:15px;list-style-type:none;padding-left:10px;'>用法：<input name='' style='width:85%;border:2px solid #DCDCDC;'></li><li style='margin-top:15px;list-style-type:none;padding-left:10px;'>服用要求：<input name='' style='width:80%;border:2px solid #DCDCDC;'></li> <li style='margin-top:15px;list-style-type:none;padding-left:10px;'>饮片：<input name='' style='width:30%;border:2px solid #DCDCDC;'placeholder='饮片名称'/><input name='' style='width:5%;border:2px solid #DCDCDC;'placeholder='数量'/>g<input name='' style='width:30%;border:2px solid #DCDCDC;' placeholder='备注'/> ￥0.00 <button id='delete_tr1"+(delete_num)+"' style='margin-left:20px;background:#3d77b9;color:#fff;width:3%;height:20px;'class='short-btn'onclick='delete_tr1(this)'></button></li></div><button id='add_tr1"+(ref)+"' style='margin:20px 0px 0px 10px;background:#3d77b9;color:#fff;' class='short-btn' onclick='add_tr1(this)'>增加药品</button><button id='delete1"+(ref)+"' style='margin:20px 0px 0px 430px;background:#3d77b9;color:#fff;width:40px;'  onclick='delete_div1(this)' class='short-btn'>删除</button></div>");
  ref++;
            }
function delete_div1(obj){
  $('#'+obj.id).parent().remove();
  }
function delete_tr1(obj)  {
  $('#'+obj.id).parent().remove();
  }
function add_tr1(obj){
	$('#'+obj.id).parent().find('div').append("<li style='margin-top:15px;list-style-type:none;padding-left:10px;'>饮片：<input name='' style='width:30%;border:2px solid #DCDCDC;'placeholder='饮片名称'/><input name='' style='width:5%;border:2px solid #DCDCDC;'placeholder='数量'/>g<input name='' style='width:30%;border:2px solid #DCDCDC;' placeholder='备注'/> ￥0.00 <button id='delete_tr1"+(delete_num)+"' style='margin-left:20px;background:#3d77b9;color:#fff;width:3%;height:20px;'class='short-btn'onclick='delete_tr1(this)'></button></li>");
	delete_num++;
}

</script>
<script type="text/javascript">
var delete_num=1;
function addNewDiv3(){
  $("#checkitem").append("<li style='margin-top:15px;list-style-type:none;padding-left:10px;'><input name='' style='width:50%;border:2px solid #DCDCDC;margin-right:20px;'placeholder='检查项'/><input name='' style='width:20%;border:2px solid #DCDCDC;'placeholder='次数'/>￥0.00 <button id='delete_tr1"+(delete_num)+"' style='margin-left:20px;background:#3d77b9;color:#fff;width:3%;height:20px;'class='short-btn'onclick='delete_tr2(this)'></button></li>");
  delete_num++;
            }
function delete_tr2(obj)  {
  $('#'+obj.id).parent().remove();
  }


</script>

<script type="text/javascript">
var delete_num=1;
function addNewDiv4(){
  $("#addCostsmain").append("<li style='margin-top:15px;list-style-type:none;padding-left:10px;'><input name='' style='width:50%;border:2px solid #DCDCDC;margin-right:20px;'placeholder='材料费用'/>￥<input name='' style='width:20%;border:2px solid #DCDCDC;'placeholder='价格'/> <button id='delete_tr1"+(delete_num)+"' style='margin-left:20px;background:#3d77b9;color:#fff;width:3%;height:20px;'class='short-btn'onclick='delete_tr3(this)'></button></li>");
  delete_num++;
            }
function delete_tr3(obj)  {
  $('#'+obj.id).parent().remove();
  }
  </script>
<script>  
   function fenxif()
{
	var zhusu = document.getElementById('zhusu').value;
	var jiwang =document.getElementById('jiwang').value;
	var geren=document.getElementById('geren').value;
	var jiazu = document.getElementById('jiazu').value;

	//var patient-tem=document.getElementById('zhusu').value;
	//var patient-weight=document.getElementById('zhusu').value;
	//var patient-rate=document.getElementById('zhusu').value;
	//var patient-blood1=document.getElementById('zhusu').value;
	//var patient-blood2=document.getElementById('zhusu').value;
	var other=document.getElementById('other').value;
	
	//alert(zhusu);
	
	if(zhusu==""){
		alert("您未填写主诉！");
	}
	else{
		alert("正在分析，请稍后...");
		var xmlhttp;
		if (window.XMLHttpRequest)
		{
			// IE7+, Firefox, Chrome, Opera, Safari 浏览器执行代码
			xmlhttp=new XMLHttpRequest();
		}
		else
		{
			// IE6, IE5 浏览器执行代码
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange=function()
		{
			if (xmlhttp.readyState==4 && xmlhttp.status==200)
			{
			document.getElementById("fenxiquyu").innerHTML=xmlhttp.responseText;
			}
		}
		xmlhttp.open("POST","php/fenxi.php",true);
		xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xmlhttp.send("zhusu="+zhusu+"&jiwang="+jiwang+"&geren="+geren+"&jiazu="+jiazu+"&other="+other);
		}
		
	}
  </script>
 <script type="text/javascript"> 

function saverecord(){  
    var patientID = $("input[name='jiezhen']:checked").val();
    document.getElementById('newform').action = "php/saverecord.php?patientID="+patientID;  
    document.getElementById("newform").submit();  
}  
function newrecord(){  
    //document.getElementById('newform').action = "php/newrecord.php";  
    //document.getElementById("newform").submit();  
	ref1.location.reload();
} 
function aa() {
	
var code = event.keyCode;
if(code == 32){
//alert('你按了空格键！');
fenxif();
}
if(code == 13){
//alert('你按了空格键！');
fenxif();
}
}

   </script>
   
 <script>

function bb()
{
	var patientID = $("input[name='jiezhen']:checked").val();
	//alert(patientID);
	if(patientID==null){
		alert("您未选中待诊患者！");
	}
	else{
		var xmlhttp;
		if (window.XMLHttpRequest)
		{
			// IE7+, Firefox, Chrome, Opera, Safari 浏览器执行代码
			xmlhttp=new XMLHttpRequest();
		}
		else
		{
			// IE6, IE5 浏览器执行代码
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange=function()
		{
			if (xmlhttp.readyState==4 && xmlhttp.status==200)
			{
			document.getElementById("jzdiv").innerHTML=xmlhttp.responseText;
			}
		}
		xmlhttp.open("POST","php/jiezhen.php",true);
		xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xmlhttp.send("patientID="+patientID);
		}
		document.getElementById('light').style.display='none';
		document.getElementById('fade').style.display='none';
	}
</script>
  
</head>

<body id="J-main-body">
<form id="newform" action="php/newrecord.php" method="post">
<?php include 'php/head.php';?>
<script> 
var para = document.getElementById("h2").className = "nav-list nav-registration nav-check";  
</script>
    <div class="cloudClinic-main flt" id="cloudClinic-main" style="height: 556px;">
        <div class="cc-left-nav flt" id="page-left-nav"><a href="newRecord.php" class="left-nav-newRecord cc-left-mark"><span class="ln-i-newRecord"></span>门诊病历</a><a href="newPrescription.php" class="left-nav-newPrescription "><span class="ln-i-newPrescription"></span>门诊处方</a><a href="fixSearch.php" class="left-nav-fixSearch "><span class="ln-i-fixSearch"></span>患者列表</a><div class="nav-today-list"><p class="today-list-title">今日就诊</p><div class="today-list-load" style="display: none;"><div class="loading-main">正在加载中,请稍后...</div></div><div class="today-list-data j_today_list" style="height: 390px;"><p class="today-list-none">暂无今日就诊</p></div></div></div>
        <div class="page-main-content flt" id="page-main-content" style="width: 1211px;">
            <!--PAGESTART-->
            <!--页面顶部固定条start-->
            <div class="fixed-panel top-fixed" id="top-fixed-panel">
                <div class="nav-fixed">
                    <div class="nav-btn">	
                        <input class='short-btn' name='1' type='button' value='接诊' onclick = "document.getElementById('light').style.display='block';" >
						<input class='short-btn' name='fenxi' type='button' value='分析' onclick="fenxif()" >
						<input class='short-btn' name='submit1' value='保存' type='button' onclick="saverecord()" >  
                    </div>
                    <div class="record-pop record-error"></div>
                    <div class="record-pop record-success"></div>
                </div>
            </div>
			
			<div id="light" style="display: none; position: absolute; top: 10%; left: 5%; width:50%; height: 60%;padding:30px; border: 1px solid #3d77b9; background-color: white; z-index:1002; overflow: auto;" >				
			<div class="newRegister-content" style="font-size:16px;">
				
					<h1 style="font-size:25px;padding:5px;" >选择患者</h1>
					<hr>
					<table CELLPADDING="100" CELLSPACING="100">
					<?php
						mysql_connect("localhost","root","root");  
						mysql_select_db("hospital");  
						mysql_query("set names utf8");
						$sql="select * from patient where status='待诊'";
						$result=mysql_query($sql);
						while($a=mysql_fetch_array($result)){
					?>
					<tr>
					<td style="padding:10px 40px 10px 40px;"><input type="radio" name="jiezhen" value="<?php echo $a['id'];?>" >
					<?php echo $a['patname'];?></td>
					<td style="padding:10px 40px 10px 40px;"><?php echo $a['sex'];?></td>
					<td style="padding:10px 40px 10px 40px;"><?php echo $a['age_number'].$a['age_unit']; ?></td>
					<td style="padding:10px 40px 10px 40px;"><?php echo $a['pattime'];?></td>
					</tr>
					
				<?php }?>
				</table>
                
                   


				   
                <div style="text-align:center;height:50px;line-height:30px;margin-top:30px;">
                <p>
				<input class='short-btn' name='jiezhen' type='button' value='接诊' style=" width:50px; height:30px; border:#0ss00 1px solid;vertical-align:middle;margin-left:20px;"  onclick="bb()" >
				<input type="button" name="close" class="short-btn" style=" width:50px; height:30px; border:#0ss00 1px solid;vertical-align:middle;margin-left:20px;" value="关闭" onclick ="document.getElementById('light').style.display='none';document.getElementById('fade').style.display='none';" >
				</p>
				</div>     
                                
            </div>
			</div>
            <!--页面顶部固定条end-->
			
            <div class="main-content-inner flt">
                <!--页面主体start-->
				
                <div class="cloudClinic-box" style="height: 492px; width: 812px;">
                    <div class="main-header">
					<div id="jzdiv">
                        <div class="first-line">
                            <p class="single-information name">
                                <b class="info-must">*</b><b>姓名:</b><input type="text" name="patient-name" class="patient-name zh-ipt recordIpt mustInt p_patientName" issug="1"><ul class="sug-ul-dom " style="border: 1px solid rgb(223, 223, 223); width: 229.567px; display: none;"></ul>
                            </p>
                            <ul class="name-search-content" style="display: none;"></ul>
                            <p class="single-information sex">
                                <b class="info-must">*</b><b>性别:</b>
                                 &nbsp;<input name="Sex" checked="true" id="Radio1" type="radio"  value="男"/>男&nbsp;<input name="Sex" id="Radio2"  type="radio"value="女">女
                            </p>
                        </div>
                        <div class="second-line">
                            <p class="single-information">
                                <b class="info-must">*</b><b>年龄:</b>
								<input type="text" name="patient-age" class="patient-age recordIpt mustInt p_age">
                                
								<select name="age-unit" class="J_ageUnit ui-select">
                                            <option value="岁" selected="selected" title="岁">岁</option>
                                            <option value="月" title="月">月</option>
                                            <option value="天" title="天">天</option>
                                        </select>
                            </p>
							
                            <p class="single-information phone">
                                <b class="info-must">*</b><b>电话:</b><input type="text" name="patient-tel" class="phone-num zh-ipt recordIpt p_patientPhone">
                            </p>
							
                        </div>
						</div>
                        <div class="first-patient-history autoHeight">
                            <p class="autoTitle" style="line-height: 16px;"><b class="info-must">*</b>主诉/<br>现病史:</p>
                            <div>
							<input name="zhusu" class="patient-old recordIpt autoIpt gr-border J_divEditable" contenteditable="true" id="zhusu" onkeyup="aa()"/>
							</div>
						</div>
                        <div class="patient-history autoHeight">
                            <p class="autoTitle">既往史:</p>
							<div><input name="jiwang"class="patient-history zh-ipt2 recordIpt autoIpt p_previousHistory gr-border J_divEditable" contenteditable="true" id="jiwang" onkeyup="aa()"/></div>
                        </div>
                        <div class="patient-history autoHeight">
                            <p class="autoTitle">个人史:</p>
							<div><input name="geren"class="patient-history zh-ipt2 recordIpt autoIpt p_personalHistory gr-border J_divEditable" contenteditable="true" id="geren" onkeyup="aa()"/></div>
                        </div>
                        <div class="patient-history2 autoHeight">
                            <p class="autoTitle">过敏史:</p>
                            <div><input name="guomin" class="patient-history2 zh-ipt2 recordIpt autoIpt p_allergyHistory gr-border J_divEditable" contenteditable="true"/></div>
							
                        </div>
                        <div class="patient-history2 autoHeight">
                            <p class="autoTitle">家族史:</p>
                            
							<div><input name="jiazu"class="patient-history zh-ipt2 recordIpt autoIpt p_previousHistory gr-border J_divEditable" contenteditable="true" id="jiazu" onkeyup="aa()"/></div>
                        </div>
                    </div>
                    <div class="main-mid">
                        <div class="two-line dif-width">
                            <b class="check-title">体格检查:</b>
                <p class="check-up same-line">
                    &nbsp;体温:<input type="text" name="patient-tem"  id="patient-tem" class="zh-ipt recordIpt numIpt p_temperature">℃
                </p>
                <p class="check-up same-line">
                    体重:<input type="text" name="patient-weight"  id="patient-weight" class="zh-ipt recordIpt numIpt p_weight">KG
                </p>
                <p class="check-up same-line check-up2">
                    心率:<input type="text" name="patient-rate" id="patient-rate" class="zh-ipt recordIpt numIpt p_heartRate">bpm
                </p>
                <p class="check-up1 same-line">
                    血压:<input type="text" placeholder="收缩压" name="patient-blood1" id="patient-blood1" class="zh-ipt1 recordIpt numIpt p_bloodPressureSBP">/<input type="text" placeholder="舒张压" name="patient-blood2"  id="patient-blood2" class="zh-ipt1 recordIpt numIpt p_bloodPressureDBP">mmHg
                </p>
                            <p class="other">
                                <input autoheight="true" name="other" id="other" placeholder="其他体格检查" class="zh-ipt recordIpt p_otherPhysique" onkeyup="aa()"></input>
                            </p>
                        </div>
                    </div>
                    <div class="main-mid2">
                        <div class="there-line">
                            <b class="info-must">*</b><b>诊断:</b>
							<input autoheight="true" name="zhenduan" ></input>
                           
                        </div>
                    </div>
                    <div class="main-mid3 f-ps">
                        <div class="four-line">
                            <b>检查治疗项:</b>
                            <button type="button" class="short-btn addCheck" onclick="addNewDiv3()">添加</button>
                            <div class="check-item" id="checkitem">
                                
                                
                            </div>
                        </div>
                    </div>
                    <!-- - - - - - - - - - - 处方 - - - - - - - - - - -->
                    <div class="main-mid4 f-ps">
                        <div class="prescriptions" id="t">
                            <b style="font-size: 14px;">处方:</b>
                            <button type="button" class="addWestDrug long-btn" onclick="addNewDiv()">添加成药处方</button>
                            <button type="button" class="addChineseDrug long-btn" onclick="addNewDiv2()">添加饮片处方</button>
                            <p class="loadCommonPres long-btn">载入常用处方</p>
                        </div>
                        <div class="westDrug">
                        </div>
                        <div class="chineseDrug">
                        </div>
                    </div>
                    <!-- - - - - - - - - - - 附加费用 - - - - - - - - - - -->
                    <div class="main-mid6 f-ps">
                        <div class="four-line1">
                            <b>附加费用:</b>
                            <button  type="button" class="short-btn addCost" onclick="addNewDiv4()">添加</button>
                            
                                <div class="addCosts-main" id="addCostsmain">
                                    
                                    
                                    
                                </div>
                            
                        </div>
                    </div>
                    <!-- - - - - - - - - - - 医嘱- - - - - - - - - - -->
                    <div class="doctorSay autoHeight">
                        <p class="autoTitle">医嘱:</p>
                        <div class="single-line">
                            <!--<div name='yizhu' class="zh-ipt2 recordIpt autoIpt2 gr-border J_divEditable J_advice_content" contenteditable="true"></div>-->
							<input autoheight="true" name="yizhu" class="zh-ipt2 recordIpt autoIpt2 gr-border J_divEditable J_advice_content" contenteditable="true" onkeyup="aa()"></input>
                            <div class="advice-temp J_advice_temp">...</div>
                        </div>
                    </div>
                    <!-- - - - - - - - - - - 合计- - - - - - - - - - -->
                    <div class="main-mid7">
                        <div class="four-line2">
                            <p class="totalAmount">合计金额：<em>￥<i style="font-weight: bold"> 0.00</i></em></p>
                        </div>
                    </div>
                </div>

			<!--右侧栏-->
            <div class="page-iframe-content" style="left:812px;">
                <div id="cdss_container" class=" cdss-parent-context-part" style="height: 100%;">
			    <div class="cdss-header"><label for="cdss_search_input" class="cdss-sh-box"><input type="text" id="cdss_search_input" placeholder="支持首字母搜索诊断"> <i class="cdss-icon cdss-icon-search"></i></label><a class="cdss-sh-btn" id="cdss_know_search_btn">搜索</a></div>
					
				<div class="cdss-page-part" id="cdss_page_part_box" style="height: 620px;">
				<div class="cdss-view-main" id="cdss_view_main">
					<dl class="assisted-interogation-part assisted-inner-part">
					<dt id="cdss_fz_t_name">辅助输入</dt>
						<dd id="cdss_history_data" class="cdss-item-marks hide"></dd>
						<dd id="cdss_assistedmarks_selected" class="cdss-item-marks"> 
							<span symtype="" class="cdss-im-mk">发热</span> 
							<span symtype="" class="cdss-im-mk">头痛</span>  
							<span symtype="" class="cdss-im-mk">头晕</span>  
							<span symtype="" class="cdss-im-mk">咽痛</span>  
							<span symtype="" class="cdss-im-mk">鼻塞</span> 
							<span symtype="" class="cdss-im-mk">流涕</span>  
							<span symtype="" class="cdss-im-mk">咳嗽</span>  
							<span symtype="" class="cdss-im-mk">咳痰</span>  
							<span symtype="" class="cdss-im-mk">呼吸困难</span>
							<span symtype="" class="cdss-im-mk">腹痛</span>  
							<span symtype="" class="cdss-im-mk">腹泻</span>  
							<span symtype="" class="cdss-im-mk">腹胀</span>  
							<span symtype="" class="cdss-im-mk">恶心</span>  
							<span symtype="" class="cdss-im-mk">呕吐</span>
							<span symtype="" class="cdss-im-mk">反酸</span>  
							<span symtype="" class="cdss-im-mk">便秘</span>  
							<span symtype="" class="cdss-im-mk">胸痛</span>  
							<span symtype="" class="cdss-im-mk">心悸</span>  
							<span symtype="" class="cdss-im-mk">腰背痛</span> 
							<span symtype="" class="cdss-im-mk">关节痛</span>  
							<span symtype="" class="cdss-im-mk">尿频</span>  
							<span symtype="" class="cdss-im-mk">尿急</span>  
							<span symtype="" class="cdss-im-mk">尿痛</span>  
							<span symtype="" class="cdss-im-mk">多尿</span> 
							<span symtype="" class="cdss-im-mk">排尿困难</span>  
							<span symtype="" class="cdss-im-mk">水肿</span>  
							<span symtype="" class="cdss-im-mk">皮疹</span> 
						</dd>
					</dl>
					<dl class="common-diagnoses-part">
						<dt id="cdss_cj_t_name">常见诊断</dt>
						<dd id="common_diagnoses_part_dd">
						<div id="fenxiquyu"></div>
						</dd>
					</dl>
				</div>
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

	
	
	
	
	
	
    <script type="text/javascript">
	/*在全部的input里面都可以辅助输入，发现呈现较乱，故用旧方法
$('input').focus(function(){
				inputid=$(this).attr('id');
			
			});
	
    spans = document.getElementsByTagName("span");//获得所有的span
    for (i = 0; i < spans.length; i++) {
        if (spans[i].className == "cdss-im-mk") {
            spans[i].onclick = function () {  //定义onclick事件
                var text = document.getElementById(inputid).value;//文本框内容
                if (text != "") {
                    var text1 =  this.innerHTML;//span内容
                    var t = text.search(text1);
                    if (t == -1) {//如果没有重复值
                        document.getElementById(inputid).value = document.getElementById(inputid).value + ' ' + this.innerHTML;
                    }
                    else {//如果有重复值
						text=text.replace(text1,'');
						document.getElementById(inputid).value = text;
                    }
                }
                else
                { document.getElementById(inputid).value = this.innerHTML; }
			
            } 
        }
    }
	*/
	spans = document.getElementsByTagName("span");//获得所有的span
    for (i = 0; i < spans.length; i++) {
        if (spans[i].className == "cdss-im-mk") {
            spans[i].onclick = function () {  //定义onclick事件
                var text = document.getElementById("zhusu").value;//文本框内容
                if (text != "") {
                    var text1 =  this.innerHTML;//span内容
                    var t = text.search(text1);
                    if (t == -1) {//如果没有重复值
                        document.getElementById("zhusu").value = document.getElementById("zhusu").value + ' ' + this.innerHTML;
                    }
                    else {//如果有重复值
						text=text.replace(text1,'');
						document.getElementById("zhusu").value = text;
                    }
                }
                else
                { document.getElementById("zhusu").value = this.innerHTML; }
			
            } 
        }
    }
    </script>

<script>

$('span').on('click',function(){
	
	if($(this).attr('class') == "cdss-im-mk"){
		$(this).addClass("cdss-im-mk active");
		fenxif();
	}
	
	else{
		$(this).removeClass("active");
	}
	//alert($(this).attr('class'));
})

</script>


    <!--JSEND-->





</form>


</body></html>