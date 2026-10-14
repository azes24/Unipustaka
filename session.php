<?php
if(!isset($_SESSION['id'])){
    header("location:".BASE_URL."/login/loginpemustaka.php");
    exit();
}
?>