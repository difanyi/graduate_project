<div class="cloudClinic-body" superadmin="0">
    <div class="cloudClinic-header flt">
        <div class="header-content" id="header-content" data-warn="1">
          
          <h2 class="header-content-logo j_logo_pos">
        <img src="images/header_logo.png" class="content-logo-pic" height="44" alt="">诊所系统</h2>
        <nav class="header-nav">
		
        <a href="registration.php" id="h1" class="nav-list nav-registration ">挂号</a>
		 
        <a href="newRecord.php" id="h2" class="nav-list nav-clinic ">门诊</a>
        
        <a href="drugList.php" id="h6"  class="nav-list nav-statistics ">药品管理</a>
        <a href="userInfo.php"  id="h7" class="nav-list nav-clinicMana ">诊所管理</a></nav>
        <div class="header-user">
        
        
        <div class="menu" >    
<ul>     
   <li><a href="userinfo.php" style="color:white">欢迎 &nbsp
   <?php 

		  echo $_SESSION['name'];
   ?>
   
   </a>    
<ul>      
   <li style="border:1px solid #eee;"><a href="php/loginout.php" style="color:white">退出登录</a></li>    
</ul>    
</li>     
</ul>    
</div>     

</div>
</div>
</div>