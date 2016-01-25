<?php get_header(); ?>
 
<div id="page" class="ui grid container">
  <div class="three wide column">
    
    <h4 class="ui header small-caps">upcoming events</h4>
    <div class="ui segments">
      <?php

      global $post;
      $post_id = $post->ID;

      /* Get all Sticky Posts */
      $sticky = get_option( 'sticky_posts' );

      /* Sort Sticky Posts, newest at the top */
      rsort( $sticky );

      /* Get top 5 Sticky Posts */
      $sticky = array_slice( $sticky, 0, 15 );
     
      $args = array(
        'post__in' => $sticky, 
        'ignore_sticky_posts' => 1,
        'post__not_in' => array( $post_id ),
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

      <div class="ui raised segment">
          <h4 class="ui header"><?php echo get_the_title(); ?>
            <div class="sub header"><?php echo date('F d, Y',strtotime( get_field( 'race_date' ) ) ); ?></div>
          </h4>
          
          <a href="<?php echo get_permalink(); ?>" class="ui small image">
            <?php echo get_the_post_thumbnail(); ?>
          </a>
      </div>

      <?php endwhile; 
      wp_reset_postdata();
      ?>
    </div>  
  
  </div> <!-- three wide left col -->
  <div class="thirteen wide column">

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
        </div>      
      </h1>
      <div class="ui raised clearing padded segment">
        <div class="ui top left attached green inverted large label member-joined-<?php echo $post->ID; ?>"><?php the_field('member_joined'); ?> Joined</div>
          <div class="ui hidden divider"></div>    
          <?php 
              $content = the_content();
              $content = preg_replace("/<img[^>]+\>/i", " ", $content);          
              $content = apply_filters('the_content', $content);
              $content = str_replace(']]>', ']]>', $content);
              echo $content;
          ?>
          <div class="fb-like" data-href="<?php the_permalink(); ?>" data-layout="button_count" data-action="like" data-show-faces="false" data-share="true"></div>
          <?php 
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
          <?php /*
          <tr>
            <td class="collapsing">
              <i class="pin icon"></i> Tags
            </td>
            <td><?php 
              $taxonomies = array( 
                  'post_tag',
                  'event_tag',
              );
            var_dump(wp_get_post_terms( $post_id, 'event_tag' )); ?></td>
          </tr> */ ?>
        </tbody>
      </table>

      <!-- Facebook Comments -->
      <div class="ui segment">
        <div class="header">Comments and feedback</div>
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
  </div> <!-- thirteen wide right col -->

</div> <!-- page -->

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
