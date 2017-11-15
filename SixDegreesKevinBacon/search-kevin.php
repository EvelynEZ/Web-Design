<?php
/*
Jiaqi Zhang; Section: AJ; HW06
This page shows a list of movies with the given actor and Kevin Bacon. Message given when the given
actor cannot be found in the database or there's no movie made together by the actor and Bacon, 
otherwise a list of movies should be shown.
*/
include("common.php");

$fullname = getName(); //get the fullname from the user's input
$actor_id = findid($fullname); //find the given actor's id from the database.

if ($actor_id != null){
	//this query jsearches for movies which involves Kevin Bacon and the given actor.
	$query = "SELECT m.name, m.year FROM movies m
			JOIN roles r1 ON m.id = r1.movie_id
			JOIN roles r2 ON m.id = r2.movie_id
			JOIN actors a1 ON a1.id = r1.actor_id
			WHERE a1.first_name = 'Kevin'
			AND a1.last_name = 'Bacon'
			AND r2.actor_id = $actor_id
			AND r1.movie_id = r2.movie_id
			ORDER BY m.year DESC, m.name ASC";	
	displaytable($query, $fullname, "Films with $fullname and Kevin Bacon");
}

bottom();
?>