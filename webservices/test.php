<?php 
include("../wp-config.php");
	global $post;
	query_posts( array (  'post_type' => 'restaurants','lang' => 'en', 'order'=> 'DESC','showposts'=>-1) ); 
	while ( have_posts() ) : the_post();
	echo "<pre>";
		print_r($post);
	echo "</pre>";
	endwhile; wp_reset_query();