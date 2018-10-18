<?php
session_start();
session_destroy();
unset($_SESSION);
 echo "<script>url='/graduate-html/login.php';window.location.href=url;</script> ";
?>