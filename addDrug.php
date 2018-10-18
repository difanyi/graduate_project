<?php include 'php/ifsession.php';?>
<!DOCTYPE html>
<!-- saved from url=(0048)http://his.huimei.com/view/drugList/drugAdd.html -->
<html lang="zh"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <link rel="icon" href="http://his.huimei.com/images/favicon.ico?v=ceabd01deb" type="image/x-icon">
    <title id="CC-title">新增药品</title>
    <link rel="stylesheet" href="css/base.css">
    <link rel="stylesheet" href="css/overlay.css">
    <!--STYLESTART-->    
    <link rel="stylesheet" href="css/laydate.css">
    <link rel="stylesheet" href="css/drugAdd.css">
    <link rel="stylesheet" href="css/ui-select.css">

</head>
<body id="J-main-body" onload="aa()">

<div class="cloudClinic-body" superadmin="0">
   <?php include 'php/head.php';?>
    <div class="cloudClinic-main flt" id="cloudClinic-main" style="height: 531px;">
        <div class="cc-left-nav flt" id="page-left-nav">
		<a href="drugList.php" class="left-nav-drugList cc-left-mark"><span class="ln-i-drugList"></span>药品信息管理</a>
		<a href="" class="left-nav-drugHousing "><span class="ln-i-drugHousing"></span>药品入库</a>
		<a href="orderEarning.php" class="left-nav-orderEarning "><span class="ln-i-orderEarning"></span>库存预警</a>
		<a href="dateEarning.php" class="left-nav-dateEarning "><span class="ln-i-dateEarning"></span>效期提醒</a>
	</div>
       
        	<!--页面主体start-->
			<?php
			error_reporting(E_ALL^E_NOTICE);
				$id=$_GET['id'];
				if($id){
					mysql_connect("localhost","root",'root') ;
mysql_select_db("hospital");
mysql_query("set names utf8");
$sql="select * from drugs where Yp_id=$id";
$rest=mysql_query($sql);
while($row=mysql_fetch_assoc($rest)){?>
			<form id="newform" action="php/savedrugtype.php?id=<?php echo $row['Yp_id'];?>" method="post"> 
				<div class="page-main-content flt" id="page-main-content" style="width: 1211px;"><div class="fixed-panel top-fixed" id="top-fixed-panel">
            	<div class="header">
                    <span class="header-title f-left"><i class="J_saveTypeTitle">编辑</i>药品</span>
                    <input class="short-btn" type="submit" value="保存" onclick="">
                    <input class="short-btn" type="button" value="取消" onclick="">
                </div>
            </div><div class="main-content-inner flt">
				
				<div class="main">
                    
                        <div class="main-form">
                            <div class="main-form-block f-clrfix">
                                <div class="main-block-title">基本信息</div>
                                <div class="main-block-content">
                                    <div class="main-con-col f-clrfix">
                                        <div class="main-con-item col-md-4 sug-wrap">
                                            <span class="main-item-desc"><i>*</i>药品名称：</span>
                                            <input type="text" name="Yp_Name" value="<?php echo $row['Yp_Name'];?>"  onfocus="if (value =='<?php echo $row['Yp_Name'];?>'){value =''}" onblur="if (value ==''){value='<?php echo $row['Yp_Name'];?>'}"" class="J_drugName J_createSug J_inputChar150" issug="1"><ul class="sug-ul-dom " style="border: 1px solid rgb(223, 223, 223); width: 400px; display: none;"></ul>
                                        </div>
										    
<script type="text/javascript">				
    function aa(){
   document.getElementsByName('Yp_LB')[0].value = '<?php echo $row['Yp_LB'] ?>';
	   }			  
</script>
                                        <div class="main-con-item col-md-4" id="div1"  >
                                            <span class="main-item-desc"><i>*</i>药品类型：</span>
                                            <select class="select-drugtype J_drugType" name="Yp_LB" >
                                                <option value=""></option>
                                                <option value="西药">西药</option>
                                                <option value="中成药">中成药</option>
                                                <option value="中草药">中草药</option>
                                                <option value="卫生材料">卫生材料</option>
                                                <option value="其他">其他</option>
                                            </select>
                                        </div>
                                        <div class=" col-md-4">
                                            <span class="main-item-desc J_otcText">OTC：</span>
											<?php if($row['IsOTC']=='是'){?>
											<input name="IsOTC" id="Radio1" type="radio" value="是" checked="true"/>是&nbsp;
											<input name="IsOTC" id="Radio2"  type="radio" value="否" >否
                                            <?php }else{?>
											<input name="IsOTC" id="Radio1" type="radio" value="是"/>是&nbsp;
											<input name="IsOTC" id="Radio2"  type="radio" value="否" checked="true">否
											<?php }?>
                                        </div>
                                    </div>
            
                                    <div class="main-con-col f-clrfix">
                                        <div class="main-con-item col-md-4 drug-spec">
                                            <span class="main-item-desc"><i>*</i>包装规格：</span>
                                            <div class="drug-spec-bigitem">
                                                <input type="text" name="Yp_BZGG" value="<?php echo $row['Yp_BZGG'];?>"  onfocus="if (value =='<?php echo $row['Yp_BZGG'];?>'){value =''}" onblur="if (value ==''){value='<?php echo $row['Yp_BZGG'];?>'}"" class="J_inputChar50">
                                            </div>
                                            &nbsp;/
                                            <div class="drug-spec-item sug-wrap">
                                                <input type="text" name="Yp_BZDW" value="<?php echo $row['Yp_BZDW'];?>"  onfocus="if (value =='<?php echo $row['Yp_BZDW'];?>'){value =''}" onblur="if (value ==''){value='<?php echo $row['Yp_BZDW'];?>'}"" maxlength="6" class="J_createSug">
                                            </div>
                                        </div>
                                        <div class="main-con-item col-md-4 classify-wrap">
                                            <span class="main-item-desc classify">药品状态：</span>
                                            <div class="drug-spec-bigitem classify-outer">
                                                <input type="text" name="Yp_ZT"  value="<?php echo $row['Yp_ZT'];?>"  onfocus="if (value =='<?php echo $row['Yp_ZT'];?>'){value =''}" onblur="if (value ==''){value='<?php echo $row['Yp_ZT'];?>'}"" class="J_inputClassify classify_input J_createSug">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <span class="main-item-desc">状态：</span>
                                            
											<?php if($row['Yp_status']=='启用'){?>
											<input name="Yp_status" id="Radio3" type="radio" value="启用" checked="true"/>启用&nbsp;
											<input name="Yp_status" id="Radio4"  type="radio" value="停用" />停用
                                            <?php }else{?>
											<input name="Yp_status" id="Radio1" type="radio" value="是"/>启用&nbsp;
											<input name="Yp_status" id="Radio2"  type="radio" value="否" checked="true">停用
											<?php }?>
                                        </div>
                                    </div>
                                    <div class="main-con-col f-clrfix">
                                        <div class="main-con-item col-md-4 sug-wrap">
                                            <span class="main-item-desc"><i class="J_manufacturerRequire">*</i>生产厂家：</span>
                                            <input type="text" name="Yp_SCCJ"  value="<?php echo $row['Yp_SCCJ'];?>"  onfocus="if (value =='<?php echo $row['Yp_SCCJ'];?>'){value =''}" onblur="if (value ==''){value='<?php echo $row['Yp_SCJJ'];?>'}"" class="J_searchSug J_createSug">
                                        </div>
                                        <div class="main-con-item col-md-4">
                                            <span class="main-item-desc">批准文号：</span>
                                            <input type="text" name="Yp_PZWH" value="<?php echo "国药准字".$row['Yp_PZWH'];?>"  onfocus="if (value =='<?php echo $row['Yp_PZWH'];?>'){value =''}" onblur="if (value ==''){value='<?php echo $row['Yp_PZWH'];?>'}"" class="J_inputChar50" >
                                        </div>
										
                                    </div>
                                </div>
                            </div>
            
                            <div class="main-form-block">
                                <div class="main-block-title">库存销售设置</div>
                                <div class="main-block-content f-clrfix">
                                    <div class="main-con-col f-clrfix">
										<div class="main-con-item col-md-4">
											<span class="main-item-desc"><i>*</i>库存：</span>
											<input type="text" name="Yp_KC" maxlength="6" class="J_defaultValue J_inputIntZero" value="<?php echo $row['Yp_KC'].$row['Yp_BZDW'];?>"  onfocus="if (value =='<?php echo $row['Yp_KC'];?>'){value =''}" onblur="if (value ==''){value='<?php echo $row['Yp_KC'];?>'}"">
											<i class="J_countUnit J_unit"></i>
										</div>
										<div class="main-con-item col-md-4">
											<span class="main-item-desc"><i>*</i>进货价：</span>
											<input type="text" name="Yp_JHJ" class="J_defaultValue J_inputFloatZero" value="<?php echo $row['Yp_JHJ'];?>"  onfocus="if (value =='<?php echo $row['Yp_JHJ'];?>'){value =''}" onblur="if (value ==''){value='<?php echo $row['Yp_JHJ'];?>'}""">&nbsp;元
										</div>
										<div class="main-con-item col-md-4">
											<span class="main-item-desc"><i>*</i>售出价：</span>
											<input type="text" name="Yp_SCJ" class="J_defaultValue J_inputFloatZero" value="<?php echo $row['Yp_SCJ'];?>"  onfocus="if (value =='<?php echo $row['Yp_SCJ'];?>'){value =''}" onblur="if (value ==''){value='<?php echo $row['Yp_SCJ'];?>'}"">&nbsp;元
											<span class="warn J_inputWarn"></span>
										</div>
										 
                                    </div>
                                </div> 
								<div class="f-clrfix" style="margin-bottom:25px;">
								        <div class="main-con-item col-md-4">
											<span class="main-item-desc"><i>*</i>库存阈值：</span>
											<input type="text" name="Yp_KCFZ" maxlength="6" class="J_defaultValue J_inputIntZero" value="<?php echo $row['Yp_KCFZ'].$row['Yp_BZDW'];?>"  onfocus="if (value =='<?php echo $row['Yp_KCFZ'];?>'){value =''}" onblur="if (value ==''){value='<?php echo $row['Yp_KCFZ'];?>'}"">
											<i class="J_countUnit J_unit"></i>
										</div>  
                                    <div class="main-con-item col-md-4">
										<span class="main-item-desc"><i>*</i>效期：</span>
										<div class="validityDate">
											<input type="text" name="Yp_XQ" data-default-value="2999-01-01"  id="J_date" value="<?php echo $row['Yp_XQ'];?>"  onfocus="if (value =='<?php echo $row['Yp_XQ'];?>'){value =''}" onblur="if (value ==''){value='<?php echo $row['Yp_XQ'];?>'}"" class="J_inputChar100 J_defaultValue validity-date">
										</div>
									</div>
                                </div>
                                
                            </div>
            
                      
            
                            
							
                        </div>
                </div>
			</form>
<?php } }else{?>
<form id="newform" action="php/savedrugtype.php?id=0" method="post"> 
<div class="page-main-content flt" id="page-main-content" style="width: 1211px;"><div class="fixed-panel top-fixed" id="top-fixed-panel">
            	<div class="header">
                    <span class="header-title f-left"><i class="J_saveTypeTitle">新增</i>药品</span>
                    <input class="short-btn" type="submit" value="保存" onclick="">
                    <input class="short-btn" type="button" value="取消" onclick="">
                </div>
            </div><div class="main-content-inner flt">
				<div class="main">
                        <div class="main-form">
                            <div class="main-form-block f-clrfix">
                                <div class="main-block-title">基本信息</div>
                                <div class="main-block-content">
                                    <div class="main-con-col f-clrfix">
                                        <div class="main-con-item col-md-4 sug-wrap">
                                            <span class="main-item-desc"><i>*</i>药品名称：</span>
                                            <input type="text" name="Yp_Name" placeholder="商品名" class="J_drugName J_createSug J_inputChar150" issug="1"><ul class="sug-ul-dom " style="border: 1px solid rgb(223, 223, 223); width: 400px; display: none;"></ul>
                                        </div>
                                        <div class="main-con-item col-md-4">
                                            <span class="main-item-desc"><i>*</i>药品类型：</span>
                                            <select class="select-drugtype J_drugType" name="Yp_LB" data-change-way="add">
                                                <option value=""></option>
                                                <option value="西药">西药</option>
                                                <option value="中成药">中成药</option>
                                                <option value="中草药">中草药</option>
                                                <option value="卫生材料">卫生材料</option>
                                                <option value="其他">其他</option>
                                            </select>
                                        </div>
                                        <div class=" col-md-4">
                                            <span class="main-item-desc J_otcText">OTC：</span>
											<input name="IsOTC" id="Radio1" type="radio" value="是"/>是&nbsp;
											<input name="IsOTC" id="Radio2"  type="radio" value="否" checked="true">否
                                            
                                        </div>
                                    </div>
            
                                    <div class="main-con-col f-clrfix">
                                        <div class="main-con-item col-md-4 drug-spec">
                                            <span class="main-item-desc"><i>*</i>包装规格：</span>
                                            <div class="drug-spec-bigitem">
                                                <input type="text" name="Yp_BZGG" placeholder="规格包装描述" class="J_inputChar50">
                                            </div>
                                            &nbsp;/
                                            <div class="drug-spec-item sug-wrap">
                                                <input type="text" name="Yp_BZDW" placeholder="包装单位" maxlength="6" class="J_createSug">
                                            </div>
                                        </div>
                                        <div class="main-con-item col-md-4 classify-wrap">
                                            <span class="main-item-desc classify">药品状态：</span>
                                            <div class="drug-spec-bigitem classify-outer">
                                                <input type="text" name="Yp_ZT" class="J_inputClassify classify_input J_createSug">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <span class="main-item-desc">状态：</span>
                                            <input name="Yp_status" id="Radio3" type="radio" value="启用" checked="true"/>启用&nbsp;
											<input name="Yp_status" id="Radio4"  type="radio" value="停用" />停用
                                        </div>
                                    </div>
                                    <div class="main-con-col f-clrfix">
                                        <div class="main-con-item col-md-4 sug-wrap">
                                            <span class="main-item-desc"><i class="J_manufacturerRequire">*</i>生产厂家：</span>
                                            <input type="text" name="Yp_SCCJ" class="J_searchSug J_createSug">
                                        </div>
                                        <div class="main-con-item col-md-4">
                                            <span class="main-item-desc">批准文号：</span>
                                            <input type="text" name="Yp_PZWH" class="J_inputChar50">
                                        </div>
										
                                    </div>
                                </div>
                            </div>
            
                            <div class="main-form-block">
                                <div class="main-block-title">库存销售设置</div>
                                <div class="main-block-content f-clrfix">
                                    <div class="main-con-col f-clrfix">
										<div class="main-con-item col-md-4">
											<span class="main-item-desc"><i>*</i>库存：</span>
											<input type="text" name="Yp_KC" maxlength="6" class="J_defaultValue J_inputIntZero" data-default-value="0">
											<i class="J_countUnit J_unit"></i>
										</div>
										<div class="main-con-item col-md-4">
											<span class="main-item-desc"><i>*</i>进货价：</span>
											<input type="text" name="Yp_JHJ" class="J_defaultValue J_inputFloatZero" data-default-value="0.00">&nbsp;元
										</div>
										<div class="main-con-item col-md-4">
											<span class="main-item-desc"><i>*</i>处方价：</span>
											<input type="text" name="Yp_SCJ" class="J_defaultValue J_inputFloatZero" data-default-value="0.00">&nbsp;元
											<span class="warn J_inputWarn"></span>
										</div>
										 
                                    </div>
                                </div> 
								<div class="f-clrfix" style="margin-bottom:25px;">
								        <div class="main-con-item col-md-4">
											<span class="main-item-desc"><i>*</i>库存阈值：</span>
											<input type="text" name="Yp_KCFZ" maxlength="6" class="J_defaultValue J_inputIntZero" data-default-value="0">
											<i class="J_countUnit J_unit"></i>
										</div>  
                                    <div class="main-con-item col-md-4">
										<span class="main-item-desc"><i>*</i>效期：</span>
										<div class="validityDate">
											<input type="text" name="Yp_XQ" placeholder="2999-01-01" class="J_inputChar100 J_defaultValue validity-date" id="J_date">
										</div>
									</div>
                                </div>
                                
                            </div>
            
                      
            
                            
							
                        </div>
                    
                </div>
				
				
            <!--页面主体end-->
            </div></div></form>
			<?php }?>
    </div>
   
</div>


</body></html>