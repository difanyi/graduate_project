<?php
//储存结果
header("content-type=text/html;charset=utf-8");
include("getText.php");
//error_reporting(E_ALL || ~E_NOTICE);//忽略notice警告
ini_set('max_execution_time', '0');//不限制时间

//删除空格
function trimall($str){
    $qian=array(" ","　","\t","\n","\r");$hou=array("","","","","");
    return str_replace($qian,$hou,$str);    
}

//对病症进行匹配
function getsick($text){//$text 为feature数组
	mysql_connect("localhost","root","root");  
	mysql_select_db("hospital");  
	mysql_query("set names utf8");
	
	$f_num=count($text);//feature数量

	
	$sql = "select id from disease order by id desc"; //取得最后一个疾病的id，得到疾病数量 
	$result = mysql_query($sql);
	$sql_num=mysql_fetch_assoc($result);
	
    //$num  记录包含相同病症的数量  初始化0
	for($i=0;$i<=$sql_num['id'];$i++){
		$num[]=0;
	}
	
	for($i=0;$i<=$sql_num['id'];$i++){   //初始化rate数组
		$rate[]=0;
	}

    
	foreach($text as $val){
		$feature=$val;	
		for($i=1;$i<=49;$i++){   //此处有一个固定值
			//$sql = "select id,disease_name from disease where  feature".$i." like '%".str_replace(' ','',$feature)."%';"; //SQL语句 
			//$sql = "select id,disease_name from disease where  feature".$i." ='$feature';"; //SQL语句 	
			//这边要将病症拆成字进行处理
			$a = preg_replace('/([\x{4e00}-\x{9fa5}])/u', '$1%', $feature);//在字符中间加%   a%b%c%   正则
			$sql = "select id,disease_name,feature".$i." from disease where feature".$i." like '%".$a."';";//模糊查询
			$result = mysql_query($sql);
			
			$k=0;
			while($a = mysql_fetch_assoc($result)){  	 //如果存在该病症
				$id=$a['id'];
				$num[$id]++;
			}
		//echo "<br>";
	}
}
foreach ($num as $id=>$val){
	$sql="select count from disease where id=$id";
	$a= mysql_fetch_array(mysql_query($sql));
	if($val!=0){
		//echo $val."  ";
		//echo ($val+$a['count'])."        ";
		$rate[$id]=round((($val/($f_num+$a['count']))*100),2);
		//echo $rate[$id]." ";
		//echo "<br>";
	}
}
	//按照符合病症数倒序排序
	arsort($rate);
	$key_id1=array_keys($rate);
	
	//取前十个作为结果输出,取$num中的key，到数据库取疾病名
	$key_id=array_slice($key_id1,0,50);//控制输出数量

	$n=0;//计疾病数
	//输出病症及概率
	foreach($key_id as $val){
	$sql = "select * from disease where  id= '$val';"; //SQL语句  
	$result = mysql_query($sql);
	
	while(@$a = mysql_fetch_assoc($result)){     //如果存在该病症 
		//计算概率，此处假设所有的特征导致疾病的概率相等
		@$dis_rate=$rate[$val];
	    if($dis_rate!=0){
			//echo $n++;
			//echo "   疾病名称：".$a['disease_name'];
			//echo "   致病率：".$dis_rate."%";
			
			
			//模糊匹配内容
			//首先需要降数组$text中的内容表达为正则表达式
			$result=array();
			$k=0;
			for($i=1;$i<=49;$i++){   //此处有一个固定值
				foreach($text as $val){
					//获得正则表达式
					$val = preg_replace('/([\x{4e00}-\x{9fa5}])/u', '$1)([\x{4e00}-\x{9fa5}]|\s{0}|[\w\W]*)(', $val);
					$val = substr($val,0,strlen($val)-1); 
					$val="/(".$val."+$/u";
					//匹配
					if(preg_match($val,$a['feature'.$i])){
						array_unshift($result,$a['feature'.$i]); 
						$k++;
					}
					else{
						array_push($result,$a['feature'.$i]); 
					}
				}	
			}
			$sql_insert="insert into disease_result(disease_name,rate,num) values ('".$a['disease_name']."',".($dis_rate/100).",".$k.")";
			//echo $sql_insert."<br>";
			mysql_query($sql_insert);
			
			$result=array_unique($result);//$result中存储排好序的病症
			//print_r($result);
			$i=1;
			foreach($result as $key=>$val){//储存
				if($val!=''){
					$sql_insert="update disease_result set feature".($i++)."= '".$result[$key]."' where disease_name='".$a['disease_name']."'";
					//echo $sql_insert."<br>";
					mysql_query($sql_insert);
				}
			}
			/*
			foreach($result as $key=>$val){//打印
				if($key<$k){
					echo " <b>".$val."</b>";
				}
				else{
					echo " ".$val;
				}
			}
			*/
	    }
	}
	//echo "<br>";
	}
}



function getdisease($dis_description){
//从数据库终取得features
$dis_description=getstr($dis_description);
$feature=array();
mysql_connect("localhost","root","root");  
mysql_select_db("hospital");  
mysql_query("set names utf8");


						
							
							

$sql="select feature.feature,feature.id from feature where LOCATE(feature.feature,'".$dis_description."')> 0";
$result = mysql_query($sql);



while($a = mysql_fetch_assoc($result)){  	 //如果存在该病症
	$feature[]=$a['feature'];
}
/*
echo "<pre>原始";
print_r($feature);
echo "<pre>";
*/
//对feature数组进行处理，如果一个元素包含另一个关键词，删除被包含的
for($i=count($feature)-1;$i>=0;$i--){
	for($j=count($feature)-1;$j>=0;$j--){
		//echo $i."    ".$j;
		//echo  strstr($feature[12], $feature[6]);
		if($i!=$j){
		if(strstr($feature[$i], $feature[$j])){
			//echo $feature[$i]."包含".$feature[$j]." ";
			//unset($feature[$j]); 
			array_splice($feature,$j,1);
		}
		}	
	}
}
//把$feature数组的一些关键词进行替换

    $feature1=getarr($feature);
/*
echo "<pre>去除重复词并优化";
print_r($feature1);
echo "<pre>";
*/
//获取疾病
getsick($feature1);

}
/*
session_start();
$dis_description = $_POST['dis_description'];
$dis_description=getstr($dis_description);
//echo $dis_description;
getdisease($dis_description);
echo "<script  type='text/javascript'>alert('分析成功！'); </script>";  
echo "<script>url='../php/tapeText.php';window.location.href=url;</script> ";
*/
?>