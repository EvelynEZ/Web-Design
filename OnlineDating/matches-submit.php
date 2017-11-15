<?php 
#Jiaqi Zhang; Section: AJ; HW04.
#This php page shows matches for registered users. Their matched user(s) have opposite gender, 
#compatible age, same favorite os and at least one personality type in common with them.
#Functions:      1).getUser function: look for the information of the current user.
#                2).compareType function: compare the personality type of users from the database 
#to the current user, returns true if there is any same type at the same index.
include("common.php");
$name=$_GET["name"];
?>
<h1>Matches for <?=$name?> </h1>
<?php 
$user=getUser($name);
list($name, $gender, $age, $type, $os, $min, $max) = explode(",", $user);

foreach(file("singles.txt") as $applicant){
	list($aname, $agender, $aage, $atype, $aos, $amin, $amax) = explode(",", $applicant);
	if(($agender != $gender) && ($aage <= $max) && ($aage >= $min) && ($age <= $amax) && 
		($age >= $amin) && ($aos == $os) && (compareType($type, $atype))) { 
		?>
		<div class = "match">
			<p>
			    <img src="https://webster.cs.washington.edu/images/nerdluv/user.jpg" alt="user"/>
				<?=$aname?>
			</p>
			<ul>
			    <li><strong>gender:</strong><?=$agender?></li>
			    <li><strong>age:</strong><?=$aage?></li>
			    <li><strong>type:</strong><?=$atype?></li>
			   	<li><strong>OS:</strong><?=$aos?></li>
			</ul>	   
		</div>
	<?php
	}
}

function getUser($name){
  	foreach(file("singles.txt") as $user){
		if(explode(",", $user)[0] == $name){
			return $user;
		} 
	}   
}

function compareType($type, $atype){
	$index = 0;
	while($index < strlen($type)){
		if($type[$index] == $atype[$index]){
			return true;
		}
		$index++;
	}
	return false;
}

bottom();
?>