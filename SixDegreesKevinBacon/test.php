<?php
$db = new PDO("mysql:dbname=imdb_small", "zjq95","O7j2ZSjmP2"); //can i put this part in common?
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


$rows = $db->query("SELECT m.name, m.year FROM movies m
					JOIN roles r ON r.movie_id = m.id
					JOIN actors a ON a.id = r.actor_id
					WHERE a.last_name = 'Smith'
					AND a.first_name LIKE 'Will%'
					ORDER BY m.year DESC ");
foreach( $rows as $row){
	print_r($row["name"].$row["year"]."\n");
}



?>