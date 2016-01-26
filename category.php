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
                	<p><?php //the_content(); 
                		$content = get_the_content();
		                  $content = preg_replace("/<img[^>]+\>/i", " ", $content);          
		                  $content = apply_filters('the_content', $content);
		                  $content = str_replace(']]>', ']]>', $content);
		                  $content = preg_replace('/^\s+|\n|\r|\s+$/m', '', $content);
		                  $content = wp_trim_words($content, 50, ' ...');
		                  
		                  echo $content;
                	?></p>
              	  </div>
              	  <div class="meta">
              	  	Tags 
              	  	<?php 
			        	$tags = get_the_tags();
			        	if ($tags) {
						  foreach($tags as $tag) {
						    echo '<a href="'.get_tag_link($tag->term_id).'" class="ui label">'.$tag->name.'</a>';
						  }
						}
			         ?>
              	  </div>
              	  <div class="extra">
              	  	<div class="fb-like" data-href="<?php the_permalink(); ?>" data-layout="button_count" data-action="like" data-show-faces="false" data-share="true"></div>
              	  </div>
	            </div>
	             
	         </div>
	      <?php endwhile; ?>
	  	<?php endif; ?>
    	</div>

	</div>

<?php get_footer(); ?>
