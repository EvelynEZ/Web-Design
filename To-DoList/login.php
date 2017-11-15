<?php
#Jiaqi Zhang; Section: AJ; HW05
#This page recieves data from the start.php page. If the current username exists and password
#matches, the current user, as well as any other logged-in users, will be directed to their
#to-do list page. For new users, valid username and password will be saved and they should 
#be directed to a blank to-do list. Invalid input would direct the page back to start.php.
session_start();
if(isset($_SESSION["name"])){ 
	redirect("todolist");
} 

$name = $_POST["name"];
$password = $_POST["password"];

if($name == null || $password == null){ ?>
	<p>Invalid Username or Password. </p>
<?php
	die();
} 

if (findUser($name) != null) { #user exists
	if(findUser($name)[1] != $password ) { #password is wrong.
		redirect("start");
	} else { #password matches, log the user in.
		login($name);
	}
} else{ #user does not exist, prepare to register a new account.
	if(preg_match("/^[a-z]{1}([0-9a-z]){2,7}$/", $name) && preg_match("/^[0-9].{4,10}[^0-9a-z]$/", $password)) {
		#checks if the username and password are valid, log the user in if both valid.
		file_put_contents("users.txt", $name.":".$password."\n", FILE_APPEND);
		login($name);
	} else {   #username or password invalid, redirected to the start.php page.
		redirect("start");
	}
}

#This function takes the username submitted by the user as a parameter, looks for a match of the username in the
#"users.txt" file, returns user's line of information immediately when it finds a match. If no match found,
#function returns null. 
function findUser ($name){
	$users = file("users.txt");
	foreach($users as $user){
		$userinfo = explode(":", trim($user));
		if($name == $userinfo[0]){
			return $userinfo;
		}
	}
	return null;
}

#This function is only called when all input are valid. A login session plus a cookie which marks the login time
#are created for the user with the name given in the paramater. Then the logged-in user is directed to the 
#todolist.php page.
function login ($name){
	$_SESSION["name"] = $name;
	$date = date("D y M d, g:i:s a");
	setcookie("date", $date, time() + 60*60*24*7);
	redirect("todolist");
}

#This funciton takes the $page parameter and redirects to the page that the parameter: $page indicates.
function redirect($page){
	header("Location: $page.php");
	die();
}
?>












