<!DOCTYPE html>
<?php /*
Jiaqi Zhang; AJ; HW06
This is for any common code or function shared by the MyMDB site.
*/ ?>
<html>
	<head>
		<title>My Movie Database (MyMDb)</title>
		<meta charset="utf-8" />
		<link href="https://webster.cs.washington.edu/images/kevinbacon/favicon.png" type="image/png" rel="shortcut icon" />

		<!-- Link to your CSS file that you should edit -->
		<link href="bacon.css" type="text/css" rel="stylesheet" />
	</head>

	<body>
		<div id="frame">
			<div id="banner">
				<a href="mymdb.php"><img src="https://webster.cs.washington.edu/images/kevinbacon/mymdb.png" alt="banner logo" /></a>
				My Movie Database
			</div>
			<div id = "main">

<?php
//This function takes user's given name and returns the fullname as a string.
function getName(){
	$firstname = $_GET["firstname"]; 
	$lastname = $_GET["lastname"];
	return $firstname." ".$lastname;
}

//The function takes a given fullname as parameter and looks for the actor's id in the database.
//If no actor with given name is found, message should be generated, otherwise return the id as 
//a number.
function findid($fullname){	
	list($firstname, $lastname) = explode(" ", $fullname);
	//This query looks for actors with the given name, for those with same names, the one
	//with more movie count the smaller id number should be the macth.
	$query = "SELECT id FROM actors
					WHERE first_name LIKE  '$firstname%'
					AND last_name = '$lastname'
					ORDER BY film_count DESC, id ASC
					LIMIT 1";
	

	//get the result array from the PDO
	$id  = perform_query($query); 
	//if no actor with given name is found. 
	if($id -> rowCount() == 0) { 
	?>
		<p>Actor <?=$firstname." ".$lastname;?> Not Found. </p>
	<?php
		return null;
	} else {
		return $id->fetch(PDO::FETCH_ASSOC)["id"];
	}
}

//The function takes query strings, an given fullname and caption for a tabel, then ouput the 
//results as an ordered tabel.
function displaytable($query, $fullname, $caption){
	//get the result array from PDO.
	$rows = perform_query($query); 
	//checks if any movie's found in the database.
	if($rows -> rowCount() == 0){ 
	?> 
		<p> <?=$fullname ?> wasn't in any films with Kevin Bacon. </p>
	<?php
	} else { 
	 	$count = 1;  
	 	//outputs the array's info into an ordered tabel.?>
	 	<h1>Results for <?=$fullname ?></h1>
		<table>
			<caption><?=$caption ?></caption>
			<tr><th>#</th><th>Title</th><th>Year</th></tr>
			<?php
			foreach($rows as $row) { ?>
				<tr>
					<td><?=$count ?></td>
					<td><?=$row["name"] ?></td> 
					<td><?=$row["year"] ?></td>
				</tr>
				<?php
				$count++;
			} ?>
		</table>
	<?php
	}
}

//This function takes the given query string and performs it in the database
//returns the found PDO array.
function perform_query ($query){
	$db = new PDO("mysql:dbname=imdb;host=localhost;charset=utf8", "zjq95","O7j2ZSjmP2");
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
	return $db->query($query);
}

//The footer of the page, includes two forms which enables users to input and search for
//actors with given names.
function bottom() { ?>
					<!-- form to search for every movie by a given actor -->
				<form action="search-all.php" method="get">
					<fieldset>
						<legend>All movies</legend>
						<div>
							<input name="firstname" type="text" size="12" placeholder="first name" autofocus="autofocus" /> 
							<input name="lastname" type="text" size="12" placeholder="last name" /> 
							<input type="submit" value="go" />
						</div>
					</fieldset>
				</form>

				<!-- form to search for movies where a given actor was with Kevin Bacon -->
				<form action="search-kevin.php" method="get">
					<fieldset>
						<legend>Movies with Kevin Bacon</legend>
						<div>
							<input name="firstname" type="text" size="12" placeholder="first name" /> 
							<input name="lastname" type="text" size="12" placeholder="last name" /> 
							<input type="submit" value="go" />
						</div>
					</fieldset>
				</form>
			</div> <!-- end of #main div -->
		
			<div id="w3c">
				<a href="https://webster.cs.washington.edu/validate-html.php"><img src="https://webster.cs.washington.edu/images/w3c-html.png" alt="Valid HTML5" /></a>
				<a href="https://webster.cs.washington.edu/validate-css.php"><img src="https://webster.cs.washington.edu/images/w3c-css.png" alt="Valid CSS" /></a>
			</div>
		</div> <!-- end of #frame div -->
	</body>
</html>
<?php
}
?>