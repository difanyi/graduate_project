<?php 
mysql_connect("localhost","root",'root') ;
mysql_select_db("hospital");
mysql_query("set names utf8");
$result3=mysql_query("select docname from department ");
while($row3=mysql_fetch_assoc($result3)){
	$a[]=$row3['docname'];
	@$i++;
}
echo "<pre>";
//var_dump($a);
echo "</pre>";

for($k=0;$k<$i;$k++){

$str[$k]=substr($a[$k],1,(strlen($a[$k])));

}
echo "<pre>";
var_dump($str);
echo "</pre>";
$p=0;
/*
array(5) {
  [0]=>
  string(27) "强强,天宇,段誉,文人"
  [1]=>
  string(16) "温柔,戴菲菲"
  [2]=>
  string(6) "张三"
  [3]=>
  string(13) "尔,任天野"
  [4]=>
  string(6) "花花"
}
*/

?>