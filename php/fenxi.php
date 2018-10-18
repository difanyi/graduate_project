<?php
//分析数据
header("content-type=text/html;charset=utf-8");
include("sqlresult.php");
session_start();
//获取所有的有效值   目前截至体格检查

$zhusu = $_POST['zhusu'];
$jiwang = $_POST['jiwang'];
$geren=$_POST['geren'];
$jiazu = $_POST['jiazu'];

$other=$_POST['other'];
$tigejiancha="";

$tigejiancha=$tigejiancha.$other;

$str=$zhusu.$jiwang.$geren.$jiazu.$tigejiancha;
//echo $str;
getdisease($str);
//echo "<script  type='text/javascript'>alert('分析成功！'); </script>";  
//echo "<script>window.history.back();</script> ";

?> 

	   <ul>   
						<?php 
							
							//mysql_connect("localhost","root","root");   //连接数据库  
							//mysql_select_db("hospital");  //选择数据库  
							//mysql_query("set names utf-8"); //设定字符集
							

							$sql="select * from disease_result";
							$result = mysql_query($sql);

							if(mysql_num_rows($result)==0){
								echo "<h1>请输入病例！</h1>";
							}
	
							while($a = mysql_fetch_assoc($result)){  	 //如果存在该病症
						?>
						<li>
						<div class="cdss-item-title cdss-item-marks" name="8457C0ACE0" title="<?php echo $a['disease_name'];?>" mayo="false" detail="false" treatment="false" reference="false">
							<label class="cdss-diagnoses-item-add " diseaseguid="34051" diseasename="<?php echo $a['disease_name'];?>" diseasecode="J06.900" diseaseid="34051">
								<i class="cdss-icon cdss-icon-add"></i> 
								<font style="font-weight:bold;"><?php echo $a['disease_name'];?></font>
							</label>
						</div>
						<div class="cdss-item-marks">
							<table cellpadding="0" cellspacing="0" border="0">       
								<tbody>
									<tr>	
										<td width="35" valign="top"><b>表现:</b></td>
										<td> 
										<?php
											for($i=1;$i<=49;$i++){
												if($a['feature'.$i]!=''){
													if($i<=$a['num']){
														echo "<span class='cdss-im-mk active' symtype='0'>".$a['feature'.$i]."</span>";
													}
													else{
														echo "<span class='cdss-im-mk' symtype='0'>".$a['feature'.$i]."</span>";
													}
												}	
											}
							
										?>
							           </td>
						            </tr> 
     
								</tbody>
							</table>
							<?php
							}
							$sql_deleteall="TRUNCATE TABLE disease_result";
							mysql_query($sql_deleteall);
							?>
						</div>
						<ul class="cdss-sub-diagnoses-list"></ul>
						</li>
						</ul>