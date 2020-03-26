<?php 
//if the user submitted a comment
if( $_POST['did_comment'] ){
	//sanitize all fields
	$body = clean_string( $_POST['body'] );
	//TODO: remove this when we have a real log in system
	$user_id = 1;

	//validate all fields
	$valid = true;

	//if the body is empty or more than 200 characters
	if( strlen( $body ) == 0 OR strlen( $body ) > 200 ){
		$valid = false;
		$errors['body'] = 'Your comment needs to be between 1 - 200 characters long.';
	}

	//if valid, add the comment to the database
	if( $valid ){
		$sql = "INSERT INTO comments
				( user_id, body, date, post_id, is_approved )
				VALUES 
				( $user_id, '$body', NOW(), $post_id, 1 )";
		//run it
		$result = $db->query($sql);
		//check it twice
		if( ! $result ){
			echo $db->error;
		}
		if( $db->affected_rows >= 1 ){
			$feedback = 'Thank you for commenting';
		}else{
			$feedback = 'Comment could not be added to the database';
		}

		//display feedback 
	}else{
		$feedback = 'Fix the following problems with the comment:';
	}
	//give the user feedback
}//end comment parse

//no close php 