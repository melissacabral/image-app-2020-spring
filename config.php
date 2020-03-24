<?php
//databse configuration
$host = 'localhost';
$db_name = 'phpclassimageapp';
$db_user = 'phpimageapp';
$db_password = 'Pz4FUqHNp0bVLWA7';

//connect to the DB
$db = new mysqli( $host, $db_user, $db_password, $db_name );

//check for connection error
if($db->connect_errno > 0){
	die( 'Could not connect to the Database' );
}

//no close php