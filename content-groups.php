<div class="item">
    <a class="ui small image" href="<?php the_permalink(); ?>">
      <?php if ( has_post_thumbnail() ) {                  
          echo get_the_post_thumbnail();
      }else {
        echo '<img src="'.WP_CONTENT_URL.'/uploads/thumbnail/wireframe.png">';
      }
      ?>
    </a>
    <div class="content">              
      <a class="header" href="<?php the_permalink(); ?>"><?php the_title(); ?> </a>
      <div class="meta">
        <span class="location"><?php echo get_post_meta( get_the_ID(), '_group_location', true ); ?></span> &mdash;
        <span class="privacy"><?php

            $group_privacy = get_post_meta( get_the_ID(), '_is_private', true ); 

            $group_privacy == 1 ? $privacy = "Private Group" : $privacy = "Public Group";

            echo $privacy;
          ?>
        </span>               
      </div>

      <div class="description">                
        <p><?php the_content(); ?></p>
      </div>
      
      <div class="extra">                
        <span class="member-total-<?php echo get_the_ID(); ?>"><?php 
          
          $total_members = get_post_meta( get_the_ID(), '_group_total', true ); 

          if ( empty( $total_members ) ) $total_members = 0;
          $plural = (  $total_members > 1 ) ? ' members' : ' member';
          echo $total_members . $plural;

        ?></span>
       
        <?php if ( is_user_logged_in() && $post->post_author != get_current_user_id() ) : ?>
          <button name="btn_join_group" id="btn_join_group" class="ui teal right floated default button btn-join-<?php echo get_the_ID(); ?>" value="<?php echo get_the_ID(); ?>">Join This Group</button>
        <?php endif; ?>
        <?php if ( ! is_user_logged_in() ) : ?>
          <a href="<?php echo home_url(); ?>" class="ui teal right floated default button" >Login or Register To Join</a>
        <?php endif; ?>
        <span class="error-message-"<?php echo get_the_ID(); ?>></span>
      </div>

    </div>
  </div>