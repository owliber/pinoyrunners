<?php
/*
Template Name: Events Template
*/

get_header();

?>
<div id="page" class="ui grid container">
  <div class="twelve wide column">
        <div class="ui relaxed divided items"> 
          <?php if ( ! is_user_logged_in() ) : ?>
            <button id="btn_subscribe" class="ui right floated green default button">Subscribe</button>
          <?php endif; ?>
          <h2 class="ui left aligned header">
          <i class="calendar icon"></i>
            <div class="content">
            Race Events
            <div class="sub header"> Lists of all race events as of <?php echo date('F d, Y',strtotime(CUR_DATE)); ?></div>
          </div>
        </h2>
          <?php 

              $args = array(
                'posts_per_page'   => 25,
                'offset'           => 0,     
                'post_type'        => 'events',
                'post_status'      => 'publish',
              );

              $events = get_posts( $args ); 

          ?>

          <?php if ( count( $events ) > 0 ) : ?>            
          <?php foreach ( $events as $event ) : ?>
          <?php setup_postdata( $event ); ?>
          <div class="item">
            <a class="ui medium image" href="<?php echo home_url( 'events/' . $event->post_name ); ?>">
              <?php if ( has_post_thumbnail( $event->ID ) ) {                  
                  echo get_the_post_thumbnail( $event->ID );
              }else {
                
                echo '<img src="'.WP_CONTENT_URL.'/uploads/thumbnail/wireframe.png">';
              }
              ?>
            </a>
            <div class="content">              
              <a class="header" href="<?php echo home_url( 'events/' . $event->post_name ); ?>"><?php echo $event->post_title; ?> </a>
              
              <div class="meta">
                <span class="date"><i class="calendar outline icon"></i> <?php echo date('F d, Y',strtotime(get_post_meta( $event->ID, 'race_date', true ))); ?></span><br />  
              </div>
              <div class="meta">
                <span class="location"><i class="marker icon"></i> <?php echo get_post_meta( $event->ID, 'location', true ); ?></span><br />                
              </div>
              <div class="meta">
                <span class="distance"><i class="road icon"></i> <?php echo implode("/", get_post_meta( $event->ID, 'distance', true )) ; ?></span>  
              </div>

              <div class="description">                
                <p>
                <?php 
                  //Remote the attached image
                  $content = get_the_content();
                  $content = preg_replace("/<img[^>]+\>/i", " ", $content);          
                  $content = apply_filters('the_content', $content);
                  $content = str_replace(']]>', ']]>', $content);
                  $content = preg_replace('/^\s+|\n|\r|\s+$/m', '', $content);
                  $content = wp_trim_words($content, 50, ' ...');
                  
                  echo $content;

                ?></p>
              </div>
              <div class="extra">
                <div class="fb-like" data-href="<?php echo get_post_permalink( $event->ID ); ?>" data-layout="button_count" data-action="like" data-show-faces="false" data-share="true"></div>
              </div>
              <div class="extra"> 
                <span class="member-joined-archive-<?php echo $event->ID; ?>">
                <?php 

                  $runner_count = get_post_meta( $event->ID, 'member_joined', true ); 
                  $runner_count > 1 ? $s = ' runners' : $s = ' runner';

                  echo $runner_count . $s . ' will be attending this event';
                  
                ?></span>
                              
                <?php if ( is_user_logged_in() ): ?>
                  <?php if( is_member_joined( $event->ID ) ) : ?>
                    <button class="ui right floated teal default button" disabled>You joined this race</button>
                  <?php else: ?>
                    <button name="btn_join_archive_event" id="btn_join_archive_event" class="ui right floated teal default button btn-join-archive-event-<?php echo $event->ID; ?>" value="<?php echo $event->ID; ?>">Join this race</button>
                  <?php endif; ?>
                <?php endif; ?>
                <?php if ( ! is_user_logged_in() ) : ?>
                  <a href="<?php echo home_url( 'register' ); ?>" class="ui right floated teal default button" >Join this race</a>
                <?php endif; ?>

                <span class="error-archive-"<?php echo $event->ID; ?>></span>
              </div>              

            </div>
          </div>
          <?php endforeach; ?>
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
  </div> <!-- twelve wide left col -->
  <div class="four wide right column">
    <h3 class="ui header">Featured Events</h3>
    <div class="ui segments">
      <?php
      /* Get all Sticky Posts */
      $sticky = get_option( 'sticky_posts' );

      /* Sort Sticky Posts, newest at the top */
      rsort( $sticky );

      /* Get top 5 Sticky Posts */
      $sticky = array_slice( $sticky, 0, 5 );

      $args = array(
        'post__in' => $sticky, 
        'ignore_sticky_posts' => 1,
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

      <div class="ui raised segment">
          <h4 class="ui header"><?php echo get_the_title(); ?>
            <div class="sub header"><?php echo date('F d, Y',strtotime( get_field( 'race_date' ) ) ); ?></div>
          </h4>
          
          <a href="<?php echo get_permalink(); ?>" class="ui medium image">
            <?php echo get_the_post_thumbnail(); ?>
          </a>
      </div>

      <?php endwhile; 
      wp_reset_postdata();
      ?>
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
