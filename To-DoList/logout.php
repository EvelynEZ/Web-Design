<?php
#Jiaqi Zhang; Section: AJ; HW05
#When users decide to log out, they are directed to this page. Their login session is ended 
#and shouldbe directly directed to the start page.
session_start();
session_destroy();
header("Location: start.php");
die();
?>