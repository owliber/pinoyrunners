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
		      <img src="<?php echo $url; ?>" class="ui circular medium image">
		      <div class="ui hidden divider"></div>
		      <div class="content">
		        <?php echo the_title(); ?>
		        
		      </div>      
		    </h1>

		    <div class="ui raised clearing padded segment">
		        <?php the_content(); ?>
		        Tags
		        <?php 
		        	$tags = get_the_tags();
		        	if ($tags) {
					  foreach($tags as $tag) {
					    echo '<a href="'.get_tag_link($tag->term_id).'" class="ui tag label">'.$tag->name.'</a>';
					  }
					}
		         ?>
		    </div>
		    <div class="ui segment">
		        <div class="header">Comments and feedback</div>
		        <div class="fb-comments" data-href="<?php the_permalink(); ?>" data-width="100%" data-numposts="10"></div>
		      </div>

	    <?php
			// Add facebook comment plugin here

			// add ajax loader here

		// End the loop.
		endwhile;
		?>
	</div><!-- ui container -->

<?php get_footer(); ?>
