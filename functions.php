<?php

add_theme_support( 'menus' );
add_theme_support( 'custom-header' );
add_theme_support( 'post-thumbnails' );
add_theme_support( 'html5', array( 'search-form' ) );
add_action( 'init', 'register_theme_menus' );
add_filter('jetpack_enable_open_graph', '__return_false', 99);

if( ! is_home() ) :
    add_theme_support( 'infinite-scroll', array(
                'container' => 'content',
                'footer' => false,
                'type' => 'scroll', //scroll, click
                'wrapper'   => false,
                'posts_per_page' => 7,
            ) );
endif;

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
    
    if( is_user_logged_in() )
         wp_enqueue_style( 'daterangepicker-css', plugins_url( PR_Membership::PLUGIN_FOLDER  . '/css/daterangepicker.min.css' ));
	
}

add_action( 'wp_enqueue_scripts', 'wppr_theme_scripts' );
function wppr_theme_scripts() {
	wp_enqueue_script( 'jquery-min-js', get_stylesheet_directory_uri() . '/js/jquery.min.js', '', '', false );
	wp_enqueue_script( 'sui-min-js', get_stylesheet_directory_uri() . '/js/semantic.min.js', array('jquery'), '', false );
    wp_enqueue_script( 'membership-js', plugins_url( PR_Membership::PLUGIN_FOLDER  . '/js/membership-js.js' ), array('jquery'), '', true );

    if( is_user_logged_in() ):
        wp_enqueue_script( 'moment-min', plugins_url( PR_Membership::PLUGIN_FOLDER  . '/js/moment.js'), array('jquery' ), '', false );
        wp_enqueue_script( 'daterangepicker-min', plugins_url( PR_Membership::PLUGIN_FOLDER  . '/js/daterangepicker.js' ), array('jquery'), '', false );
    endif;    

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

            $first_name =  get_user_meta( get_current_user_id(), 'first_name', true );
            if( isset( $first_name ) && ! empty( $first_name ))
                $member_name = $first_name;
            else
                $member_name = ucfirst($current_user->user_nicename);

            if ( wp_is_mobile() ) :

                $items .= '<div class="ui dropdown item">
                                <a class="view-ui item">
                                    <i class="sidebar icon"></i> Menu
                                 </a>
                                 <div class="menu">
                                    <a href="'.home_url( 'home' ).'" class="item"> Home</a>
                                    <a href="'.home_url( 'connect' ).'" class="item"> Connect</a>
                                    <a href="'.home_url( 'events' ).'" class="item"> Events</a>
                                    <a href="'.home_url( 'blog' ).'" class="item"> Blog</a>
                                    <hr />
                                    <a class="item" href="'.home_url( 'member/'.$current_user->user_login ).'"> View Page</a>
                                    <a class="item" href="'.home_url( 'settings/profile' ).'"> Edit Profile</a>
                                    <a class="item" href="'.home_url( 'settings/account' ).'"> Account</a>
                                    <a class="item" href="'.home_url( 'settings/privacy' ).'"> Privacy</a>                            
                                    <a class="item" href="' . wp_logout_url('/index.php') . '" title="Logout"> ' . __( 'Logout' ) . '</a>
                                </div>
                            </div>';
                // if ( PR_Membership::is_member_page() ) :
                //     $items .= '<div class="item"> <button id="btn-edit-page" class="ui red button">Edit Page</button> </div>';
                // endif;
            else :

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
                                    <div class="item">
                                        <div class="fb-like" data-href="https://pinoyrunners.co" data-layout="button_count" data-action="like" data-show-faces="false" data-share="false"></div>
                                    </div>
            				    	<a href="'.home_url( 'home' ).'" class="item">Home</a>
            				    	<a href="'.home_url( 'events' ).'" class="item">Events</a>
                                    <a href="'.home_url( 'blog' ).'" class="item">Blog</a>
            				    	<div class="ui dropdown item">						
            	                        <a class="item">
            	                           '.$member_name.'                                       
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
            endif;
    	
    } elseif ( $menu_location == 'frontpage-menu') {

    	$show_login = "";
    	$show_connect = "";
        $register = is_page( 'register' );
        $login = is_page( 'login' );

        if ( wp_is_mobile() ) :

            $items .= '<div id="mobile_menu" class="ui dropdown item">
                                <a class="view-ui item">
                                    <i class="sidebar icon"></i> Menu
                                 </a>
                                 <div class="menu">
                                    <a href="'.home_url( 'login' ).'" class="item">Login</a>
                                    <a href="'.home_url( 'register' ).'" class="item">Register</a>
                                    <a href="'.home_url( 'connect' ).'" class="item">Connect</a>
                                    <a href="'.home_url( 'events' ).'" class="item">Events</a>
                                    <a href="'.home_url( 'blog' ).'" class="item">Blog</a>  
                                </div>
                            </div>';
        else :

        	if ( ! is_front_page() && ! $register && ! $login ) {

                $show_login = '<a href="'.home_url( 'login' ).'" class="login item">Login</a>';
                $fb_like = '<div class="item">
                                    <div class="fb-like" data-href="https://pinoyrunners.co" data-layout="button_count" data-action="like" data-show-faces="false" data-share="false"></div>
                                </div>';
                $menu_location = 'right';

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
                
       		} else {
                $menu_location = 'left';
                $fb_like = '';
            }

        	$items .= '<div id="lrmenu" class="'.$menu_location.' menu">
                            '.$fb_like.'
    						<a href="'.home_url( 'connect' ).'" class="item">Connect</a>
                            <a href="'.home_url( 'events' ).'" class="item">Events</a>
                            <a href="'.home_url( 'blog' ).'" class="item">Blog</a>
                            <!-- <a href="'.home_url( 'about' ).'" class="item">About</a> -->
                            '.$show_login.'
                      </div>';
        endif;
        
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
        'menu_position' => 4,
        'menu_icon' => 'dashicons-share',
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
        'menu_position' => 4,
        'menu_icon' => 'dashicons-calendar-alt',        
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

function author_link( $author_link ) {

    $member = get_url_user_name();
    $author_link = home_url( 'member/'.$member);
    return $author_link;

}

function wpseo_disable_rel_next_home( $link ) {
  if ( is_home() ) {
    return false;
  }
}
add_filter( 'wpseo_next_rel_link', 'wpseo_disable_rel_next_home' );

add_action( 'wpseo_head', 'seo_modify');
function seo_modify() {
    if( is_author()) { 
        add_filter( 'wpseo_canonical', '__return_false' );
        add_filter( 'wpseo_author_link', 'author_link');
        add_filter( 'wpseo_opengraph_url', 'author_link');
        add_filter( 'wpseo_opengraph_image', 'author_background_image');        
        add_filter( 'wpseo_twitter_image', 'author_background_image');
        add_filter( 'wpseo_opengraph_desc', 'author_description');
        add_filter( 'wpseo_metadesc', 'author_description');
    }
}

add_action( 'init', 'enqueue_ajax_actions' );
function enqueue_ajax_actions() {
    if( is_user_logged_in() ) :
        add_action( 'wp_ajax_join_group', 'join_group' );
        add_action( 'wp_ajax_nopriv_join_group', 'join_group' );
        add_action( 'wp_enqueue_scripts', 'enqueue_join_ajax_script' );
    endif;
}

function enqueue_join_ajax_script() {   
  wp_enqueue_script( 'ajax-join-js', plugins_url(PR_Membership::PLUGIN_FOLDER  . '/js/ajax-join.js'), array('jquery'), '1.0.0', true );
  wp_localize_script( 'ajax-join-js', 'AjaxJoin', array(
    'ajaxurl' => admin_url( 'admin-ajax.php' ),
    'security' => wp_create_nonce( 'pr-join-a-group-event' ),
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

if ( ! is_home() ) :
    add_action( 'wp_ajax_join_event', 'join_event' );
    add_action( 'wp_ajax_nopriv_join_event', 'join_event' );
endif;

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


function new_user_column( $column ) {
    $column['is_featured'] = 'Featured';
    return $column;
}
add_filter( 'manage_users_columns', 'new_user_column' );

function new_modify_user_table_row( $val, $column_name, $user_id ) {
    $user = get_userdata( $user_id );
    switch ($column_name) {
        case 'is_featured' :
            $val = get_the_author_meta( 'is_featured', $user_id );
            if( $val == 1) 
                $retval = 'Yes';
            else 
                $retval = 'No';
            return $retval;
            break;
        default:
    }
    return $return;
}
add_filter( 'manage_users_custom_column', 'new_modify_user_table_row', 10, 3 );

function add_class_to_image_links($html, $attachment_id, $attachment) {
    $linkptrn = "/<a[^>]*>/";
    $found = preg_match($linkptrn, $html, $a_elem);

    // If no link, do nothing
    if($found <= 0) return $html;

    $a_elem = $a_elem[0];

    // Check to see if the link is to an uploaded image
    $is_attachment_link = strstr($a_elem, "wp-content/uploads/");

    // If link is to external resource, do nothing
    if($is_attachment_link === FALSE) return $html;

    if(strstr($a_elem, "class=\"") !== FALSE){ // If link already has class defined inject it to attribute
        $a_elem_new = str_replace("class=\"", "class=\"ui centered fluid image ", $a_elem);
        $html = str_replace($a_elem, $a_elem_new, $html);
    }else{ // If no class defined, just add class attribute
        $html = str_replace("<a ", "<a class=\"ui centered fluid image\" ", $html);
    }

    return $html;
}
add_filter('image_send_to_editor', 'add_class_to_image_links', 10, 3);

function jetpackme_remove_rp() {
    if ( class_exists( 'Jetpack_RelatedPosts' ) ) {
        $jprp = Jetpack_RelatedPosts::init();
        $callback = array( $jprp, 'filter_add_target_to_dom' );
        remove_filter( 'the_content', $callback, 40 );
    }
}
add_filter( 'wp', 'jetpackme_remove_rp', 20 );

add_filter( 'img_caption_shortcode', 'cleaner_caption', 10, 3 );
function cleaner_caption( $output, $attr, $content ) {

    /* We're not worried abut captions in feeds, so just return the output here. */
    if ( is_feed() )
        return $output;

    /* Set up the default arguments. */
    $defaults = array(
        'id' => '',
        'align' => 'alignnone',
        'width' => '',
        'caption' => ''
    );

    /* Merge the defaults with user input. */
    $attr = shortcode_atts( $defaults, $attr );

    /* If the width is less than 1 or there is no caption, return the content wrapped between the < tags. */
    if ( 1 > $attr['width'] || empty( $attr['caption'] ) )
        return $content;

    /* Set up the attributes for the caption <div>. */
    $attributes = ( !empty( $attr['id'] ) ? ' id="' . esc_attr( $attr['id'] ) . '"' : '' );
    $attributes .= ' class="wp-caption ' . esc_attr( $attr['align'] ) . '"';
/*  $attributes .= ' style="width: ' . esc_attr( $attr['width'] ) . 'px"';   */

    /* Open the caption <div>. */
    $output = '<div' . $attributes .'>';

    /* Allow shortcodes for the content the caption was created for. */
    $output .= do_shortcode( $content );

    /* Append the caption text. */
    $output .= '' . $attr['caption'] . '';

    /* Close the caption </div>. */
    $output .= '</div>';

    /* Return the formatted, clean caption. */
    return $output;
}

add_action('login_init', 'acme_autocomplete_login_init');
function acme_autocomplete_login_init()
{
    ob_start();
}
 
add_action('login_form', 'acme_autocomplete_login_form');
function acme_autocomplete_login_form()
{
    $content = ob_get_contents();
    ob_end_clean();
    $content = str_replace('id="user_pass"', 'id="user_pass" autocomplete="off"', $content);
    echo $content;
}
