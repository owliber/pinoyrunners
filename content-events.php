<div class="post item" id="post-<?php the_ID(); ?>">
  <a class="ui centered medium rounded image" href="<?php the_permalink(); ?>">
    <?php if ( has_post_thumbnail() ) {                  
        echo get_the_post_thumbnail();
    } else {                
      echo '<img src="'.WP_CONTENT_URL.'/uploads/thumbnail/wireframe.png">';
    } ?>
  </a>
  <div class="content">              
    <a class="header" href="<?php the_permalink(); ?>"><?php the_title(); ?> </a>
    
    <div class="meta">
      <span class="date"><i class="calendar outline icon"></i> <?php echo date('F d, Y',strtotime( get_post_meta( get_the_ID(), 'race_date', true ))); ?></span><br />  
    </div>
    <div class="meta">
      <span class="location"><i class="marker icon"></i> <?php echo get_post_meta( get_the_ID(), 'location', true ); ?></span><br />                
    </div>
    <div class="meta">
      <span class="distance"><i class="road icon"></i> <?php echo implode("/", get_post_meta( get_the_ID(), 'distance', true )) ; ?></span>  
    </div>
    <div class="meta">
      <div class="fb-like" data-href="<?php the_permalink(); ?>" data-layout="button_count" data-action="like" data-show-faces="false" data-share="true"></div>
    </div>

    <div class="description">                
      <?php 
        //Remove the attached image
        $content = get_the_content();
        $content = preg_replace("/<img[^>]+\>/i", " ", $content);          
        $content = apply_filters('the_content', $content);
        $content = str_replace(']]>', ']]>', $content);
        $content = preg_replace('/^\s+|\n|\r|\s+$/m', '', $content);
        $content = wp_trim_words($content, 25, ' ...');
        echo $content;

      ?>
    </div>
    
    <div class="extra"> 
      <span class="member-joined-archive-<?php echo get_the_ID(); ?>">
      <?php 

        $runner_count = get_post_meta( get_the_ID(), 'member_joined', true ); 
        $runner_count > 1 ? $s = ' runners' : $s = ' runner';

        echo $runner_count . $s . ' will be attending this event';
        
      ?></span>
                    
      <?php if ( is_user_logged_in() ): ?>
        <?php if( is_member_joined( get_the_ID() ) ) : ?>
          <button class="ui right floated teal default button" disabled>You joined this race</button>
        <?php else: ?>
          <button name="btn_join_archive_event" id="btn_join_archive_event" class="ui right floated teal default button btn-join-archive-event-<?php echo get_the_ID(); ?>" value="<?php echo get_the_ID() ?>">Join this race</button>
        <?php endif; ?>
      <?php endif; ?>
      <?php if ( ! is_user_logged_in() ) : ?>
        <a href="<?php echo home_url( 'register' ); ?>" class="ui right floated teal default button" >Join this race</a>
      <?php endif; ?>

      <span class="error-archive-"<?php echo get_the_ID(); ?>></span>
    </div>              
  </div>
</div>