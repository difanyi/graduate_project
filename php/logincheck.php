<?php  

    header("content-type=text/html;charset=utf-8");
  
    //if($_POST["submit"]=="��¼")  
   // {  
		
        if($_POST["username"] == "" || $_POST["password"] == "")  
        {  

			echo "<script>alert('�������û��������룡'); history.go(-1);</script>";  
			
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
                echo "<script>alert('�û��������벻��ȷ��');history.go(-1);</script>";  
            }  
        }  
    //}  
   // else  
   // {  
		
		
       // echo "<script>alert('�ύδ�ɹ���'); history.go(-1);</script>";  
   // }  
  
?>  