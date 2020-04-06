<?php
//databse configuration
$host = 'localhost';
$db_name = 'phpclassimageapp';
$db_user = 'phpimageapp';
$db_password = 'Pz4FUqHNp0bVLWA7';


//Debug mode on or off
//true: show all errors and superglobal arrays 
//false: live site mode
define( 'DEBUG_MODE', true );

//SALT for securing passwords 
define( 'SALT', '054635487&^*%bg8542.0^#%&,mag rkj52840gnvu7t^%$jvhgvgy5' );


//==============STOP EDITING===========

session_start();

//error reporting
if( DEBUG_MODE ){
	// error_reporting( E_ALL );
	error_reporting( E_ALL & ~E_NOTICE );
}else{
	//hide all errors
	error_reporting(0);
	ini_set('display_errors', 0);
}


//connect to the DB
$db = new mysqli( $host, $db_user, $db_password, $db_name );

//check for connection error
if($db->connect_errno > 0){
	die( 'Could not connect to the Database' );
}


//no close php