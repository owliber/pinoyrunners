<?php
/*
	Template Name: Frontpage Template
*/

?>
<?php get_header(); ?>

	<div class="ui two column middle aligned very relaxed stackable grid container">
	  <div class="ten wide column welcome">
	  		<h1 class="ui green huge header">Run. Connect. Share.</h1>
			<p class="lead">Run with your friends and fellow runners. <br />Connect, discover and share your achievements, <br />activities and profiles to the community.</p>
	  </div>
	  <!-- <div class="ui vertical divider">run</div> -->
	  <div class="six wide left aligned column">
	  	<div class="ui hidden divider"></div>
	    <?php get_sidebar('front-page'); ?>	
	  </div>
	</div>

    <video autoplay loop muted poster="<?php echo get_template_directory_uri(); ?>/img/running.jpg" id="bgvid">
		<source src="<?php echo get_template_directory_uri(); ?>/assets/videos/running-01.ogv" type="video/ogg">
        <source src="<?php echo get_template_directory_uri(); ?>/assets/videos/running-01.webm" type="video/webm">
	</video>

<?php get_footer(); ?>