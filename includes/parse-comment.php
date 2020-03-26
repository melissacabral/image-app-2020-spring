<?php 
//if the user submitted a comment
if( $_POST['did_comment'] ){
	//sanitize all fields
	$body = clean_string( $_POST['body'] );

	//validate all fields
	//if valid, add the comment to the database
	//give the user feedback
}//end comment parse

//no close php 