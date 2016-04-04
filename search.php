<?php
/**
 * The template for displaying search results pages.
 *
 */

get_header(); ?>

	<div id="page" class="ui grid container">
		<?php 
		
		$keyword = esc_attr( trim( get_query_var('s') ) );
		
		//Get results for users
		$user_args = array(
			'meta_query' => array(
                'relation' => 'OR',
				array(	'key' => 'last_name',
		                'value' => $keyword,
				        'compare' => 'LIKE'
			         ),
				array(	'key' => 'first_name',
		                'value' => $keyword,
						'compare' => 'LIKE'
				),
				array(	'key' => 'interests',
		                'value' => $keyword,
						'compare' => 'LIKE'
				),
				array(	'key' => 'description',
		                'value' => $keyword,
						'compare' => 'LIKE'
				),
			),
		);
		$user_results = new WP_User_Query( $user_args );
		$members = $user_results->get_results();
		$member_total = $user_results->get_total();
		
		$search_args = array(
			's' => $keyword,
			'post_type' => array( 'post', 'events', 'groups' ),
		);

		$search = new WP_Query( $search_args );
		$search_total = $search->found_posts;
		$total_results = $search_total + $member_total;
		?>
		
			<div class="ui relaxed divided items">
				<h3 class="ui left aligned header">
					<div class="ui <?php echo wp_is_mobile() ? 'mobile' : ''; ?> centered leaderboard ad" data-text="Leaderboard">
						<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
						<!-- search_result_top_ad -->
						<ins class="adsbygoogle"
						     style="display:inline-block;width:728px;height:90px"
						     data-ad-client="ca-pub-8465880978474028"
						     data-ad-slot="9209047208"></ins>
						<script>
						(adsbygoogle = window.adsbygoogle || []).push({});
						</script>
					</div>
					<div class="ui hidden divider"></div>
		          <i class="search icon"></i>
		            <div class="content">
		            <?php printf( __( 'Found '.$total_results.' result(s) for keyword "%s"', 'pr-membership' ), get_search_query() ); ?>
		          </div>
		        </h3>

				<?php

				if ( $search->have_posts() ) : 
					 while( $search->have_posts() ) :
				        setup_postdata( $search );  
				        $search->the_post();
				        $ID = get_the_id();
				      ?>
				      <div class="item">
			             <a href="<?php echo get_permalink(); ?>" class="ui small image">
				            <?php echo get_the_post_thumbnail(); ?>
				          </a>
			            <div class="content">              
			              <a class="header" href="<?php echo the_permalink(); ?>"><?php echo get_the_title(); ?> </a>
			              <div class="description">                
			                <p>
			                <?php 
			                  //Remove the attached image
			                  $content = get_the_content();
			                  $content = preg_replace("/<img[^>]+\>/i", " ", $content);          
			                  $content = apply_filters('the_content', $content);
			                  $content = str_replace(']]>', ']]>', $content);
			                  $content = preg_replace('/^\s+|\n|\r|\s+$/m', '', $content);
			                  $content = wp_trim_words($content, 50, ' ...');
			                  
			                  echo $content;

			                ?></p>
			              </div>
			            </div>
			          </div>

					<?php
					endwhile;
				endif; ?>
				<!-- Display member results -->
				<?php foreach( $members as $member ) : 
						$thumb_file = get_user_meta( $member->ID, 'pr_member_thumbnail_image', true );
      
			            if ( empty( $thumb_file )) {
			              $thumbnail = 'https://placeholdit.imgix.net/~text?txtsize=75&txt=thumbnail&w=800&h=800';
			            } else {
			              $thumbnail = THUMB_DIR . '/'.$thumb_file;
			            }
				?>
				<div class="item">
		            <a href="<?php echo home_url( 'member/'.$member->user_login ); ?>" class="ui small image">
		            	<img src="<?php echo $thumbnail; ?>">
		          	</a>
		          	<div class="content">
		          		<a class="header" href="<?php echo home_url( 'member/'.$member->user_login ); ?>">
		                <?php 
		                	if( is_public( 'show_name', $member->ID ) &&  get_user_meta( $member->ID, 'first_name', true ) != "" && get_user_meta( $member->ID, 'last_name', true ) != "" ) {
		                      $firstname = get_user_meta( $member->ID, 'first_name', true ); 
		                      $lastname = get_user_meta( $member->ID, 'last_name', true ); 
		                      $member_name = $firstname . ' ' . $lastname;
		                    } else {
		                      $member_name = ucfirst( $member->user_nicename );
		                    }
		                    echo $member_name;
		                ?>
		              </a>
		              <div class="description">
		                <p><?php echo wp_trim_words(get_user_meta( $member->ID, 'description', true ), 50, ' ...'); ?></p>
		              </div>
		              <div class="extra">
		                <?php 
		                  $interests = get_user_meta( $member->ID, 'interests', true );
		                  if ( !empty( $interests ) ) :
		                ?>
		                 <div class="ui list">
		                  <label>Interests</label>
		                  <?php 
		                      foreach( $interests as $interest ) : ?>
		                      <a href="<?php echo home_url( 'search/'.$interest ); ?>" class="ui small label"><?php echo $interest; ?></a>
		                    <?php endforeach; ?>
		                </div>
		                <?php endif; ?>
		                <?php $year_started_running = get_user_meta( $member->ID, 'year_started_running', true ); ?>
		                <?php if ( !empty( $year_started_running )) : ?>
		                  <span class="date">Running since <?php echo $year_started_running; ?></span>
		                <?php endif; ?>
		              </div>
		          	</div>
				</div>
				<?php endforeach; ?>
			</div>

	</div>
<?php get_footer(); ?>
