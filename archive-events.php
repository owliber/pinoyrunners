<?php
/*
Template Name: Events Template
*/

get_header();

?>
<div id="page" class="ui grid stackable container">
  <div class="twelve wide column">
        <h2 class="ui left aligned header">
          <i class="calendar icon"></i>
            <div class="content">
            Race Events
            <div class="sub header"> Lists of all race events as of <?php echo date('F d, Y',strtotime(CUR_DATE)); ?></div>
          </div>
        </h2>
        <div id="content" class="ui relaxed divided items">   

          <?php 

              $args = array( 
                'post_type'        => 'events',
                'post_status'      => 'publish',
              );

              $posts = get_posts( $args ); 
              $i = 1;
          ?>

          <?php if ( count( $posts ) > 0 ) : ?>    
          
          <?php foreach ( $posts as $post ) : setup_postdata( $post );  ?>     
          <?php get_template_part( 'content','events' ); ?>
          <?php if($i % 5 == 0) : ?>
              <div class="ui <?php echo wp_is_mobile() ? 'mobile' : ''; ?> centered leaderboard ad" data-text="Leaderboard">
                <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
                <!-- events_feed_interval_ad -->
                <ins class="adsbygoogle"
                     style="display:inline-block;width:728px;height:90px"
                     data-ad-client="ca-pub-8465880978474028"
                     data-ad-slot="6600772803"></ins>
                <script>
                (adsbygoogle = window.adsbygoogle || []).push({});
                </script>
              </div>
          <?php endif; ?>
          <?php $i++;
          endforeach; ?>          
          <?php wp_reset_postdata(); ?>
          <?php else: ?>
          
            <div class="ui info message">
              <i class="close icon"></i>
              <div class="header">
                There are no events yet. Please check again later.
              </div>
            </div>

        <?php endif; ?>
      </div> <!-- items -->
      <div class="ui <?php echo wp_is_mobile() ? 'mobile' : ''; ?> centered leaderboard ad" data-text="Leaderboard">
          <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
          <!-- events_feed_bottom_ad -->
          <ins class="adsbygoogle"
               style="display:inline-block;width:728px;height:90px"
               data-ad-client="ca-pub-8465880978474028"
               data-ad-slot="4286434807"></ins>
          <script>
          (adsbygoogle = window.adsbygoogle || []).push({});
          </script>
      </div>
  </div> <!-- twelve wide left col -->
  <div class="four wide right column">
    <div class="ui <?php echo wp_is_mobile() ? 'mobile' : ''; ?> centered medium rectangle ad" data-text="Medium Rectangle">
      <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
      <!-- events_right_top_ad -->
      <ins class="adsbygoogle"
           style="display:inline-block;width:300px;height:250px"
           data-ad-client="ca-pub-8465880978474028"
           data-ad-slot="3507705606"></ins>
      <script>
      (adsbygoogle = window.adsbygoogle || []).push({});
      </script>
    </div>
    <div class="ui hidden divider"></div>
    <?php if ( ! is_user_logged_in() ) : ?>
      <button id="btn_subscribe" class="ui green default button">Subscribe</button>
    <?php endif; ?>
    <h4 class="ui header small-caps">featured events</h4>
    <div class="ui segments">
      <?php

        $args = array(
          'post_type' => 'events',
          'meta_key' => 'race_date',
          'orderby' => 'meta_value_num',
          'order' => 'ASC',
          'meta_query'  => array(
            'relation'    => 'AND',
            array(
              'key'     => 'is_featured',
              'value'     => '1',
              'compare'   => '=',
            ),
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
          
          <a href="<?php echo get_permalink(); ?>" class="ui medium rounded image">
            <?php echo get_the_post_thumbnail(); ?>
          </a>
      </div>

      <?php endwhile; 
      wp_reset_postdata();
      ?>
    </div>

    <div class="ui <?php echo wp_is_mobile() ? 'mobile' : ''; ?> centered medium rectangle ad" data-text="Medium Rectangle">
      <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
      <!-- events_right_middle_ad -->
      <ins class="adsbygoogle"
           style="display:inline-block;width:300px;height:250px"
           data-ad-client="ca-pub-8465880978474028"
           data-ad-slot="1751770805"></ins>
      <script>
      (adsbygoogle = window.adsbygoogle || []).push({});
      </script>
    </div>

    <h4 class="ui header small-caps">upcoming events</h4>
    <div class="ui segments">
      <?php

      global $post;
      $post_id = $post->ID;
     
      $args = array(
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
          
          <a href="<?php echo get_permalink(); ?>" class="ui medium rounded image">
            <?php echo get_the_post_thumbnail(); ?>
          </a>
      </div>

      <?php endwhile; 
      wp_reset_postdata();
      ?>
    </div>
    <div class="ui segment">
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
    <div class="ui <?php echo wp_is_mobile() ? 'mobile' : ''; ?> centered medium rectangle ad" data-text="Medium Rectangle">
      <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
      <!-- events_right_bottom_ad -->
      <ins class="adsbygoogle"
           style="display:inline-block;width:300px;height:250px"
           data-ad-client="ca-pub-8465880978474028"
           data-ad-slot="7798304409"></ins>
      <script>
      (adsbygoogle = window.adsbygoogle || []).push({});
      </script>
    </div>
      
  </div> <!-- four wide col -->
</div> <!-- page -->
    
<div id="modal-subscribe" class="ui small modal">    
  <div class="ui segment">
    <form class="ui form" action="https://feedburner.google.com/fb/a/mailverify" method="post" target="popupwindow" onsubmit="window.open('https://feedburner.google.com/fb/a/mailverify?uri=pinoyrunners', 'popupwindow', 'scrollbars=yes,width=550,height=520');return true">
      <h3 class="ui header">
        Subscribe to our newsletter to receive new events and updates.
      </h3>    
      <div class="content">
        <div class="inline fields">
          <div class="required six wide field">
            <div class="ui input">       
              <input id="subscriber_name" type="text" placeholder="Enter your name" required>            
            </div>
          </div>
          <div class="required ten wide field">    
            <div class="ui input">         
            <input id="subscriber_email" type="text" name="email" placeholder="Enter your email address" required>
            </div> 
          </div>
          <div class="field">    
            <input type="hidden" value="pinoyrunners" name="uri"/><input type="hidden" name="loc" value="en_US"/>
            <button type="submit" id="subscribe" class="ui teal button" value="Subscribe" >Subscribe</button>
          </div>
        </div>
      </div>      
    </form>
  </div>
</div>  

<?php get_footer(); ?>
