<?php require( 'includes/header.php'); ?>

	<main class="content">
		
		<?php 
		//write the query: get up to 20 published posts, in reverse-date order
		$sql = "SELECT posts.*, users.username, users.profile_pic, categories.name
					FROM posts, users, categories
					WHERE posts.user_id = users.user_id
					AND posts.category_id = categories.category_id
					AND posts.is_published = 1
					ORDER BY posts.date DESC
					LIMIT 20";
		// run it
		$result = $db->query($sql);

		//check to see if it failed
		if( ! $result ){
			echo $db->error;
		}

		//check it - did it find any posts?
		if( $result->num_rows >= 1 ){

			//loop it
			while( $post = $result->fetch_assoc() ){ ?>
		<div class="post">
			<a href="single.php?post_id=<?php echo $post['post_id']; ?>">
				<img class="post-image" src="<?php echo $post['image']; ?>" alt="<?php echo $post['title']; ?>">
			</a>
			<span class="author">
				<img src="<?php echo $post['profile_pic']; ?>" width="50" height="50">
				<?php echo $post['username']; ?>
			</span>

			<h2><?php echo $post['title']; ?></h2>
			<p><?php echo $post['body']; ?></p>

			<span class="category"><?php echo $post['name']; ?></span>

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

<?php include( 'includes/footer.php' ); ?>
	