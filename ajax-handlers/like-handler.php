<?php
// This file handles like/un-like
// responds with an updated "like interface"

//requires 2 pieces of data: post_id and user_id

//load all dependencies
require( '../config.php' );
require_once('../includes/functions.php');


//sanitize all incoming data

$post_id = clean_int( $_REQUEST['postId'] ); 
$user_id = clean_int( $_REQUEST['userId'] );

//check to see if this combo is already in the likes table
$sql = "SELECT * FROM likes
		WHERE user_id = $user_id
		AND post_id = $post_id
		LIMIT 1";

$result = $db->query( $sql );

if( ! $result ){
	echo $db->error;
}

if( $result->num_rows >= 1 ){
	//they already like this. delete the like.
	$sql =  "DELETE FROM likes
				WHERE post_id = $post_id
				AND user_id = $user_id";
}else{
	//they don't yet like it. add the like.
	$sql = "INSERT INTO likes
			( post_id, user_id )
			VALUES
			( $post_id, $user_id )";
}

//run the resulting query
$result = $db->query( $sql );



//update the heart and the count
like_interface($post_id, $user_id);