<?php
/**
 * The template for displaying archive pages
 *
 */

get_header(); ?>

	<div id="page" class="ui grid stackable container">

		<h2 class="ui left aligned header">
			<div class="ui <?php echo wp_is_mobile() ? 'mobile' : ''; ?> centered leaderboard ad" data-text="Leaderboard">
				<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
				<!-- blog_feed_top -->
				<ins class="adsbygoogle"
				     style="display:inline-block;width:728px;height:90px"
				     data-ad-client="ca-pub-8465880978474028"
				     data-ad-slot="3581316006"></ins>
				<script>
				(adsbygoogle = window.adsbygoogle || []).push({});
				</script>
			</div>
			<div class="ui hidden divider"></div>
            <div class="content">
            	Runner's Blog
          	</div>
        </h2>

		<div class="ui divided items">
	        <?php if ( have_posts() ) : $i = 1; ?>
	        <?php while ( have_posts() ) : the_post(); ?>
	        <?php get_template_part( 'content','blog' ); ?>
	        <?php if($i % 5 == 0) : ?>
	        <div class="item">
	        	<div class="ui <?php if( wp_is_mobile() ) echo 'mobile'; ?> small rectangle  ad" data-text="Small Rectangle">
			      	<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
					<!-- blog_item_head_ad -->
					<ins class="adsbygoogle"
					     style="display:inline-block;width:250px;height:250px"
					     data-ad-client="ca-pub-8465880978474028"
					     data-ad-slot="7239901207"></ins>
					<script>
					(adsbygoogle = window.adsbygoogle || []).push({});
					</script>
			    </div>
	          	<div class="content">
	              <div class="ui centered <?php if( wp_is_mobile() ) echo 'mobile'; ?> leaderboard ad" data-text="Leaderboard">
	                <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
					<!-- blog_feed_interval_ad -->
					<ins class="adsbygoogle"
					     style="display:inline-block;width:728px;height:90px"
					     data-ad-client="ca-pub-8465880978474028"
					     data-ad-slot="4565636408"></ins>
					<script>
					(adsbygoogle = window.adsbygoogle || []).push({});
					</script>
	              </div>
          		</div>
            </div>
          	<?php endif; $i++; ?>
	      	<?php endwhile; ?>
	  	<?php endif; ?>
    	</div>
    	
	</div>

<?php get_footer(); ?>
