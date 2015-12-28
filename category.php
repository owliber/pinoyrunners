<?php
/**
 * The template for displaying archive pages
 *
 */

get_header(); ?>

	<div id="page" class="ui container">
		<div class="ui divided items">

          	<h2 class="ui left aligned header">
	            <div class="content">
	            	Recent Blog
	          	</div>
	        </h2>

	        <?php if ( have_posts() ) : ?>
	        <?php while ( have_posts() ) : the_post(); ?>

	        <div class="item">
	        	<a class="ui small image" href="<?php the_permalink(); ?>">
	              <?php if ( has_post_thumbnail() ) {                  
	                  echo get_the_post_thumbnail();
	              } else {	                
	                echo '<img src="'.WP_CONTENT_URL.'/uploads/thumbnail/wireframe.png">';
	              }?>
	            </a>
	            <div class="content">              
	              <a class="header" href="<?php the_permalink(); ?>"><?php echo the_title(); ?> </a>
	              <div class="meta">
              	  	<?php the_date(); ?>
              	  </div>
	              <div class="description">                
                	<p><?php the_content(); ?></p>
              	  </div>
              	  <div class="meta">
              	  	<?php the_tags(); ?>
              	  </div>
	            </div>
	             
	         </div>
	      <?php endwhile; ?>
	  	<?php endif; ?>
    	</div>

	</div>

<?php get_footer(); ?>
