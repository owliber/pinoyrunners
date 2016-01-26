<?php

add_theme_support( 'menus' );
add_theme_support( 'custom-header' );
add_theme_support( 'post-thumbnails' );
//add_theme_support( 'custom-background' );
add_theme_support( 'html5', array( 'search-form' ) );
add_action( 'init', 'register_theme_menus' );
//add_theme_support( 'title-tag' );
add_filter('jetpack_enable_open_graph', '__return_false', 99);

function register_theme_menus() {

	register_nav_menus(
		array(
			'frontpage-menu' => __( 'Frontpage Menu', 'pinoyrunners' ),
			'homepage-menu' => __( 'Homepage Menu', 'pinoyrunners' ),
			'left-sidebar-menu' => __( 'Left Sidebar Menu', 'pinoyrunners' ),
			'right-sidebar-menu' => __( 'Right Sidebar Menu', 'pinoyrunners' ),
		)
	);
	
}

add_action( 'wp_enqueue_scripts', 'wppr_theme_styles' );
function wppr_theme_styles() {
	wp_enqueue_style( 'sui-min-css', get_stylesheet_directory_uri() . '/css/semantic.min.css' );
	wp_enqueue_style( 'main-css', get_stylesheet_directory_uri() . '/style.css' );
    wp_enqueue_style( 'daterangepicker-css', plugins_url( PR_Membership::PLUGIN_FOLDER  . '/css/daterangepicker.min.css' ));
	
}

add_action( 'wp_enqueue_scripts', 'wppr_theme_scripts' );
function wppr_theme_scripts() {
	wp_enqueue_script( 'jquery-min-js', get_stylesheet_directory_uri() . '/js/jquery.min.js', '', '', false );
	wp_enqueue_script( 'sui-min-js', get_stylesheet_directory_uri() . '/js/semantic.min.js', array('jquery'), '', false );
    
    wp_enqueue_script( 'moment-min', plugins_url( PR_Membership::PLUGIN_FOLDER  . '/js/moment.js'), array('jquery' ), '', false );
    wp_enqueue_script( 'daterangepicker-min', plugins_url( PR_Membership::PLUGIN_FOLDER  . '/js/daterangepicker.js' ), array('jquery'), '', false );
    wp_enqueue_script( 'membership-js', plugins_url( PR_Membership::PLUGIN_FOLDER  . '/js/membership-js.js' ), array('jquery'), '', true );
    

}

/**
 * Redirect user after successful login.
 */
add_filter( 'login_redirect', 'pr_login_redirect', 10, 3 );
function pr_login_redirect( $redirect_to, $request, $user ) {
	global $user;

	$home_url = home_url( 'home' );
	
	if ( isset( $user->roles ) && is_array( $user->roles ) ) {
		//check for admins
		if ( in_array( 'administrator', $user->roles ) ) {
			// redirect them to the default place
			return $redirect_to;
		} else {
			return $home_url;
		}
	} else {
		return $redirect_to;
	}
}

/**
 * Add a custom menu
 */
add_filter( 'wp_nav_menu_items', 'add_custom_menus', 20, 5);
function add_custom_menus($items, $args)
{
    
    $menu_location = $args->theme_location;
    $items = null;
    $show_edit_button = null;
    $show_admin_link = null;

    
    if( is_user_logged_in() && $menu_location == 'homepage-menu' ) {
        
        if( is_super_admin( get_current_user_id() ) )
            $show_admin_link = '<a class="item" href="'.home_url( 'wp-admin' ).'">Admin Page</a>';

        $current_user = wp_get_current_user();

        if ( PR_Membership::is_member_page() )
        	$show_edit_button = '<div class="item"> <button id="btn-edit-page" class="ui red button">Edit Page</button> </div>';

        	$items .= '<div class="left menu">
    					    <div class="item">
    					      <div class="ui search">
                                  <div class="ui icon input">
                                    <form role="search" method="post" class="search-form" action="'.home_url().'">
                                      <label>
                                          <input type="search" class="search-field" placeholder="'.esc_attr_x( 'Search an event, member, groups or interests …', 'placeholder' ).'" value="'.get_search_query().'" name="s" title="'.esc_attr_x( 'Search an event, member, groups or interests', 'label' ).'" required>
                                      </label>
                                    </form>
                                    <i class="search icon"></i>
                                  </div>
                                </div>
    					    </div>
    					    <a href="'.home_url( 'connect' ).'" class="item">Connect</a>
    				    </div>
    				    <div class="right menu">
    				    	<a href="'.home_url( 'home' ).'" class="item">Home</a>
    				    	<a href="'.home_url( 'events' ).'" class="item">Events</a>
                            <a href="'.home_url( 'blog' ).'" class="item">Blog</a>
    				    	<div class="ui dropdown item">						
    	                        <a href="'.home_url( $current_user->user_login ).'" class="item">
    	                           '.ucfirst($current_user->user_nicename).'                                       
    								<i class="dropdown icon"></i>
    	                        </a>
    	                        <div class="menu">
                                  '.$show_admin_link.'
    	                           <a class="item" href="'.home_url( 'member/'.$current_user->user_login ).'">View Page</a>
    	                           <a class="item" href="'.home_url( 'settings/profile' ).'">Edit Profile</a>
    	                           <a class="item" href="'.home_url( 'settings/account' ).'">Account</a>
    	                           <a class="item" href="'.home_url( 'settings/privacy' ).'">Privacy</a>
    	                           <!-- <a class="item" href="'.home_url( 'settings/notifications' ).'">Notications</a> -->
    	                           <a class="item" href="' . wp_logout_url('/index.php') . '" title="Logout">' . __( 'Logout' ) . '</a>
    	                        </div> <!-- /Sub menu -->
                        	</div>
                        	'.$show_edit_button.'
    				  </div>';
    	
    } elseif ( $menu_location == 'frontpage-menu') {

    	$show_login = "";
    	$show_connect = "";
        $register = is_page( 'register' );
        $login = is_page( 'login' );

    	if ( !is_front_page() && ! $register && ! $login ) {

    	 $items .= '<div class="left menu">
					    <div class="item">
					      <div class="ui icon input">
                            <form role="search" method="post" class="search-form" action="'.home_url().'">
                              <label>
                                  <input type="search" class="search-field" placeholder="'.esc_attr_x( 'Search an event, member, groups or interests …', 'placeholder' ).'" value="'.get_search_query().'" name="s" title="'.esc_attr_x( 'Search an event, member, groups or interests ', 'label' ).'" required>
                              </label>
                            </form>
                            <i class="search icon"></i>
                          </div>
					    </div>
					    <a href="'.home_url( 'register' ).'" class="item">Register</a>
				    </div>';
   		 }

    	if ( ! is_front_page() && ! $register && ! $login ) :
            $show_login = '<a href="'.home_url( 'login' ).'" class="login item">Login</a>';
    	    $menu_location = 'right';
        else:
            $menu_location = 'left';
        endif;

    	$items .= '<div id="lrmenu" class="'.$menu_location.' menu">
						<a href="'.home_url( 'connect' ).'" class="item">Connect</a>
                        <a href="'.home_url( 'events' ).'" class="item">Events</a>
                        <a href="'.home_url( 'blog' ).'" class="item">Blog</a>
                        <!-- <a href="'.home_url( 'about' ).'" class="item">About</a> -->
                        '.$show_login.'
                  </div>';

        
    }
    
    return $items;
    
}

add_filter( 'wp_nav_menu_args', 'my_wp_nav_menu_args' );
function my_wp_nav_menu_args( $args = '' ) {
	$args['container'] = false;
	return $args;
}

//Send email in html format
add_filter('wp_mail_content_type','set_content_type');
function set_content_type($content_type){
	return 'text/html';
}


//Hide admin bar to members
add_action('set_current_user', 'hide_admin_bar_to_members');
add_filter('show_admin_bar', '__return_false');
function hide_admin_bar_to_members() {
  if (!current_user_can('edit_posts')) {
    show_admin_bar(false);
  }
}

function redirect_to_home() {
	echo '<script>window.location.href="'.home_url().'"</script>';
}

function generate_key( $var ) {
	$key = sha1(mt_rand(10000,99999).time().$var);
	return $key;
}

function var_dump_pre( $post ) {
	echo '<pre>';
	var_dump($post);
	echo '</pre>';
}

add_action('init','author_base_rewrite');
function author_base_rewrite() {
	global $wp_rewrite;
	$wp_rewrite->author_base = 'member';
	//$wp_rewrite->author_base = '';
	$wp_rewrite->flush_rules();
}

add_action( 'init', 'custom_post_type_groups' );
function custom_post_type_groups() {
    
    $group_label = array(
        'name' => 'Groups',
        'singular_name' => 'Group',
        'add_new' => 'Add Group',
        'add_new_item' => 'Add New Group',
        'edit_item' => 'Edit Group',
        'new_item' => 'New Group',
        'all_items' => 'All Groups',
        'view_item' => 'View Group',
        'search_items' => 'Search Groups',
        'not_found' => 'No Group found',
        'not_found_in_trash' => 'No Group found in Trash',
        'parent_item_colon' => '',
        'menu_name' => 'Groups',
    );

    $group_args = array (
        'labels' => $group_label,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'query_var' => true,
        'rewrite' => array( 'slug' => 'groups'),
        'capability_type' => 'page',
        'has_archive' => true,
        'hierarchical' => true,
        'menu_position' => null,
        //'menu_icon' => get_template_directory_uri() . '/images/icons/people.png',
        'supports' => array('title', 'editor', 'author', 'thumbnail', 'excerpt','page-attributes', 'comments'),
    );

    register_post_type('groups', $group_args);
}

add_action( 'init', 'custom_post_type_event' );
function custom_post_type_event() {
    
    $event_label = array(
        'name' => 'Events',
        'singular_name' => 'Event',
        'add_new' => 'Add Event',
        'add_new_item' => 'Add New Event',
        'edit_item' => 'Edit Event',
        'new_item' => 'New Event',
        'all_items' => 'All Events',
        'view_item' => 'View Event',
        'search_items' => 'Search Events',
        'not_found' => 'No Event found',
        'not_found_in_trash' => 'No Event found in Trash',
        'parent_item_colon' => '',
        'menu_name' => 'Events',
    );
    $event_args = array (
        'labels' => $event_label,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'query_var' => true,
        'rewrite' => array( 'slug' => 'events'),
        //'capability_type' => 'page',
        'has_archive' => true,
        'hierarchical' => true,
        'menu_position' => null,
        //'menu_icon' => get_template_directory_uri() . '/images/icons/people.png',        
        'supports' => array('title', 'editor', 'author', 'thumbnail', 'excerpt','page-attributes', 'comments', 'tags', 'publicize'),
    );
    register_taxonomy('event_tag','events', array(
        'hierarchical' => false,
        'labels' => __( 'Tags', 'pinoyrunners'),
        'singulare_name' => __( 'Tag', 'pinoyrunners' ),
        'query_var' => true,
        'rewrite' => array( 'slug' => 'event' ),

      ));

    register_post_type('events', $event_args);
}

// get taxonomies terms links
function custom_taxonomies_terms_links( $post_id ){
  // get post by post id
  $post = get_post( $post_id );

  // get post type by post
  $post_type = $post->post_type;

  // get post type taxonomies
  $taxonomies = get_object_taxonomies( $post_type, 'objects' );

  $out = array();
  foreach ( $taxonomies as $taxonomy_slug => $taxonomy ){

    // get the terms related to post
    $terms = get_the_terms( $post_id, $taxonomy_slug );

    if ( !empty( $terms ) ) {
      $out[] = "<h2>" . $taxonomy->label . "</h2>\n<ul>";
      foreach ( $terms as $term ) {
        $out[] =
          '  <li><a href="'
        .    get_term_link( $term->slug, $taxonomy_slug ) .'">'
        .    $term->name
        . "</a></li>\n";
      }
      $out[] = "</ul>\n";
    }
  }

  return implode('', $out );
}


function get_url_user_name() {
	$URI = $_SERVER['REQUEST_URI'];		 
	$member = str_replace('/', '', str_replace('member','', $URI));
	return $member;
}

function is_valid_member_page() {

	$member = get_url_user_name();

	if( username_exists( $member) ) {
		return true;
	} else  {
		return false;
	}
}

function author_background_image( $image ) {
  
    $member = get_url_user_name();
    $profile = get_user_by( 'login', $member );
    $user_id = $profile->ID;
    $image_file = get_user_meta( $user_id, 'pr_member_background_image', true );
    $image = PROFILE_URL . $image_file;

    return $image;
}

function author_description( $description ) {

    $member = get_url_user_name();
    $profile = get_user_by( 'login', $member );
    $user_id = $profile->ID;
    $description = get_the_author_meta( 'description', $user_id);

    return $description;

}

function seo_modify() {
    if( is_author()) { 
        add_filter( 'wpseo_opengraph_image', 'author_background_image');
        add_filter( 'wpseo_opengraph_desc', 'author_description');
        add_filter( 'wpseo_metadesc', 'author_description');
    }
}

add_action( 'wpseo_head', 'seo_modify',1,3);

add_action( 'wp_ajax_join_group', 'join_group' );
add_action( 'wp_ajax_nopriv_join_group', 'join_group' );
add_action( 'wp_ajax_subscribe_to_newsletter', 'subscribe_to_newsletter' );
add_action( 'wp_ajax_nopriv_subscribe_to_newsletter', 'subscribe_to_newsletter' );
add_action( 'wp_enqueue_scripts', 'enqueue_join_ajax_script' );

function enqueue_join_ajax_script() {   

  wp_enqueue_script( 'ajax-join-js', plugins_url(PR_Membership::PLUGIN_FOLDER  . '/js/ajax-join.js'), array('jquery'), '1.0.0', true );
  wp_localize_script( 'ajax-join-js', 'AjaxJoin', array(
    // URL to wp-admin/admin-ajax.php to process the request
    'ajaxurl' => admin_url( 'admin-ajax.php' ),
    // generate a nonce with a unique ID "myajax-post-comment-nonce"
    // so that you can check it later when an AJAX request is sent
    'security' => wp_create_nonce( 'pr-join-a-group-event' ),
    'subscribe' => wp_create_nonce( 'pr-subscribe-to-newsletter' )
  ));
  
}

function join_group() {

	if ( isset( $_POST['group_id'] ) && intval( $_POST['group_id'] ) ) {

		require_once( WP_PLUGIN_DIR . '/pr-membership/models/group-model.php' );
        $model = new Group_Model;

        check_ajax_referer( 'pr-join-a-group-event', 'security' );

        $group_id = $_POST['group_id'];
        $user_id = get_current_user_id();

        $group_privacy = get_post_meta( $group_id, '_is_private', true );
        $total_member = get_post_meta( $group_id, '_group_total', true );

        if ( $group_privacy == 1 ) {

            $approval = 0;
            $total_member = $total_member;

        } else {

            $approval = 1; 
            $total_member = $total_member + 1; 
        } 

        // $group_id, $user_id, $is_admin
        $result = $model->add_group_member( $group_id, $user_id, $approval );

        if ( $result ) {

        	
            if( $group_privacy == 0)
        	   update_post_meta( $group_id, '_group_total', $total_member + 1, $total_member );

        	$result_code = 0;
        	$result_msg = "success";

        } else {

        	$result_code = 1;
        	$result_msg = "failed";
        }

        wp_send_json( array( 
            'result_code'=>$result_code, 
            'result_msg'=>$result_msg,
            'group_id' => $group_id,
            'group_privacy' => $group_privacy,
            'member_total'=> $total_member,
        ) );

        wp_die(); 

   }

}

function subscribe_to_newsletter() {

    if ( isset( $_POST['name'] ) && isset( $_POST['email'] ) && is_email( $_POST['email'] ) ) {

        require_once( WP_PLUGIN_DIR . '/pr-membership/models/subscriber-model.php' );
        $model = new Subscriber_Model;

        $model->name = sanitize_text_field( $_POST['name'] );
        $model->email = sanitize_email( $_POST['email'] );
        $result = $model->insert();

        if( $result ) {
            $result_code = 0;
            $result_msg ="Thank you for subscribing to us! See you on the road!";
        } else {
            $result_code = 0;
            $result_msg ="Something went wrong, please try again later!";
        }        

        wp_send_json( array( 
                'result_code'=>$result_code, 
                'result_msg'=>$result_msg,
            ) );

        wp_die();

    }
}

function get_groups() {

	require_once( WP_PLUGIN_DIR . '/pr-membership/models/group-model.php' );
    $model = new Group_Model;
    $ids = array();

    $user_id = get_current_user_id();

    $groups = $model->get_member_groups( $user_id );

    foreach( $groups as $group ) {
    	$ids[] = $group->group_id;
    }

    return $ids;
}

function get_members( $group_id ) {

	require_once( WP_PLUGIN_DIR . '/pr-membership/models/group-model.php' );
    $model = new Group_Model;
    $members = array();

	$group_members = $model->get_members( $group_id );

	foreach( $group_members as $member ) {

		$members[] = $member->user_id;
	}

	$member_lists = get_users( array( 'include' => $members ) );

	return $member_lists;
}

add_action( 'wp_ajax_join_event', 'join_event' );
add_action( 'wp_ajax_nopriv_join_event', 'join_event' );

function join_event() {
    
    if ( isset( $_POST['event_id'] ) && intval( $_POST['event_id'] ) ) {

        require_once( WP_PLUGIN_DIR . '/pr-membership/models/event-model.php' );
        $model = new Event_Model;

        check_ajax_referer( 'pr-join-a-group-event', 'security' );

        $event_id = $_POST['event_id'];
        $user_id = get_current_user_id();

        $result = $model->join_member( $event_id, $user_id);

        if ( $result ) {

            $total_joins = get_post_meta( $event_id, 'member_joined', true );
            update_post_meta( $event_id, 'member_joined', $total_joins + 1, $total_joins );

            $result_code = 0;
            $result_msg = "success";

        } else {

            $result_code = 1;
            $result_msg = "failed";
        }

        wp_send_json( array( 
            'result_code'=>$result_code, 
            'result_msg'=>$result_msg,
            'event_id' => $event_id,
            'member_joined'=> $total_joins + 1,
        ) );

        wp_die(); 

   }

}

function is_member_joined( $event_id ) {

    require_once( WP_PLUGIN_DIR . '/pr-membership/models/event-model.php' );
    $model = new Event_Model;

    $user_id = get_current_user_id();
    $result = $model->check_event_joins( $event_id, $user_id );

    if( $result )
        return true;
    else
        return false;

}

function is_request_pending( $group_id ) {

    require_once( WP_PLUGIN_DIR . '/pr-membership/models/group-model.php' );
    $model = new Group_Model;

    $user_id = get_current_user_id();
    $result = $model->check_group_joins( $group_id, $user_id );

    if( $result )
        return true;
    else
        return false;

}

function is_not_joined_in_group( $group_id ) {

    require_once( WP_PLUGIN_DIR . '/pr-membership/models/group-model.php' );
    $model = new Group_Model;

    $user_id = get_current_user_id();
    $result = $model->check_group_joins( $group_id, $user_id );

    if( $result )
        return true;
    else
        return false;

}

function is_public( $key, $user_id ) {

    if( metadata_exists( 'user', $user_id, $key ) ) {
        $meta = get_user_meta( $user_id, $key, true );

        if( $meta == 1 )
            return true;
    }

    return false;

}

//Include custom post types in feedburner RSS
function myfeed_request($qv) {
    if (isset($qv['feed']))
        $qv['post_type'] = array( 'post', 'events' );  get_post_types(); //
    return $qv;
}
add_filter('request', 'myfeed_request');
