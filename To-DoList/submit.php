<?php
#Jiaqi Zhang; Section: AJ; HW05
#This page takes the add/delete actions from the todolist.php page, modifies user's todolist file.
#If any parameter or info is missing or invalid, the page would generate an error message and 
#exits, otherwise, the page should always be redirected to the todolist.php page.
session_start();

if (!isset($_SESSION["name"])){
	header("Location: start.php");
	die();
} 

if(!isset($_POST["action"]) || !isset($_SESSION["name"])){ ?>
	<p>Error: Missing required info. </p>
	<?php
	die();
}

$action = $_POST["action"];
$name = $_SESSION["name"];
$filename = "todo_$name.txt";

if ($action == "add"){
	$item = $_POST["item"];
	file_put_contents($filename, trim($item)."\n", FILE_APPEND);
	#new items are put at the end of user's todo file.
} else { # ($action == "delete")
	$index = $_POST["index"]; 
	#only the item with the submitted index will be deleted from the file.
	if($index < count(file($filename))){ #index is a number in bound.
		$file = file($filename);
		for ($i = $index; $i < count($file) - 1; $i++){
			$file[$i] = $file[$i + 1];
		}
		array_pop($file);
		file_put_contents($filename, ""); #deletes the contents in the current file.
		foreach ($file as $line){
			file_put_contents($filename, $line, FILE_APPEND);
		}
	} else {  ?>
		<p> Error: invalid index. </p>
		<?php
		die();
	}
}

header("Location: todolist.php");
die();
?>