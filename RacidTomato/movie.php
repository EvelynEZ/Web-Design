<?php 
	$movie = $_GET["film"];
	list($title, $year, $rate) = file("$movie/info.txt");
	$review = glob("$movie/review*.txt");
?>

<!DOCTYPE html>
<!-- Jaiqi Zhang; Section: AJ; HW03:movie.php; 
Extra Feature: 1).Top/Bottom banner fixed. 2).Changing Page Title. 3).Mega Tags html. 
The php code enables the page to show reviews for a variety of movies using the same code. -->
<html>
	<head>
		<title>Rancid Tomatoes - <?= $title ?> </title>
		<meta charset="utf-8" />
		<meta name="keywords" content="movie review, rotten tomato" />
		<meta name="description" content="This website shows a variety of movie reviews." />
		<link href="movie.css" type="text/css" rel="stylesheet" />
		<link href="https://webster.cs.washington.edu/images/rotten.gif" rel="icon" type="image/png" />
	</head>

	<body>
		<?php wideBanner ("topbanner"); ?>
		
		<h1> <?= $title ?>(<?=trim($year)?>)</h1>

		<div class="overall">
			<?php rateBanner($rate); ?>
			<div class="overview">	
				<img src="<?= $movie ?>/overview.png" alt="general overview" />
				<dl>
					<?php 
					$infos = file("$movie/overview.txt");
					foreach ($infos as $info){
						list($definition, $description) = explode (":", $info);
					?>
						<dt><?=$definition?></dt>
						<dd><?=$description?></dd>
					<?php 
					} ?>
				</dl>
			</div>

			<div class="leftsection">
				<div id="critic">
					<?php 
					writeReview($review, 0, count($review)/2); 
					writeReview($review, (int)((count($review) + 1)/2), count($review)); 
					?>
				</div>
			</div>

			<p id="page">(1-<?= count($review) ?>) of <?=count($review) ?></p>
			<?php rateBanner($rate); ?>
		</div>

		<div id="validator">
			<a href="https://webster.cs.washington.edu/validate-html.php"><img src="https://webster.cs.washington.edu/images/w3c-html.png" alt="Valid HTML5"/></a><br />
			<a href="https://webster.cs.washington.edu/validate-css.php"><img src="https://webster.cs.washington.edu/images/w3c-css.png" alt="Valid CSS"/></a>
		</div>

		<?php wideBanner("bottombanner"); ?>
	</body>

	<?php 
	function writeReview($review, $start, $end) { ?>
		<div class="column">
			<?php
			for ($i = $start; $i < $end; $i++) { ?>
				<div class="review">
					<?php 
					list($quote, $vote, $user, $pub) = file("$review[$i]");
					?>
					<p class="quote">
						<img src="https://webster.cs.washington.edu/images/<?= trim(strtolower($vote)) ?>.gif" alt="<?= $vote ?>"/>
						<q><?= trim($quote) ?></q>
					</p>
					<p class="viewer">
						<img src="https://webster.cs.washington.edu/images/critic.gif" alt="Critic"/>
						<?= $user ?> <br />
						<span><?= $pub ?></span>
					</p>
				</div>
			<?php 
			} ?>
		</div>
	<?php 
	} 

	function rateBanner ($rate) {  ?>
		<div class="rottenbanner">
			<?php 
			if ($rate >= 60){
			?> 
				<img src="https://webster.cs.washington.edu/images/freshlarge.png" alt="Fresh"/>
			<?php 
			} else { ?>
				<img src="https://webster.cs.washington.edu/images/rottenlarge.png" alt="Rotten"/>
			<?php 
			} ?>
			<span><?=$rate?>%</span>
		</div>
	<?php 
	} 

	function wideBanner ($tag) { ?>
		<div id="<?= $tag ?>">
			<img src="https://webster.cs.washington.edu/images/rancidbanner.png" alt="Rancid Tomatoes"/>
		</div>
	<?php
	} ?>

</html>
