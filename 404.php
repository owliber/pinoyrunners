<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @package WordPress
 * @subpackage Twenty_Fifteen
 * @since Twenty Fifteen 1.0
 */

get_header(); ?>

	<div id="page" class="ui grid container">
		<div class="ui divided items"> 			
			<h2 class="ui left aligned header">
	            <div class="content">
	            <?php _e( 'Oops! That page can&rsquo;t be found or no longer available.', 'pinoyrunners' ); ?>
	          </div>
	        </h2>	
	        
	        <div class="ui fluid search">
	          <div class="ui icon input">
	            <form role="search" method="post" class="search-form" action="<?php echo home_url(); ?>">
	              <label>
	                  Please try to search <input type="search" class="search-field" placeholder="<?php echo esc_attr_x( 'Search …', 'placeholder' ); ?>" value="" name="s" title="<?php echo esc_attr_x( 'Search ', 'label' ); ?>" required>
	              </label>
	            </form>
	            <i class="search icon"></i>
	          </div>		      
	      </div>
        </div>
	    

	</div><!-- page container -->

<?php get_footer(); ?>
