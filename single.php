<?php
/**
 * The template for displaying all single posts and attachments
 *
 */

get_header(); ?>

	<div id="page" class="ui container">
		<?php
		// Start the loop.
		while ( have_posts() ) : the_post(); ?>

			<h1 class="ui center aligned icon header">
		      <?php 
		        if ( has_post_thumbnail() ) {  
		          $url = wp_get_attachment_url( get_post_thumbnail_id() );             
		        } else {
		          $url = WP_CONTENT_URL.'/uploads/thumbnail/wireframe.png';
		        }        
		      ?>
		      <img src="<?php echo $url; ?>" class="ui circular small image">
		      <div class="ui hidden divider"></div>
		      <div class="content">
		        <?php echo the_title(); ?>
		        
		      </div>      
		    </h1>

		    <div class="ui raised clearing padded segment">
		        <?php the_content(); ?>
		    </div>

	    <?php
			// Add facebook comment plugin here

			// add ajax loader here

		// End the loop.
		endwhile;
		?>
	</div><!-- ui container -->

<?php get_footer(); ?>
