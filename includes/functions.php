<?php
//clean a string for the database
function clean_string( $input ){
	//get the DB connection from outside this function
	global $db;

	$output = filter_var( $input, FILTER_SANITIZE_STRING );
	$output = mysqli_real_escape_string( $db, $output );

	return $output;
}


//clean an integer for the database
function clean_int( $input ){
    //get the DB connection from outside this function
    global $db;

    $output = filter_var( $input, FILTER_SANITIZE_NUMBER_INT );
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

//check to see if the viewer is logged in
//returns false if not logged in
//return an array of all user info if they are logged in
function check_login(){
    global $db;
    
    $_SESSION['secret_key'] = $_COOKIE['secret_key'];
    $_SESSION['user_id'] = $_COOKIE['user_id'];
    
    if( isset($_SESSION['secret_key']) AND isset($_SESSION['user_id']) ){
        //check to see if these keys match the DB
        $secret_key = $_SESSION['secret_key'];
        $user_id = $_SESSION['user_id'];

        $sql = "SELECT * FROM users
                WHERE user_id = $user_id
                AND secret_key = '$secret_key'
                LIMIT 1";

        $result = $db->query($sql);
        if(! $result){
            return false;
        }
        if($result->num_rows == 1){
            //success! return all the info about the logged in user
            return $result->fetch_assoc();
        }else{
            return false;
        }
    }else{
        //not logged in
        return false;
    }
}


//helpers for select dropdowns, checkboxes and radio buttons

//use in <option> tags
function selected( $thing1, $thing2 ){
    if( $thing1 == $thing2 ){
        echo 'selected';
    }
}

//use in checkboxes and radio buttons
function checked( $thing1, $thing2 ){
    if( $thing1 == $thing2 ){
        echo 'checked';
    }
}

//display any post image at any known size
function display_post_image( $post_id, $size = 'medium' ){
    global $db;

    //get the image of this post
    $sql = "SELECT image, title
            FROM posts 
            WHERE post_id = $post_id
            LIMIT 1";
    $result = $db->query($sql);
    if(! $result){
        echo $db->error;
    }
    if( $result->num_rows >= 1 ){
        $post = $result->fetch_assoc();

        $image = 'uploads/' . $post['image'] . '_' . $size . '.jpg';
        $title = $post['title'];

        echo "<img src='$image' class='post-image' alt='$title'>";
    }
}


//count the likes on any post
function count_likes( $post_id ){
    global $db;
    $sql = "SELECT COUNT(*) AS total_likes
            FROM likes
            WHERE post_id = $post_id";
    $result = $db->query($sql);
    if( !$result ){
        echo $db->error;
    }
    if( $result->num_rows >= 1 ){
       while( $likes = $result->fetch_assoc() ){
            $likes =  $likes['total_likes'];

            //show the number with good grammar (ternary operator example)
            echo $likes == 1 ? '1 person likes this' : "$likes people like this";
       }
    }
}


//Like button (heart) interface
function like_interface( $post_id, $user_id = 0 ){
    global $db;
    //if there is a logged in user, check if this user likes this post
    if( $user_id ){
        $sql = "SELECT * FROM likes
                WHERE user_id = $user_id
                AND post_id = $post_id
                LIMIT 1";
        $result = $db->query($sql);
        if( ! $result ){
            echo $db->error;
        }
        if( $result->num_rows >= 1 ){
            //you like this
            $class = 'you-like';
        }else{
            $class = '';
        }

    }//end if logged in

    ?>
    <span class="like-interface">
        <span class="<?php echo $class; ?>">
            <span class="heart-button" data-postid="<?php echo $post_id; ?>">❤</span>   

            <?php count_likes( $post_id ); ?>         
        </span>
    </span>

    <?php

}



//no close php