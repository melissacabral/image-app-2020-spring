<?php 
require( 'includes/header.php'); 

//write the query: get the post that was clicked on
//URL will look like single.php?post_id=5
$post_id = filter_var( $_GET['post_id'], FILTER_SANITIZE_NUMBER_INT );

//in case post_id is missing, set it to 0 so the sql doesn't break
if( ! $post_id ){
	$post_id = 0;
}

include( 'includes/parse-comment.php' );  
?>
	<main class="content">
		
		<?php 
		

		$sql = "SELECT posts.*, users.username, users.profile_pic, categories.name
					FROM posts, users, categories
					WHERE posts.user_id = users.user_id
					AND posts.category_id = categories.category_id
					AND posts.is_published = 1
					AND posts.post_id = $post_id
					LIMIT 1";
		// run it
		$result = $db->query($sql);

		//check to see if it failed
		if( ! $result ){
			echo $db->error;
		}

		//check it - did it find any posts?
		if( $result->num_rows >= 1 ){

			//loop it
			while( $post = $result->fetch_assoc() ){ 

				//needed for the comment form below
				$allow_comments = $post['allow_comments'];
		?>
		<div class="post">
			<img class="post-image" src="<?php echo $post['image']; ?>" alt="<?php echo $post['title']; ?>">

			<span class="author">
				<img src="<?php echo $post['profile_pic']; ?>" width="50" height="50">
				<?php echo $post['username']; ?>
			</span>

			<h2><?php echo $post['title']; ?></h2>
			<p><?php echo $post['body']; ?></p>

			<span class="category"><?php echo $post['name']; ?></span>

			<span class="date"><?php nice_date( $post['date'] ); ?></span>
		</div>

		<?php 
			} //end while
			//free the result
			$result->free();


			//get all the approved comments on this post in chronological order
			$sql = "SELECT users.profile_pic, users.username, comments.body, comments.date
					FROM users, comments
					WHERE comments.user_id = users.user_id
					AND comments.post_id = $post_id
					AND comments.is_approved = 1
					LIMIT 50";
			//run it
			$result = $db->query($sql);

			//check it twice
			if( !$result ){
				echo $db->error;
			}

			//did we find at least 1 row?
			if( $result->num_rows >= 1 ){

		?>
		<section class="comments">
			<h2>Comments on this post</h2>	

			<?php while( $comment = $result->fetch_assoc() ){ ?>
			<div class="one-comment">
				<div class="user">
					<img src="<?php echo $comment['profile_pic']; ?>" width="30" height="30">
					<?php echo $comment['username']; ?>
				</div>

				<p><?php echo $comment['body']; ?></p>

				<span class="date"><?php echo timeago( $comment['date'] ); ?></span>

			</div><!-- end .one-comment -->	
			<?php } //end while there are comments ?>

		</section>

		<?php
			} //end if comments found
			else{
				echo 'This post has no comments';
			}

			if( $allow_comments ){
				if( $logged_in_user ){
					include('includes/comment-form.php');
				}else{
					echo '<div class="feedback">You must be logged in to comment on this.</div>';
				}
			}

		} //end if posts found
		else{
			echo 'Sorry, no posts to show right now';
		} 
		?>



	</main>

<?php include( 'includes/sidebar.php' ); ?>

<?php include( 'includes/footer.php' ); ?>
	