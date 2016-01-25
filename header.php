<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">      
    <title><?php wp_title( '|', true, 'right' ); ?> &mdash; <?php bloginfo( 'description' ); ?></title>

    <?php wp_head(); ?>

  </head>

  <body class="site" <?php body_class(); ?>>

      <!-- Facebook Plugin -->
      <div id="fb-root"></div>
      <script>(function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.5&appId=1726152354286226";
        fjs.parentNode.insertBefore(js, fjs);
      }(document, 'script', 'facebook-jssdk'));</script>
      <!-- Facebook Plugin -->
      
      <!-- Toggable Top Sidebar For Editing Page -->
      
      <div class="ui top sidebar">
      <?php if ( is_user_logged_in() && is_author() ) : ?>
          <?php echo do_shortcode( '[pr_edit_page]' ); ?>
      <?php endif; ?>
      </div><!-- Toggable Sidebar -->
      

      <div <?php if( ! is_front_page() ) echo 'id="topnav"'; ?> class="ui top fixed secondary transparent menu">
        
        <!-- Header Image -->
        <div class="header item">
          <!-- Has upload header image -->
          <?php if ( get_header_image() != '' ) : ?>
          <?php is_user_logged_in() ? $logo_url = home_url( 'home' ) : $logo_url = home_url(); ?>
            <a href="<?php echo $logo_url; ?>"><img src="<?php header_image(); ?>" width="<?php echo get_custom_header()->width; ?>" height="<?php echo get_custom_header()->height; ?>" alt="<?php bloginfo( 'name' ); ?>"/></a>
          <?php endif; ?>

          <!-- No image uploaded -->
          <?php if( !get_header_image() ) : ?>
            <a class="brand" href="#"><?php bloginfo( 'name' ); ?></a>
          <?php endif; ?>
        </div><!-- Header Image -->       

          <?php
             /**
            * Displays a navigation menu
            * @param array $args Arguments
            */
            $menu = array(              
              'theme_location' => is_user_logged_in() ? 'homepage-menu' : 'frontpage-menu',
              'container' => '',
              'items_wrap' => '%3$s'
            );

            wp_nav_menu( $menu );
          ?>
        
    </div>
