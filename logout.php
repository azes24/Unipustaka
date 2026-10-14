<?php
session_start();
session_destroy();
header("location:login/loginpemustaka.php");
exit();
?>