<?php  
    //if(isset($_POST["submit"]) && $_POST["submit"] == "ע��")  
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
            echo "<script>alert('��ȷ����Ϣ�����ԣ�'); window.location.href = document.referrer;</script>";  
        }  
        else  
        {  
            if($psw == $psw_confirm)  
            {  
		
				//if($codeT==$codeP){
					mysql_connect("localhost","root","root");   //�������ݿ�  
					mysql_select_db("hospital");  //ѡ�����ݿ�  
					mysql_query("set names utf-8"); //�趨�ַ���  
					$sql = "select username from user where username = '$_POST[username]'"; //SQL���  
					$result = mysql_query($sql);    //ִ��SQL���  
					$num = mysql_num_rows($result); //ͳ��ִ�н��Ӱ�������  
					if($num)    //����Ѿ����ڸ��û�  
					{  
						echo "<script>alert('�û����Ѵ���');window.location.href = document.referrer;</script>";  
					}  
					else    //�����ڵ�ǰע���û�����  
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
							echo "<script>alert('ע��ɹ���'); </script>";  
							echo "<script>url='../registration.php';window.location.href=url;</script> ";
						}  
						else  
						{  
							echo "<script>alert('ϵͳ��æ�����Ժ�'); window.location.href = document.referrer;</script>";  
						}  
					}
				//}
				//else{
					//echo "<script>alert('��֤�����'); window.location.href = document.referrer;</script>"; 
				//}
            }  
            else  
            {  
                echo "<script>alert('���벻һ�£�'); window.location.href = document.referrer;</script>";  
            }  
        }  
  //  }  
  //  else  
    //{  
      //  echo "<script>alert('�ύδ�ɹ���'); history.go(-1);</script>";  
   // }  
?>  