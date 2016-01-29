<?php get_header(); ?>

<div id="page" class="ui container">
      <?php 
        global $post;
        $result = get_post( $post->ID ); 
      ?>
      <h1 class="ui center aligned icon header">

        <?php 
          if ( has_post_thumbnail( $post->ID ) ) {  

            $url = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );                
              
          }else {
            
            $url = WP_CONTENT_URL.'/uploads/thumbnail/wireframe.png';
          }        
        ?>
        <img src="<?php echo $url; ?>" class="ui circular medium image">
        <div class="ui hidden divider"></div>
        <div class="content">
          <?php echo $result->post_title; ?>
          <div class="sub header">
            <?php $group_privacy = get_post_meta( $post->ID, '_is_private', true ); 
              if( $group_privacy == 1 )
                $privacy = "Private Group";
              else
                $privacy = "Public Group";
            
              echo $privacy;
            ?>
          </div>
        </div>
        
      </h1>

        <div class="ui relaxed divided items"> 

           <?php if ( is_request_pending( $post->ID )) : ?>
            <button class="ui right floated teal button" disabled> Pending Request</button>
            <?php endif; ?>
           <?php if ( is_not_joined_in_group( $post->ID )) : ?>
            <button id="btn_join_group" class="ui right floated green button btn-join-<?php echo $post->ID; ?>" value="<?php echo $post->ID; ?>">Join Group</button>
           <?php endif; ?>

          <div class="ui right floated buttons">
            <a href="<?php echo home_url( 'groups' ); ?>" class="ui button">Global Groups</a>
            <a href="<?php echo home_url( 'home/mygroups' ); ?>" class="ui teal button">My Groups</a>
          </div>
          <span class="error-<?php echo $post->ID; ?>"></span>
          <h2 class="ui left aligned header">
            <i class="users icon"></i>
              <div class="content">
              Members 
               <div class="sub header member-total-<?php echo $post->ID; ?>"><?php echo get_post_meta( $post->ID, '_group_total', true ); ?> runners</div>
            </div>
          </h2>
      
          <?php 
          $members = get_members( $post->ID );
          foreach( $members as $member ) : 

            $thumb_file = get_user_meta( $member->ID, 'pr_member_thumbnail_image', true );
      
            if ( empty( $thumb_file )) {
              $thumbnail = 'http://placehold.it/800x800';
            } else {
              $thumbnail = THUMB_DIR . '/'.$thumb_file;
            }

          ?>
          <div class="item">
            <a class="ui small image" href="<?php echo home_url( 'member/'.$member->user_login ); ?>">
              <img src="<?php echo $thumbnail; ?>">
            </a>
            <div class="content">
              <a class="header" href="<?php echo home_url( 'member/'.$member->user_login ); ?>">
                <?php 
                    if ( is_public( 'show_name', $member->ID ) && get_user_meta( $member->ID, 'first_name', true ) != "" && get_user_meta( $member->ID, 'last_name', true ) != "" ) {
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
                      <a class="ui small label"><?php echo $interest; ?></a>
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

      </div> <!-- divided items -->
          
          
</div> <!-- page -->

<?php get_footer(); ?>
