<?php  
    //if(isset($_POST["submit"]) && $_POST["submit"] == "注册")  
    //{  
		session_start();
		$codeT = $_POST['codeT'];
		$codeP = $_SESSION["sessionCode"];	
        $user = $_POST["username"]; 
        $psw = $_POST["password"];  
        $psw_confirm = $_POST["c-password"]; 
        $truename=$_POST["truename"];		
	    $sex=$_POST['Sex'];
		$depname=$_POST['depname'];
		
        if($user == "" || $psw == "" || $psw_confirm == ""||$truename==""||$depname==""||$sex=="")  
        {  
            echo "<script>alert('请确认信息完整性！'); window.location.href = document.referrer;</script>";  
        }  
        else  
        {  
            if($psw == $psw_confirm)  
            {  
		
				//if($codeT==$codeP){
					mysql_connect("localhost","root","root");   //连接数据库  
					mysql_select_db("hospital");  //选择数据库  
					mysql_query("set names utf-8"); //设定字符集  
					$sql = "select username from user where username = '$_POST[username]'"; //SQL语句  
					$result = mysql_query($sql);    //执行SQL语句  
					$num = mysql_num_rows($result); //统计执行结果影响的行数  
					if($num)    //如果已经存在该用户  
					{  
						echo "<script>alert('用户名已存在');window.location.href = document.referrer;</script>";  
					}  
					else    //不存在当前注册用户名称  
					{  
						@$sql_insert = "insert into user (username,password,truename,sex,depname) values('$_POST[username]','$_POST[password]','$_POST[truename]','$_POST[Sex]','$_POST[depname]')";  
						$res_insert = mysql_query($sql_insert);  
						
						if($res_insert)  
						{  
							$sql_docname="select docname from department where depname='$_POST[depname]'";
						$a=mysql_query($sql_docname);
						$d=mysql_fetch_assoc($a);
					    $dd=$d['docname'];
							$sql_update="update department set docname = concat(docname,',$_POST[truename]')  where depname='$_POST[depname]'";
							mysql_query($sql_update);
						
							
							$_SESSION['name']=$user;
							echo "<script>alert('注册成功！'); </script>";  
							echo "<script>url='../registration.php';window.location.href=url;</script> ";
						}  
						else  
						{  
							echo "<script>alert('系统繁忙，请稍候！'); window.location.href = document.referrer;</script>";  
						}  
					}
				//}
				//else{
					//echo "<script>alert('验证码错误！'); window.location.href = document.referrer;</script>"; 
				//}
            }  
            else  
            {  
                echo "<script>alert('密码不一致！'); window.location.href = document.referrer;</script>";  
            }  
        }  
  //  }  
  //  else  
    //{  
      //  echo "<script>alert('提交未成功！'); history.go(-1);</script>";  
   // }  
?>  