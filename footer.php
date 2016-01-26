	<?php wp_footer(); ?>
	
	<?php if( !is_front_page() && ! is_author() ) : ?>	
	
	<div class="ui vertical footer segment">
	    <div class="ui three column very stackable grid container">	    	
	    	<div class="four top aligned wide column">
	    		<a href="<?php echo home_url( 'connect' ); ?>" class="item">connect</a> &middot; 
	    		<a href="<?php echo home_url( 'events' ); ?>" class="item">events</a> &middot;
	    		<a href="<?php echo home_url( 'blog'); ?>" class="item">blog</a> &middot; 
	    		<a href="<?php echo home_url( 'register' ); ?>" class="item">register</a> &middot; 
	    		<a href="<?php echo home_url( 'login' ); ?>" class="item">login</a>
	    		<!-- <a href="<?php echo home_url(); ?>" class="item">terms</a> -->
	    	</div>
	    	<div id="pr-footer-logo" class="center aligned column">
	    		<a href="<?php echo home_url(); ?>"><img title="Pinoy Runners" src="<?php echo get_template_directory_uri(); ?>/assets/images/logo-small-pr.png" /></a>
	    	</div>
	    	<div class="eight right aligned wide column">
	    		
	    		copyright &copy; <?php echo CUR_YEAR; ?> &middot; <a href="<?php echo home_url(); ?>">pinoyrunners.co</a> &middot; all rights reserved.
	    		
	    	</div>	       
	    </div>
	</div>
	<?php endif; ?>
	</body>
</html>
