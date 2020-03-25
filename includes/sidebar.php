<aside class="sidebar">
	
	<?php //get the most recently joined 5 users
	$sql = "SELECT username, profile_pic
			FROM users
			ORDER BY join_date DESC
			LIMIT 5";
	//run it
	$result = $db->query($sql);	
	//check it
	if( $result->num_rows >= 1 ){
	 ?>
	
	<section class="users">
		<h2>Newest Users:</h2>

		<ul>
			<?php //loop it 
			while( $user =  $result->fetch_assoc() ){ ?>
			<li class="user">
				<img src="<?php echo $user['profile_pic']; ?>" width="55" height="55">
				<?php echo $user['username']; ?>
			</li>
			<?php } //end while 
			//free it
			$result->free();
			?>
		</ul>

	</section>
	<?php } //end if rows found ?>



	<?php //show a list of all categories, alphabetically by name 
	$sql = "SELECT categories.*, COUNT(*) AS total
			FROM categories, posts
			WHERE posts.category_id = categories.category_id
			GROUP BY posts.category_id
			ORDER BY name ASC";
	//run it
	$result = $db->query($sql);
	//check if there are categories
	if(!$result){
		echo $db->error;
	}

	if( $result->num_rows >= 1  ){
	?>
	<section class="categories">
		<h2>Image categories:</h2>

		<ul>
			<?php while( $cat = $result->fetch_assoc() ){ ?>

			<li>
				<?php echo $cat['name']; ?>
				( <?php echo $cat['total']; ?> )		
			</li>
			
			<?php } //end while loop 
			$result->free();?>
		</ul>
	</section>
	<?php } //end if there are rows ?>


	<?php //show up to 5 approved comments, newest first 
	$sql = "SELECT comments.body, users.username, posts.title
			FROM comments, users, posts
			WHERE comments.is_approved = 1
			AND users.user_id = comments.user_id
			AND posts.post_id = comments.post_id
			ORDER BY comments.date DESC";
	$result = $db->query($sql);
	//check it (twice)
		
	if(! $result){
		echo $db->error;
	}

	if( $result->num_rows >= 1 ){	
	?>
	<section class="comments">
		<h2>Recent Comments:</h2>

		<ul>
			<?php while( $comment = $result->fetch_assoc() ){ ?>
			<li>
				<?php echo $comment['username']; ?> 
				said: <?php echo $comment['body']; ?> 
				on <?php echo $comment['title']; ?>
			</li>
			<?php } //end while
			//free it
			$result->free(); ?>
		</ul>
	</section>
	<?php }//end if ?>

</aside>