<?php

session_start();
if ($_SESSION['name']== null){
	echo "<script>url='/graduate-html/login.php';window.location.href=url;</script> ";
	}


?>