<?php
/**
 * Template Name: Groups Template
 */

get_header(); 

?>

<div id="page" class="ui container">
        <div class="ui divided items"> 
          <div class="ui right floated buttons">
            <a href="<?php echo home_url( '/home/mygroups' ); ?>" class="ui button">My Groups</a>
          </div>

          <h2 class="ui left aligned header">
          <i class="users icon"></i>
            <div class="content">
            Groups
            <div class="sub header"> Join a team or group to meet new friends.</div>
          </div>
        </h2>
          <?php 

              $args = array(
                'posts_per_page'   => 25,
                'offset'           => 0,     
                'post_type'        => 'groups',
                'post_status'      => 'publish',
                'exclude'          => get_groups(),
              );

              $groups = get_posts( $args ); 

          ?>
          <?php if ( count( $groups ) > 0 ) : ?>            
          <?php foreach ( $groups as $group ) : ?>
          <?php setup_postdata( $group ); ?>
          <div class="item">
            <a class="ui small image" href="<?php echo home_url( 'groups/' . $group->post_name ); ?>">
              <?php if ( has_post_thumbnail( $group->ID ) ) {                  
                  echo get_the_post_thumbnail( $group->ID );
              }else {
                
                echo '<img src="'.WP_CONTENT_URL.'/uploads/thumbnail/wireframe.png">';
              }
              ?>
            </a>
            <div class="content">              
              <a class="header" href="<?php echo home_url( 'groups/' . $group->post_name ); ?>"><?php echo $group->post_title; ?> </a>
              <div class="meta">
                <span class="location"><?php echo get_post_meta( $group->ID, '_group_location', true ); ?></span> &mdash;
                <span class="privacy"><?php

                    $group_privacy = get_post_meta( $group->ID, '_is_private', true ); 

                    $group_privacy == 1 ? $privacy = "Private Group" : $privacy = "Public Group";

                    echo $privacy;
                  ?>
                </span>               
              </div>

              <div class="description">                
                <p><?php the_content(); ?></p>
              </div>
              
              <div class="extra">                
                <span class="member-total-<?php echo $group->ID; ?>"><?php 
                  
                  $total_members = get_post_meta( $group->ID, '_group_total', true ); 

                  if ( empty( $total_members ) ) $total_members = 0;
                  $plural = (  $total_members > 1 ) ? ' members' : ' member';
                  echo $total_members . $plural;

                ?></span>
               
                <?php if ( is_user_logged_in() && $group->post_author != get_current_user_id() ) : ?>
                  <button name="btn_join_group" id="btn_join_group" class="ui teal right floated default button btn-join-<?php echo $group->ID; ?>" value="<?php echo $group->ID; ?>">Join This Group</button>
                <?php endif; ?>
                <?php if ( ! is_user_logged_in() ) : ?>
                  <a href="<?php echo home_url(); ?>" class="ui teal right floated default button" >Login or Register To Join</a>
                <?php endif; ?>
                <span class="error-message-"<?php echo $group->ID; ?>></span>
              </div>

            </div>
          </div>
          <?php endforeach; ?>
          <?php wp_reset_postdata(); ?>
          <?php else: ?>
          
          <div class="ui info message">
            <i class="close icon"></i>
            <div class="header">
              There are no more groups. Go to your homepage and start creating a new group now.
            </div>
          </div>

        <?php endif; ?>
      </div> <!-- items -->
</div> <!-- page -->

<?php get_footer(); ?>
