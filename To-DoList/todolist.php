<?php 
#Jiaqi Zhang; Section: AJ; HW05
#This is a to-do list for loggedin users where allows users to add/delete their items or to log 
#out from their account. Any user without being logged in visiting this page should be directed
#to the start.php page.
session_start();

if (!isset($_SESSION["name"])){
	header("Location: start.php");
	die();
} 

$name = $_SESSION["name"];
include("common.php");
?>
		<div id="main">
			<h2><?=$name?>'s To-Do List</h2>

			<ul id="todolist">
				<?php
				if(file_exists("todo_$name.txt")){ 
					$count = 0;
					$items = file("todo_$name.txt");
					foreach($items as $item) {?>
						<li>
							<form action="submit.php" method="post">
								<input type="hidden" name="action" value="delete" />
								<input type="hidden" name="index" value="<?=$count?>" />
								<input type="submit" value="Delete" />
							</form>
							<?=htmlspecialchars($item); 
							#HTML encode the to-do items before outputting.?>
						</li>
						<?php
						$count++;
					}
				} ?>
				<li>
					<form action="submit.php" method="post">
						<input type="hidden" name="action" value="add" />
						<input type="text" name="item" size="25" autofocus="autofocus" />
						<input type="submit" value="Add" />
					</form>
				</li>
			</ul>

			<div>
				<a href="logout.php"><strong>Log Out</strong></a>
				<em>(logged in since <?=$_COOKIE["date"] ?>)</em>
			</div>
		</div>

<?php
bottom(); ?>