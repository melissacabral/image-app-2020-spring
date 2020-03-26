<section class="comment-form">
	<h2>Leave a Comment</h2>

	<?php 
	//display feedback
	if( isset($feedback) ){
		echo $feedback;
	} 
	?>

	<form action="single.php?post_id=<?php echo $post_id; ?>" method="post">
		<label>Comment:</label>
		<textarea name="body"></textarea>

		<input type="submit" value="Save Comment">

		<input type="hidden" name="did_comment" value="1">
	</form>
	
</section>