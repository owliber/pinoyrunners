<?php
/*
Template Name: Events Template
*/

get_header();

?>
<div id="page" class="ui container">
        <div class="ui relaxed divided items"> 
          <button class="ui right floated green default button">Subscribe</button>
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
                  //$content = trim($content, '\t\n\r\0\x0B');
                  $content = preg_replace("/<img[^>]+\>/i", " ", $content);          
                  $content = apply_filters('the_content', $content);
                  $content = str_replace(']]>', ']]>', $content);
                  $content = preg_replace('/^\s+|\n|\r|\s+$/m', '', $content);
                  $content = wp_trim_words($content, 50, ' ...');
                  
                  echo $content;

                ?></p>
              </div>
              
              <div class="extra"> 
                <span class="member-joined-archive-<?php echo $event->ID; ?>"><?php echo get_post_meta( $event->ID, 'member_joined', true ); ?> runners will be attending this event.</span>
                              
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
</div> <!-- page -->

<?php get_footer(); ?>
