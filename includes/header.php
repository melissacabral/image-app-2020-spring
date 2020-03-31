<?php 
require( 'config.php' ); 
require( 'includes/functions.php' );
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Image App</title>
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/milligram/1.3.0/milligram.min.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
	<div class="site">
	<header class="header">
		<h1><a href="index.php">Image App</a></h1>

		<nav class="main-navigation">

			<form class="searchform" method="get" action="search.php">
				<label class="screen-reader-text">Search:</label>
				<input type="search" name="phrase">

				<input type="submit" value="Search">
			
			</form>

			<ul class="menu">
				<li><a href="#">Explore</a></li>
				<li><a href="#">Log In</a></li>
				<li><a href="#">Register</a></li>
			</ul>
			
		</nav>
	</header>