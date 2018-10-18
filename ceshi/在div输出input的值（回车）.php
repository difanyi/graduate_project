<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
 <head>
  <title> New Document </title>
  
  <script type="text/javascript">
  
function showMsg(){
var code = event.keyCode;
if(code == 13){
document.getElementById("ppp").innerHTML = document.getElementById("ttt").value;

}

}

  </script>
 </head>

 <body>
<input id="ttt"onkeyup="showMsg()">
<div id='ppp' style="background:pink;"></div>
 </body>
</html>