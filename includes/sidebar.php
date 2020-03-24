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
			<li>
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
	$sql = "SELECT name FROM categories
			ORDER BY name ASC";
	//run it
	$result = $db->query($sql);
	//check if there are categories
	if( $result->num_rows >= 1  ){
	?>
	<section class="categories">
		<h2>Image categories:</h2>

		<ul>
			<?php while( $cat = $result->fetch_assoc() ){ ?>

			<li><?php echo $cat['name']; ?></li>
			
			<?php } //end while loop 
			$result->free();?>
		</ul>
	</section>
	<?php } //end if there are rows ?>


	<?php //show up to 5 approved comments, newest first 
	$sql = "SELECT body 
			FROM comments
			WHERE is_approved = 1
			ORDER BY date DESC";
	$result = $db->query($sql);
	//check it
	if( $result->num_rows >= 1 ){	
	?>
	<section class="comments">
		<h2>Recent Comments:</h2>

		<ul>
			<?php while( $comment = $result->fetch_assoc() ){ ?>
			<li><?php echo $comment['body']; ?></li>
			<?php } //end while
			//free it
			$result->free(); ?>
		</ul>
	</section>
	<?php }//end if ?>

</aside>