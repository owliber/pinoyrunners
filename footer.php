	<?php wp_footer(); ?>
	<?php if( !is_front_page() ) : ?>	
	
	<div class="ui vertical footer segment">
	    <div class="ui three column very stackable grid container">	    	
	    	<div class="four top aligned wide column">
	    		<a href="<?php echo home_url( 'connect' ); ?>" class="item">connect</a> &middot; 
	    		<a href="<?php echo home_url( 'events' ); ?>" class="item">events</a> &middot;
	    		<a href="<?php echo home_url( 'events' ); ?>" class="item">blog</a> &middot; 
	    		<a href="<?php echo home_url( 'register' ); ?>" class="item">register</a> &middot; 
	    		<a href="<?php echo home_url( 'login' ); ?>" class="item">login</a> &middot; 
	    		<a href="<?php echo home_url( 'tos' ); ?>" class="item">terms</a>
	    	</div>
	    	<div id="pr-footer-logo" class="center aligned column">
	    		<a href="<?php echo home_url(); ?>"><img title="Pinoy Runners" src="http://localhost:9000/wp-content/uploads/2015/12/logo-small-pr.png" /></a>
	    	</div>
	    	<div class="eight right aligned wide column">
	    		
	    		&copy; <?php echo CUR_YEAR; ?> &middot; some rights reserved &middot; <a href="<?php echo home_url(); ?>">pinoyrunners.co</a>
	    		
	    	</div>	       
	    </div>
	</div>
	<?php endif; ?>
	</body>
</html>
