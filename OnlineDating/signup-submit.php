<?php 
#Jiaqi Zhang; Section: AJ; HW04;
#This is the page that receives all the new user's data.

include("common.php"); 
$name=$_POST["newname"];
file_put_contents("singles.txt", $name.",".$_POST["gender"].",".$_POST["age"].
				 ",".$_POST["personality"].",".$_POST["os"].",".$_POST["min"].",".
				$_POST["max"]."\n", FILE_APPEND);
?>

<h1>Thank you!</h1>
<p>Welcome to NerdLuv, <?= $name; ?>! </p>
<p> Now <a href="matches.php">log in to see your matches!</a> </p>
<?php 
bottom();
?>
