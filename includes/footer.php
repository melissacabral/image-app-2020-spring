	<footer class="footer">
		&copy; 2020 Image App
	</footer>
</div> <!-- end div.site -->

<?php include('includes/debug-output.php'); ?>

<script
  src="https://code.jquery.com/jquery-3.4.1.min.js"
  integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
  crossorigin="anonymous"></script>

<script>
	//like interaction
	$('.likes').on( 'click', '.heart-button', function(){
		//which post? which user
		var userId = <?php echo $logged_in_user['user_id']; ?>;
		var postId = $(this).data('postid');

		//test
		//console.log( userId, postId );
		
		//get only the parent div of the heart we clicked 
		var likes_container = $(this).parents('.likes');
		
		$.ajax({
			method 	: 'GET',
			url 	: 'ajax-handlers/like-handler.php',
			data	: {
						'userId' 	: userId,
						'postId'	: postId
					},
			success	: function( response ){
						likes_container.html( response );
					},
			error 	: function(){
						console.log('Ajax Error');
					}
		});
	} );

</script>


</body>
</html>