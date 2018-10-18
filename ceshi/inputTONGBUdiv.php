<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
<style type="text/css">
  #ppp{
   width:600px;
   height:220px;
   margin:0 auto;
   border:1px solid #666;
   background-color:pink;
  }
</style> 
<script type="text/javascript">
function aa(){
		document.getElementById("ppp").innerHTML = document.getElementById("ttt").value;
	}
function showMsg(){
var code = event.keyCode;
if(code == 13){
alert('你按了回车键！');
}

</script>

</head>
<body> 
    <input id="applyCertNum" type="text" name="applyCertNum" style="width:310px;"  onkeyup="showMsg()"><br /><br />
	<input type="button" value="提 交" onclick="aa()" />
	<div id="ppp"></div>
</body>
</html>