<?php
//clean a string for the database
function clean_string( $input ){
	//get the DB connection from outside this function
	global $db;

	$output = filter_var( $input, FILTER_SANITIZE_STRING );
	$output = mysqli_real_escape_string( $db, $output );

	return $output;
}

//sanitize a boolean value
function clean_boolean( $input ){
    if(  $input != 1 ){
        $input = 0;
    }
    return $input;
}

//change the DATETIME format to a human-friendly format, like Monday, January 1
function nice_date( $timestamp ){
	$output = new DateTime( $timestamp );
	echo $output->format( 'l, F j' );
}

//Convert DATETIME to "days ago" or hours, months, years, etc
//from https://stackoverflow.com/a/18602474
function timeago($datetime, $full = false) {
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'just now';
}

//display a nice looking feedback message with possible error list. use with any form
function display_feedback( $heading, $class = '', $list = array() ){
    if( isset($heading) ){
        echo "<div class='feedback $class'>";
        echo "<h2>$heading</h2>";

        //if the list is not empty, show it
        if( ! empty($list) ){
            echo '<ul>';

            foreach( $list as $item ){
                echo "<li>$item</li>";
            }

            echo '</ul>';
        }

        echo '</div>';

    }
}


//no close php