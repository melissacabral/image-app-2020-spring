<?php 
//parse the register.php form if they submitted it
if( $_POST['did_register'] ){
	//sanitize everything
	$username 	= clean_string( $_POST['username'] );
	$email		= clean_string( $_POST['email'] );
	$password 	= clean_string( $_POST['password'] );
	$policy 	= clean_boolean( $_POST['policy'] ); 

	//validate everything
	$valid = true;
		//username not between 3 - 30 chars
	if( strlen( $username ) < 3 OR strlen( $username ) > 30 ){
		$valid = false;
		$errors['username'] = 'Choose a username between 3 - 30 characters long';
	}else{
		//username is acceptable length, but we need to check to see if it is taken
		$sql = "SELECT username 
				FROM users
				WHERE username = '$username'
				LIMIT 1";
		$result = $db->query( $sql );
		if( $result->num_rows >= 1 ){
			$valid = false;
			$errors['username'] = 'Sorry, that username is already taken. Try another.';
		}
	} //end of username checks


		//email invalid
	if( ! filter_var( $email, FILTER_VALIDATE_EMAIL ) ){
		$valid = false;
		$errors['email'] = 'Please provide a valid email address';
	}else{
		//email must not be taken 
		$sql = "SELECT email 
				FROM users
				WHERE email = '$email'
				LIMIT 1";
		$result = $db->query( $sql );
		if( $result->num_rows >= 1 ){
			$valid = false;
			$errors['email'] = 'That email address is already registered. Do you want to log in?';
		}
	}  //end of email checks
		
		//password must be at least 7 chars
	if( strlen($password) < 7 ){
		$valid = false;
		$errors['password'] = 'Your password must be at least 7 characters long.';
	}

		//policy box not checked
	if( $policy != 1 ){
		$valid = false;
		$errors['policy'] = 'You must agree to the terms of this site before registering.';
	}

	//if valid, add the user to the DB
	if( $valid ){
		$secure_password = sha1( $password . SALT );
		$sql = "INSERT INTO users
				( username, email, password, is_admin, join_date, profile_pic, bio )
				VALUES
				( '$username', '$email', '$secure_password', 0, NOW(), '', '' )";
		$result = $db->query( $sql );
		if( ! $result ){
			echo $db->error;
		}
		if( $db->affected_rows >= 1 ){
			//SUCCESS
			$feedback = 'Thank you for signing up. You can now log in to your account';
			$feedback_class = 'success';
		}else{
			//ERROR
			$feedback = 'Something went wrong when adding your account. Try again.';
			$feedback_class = 'error';
		}
	}else{
		//INVALID
		$feedback = 'There were problems with your registration. Please fix the following:';
		$feedback_class = 'error';
	}	

} //end register parser