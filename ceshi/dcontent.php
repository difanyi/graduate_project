<?php
header("content-type=text/html;charset=utf-8");
ini_set('max_execution_time', '0');//不限制时间
//实现输入一行数据，自动分词，到数据库比较病症，得出疾病
//删除空格
function trimall($str){
    $qian=array(" ","　","\t","\n","\r");$hou=array("","","","","");
    return str_replace($qian,$hou,$str);    
}

//读csv文件内容，将病症提取出变为表格形式
function readcvs(){
	$file = fopen('a.txt.csv','r'); 
	while ($data = fgetcsv($file)) { //每次读取CSV里面的一行内容
	//print_r($data); //此为一个数组，要获得每一个数据，访问数组下标即可
	$goods_list[] = $data;
	}
	//echo "<pre>";
	//print_r($goods_list);
	//echo "<pre>";
	$text=array();
	for($i=1;$i<count($goods_list[3]);$i++){
		if($goods_list[3][$i]!=null){
			$text[]=trimall($goods_list[3][$i]); 
		}
	}
	for($i=1;$i<count($goods_list[4]);$i++){
		if($goods_list[4][$i]!=null){
			$text[]=trimall($goods_list[4][$i]); 
		}
	}
	//echo "<pre>";
	//print_r($goods_list);
	//echo "<pre>";
	fclose($file);
	//text 为除去空格和空单元格的数组
	//text可进行下一步处理
	return $text;
}

//对病症进行匹配
function getsick($text){
	mysql_connect("localhost","root","root");  
	mysql_select_db("hospital");  
	mysql_query("set names utf8"); 
	$f_num=count($text);
	//echo $f_num;
	//echo "<pre>";
	//print_r ($text);
	//echo "<pre>";
	
	//$num  记录包含相同病症的数量  初始化156个0
	$sql = "select id from disease order by id desc"; //SQL语句  
	$result = mysql_query($sql);
	$sql_num=mysql_fetch_assoc($result);
 
	for($i=0;$i<=$sql_num['id'];$i++){
		$num[]=0;
	}

	foreach($text as $val){
		$feature=$val;
		for($i=1;$i<=24;$i++){   //此处有一个固定值
			$sql = "select id,disease_name from disease where  feature".$i." like '%".str_replace(' ','',$feature)."%';"; //SQL语句  
			$result = mysql_query($sql);
			//echo $sql;
	 
			while($a = mysql_fetch_assoc($result)){  	 //如果存在该病症
			//echo $a['disease_name'];
			//echo $a['id'];
			//echo "   ";  
	  
			$id=$a['id'];
			$num[$id]++;
			}
		}
		//echo "<br>";
	}

	//按照符合病症数倒序排序
	arsort($num);
	//echo "<pre>";
	//print_r ($num);
	//echo "<pre>";
	$key_id1=array_keys($num);
	//取前十个作为结果输出,取$num中的key，到数据库取疾病名
	$key_id=array_slice($key_id1,0,10);


	//输出病症及概率
	foreach($key_id as $val){
	$sql = "select disease_name from disease where  id= '$val';"; //SQL语句  
	$result = mysql_query($sql);
	while($a = mysql_fetch_assoc($result)){     //如果存在该病症 
		//计算概率，此处假设所有的特征导致疾病的概率相等
		@$dis_rate=round((($num[$val]/$f_num)*100),2);
	    if($dis_rate!=0){
			echo "疾病名称：".$a['disease_name'];
			echo "   致病率：".$dis_rate."%";
	    }
	}
	echo "<br>";
	}
}

//main函数
 //接收传入的content
session_start();
$dis_description = $_POST['dis_description'];
//新建临时文件存储content
$file = fopen("a.txt",'w');
fwrite($file,$dis_description);
fclose($file);
//执行python文件，将结果储存在csv中
exec("C:\python27\python.exe test1.py ");
//处理scv
$text=readcvs();
//result 为除去空格和空单元格的数组
//result可进行下一步处理
getsick($text);
//删除临时文件
//unlink("a.txt");
//unlink("a.txt.csv");
?>