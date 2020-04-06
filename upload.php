<?php 
require( 'includes/header.php'); 
//lock out the user if not logged in
if(! $logged_in_user){
	die('You must be logged in to see this');
}
?>

	<main class="content">
		
		this is secret!

	</main>

<?php include( 'includes/sidebar.php' ); ?>

<?php include( 'includes/footer.php' ); ?>
	