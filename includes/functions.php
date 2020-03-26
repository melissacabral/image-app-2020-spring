<?php
//clean a string for the database
function clean_string( $input ){
	//get the DB connection from outside this function
	global $db;
	
	$output = filter_var( $input, FILTER_SANITIZE_STRING );
	$output = mysqli_real_escape_string( $db, $output );

	return $output;
}

//no close php