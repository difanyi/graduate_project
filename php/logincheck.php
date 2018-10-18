<?php  

    header("content-type=text/html;charset=utf-8");
  
    //if($_POST["submit"]=="登录")  
   // {  
		
        if($_POST["username"] == "" || $_POST["password"] == "")  
        {  

			echo "<script>alert('请输入用户名或密码！'); history.go(-1);</script>";  
			
        } 
		
        else  
        {  
            mysql_connect("localhost","root","root");  
            mysql_select_db("hospital");  
            mysql_query("set names utf8");  
            $sql = "select username,password from user where username = '$_POST[username]' and password = '$_POST[password]'";  
            $result = mysql_query($sql);  
            $num = mysql_num_rows($result); 
         		
            if($num)  
            {  
                session_start();
				$_SESSION['name']=$_POST['username'];
				
               echo "<script>url='../registration.php';window.location.href=url;</script> ";

            }  
            else  
            {  
                echo "<script>alert('用户名或密码不正确！');history.go(-1);</script>";  
            }  
        }  
    //}  
   // else  
   // {  
		
		
       // echo "<script>alert('提交未成功！'); history.go(-1);</script>";  
   // }  
  
?>  