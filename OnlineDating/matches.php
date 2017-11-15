<?php 
#Jiaqi Zhang； Section: AJ; HW04
#This page allows existing users to log in and check their matches based on their info.

include("common.php"); ?>

<form action="matches-submit.php" method="GET">
	<fieldset>
		<legend>Returning User:</legend>
		<strong>Name:</strong>
		<input type="text" size="16" name="name"/> 
		<input type="submit" value="View My Matches" />
	</fieldset>
</form>

<?php 
bottom();
?>
