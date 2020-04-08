<?php 
require( 'includes/header.php'); 
//lock out the user if not logged in
if(! $logged_in_user){
	die('You must be logged in to see this');
}


//get the ID of the post we are editing
//URL will be like edit-post.php?post_id=X

$post_id = clean_int( $_GET['post_id'] );

include( 'includes/parse-edit-post.php' );


//pre-fill the form with the current post info
$user_id = $logged_in_user['user_id'];
$sql = "SELECT * FROM posts
		WHERE post_id = $post_id
		AND user_id = $user_id
		LIMIT 1";
$result = $db->query( $sql );
if( ! $result ){
	die($db->error);
}

if( $result->num_rows >= 1 ){
	$post = $result->fetch_assoc();	
}

?>

	<main class="content">
		
		<div class="important-form">
			<h1>Edit Post</h1>

			<?php display_feedback( $feedback, '', $errors ); ?>

			<?php display_post_image( $post['post_id'], 'medium' ); ?>

			<form method="post" action="edit-post.php?post_id=<?php echo $post_id; ?>">

				<label>Title</label>
				<input type="text" name="title" value="<?php echo $post['title']; ?>">

				<label>Caption</label>
				<textarea name="body"><?php echo $post['body']; ?></textarea>

				<?php //get all categories in alpha order by title
				$sql = "SELECT * 
						FROM categories
						ORDER BY name ASC";
				$result = $db->query($sql);
				if( $result->num_rows >= 1 ){
				?>				
				<label>Category</label>
				<select name="category_id">
					<?php while( $cat = $result->fetch_assoc() ){ ?>

					<option value="<?php echo $cat['category_id']; ?>" <?php selected( $cat['category_id'], $post['category_id'] ); ?>>
					<?php echo $cat['name']; ?>
					</option>

					<?php } //end while ?>
				</select>
				<?php } //end if rows ?>

				<label>
					<input type="checkbox" name="allow_comments" value="1" <?php checked( 1, $post['allow_comments'] ); ?>>
					Allow comments on this post
				</label>

				<input type="submit" value="Save Post">

				<input type="hidden" name="did_edit" value="1">
				
			</form>

		</div>

	</main>

<?php include( 'includes/sidebar.php' ); ?>

<?php include( 'includes/footer.php' ); ?>
	