<?php require( 'config.php' ); ?>
<!DOCTYPE html>
<html>
<head>
	<title>Image App</title>
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/milligram/1.3.0/milligram.min.css">
</head>
<body>
	<header class="header">
		<h1>Image App</h1>
	</header>

	<main class="content">
		
		<?php 
		//write the query: get up to 20 published posts, in reverse-date order
		$sql = "SELECT title, body, date, image 
					FROM posts
					WHERE is_published = 1
					ORDER BY date DESC
					LIMIT 20 ";
		// run it
		$result = $db->query($sql);

		//check it - did it find any posts?
		if( $result->num_rows >= 1 ){

			//loop it
			while( $post = $result->fetch_assoc() ){ ?>
		<div class="post">
			<img src="<?php echo $post['image']; ?>" alt="<?php echo $post['title']; ?>">
			<h2><?php echo $post['title']; ?></h2>
			<p><?php echo $post['body']; ?></p>
			<span class="date"><?php echo $post['date']; ?></span>
		</div>

		<?php 
			} //end while
			//free the result
			$result->free();
		} //end if posts found
		else{
			echo 'Sorry, no posts to show right now';
		} 
		?>



	</main>

	<?php include( 'includes/sidebar.php' ); ?>

	<footer class="footer">
		&copy; 2020 Image App
	</footer>

</body>
</html>