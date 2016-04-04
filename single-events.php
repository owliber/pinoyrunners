<?php get_header(); ?>
 
<div id="page" class="ui mobile reversed grid stackable container">
  <div class="four wide column">
    <div class="ui <?php echo wp_is_mobile() ? 'mobile' : ''; ?> centered medium rectangle ad" data-text="Medium Rectangle">
      <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
      <!-- event_single_left_top_ad2 -->
      <ins class="adsbygoogle"
           style="display:inline-block;width:300px;height:250px"
           data-ad-client="ca-pub-8465880978474028"
           data-ad-slot="4418920803"></ins>
      <script>
      (adsbygoogle = window.adsbygoogle || []).push({});
      </script>
    </div>
    <!-- Facebook Mobile Web Ad -->
    <script>
      window.fbAsyncInit = function() {
        FB.Event.subscribe(
          'ad.loaded',
          function(placementId) {
            console.log('Audience Network ad loaded');
          }
        );
        FB.Event.subscribe(
          'ad.error',
          function(errorCode, errorMessage, placementId) {
            console.log('Audience Network error (' + errorCode + ') ' + errorMessage);
          }
        );
      };
      (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/en_US/sdk/xfbml.ad.js#xfbml=1&version=v2.5&appId=1726152354286226";
        fjs.parentNode.insertBefore(js, fjs);
      }(document, 'script', 'facebook-jssdk'));
    </script>
    <fb:ad placementid="1726152354286226_1751468458421282" format="300x250" testmode="false"></fb:ad>
    <!-- Facebook Mobile Web Ad -->

    <h3 class="ui header small-caps">upcoming events</h3>
    <div class="ui segments">
      <?php

      global $post;
      $post_id = $post->ID;
     
      $args = array(
        'post__not_in' => array( $post_id ),
        'posts_per_page' => 15,
        'post_type' => 'events',
        'meta_key' => 'race_date',
        'orderby' => 'meta_value_num',
        'order' => 'ASC',
        'meta_query' => array(
          array(
            'key' => 'race_date',
            'value' => date('Ymd',strtotime(CUR_DATE)),
            'compare' => '>=',
          ),
        ),
      );

      $query = new WP_Query( $args );

      while( $query->have_posts() ) :
        setup_postdata( $query );  
        $query->the_post();
        $ID = get_the_id();
      ?>

      <div class="ui raised center aligned segment">
          <h4 class="ui header"><?php echo get_the_title(); ?>
            <div class="sub header"><?php echo date('F d, Y',strtotime( get_field( 'race_date' ) ) ); ?></div>
          </h4>
          
          <a href="<?php echo get_permalink(); ?>" class="ui centered medium rounded image">
            <?php echo get_the_post_thumbnail(); ?>
          </a>
      </div>

      <?php endwhile; 
      wp_reset_postdata();
      ?>
    </div>  
    <div class="ui basic segment">
      <!-- nuffnang -->
      <script type="text/javascript">
              nuffnang_bid = "190bbb46ac31869333f585289b543ad8";
              document.write( "<div id='nuffnang_ss'></div>" );
              (function() { 
                      var nn = document.createElement('script'); nn.type = 'text/javascript';    
                      nn.src = 'http://synad3.nuffnang.com.ph/ss.js';    
                      var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(nn, s.nextSibling);
              })();
      </script>
      <!-- nuffnang-->                              
    </div>
    
    <div class="ui <?php echo wp_is_mobile() ? 'mobile' : ''; ?> ad" data-text="Skyscraper">
      <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
      <!-- event_single_left_bottom_ad2 -->
      <ins class="adsbygoogle"
           style="display:inline-block;width:300px;height:600px"
           data-ad-client="ca-pub-8465880978474028"
           data-ad-slot="5337250806"></ins>
      <script>
      (adsbygoogle = window.adsbygoogle || []).push({});
      </script>
    </div>
  </div> <!-- four wide left col -->
  <div class="twelve wide column">

      <h1 class="ui center aligned icon header">
        <?php 
          if ( has_post_thumbnail( $post_id ) ) {  
            $url = wp_get_attachment_url( get_post_thumbnail_id( $post_id ) );             
          } else {
            $url = WP_CONTENT_URL.'/uploads/thumbnail/wireframe.png';
          }        
        ?>
        <img src="<?php echo $url; ?>" class="ui circular medium image">
        <div class="ui hidden divider"></div>
        <div class="content">
          <?php echo the_title(); ?>
          <div class="sub header">
            Organized by <?php the_field('organizer');?>
          </div>
          <div class="meta">
            <div class="fb-like" data-href="<?php the_permalink(); ?>" data-layout="button_count" data-action="like" data-show-faces="false" data-share="true"></div>
          </div>
        </div>      
      </h1>
      <div class="ui raised clearing padded segment">
        <div class="ui top left attached green inverted large label member-joined-<?php echo $post->ID; ?>"><?php the_field('member_joined'); ?> Joined</div>
          <div class="ui hidden divider"></div>    
          <?php 
            //display the content
            the_content();

            if( is_user_logged_in() ) :
              if ( is_member_joined( $post_id )) : ?>
              <button class="ui right floated teal button" disabled> Joined</button>
            <?php else: ?>
              <button id="btn_join_event" name="btn_join_event" class="ui right floated teal button btn-join-event-<?php echo $post->ID; ?>" value="<?php echo $post->ID; ?>"> Join This Race</button>
            <?php endif; 
            else: ?>
            <a class="ui right floated teal button" href="<?php echo home_url( 'register' ); ?>"> Join This Race</a>
          <?php endif; ?>
            <span class="error-"<?php echo $post->ID; ?>></span>
      </div>

      <!-- Race Details -->
      <table class="ui celled striped table">
        <thead>
          <tr><th colspan="2">
           Race Details       
          </th>
        </tr></thead>
        <tbody>
          <tr>
            <td class="collapsing">
              <i class="calendar outline icon"></i> Race Date
            </td>
            <td><?php echo date('F d, Y',strtotime( get_post_meta( $post_id, 'race_date', true ))); ?></td>
          </tr>
          <tr>
            <td class="collapsing">
              <i class="marker icon"></i> Race Location
            </td>
            <td><?php the_field('location'); ?></td>
          </tr>
          <tr>
            <td class="collapsing">
              <i class="road icon"></i> Distance
            </td>
            <td><?php the_field('distance'); ?></td>
          </tr>
          <tr>
            <td class="collapsing">
              <i class="payment icon"></i> Registration Fees
            </td>
            <td><?php the_field('registration_fees'); ?></td>
          </tr>
          <tr>
            <td class="collapsing">
              <i class="add to cart icon"></i> Registration Sites
            </td>
            <td><?php the_field('registration_sites'); ?></td>
          </tr>
          <tr>
            <td class="collapsing">
              <i class="puzzle icon"></i> Singlet/Shirt/Medal Designs
            </td>
            <td><?php the_field('shirt_medal_designs'); ?></td>
          </tr>
          <tr>
            <td class="collapsing">
              <i class="location arrow icon"></i> Race Maps
            </td>
            <td><?php the_field('race_maps'); ?></td>
          </tr>
          <tr>
            <td class="collapsing">
              <i class="pin icon"></i> Notes and Instructions
            </td>
            <td><?php the_field('race_notes'); ?></td>
          </tr>
        </tbody>
      </table>
      <div class="ui <?php echo wp_is_mobile() ? 'mobile' : ''; ?> centered leaderboard ad" data-text="Leaderboard">
        <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
        <!-- events_single_content_bottom -->
        <ins class="adsbygoogle"
             style="display:inline-block;width:728px;height:90px"
             data-ad-client="ca-pub-8465880978474028"
             data-ad-slot="6181970405"></ins>
        <script>
        (adsbygoogle = window.adsbygoogle || []).push({});
        </script>
      </div>
     <div class="ui raised segment">
      <div class="ui green top attached large label">Receive new event updates straight to your mailbox. Subscribe to us!</div>
      <?php if( wp_is_mobile() ) : ?>
        <div class="ui hidden divider"></div>
      <?php endif; ?>
        <form class="ui form" action="https://feedburner.google.com/fb/a/mailverify" method="post" target="popupwindow" onsubmit="window.open('https://feedburner.google.com/fb/a/mailverify?uri=pinoyrunners', 'popupwindow', 'scrollbars=yes,width=550,height=520');return true"> 
            <div class="inline fields">
              <div class="required six wide field">
                <div class="ui input">       
                  <input id="subscriber_name" type="text" placeholder="Enter your name" required>            
                </div>
              </div>
              <div class="required ten wide field">    
                <div class="ui input">         
                <input id="subscriber_email" type="text" name="email" placeholder="Enter your email address" value="" required>
                </div> 
              </div>
              <div class="field">    
                <input type="hidden" value="pinoyrunners" name="uri"/><input type="hidden" name="loc" value="en_US"/>
                <button type="submit" id="subscribe2" class="ui teal button" value="Subscribe" >Subscribe</button>
              </div>
            </div>
          </form>
          <div class="ui list">
            <label class="ui label">Follow and connect with us</label>
            <div class="item">
              <i class="facebook square icon"></i>
              <div class="content">
                Facebook &raquo; <a href="https://www.facebook.com/pinoyrunners.co" target="_blank" title="Follow pinoyrunners.co on facebook">https://www.facebook.com/pinoyrunners.co</a>
              </div>
            </div>
            <div class="item">
              <i class="twitter square icon"></i>
              <div class="content">
                Twitter &raquo; <a href="https://www.twitter.com/pinoy_runners" target="_blank" title="Tweet us on twitter @pinoy_runners">https://www.twitter.com/pinoy_runners</a>
              </div>
            </div>
            <div class="item">
              <i class="instagram square icon"></i>
              <div class="content">
                Instagram &raquo; <a href="https://www.instagram.com/pinoyrunners.co" target="_blank" title="Follow us on Instagram @pinoyrunners.co">https://www.instagram.com/pinoyrunners.co</a>
              </div>
            </div>            
            <div class="item">
              <i class="google plus square icon"></i>
              <div class="content">
                Google+ &raquo; <a href="https://plus.google.com/107903672623011381092" target="_blank" title="Follow us on Google+">https://plus.google.com/107903672623011381092</a>
              </div>
            </div>
          </div>
          <div class="ui small header">Related Events</div>
          <?php
            if ( class_exists( 'Jetpack_RelatedPosts' ) ) {
                echo do_shortcode( '[jetpack-related-posts]' );
            }
          ?>
      </div>

      <!-- Facebook Comments -->
      <div class="ui segment">
        <div class="ui top attached large label">We love to hear from you runners. Share us your thoughts!</div>
        <div class="ui hidden divider"></div>
        <div class="fb-comments" data-href="<?php the_permalink(); ?>" data-width="100%" data-numposts="10"></div>
      </div>

      <div class="ui buttons">
        <?php if ( is_user_logged_in() && is_member_joined( $post_id )) : ?>
          <button class="ui teal huge button" disabled> Joined</button>
        <?php elseif ( is_user_logged_in() && ! is_member_joined( $post_id ) ): ?>
          <button id="btn_join_event_huge" name="btn_join_event_huge" class="ui teal huge button btn-join-event-huge-<?php echo $post_id; ?>" value="<?php echo $post_id; ?>"> Join Now</button>
        <?php else: ?>
          <a href="<?php echo home_url( 'register' ); ?>" class="ui teal huge button">Join Now</a>
        <?php endif; ?>
        <div class="or"></div>
        <button id="btn_subscribe" class="ui huge button"> Subscribe</button>
      </div>
      <div class="ui hidden divider"></div>
      <div class="ui <?php echo wp_is_mobile() ? 'mobile' : ''; ?> centered leaderboard ad" data-text="Leaderboard">
        <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
        <!-- event_single_footer -->
        <ins class="adsbygoogle"
             style="display:inline-block;width:728px;height:90px"
             data-ad-client="ca-pub-8465880978474028"
             data-ad-slot="7511988006"></ins>
        <script>
        (adsbygoogle = window.adsbygoogle || []).push({});
        </script>
      </div>

  </div> <!-- thirteen wide right col -->

</div> <!-- page -->

<?php echo do_shortcode( '[sg_popup id=2]' ); ?>

<div id="modal-subscribe" class="ui small modal">
  <h3 class="ui header">
    Subscribe to our newsletter to receive new events and updates.
  </h3>
  <div class="content ui form">
  <div class="inline fields">
  <div class="required six wide field">
    <div class="ui input">       
      <input id="subscriber_name" type="text" placeholder="Enter your name" required>
    </div>
  </div>
  <div class="required ten wide field">    
    <div class="ui input">         
    <input id="subscriber_email" name="email" type="email" placeholder="Enter your email address" required>
    </div> 
  </div>
  </div>
  </div>
  <div class="actions">
    <div id="subscribe" class="ui teal button">Subscribe</div>
  </div>
</div>

<?php get_footer(); ?>
