<?php require( 'includes/header.php'); 

//search configuration - number of posts per page
$per_page = 1;


//sanitize the user's data
$phrase = clean_string( $_GET['phrase'] );

if( $phrase != '' ){
	//look it up in the database - any matching published post titles and bodies
	$sql = "SELECT *
			FROM posts
			WHERE ( title LIKE '%$phrase%' OR body LIKE '%$phrase%' )
			AND is_published = 1
			ORDER BY date DESC";
	//run it
	$result = $db->query($sql);
	//check it 
	if( !$result ){
		echo $db->error;
	}
	//get the total number of posts found before pagination
	$total = $result->num_rows;

	//how many pages do we need to hold these posts?
	$max_pages = ceil( $total / $per_page );

	//what page are we on? search.php?phrase=bla&page=3
	//if invalid page, default to page 1
	if( is_numeric( $_GET['page'] )  AND $_GET['page'] <= $max_pages AND $_GET['page'] != 0 ){
		$current_page = $_GET['page'];
	}else{
		//default to 1
		$current_page = 1;
	}

	//calculate the correct offset for the limit
	$offset = ( $current_page - 1 ) * $per_page;

	//add the LIMIT to the query
	$sql .= " LIMIT $offset, $per_page";

	//run it again
	$result = $db->query($sql);

	if( ! $result ){
		echo $db->error;
	}


} //end if phrase not blank
?>

	<main class="content">
		<section class="title">
			<h2>Search Results for <?php echo $phrase; ?></h2>
			<p><?php echo $total; ?> results found. Showing page <?php echo $current_page; ?> of <?php echo $max_pages; ?></p>
		</section>

		<?php if( $total >= 1 ){ ?>
		<div class="grid">
			
			<?php while( $post = $result->fetch_assoc() ){ ?>
			<div class="item">
				<a href="single.php?post_id=<?php echo $post['post_id']; ?>">

					<?php display_post_image( $post['post_id'], 'small' ); ?>
				</a>

				<h3><?php echo $post['title']; ?></h3>
				<span class="date"><?php nice_date( $post['date'] ); ?></span>
			</div>
			<?php } //end while ?>

		</div><!-- end .grid -->

		<section class="pagination">
			<?php 
			$prev = $current_page - 1;
			$next = $current_page + 1; 
			?>

			<?php if( $current_page > 1 ){ ?>
			<a class="button" href="search.php?phrase=<?php echo $phrase; ?>&amp;page=<?php echo $prev; ?>">Previous</a>
			<?php } ?>

			<?php if( $current_page < $max_pages ){ ?>
			<a class="button" href="search.php?phrase=<?php echo $phrase; ?>&amp;page=<?php echo $next; ?>">Next</a>
			<?php } ?>
		</section>
		<?php } ?>
		
	</main>

<?php include( 'includes/sidebar.php' ); ?>

<?php include( 'includes/footer.php' ); ?>
	