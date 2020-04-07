<?php 
require( 'includes/header.php'); 
//lock out the user if not logged in
if(! $logged_in_user){
	die('You must be logged in to see this');
}

include( 'includes/parse-upload.php' );
?>

	<main class="content">
		
		<div class="important-form">
			<h1>New Post</h1>

			<?php display_feedback( $feedback, '', $errors ); ?>

			<form action="upload.php" method="post" enctype="multipart/form-data">
				<label>Image:</label>
				
				<input type="file" name="uploadedfile">

				<hr>

				<input type="submit" value="Next: Post Details &rarr;">

				<input type="hidden" name="did_upload" value="1">
			</form>

		</div>

	</main>

<?php include( 'includes/sidebar.php' ); ?>

<?php include( 'includes/footer.php' ); ?>
	