<?php 
require( 'config.php' );
include_once( 'includes/functions.php' ); 

//form parser
require( 'includes/parse-register.php' );
?>
<!DOCTYPE html>
<html>
<head>
	<title>Sign up for an account</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/milligram/1.3.0/milligram.min.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>

	<div class="important-form">
		<h1>Create an Account</h1>
		<p>Become a member so you can upload posts, comment and like other posts</p>

		<?php display_feedback( $feedback, $feedback_class, $errors ); ?>

		<form method="post" action="register.php">
			<label for="the_username">Username</label>
			<input type="text" name="username" id="the_username" value="<?php echo $username; ?>">

			<label for="the_password">Password</label>
			<input type="password" name="password" id="the_password" value="<?php echo $password; ?>">

			<label for="the_email">Email</label>
			<input type="email" name="email" id="the_email" value="<?php echo $email; ?>">

			<label>
				<input type="checkbox" name="policy" value="1" <?php if( $policy ){ echo 'checked'; } ?>>
				I agree to the <a href="#">Terms of Service</a>
			</label>

			<input type="submit" value="Sign Up">
			<input type="hidden" name="did_register" value="1">
		</form>


	</div>
<?php include( 'includes/debug-output.php' ); ?>
</body>
</html>