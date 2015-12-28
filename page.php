<?php

/*
	Template Name: Default Page Template
 */

?>

<?php get_header(); ?>

<div class="ui site-content container">
	<?php if ( have_posts() ) : ?>
		<?php while( have_posts() ) : the_post(); ?>
		<?php the_content(); ?>
		<?php endwhile; ?>
	<?php endif; ?>
</div>

<?php get_footer(); ?>
