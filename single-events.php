<?php get_header(); ?>

<div id="page" class="ui container">
    <?php 

      global $post;

      $event = get_post( $post->ID ); 

    ?>

    <h1 class="ui center aligned icon header">
      <?php 
        if ( has_post_thumbnail( $post->ID ) ) {  
          $url = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );             
        } else {
          $url = WP_CONTENT_URL.'/uploads/thumbnail/wireframe.png';
        }        
      ?>
      <img src="<?php echo $url; ?>" class="ui circular small image">
      <div class="ui hidden divider"></div>
      <div class="content">
        <?php echo $event->post_title; ?>
        <div class="sub header">
          Organized by <?php the_field('organizer');?>
        </div>
      </div>      
    </h1>

    <div class="ui raised clearing padded segment">
      <div class="ui top left attached green inverted large label member-joined-<?php echo $post->ID; ?>"><?php the_field('member_joined'); ?> Joined</div>
        <div class="ui hidden divider"></div>    
        <?php 
            $content = $event->post_content;
            $content = preg_replace("/<img[^>]+\>/i", " ", $content);          
            $content = apply_filters('the_content', $content);
            $content = str_replace(']]>', ']]>', $content);
            echo $content;
        ?>
        <?php if ( is_member_joined( $event->ID )) : ?>
          <button class="ui right floated teal button" disabled> Joined</button>
        <?php else: ?>
          <button id="btn_join_event" name="btn_join_event" class="ui right floated teal button btn-join-event-<?php echo $post->ID; ?>" value="<?php echo $post->ID; ?>"> Join This Race</button>
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
        <td><?php echo date('F d, Y',strtotime( get_post_meta( $post->ID, 'race_date', true ))); ?></td>
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

  <div class="ui segment">
    
    <!-- Facebook Comment Plugin -->
    <div id="fb-root"></div>
    <script>(function(d, s, id) {
      var js, fjs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)) return;
      js = d.createElement(s); js.id = id;
      js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.5&appId=145957308928165";
      fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>
    <!-- Facebook Comment Plugin -->

    <div class="header">Comments and feedback</div>
    <div class="fb-comments" data-href="<?php the_permalink(); ?>" data-width="100%" data-numposts="10"></div>
  </div>

  <div class="ui buttons">
    <?php if ( is_member_joined( $event->ID )) : ?>
      <button class="ui teal huge button" disabled> Joined</button>
    <?php else: ?>
      <button id="btn_join_event_huge" name="btn_join_event_huge" class="ui teal huge button btn-join-event-huge-<?php echo $post->ID; ?>" value="<?php echo $post->ID; ?>"> Join Now</button>
    <?php endif; ?>
    <div class="or"></div>
    <button class="ui huge button"> Subscribe</button>
  </div>

</div> <!-- page -->

<?php get_footer(); ?>
