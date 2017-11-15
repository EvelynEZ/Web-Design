<?php
#Jiaqi Zhang; Section: AJ; HW05
#This is the start page with a login/register form for a online to-do list page called
#"Remember The Cow". If logged in users visit this page, they will be directed to their 
#to-do list page. 
session_start();
if(isset($_SESSION["name"])){ 
	header("Location: todolist.php");
	die();
} 
include("common.php");
?>

<div id="main">
	<p>
		The best way to manage your tasks. <br />
		Never forget the cow (or anything else) again!
	</p>

	<p>
		Log in now to manage your to-do list. <br />
		If you do not have an account, one will be created for you.
	</p>

	<form id="loginform" action="login.php" method="post">
		<div><input name="name" type="text" size="8" autofocus="autofocus"/> <strong>User Name</strong></div>
		<div><input name="password" type="password" size="8"/> <strong>Password</strong></div>
		<div><input type="submit" value="Log in" /></div>
	</form>
	
	<?php
	if (isset($_COOKIE["date"])){ ?>
		<p>
			<em>(last login from this computer was <?=$_COOKIE["date"] ?>)</em>
		</p>
	<?php
	} ?>
</div>

<?php bottom(); ?>
