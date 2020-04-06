<?php 
require( 'config.php' );
include_once( 'includes/functions.php' );


//log out logic.  URL will look like login.php?action=logout
if( $_GET['action'] == 'logout' ){
		
	//invalidate all cookies
	setcookie( 'secret_key', '', 1 );
	setcookie( 'user_id', 0, 1 );

	//destroy the session and all sess vars
	//remove all keys from session by setting it to an empty array
	session_unset();

	//from https://www.php.net/manual/en/function.session-destroy
	//this will clear the PHPSESSID cookie
	if (ini_get("session.use_cookies")) {
	    $params = session_get_cookie_params();
	    setcookie(session_name(), '', time() - 42000,
	        $params["path"], $params["domain"],
	        $params["secure"], $params["httponly"]
	    );
	}
	//invalidate the current session ID
	session_destroy();
} //end of log out


//check the user's credentials if they submitted the form
if( isset( $_POST['did_login'] ) ){
	//sanitize everything
	$username = clean_string( $_POST['username'] );
	$password = clean_string( $_POST['password'] );
	
	//validate - length checks
	$valid = true;

	//username wrong length
	if( strlen( $username ) < 3 OR strlen( $username ) > 30 ){
		$valid = false;
	}

	//password too short
	if( strlen( $password ) < 7 ){
		$valid = false;
	}

	//if valid
	if( $valid ){
		$secure_password = sha1( $password . SALT );
		//look up this combo in the db
		$sql = "SELECT * 
				FROM users
				WHERE username = '$username' 
				AND password = '$secure_password'
				LIMIT 1";
		//run it
		$result = $db->query( $sql );
		//check it
		if( !$result ){
			echo $db->error;
		}

		//if one row found, success
		if( $result->num_rows >= 1 ){
			$message = 'Success';
			//generate a secret key
			$secret_key = sha1( microtime() . SALT );
			$user = $result->fetch_assoc();
			$user_id = $user['user_id'];

			//store cookies for a week to keep the user logged in
			$exp =  time() + (60 * 60 * 24 * 7);

			setcookie( 'secret_key', $secret_key, $exp );
			$_SESSION['secret_key'] = $secret_key;

			setcookie( 'user_id', $user_id, $exp );
			$_SESSION['user_id'] = $user_id;

			//add the secret key to this user's row in the db
			$sql = "UPDATE users
					SET secret_key = '$secret_key'
					WHERE user_id = $user_id
					LIMIT 1";
			$result = $db->query($sql);
			if(! $result){
				echo $db->error;
			}
			//check that one row was updated
			if( $db->affected_rows >= 1 ){
				//redirect to home page
				$message = urlencode('Success! You are now logged in.');
				header("Location:index.php?feedback=$message");				
			}else{
				$message = 'Sorry, unable to log you in. Try again.';
			}

		}else{
			$message = 'Incorrect username and password combination.';
		}
	}else{
		$message = 'Incorrect username and password combination.';
	}

} //end of parser

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Log In to Your Account</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/milligram/1.3.0/milligram.min.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
	<div class="important-form">
		<h1>Log In</h1>

		<?php 
		//if there's a message, show it
		if( isset($message) ){
			echo "<div class='feedback'>$message</div>";
		}
		 ?>

		<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
			<label>Username:</label>
			<input type="text" name="username">

			<label>Password</label>
			<input type="password" name="password">

			<input type="submit" value="Log In" >

			<input type="hidden" name="did_login" value="1">
		</form>
	</div>

</body>
</html>