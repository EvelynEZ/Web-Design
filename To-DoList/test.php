<?php
if(isset($_COOKIE["loggedin"])){
	if($_COOKIE["loggedin"] == TRUE){
		header("Location: todolist.php");
	}
} else {
	setcookie("loggedin", FALSE);
}
$name = "";
$password = "";
if (isset($_COOKIE["name"])){
	$name = $_COOKIE["name"];
} else {
	setcookie("name", $name);
}
if(isset($_COOKIE["passwrod"])){
	$password = $_COOKIE["passwrod"];
} else {
	setcookie("password", $password);
}
file_put_contents($filename,str_replace(file($filename)[$index],"",file_get_contents($filename)));

?>