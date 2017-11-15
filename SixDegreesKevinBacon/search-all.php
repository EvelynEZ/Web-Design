<?php
/*
Jiaqi Zhang; Section: AJ; HW06
This page shows search results for all films with the given actor. Message given if a actor is 
not in the database, otherwise a table of movies the actor performed will be shown.
*/
include("common.php");

$fullname = getName(); //get the name the user typed in.
$actor_id = findid($fullname); //look for the given name's id in the database.

if($actor_id != null) { //actor exists in the database
	//This query searches for the movies which involve the given actor.
	$query = "SELECT m.name, m.year FROM movies m 
					JOIN roles r ON r.movie_id = m.id  
					JOIN actors a ON a.id = r.actor_id
					WHERE a.id = $actor_id
					ORDER BY m.year DESC, m.name ASC"; 
	displaytable($query, $fullname, "All Films"); 
}

bottom();
?>