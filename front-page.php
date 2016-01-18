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
	  
	  <div class="six wide left aligned column">
	  	<div class="ui hidden divider"></div>
	    <?php get_sidebar('front-page'); ?>	
	  </div>
	</div>	
	
	<!-- Attribution for video background -->
	<div class="attribution fade">
		<p>Background <a href="https://www.youtube.com/channel/UCbnvf4LXzPZoyk0ByxWxgVg" target="_blank">video</a> from <a href="https://www.youtube.com/channel/UCbnvf4LXzPZoyk0ByxWxgVg" target="_blank">RioRunnerVideos</a> used under <a href="http://creativecommons.org/licenses/by/2.0/" target="_blank">CC BY</a> and Standard YouTube License. <br /> 30 seconds clipped from the original and added BW effect.</p>
	</div>

    <video autoplay loop muted poster="<?php echo get_template_directory_uri(); ?>/assets/images/running.jpg" id="bgvid">
		<source src="<?php echo get_template_directory_uri(); ?>/assets/videos/running.ogv" type="video/ogg">
        <source src="<?php echo get_template_directory_uri(); ?>/assets/videos/running.webm" type="video/webm">
        <source src="<?php echo get_template_directory_uri(); ?>/assets/videos/running.mp4" type="video/mp4">
	</video>

<?php get_footer(); ?>