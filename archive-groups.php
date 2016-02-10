<?php
/**
 * Template Name: Groups Template
 */

get_header(); 

?>

<div id="page" class="ui container">
        <h2 class="ui left aligned header">
          <i class="users icon"></i>
            <div class="content">
            Groups
            <div class="sub header"> Join a team or group to meet new friends.</div>
          </div>
        </h2>
        <div class="ui right floated buttons">
          <a href="<?php echo home_url( '/home/mygroups' ); ?>" class="ui button">My Groups</a>
        </div>
        <div id="content" class="ui divided items"> 
          
          <?php 

              $args = array(
                'posts_per_page'   => 25,
                'offset'           => 0,     
                'post_type'        => 'groups',
                'post_status'      => 'publish',
                'exclude'          => get_groups(),
              );

              $posts = get_posts( $args ); 

          ?>
          <?php if ( count( $posts ) > 0 ) : ?>            
          <?php foreach ( $posts as $post ) : ?>
          <?php setup_postdata( $post ); ?>
          <?php get_template_part( 'content', 'groups' ); ?>
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
