<?php 
require( 'config.php' ); 
require( 'includes/functions.php' );

//login security check
$logged_in_user = check_login();
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
				<li><a href="index.php">Explore</a></li>


				<?php if( ! $logged_in_user ){ 
					//Menu for NOT logged in users
				?>

				<li><a href="login.php">Log In</a></li>
				<li><a href="register.php">Register</a></li>

				<?php }else{ 
					//Menu for logged in users
				?>

				<li><a href="upload.php">New Post</a></li>
				<li><a href="#"><?php echo $logged_in_user['username']; ?>'s Account</a></li>
				<li><a href="login.php?action=logout">Log Out</a></li>

				<?php } ?>
			</ul>
			
		</nav>
	</header>