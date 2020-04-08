<?php 

//if they submitted the form, parse it
if( $_POST['did_edit'] ){
	//sanitize everything
	$title 			= clean_string( $_POST['title'] );
	$body 			= clean_string( $_POST['body'] );
	$category_id 	= clean_int( $_POST['category_id'] );
	$allow_comments = clean_boolean( $_POST['allow_comments'] );

	//validate
	$valid = true;

	//title is required
	if( $title == '' ){
		$valid = false;
		$errors['title'] = 'Please fill in the title';
	}


	//if valid, update the post
	if( $valid ){
		$user_id = $logged_in_user['user_id'];
		$sql = "UPDATE posts
				SET 
				title = '$title',
				body = '$body',
				category_id = $category_id,
				allow_comments = $allow_comments,
				is_published = 1
				WHERE post_id = $post_id
				AND user_id = $user_id";
		$result = $db->query($sql);

		if(! $result){
			echo $db->error;
		}

		if( $db->affected_rows >= 1 ){
			//success
			$feedback = 'Post successfully saved.';
		}else{
			//error
			$feedback = 'No changes made.';
		}

	}else{
		$feedback = 'There were problems with your post. Fix the following:';
	}	
}//end form parser