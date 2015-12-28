<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">    
    <?php $meta = get_meta(); ?>
    <!-- For SEO Meta  -->
    <meta property="og:url"           content="<?php echo home_url( $_SERVER['REQUEST_URI'] );  ?>" />
    <meta property="og:type"          content="website" />
    <meta property="og:title"         content="<?php echo $meta['display_name']; ?>" />
    <meta property="og:description"   content="<?php echo $meta['description']; ?>" />
    <meta property="og:image"         content="<?php echo $meta['background']; ?>" />

    <title>pinoyrunners.co &mdash; An online Filipino marathoners, ultramathoners, runners, tri-athletes and fun-runner's community.</title>
    <title><?php wp_title( '|', true, 'right' ); bloginfo( 'name' ); ?></title>

    <?php wp_head(); ?>

  </head>

  <body class="site" <?php body_class(); ?>>

      <!-- Toggable Top Sidebar For Editing Page -->
      <div class="ui top sidebar">
          <?php echo do_shortcode( '[pr_upload]' ); ?>
      </div><!-- Toggable Sidebar -->

      <div id="topnav" class="ui top fixed secondary transparent menu">
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

       <!--  <div class="ui container"> -->

          <?php
             /**
            * Displays a navigation menu
            * @param array $args Arguments
            */
            $menu = array(              
              'theme_location' => is_user_logged_in() ? 'homepage-menu' : 'frontpage-menu',
              'container' => '',
              //'menu_class' => '',
              'items_wrap' => '%3$s'
            );

            wp_nav_menu( $menu );

          ?>
        <!-- </div> -->
    </div>
    <!-- <div id="content" class="ui container"> -->
