<?php
/*
* Plugin Name:     TTC Website 
* Plugin URI:      https://purplematter.com
* Description:     TTC plugin for TTC website
* Author:          TTC
* Author URI:      https://thetezos.com
* License URI:     https://www.gnu.org/licenses/gpl-2.0.html

* Text Domain:     thetezos
* Version:         0.1
*/

function varlog($x) {
    ob_start();
    var_dump($x);
    $contents = ob_get_contents();
    ob_end_clean();
    error_log($contents);
}

// OPEC: custom css for admin area
add_action( 'admin_enqueue_scripts', 'ttc_admin_style');

function ttc_admin_style() {
    if( isset( $_GET['post_type'] ) && 'mec-events' == $_GET['post_type'] ) {
        wp_enqueue_style( 'admin-style', plugins_url( 'css/admin-style.css' , __FILE__), array(), '0.1.2' );
    }
}

// OPEC: custom scripts
add_action( 'wp_enqueue_scripts', 'ttc_scripts' );

function ttc_scripts() {
    wp_enqueue_script( 'ttc-scripts', plugins_url( 'js/fe-scripts.js' , __FILE__) , array( 'jquery' ), '0.2.35', true );
}

// OPEC / hide author name + url from embed data 
add_filter( 'oembed_response_data', 'disable_embeds_filter_oembed_response_data_' );

function disable_embeds_filter_oembed_response_data_( $data ) {
    unset($data['author_url']);
    unset($data['author_name']);
    return $data;
}


// OPEC: only admins get emails about new users / changed users
function wpcode_send_new_user_notifications( $user_id, $notify = 'user' ) {
    if ( empty( $notify ) || 'user' === $notify ) {
        return;
    } elseif ( 'both' === $notify ) {
        // Send new users the email but not the admin.
        $notify = 'admin';
    }
    wp_send_new_user_notifications( $user_id, $notify );
}

add_action(
    'init',
    function () {
        // Disable default email notifications.
        remove_action( 'register_new_user', 'wp_send_new_user_notifications' );
        remove_action( 'edit_user_created_user', 'wp_send_new_user_notifications' );
 
        // Replace with custom function that only sends to user.
        add_action( 'register_new_user', 'wpcode_send_new_user_notifications' );
        add_action( 'edit_user_created_user', 'wpcode_send_new_user_notifications', 10, 2 );
    }
);


// OPEC: redirect non admins to frontend
function tcc_login_redirect( $redirect_to, $request, $user ) {
    //is there a user to check?
    if ( isset( $user->roles ) && is_array( $user->roles ) ) {
        //check for admins
        if ( in_array( 'administrator', $user->roles ) ) {
            // redirect Admins to WP Admin
            return home_url('wp-admin');
        } else {
            // redirect everyone else to the home page
            return home_url();
        }
    } else {
        return home_url();
    }
}
add_filter( 'login_redirect', 'tcc_login_redirect', 10, 3 );

// OPEC: remove admin bar for all non admin users	
add_action('after_setup_theme', 'remove_admin_bar');

function remove_admin_bar() {
    if (!current_user_can('administrator') && !is_admin()) {
        show_admin_bar(false);
    }
}

// OPEC: set auxiliary body class for user logged in status, css added to Wordpress Customizer
// Add CSS class for logged in and logged out users
add_filter('body_class','er_logged_in_filter');

function er_logged_in_filter($classes) {
    if( is_user_logged_in() ) {
        $classes[] = 'logged-in-condition';
    } else {
        $classes[] = 'logged-out-condition';
    }
    return $classes;
}

// MAY STUFF
/*
* Creating a function to create our CPT
*/
   
function projects_post_type() {

    // Set UI labels for Custom Post Type
    $labels = array(
        'name'                => _x( 'Projects', 'Post Type General Name'),
        'singular_name'       => _x( 'Project', 'Post Type Singular Name'),
        'menu_name'           => __( 'Projects', ),
        'parent_item_colon'   => __( 'Parent Project',  ),
        'all_items'           => __( 'All Projects',   ),
        'view_item'           => __( 'View Project',   ),
        'add_new_item'        => __( 'Add New Project',   ),
        'add_new'             => __( 'Add New',   ),
        'edit_item'           => __( 'Edit Project',   ),
        'update_item'         => __( 'Update Project',   ),
        'search_items'        => __( 'Search Project',   ),
        'not_found'           => __( 'Not Found',   ),
        'not_found_in_trash'  => __( 'Not found in Trash',   ),
    );
       
    $args = array(
        'label'               => __( 'projects',   ),
        'description'         => __( 'Projects on Tezos',   ),
        'labels'              => $labels,
        'supports'            => array( 'title', 'editor',  'author', 'thumbnail', 'custom-fields', ),
        'menu_icon'           => 'dashicons-editor-paste-text', 
        'menu_position'       => 5,
        'hierarchical'        => true,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 5,
        'can_export'          => true,
        'has_archive'         => true,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'capability_type'     => 'post',
        'show_in_rest' => true,
 
    );
     
    // Registering your Custom Post Type
    register_post_type( 'projects', $args );
}
 
add_action( 'init', 'projects_post_type', 0 );



function fetch_acf_fields() {
    $output = '<div class="project-socials">';
 
    // Fetch fields
    $discord = get_field('project_discord');
    $telegram = get_field('project_telegram');
    $twitter = get_field('project_twitter_X');
    $github = get_field('project_github');
    $medium = get_field('project_medium');
    
    if($twitter) {
        $output .= '<a href="' . $twitter . '" target="_blank">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" id="Layer_1" x="0px" y="0px" viewBox="0 0 1200 1227" style="enable-background:new 0 0 1200 1227;" xml:space="preserve"><style type="text/css">	.st0{fill:#FFFFFF;}</style><path class="st0" d="M663.4,561.1l247.9-288.2h-58.7L637.3,523.1L465.3,272.9H267l260,378.4L267,953.5h58.7l227.3-264.2l181.6,264.2 H933L663.4,561.1L663.4,561.1z M582.9,654.6l-26.3-37.7L347,317.1h90.2l169.1,241.9l26.3,37.7l219.9,314.5h-90.2L582.9,654.6 L582.9,654.6z"></path></svg> 
                    </a>';
    } 

    if($discord) {
        $output .= '<a href="' . $discord . '" target="_blank">
                        <?xml version="1.0" encoding="UTF-8"?><svg id="Layer_1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><style>.cls-1{stroke-width:0px;}</style></defs><path class="cls-1" d="m67.57,75.8c.16-.22.44-.26.68-.35,1.61-.63,3.17-1.35,4.69-2.15.57-.3,1.14-.62,1.7-.93.1-.06.18-.14.31-.26-.22-.18-.39-.33-.57-.48-.26-.21-.53-.41-.79-.63-.23-.19-.46-.2-.73-.08-.57.26-1.14.5-1.71.74-3.7,1.55-7.53,2.66-11.48,3.35-1.25.22-2.51.35-3.77.5-2.16.26-4.34.33-6.52.26-1.17-.04-2.34-.12-3.5-.24-1.26-.12-2.52-.26-3.77-.47-3.41-.56-6.74-1.42-9.97-2.64-1.21-.46-2.4-.95-3.59-1.46-.38-.16-.67-.16-.98.11-.38.33-.78.63-1.16.93,0,.27.22.33.37.42,1.41.81,2.85,1.56,4.35,2.21.66.29,1.32.55,1.99.83.2.08.39.17.54.25.12.26,0,.42-.08.59-.43.8-.87,1.6-1.32,2.38-.86,1.49-1.8,2.94-2.81,4.33-.07.1-.14.19-.21.29-.16.22-.36.3-.63.23-.19-.05-.37-.1-.55-.16-2.66-.87-5.28-1.85-7.84-2.99-4.36-1.95-8.5-4.29-12.42-7.01-.37-.26-.74-.53-1.11-.79-.27-.19-.44-.43-.48-.76-.01-.1-.04-.19-.04-.28-.06-.81-.13-1.62-.17-2.43-.1-2.13-.21-4.25-.13-6.38.05-1.39.14-2.77.24-4.15.08-1.05.17-2.1.31-3.14.19-1.42.39-2.84.63-4.26.55-3.19,1.37-6.31,2.36-9.39.73-2.25,1.56-4.47,2.53-6.63.62-1.37,1.24-2.75,1.92-4.09,1.35-2.67,2.83-5.27,4.47-7.77.3-.46.61-.91.91-1.38.22-.36.53-.6.92-.76,1.33-.55,2.64-1.14,3.98-1.65,2.84-1.09,5.73-2.01,8.7-2.71,1.54-.36,3.09-.65,4.63-.98.12-.03.24-.04.35-.05.18-.01.33.05.43.21.1.16.2.33.28.5.56,1.14,1.12,2.27,1.69,3.41.04.09.08.17.12.26.1.22.27.33.52.31.14-.01.28-.04.43-.06,1.09-.12,2.18-.25,3.28-.35,1.05-.1,2.09-.17,3.14-.24.38-.03.77-.03,1.15-.03,1.15,0,2.3-.03,3.45,0,1.39.05,2.77.13,4.15.24,1.33.11,2.66.28,3.99.42.41.04.5-.03.74-.52.55-1.14,1.1-2.28,1.66-3.42.08-.17.18-.34.28-.5.11-.18.28-.26.49-.23.28.04.57.08.85.14,2.61.49,5.19,1.12,7.74,1.87,3.05.91,6.02,2.04,8.95,3.31.46.2.8.48,1.08.89,2.43,3.59,4.57,7.35,6.41,11.28,1.02,2.19,1.93,4.43,2.74,6.71.73,2.05,1.36,4.14,1.9,6.25.65,2.53,1.16,5.08,1.49,7.67.2,1.56.36,3.14.53,4.7,0,.07.01.14.01.22.12,2.05.17,4.11.17,6.17,0,1.56-.13,3.1-.18,4.66-.02.62-.1,1.24-.15,1.86-.04.5-.23.89-.67,1.19-1.96,1.37-3.94,2.71-6.02,3.9-1.51.87-3.04,1.72-4.6,2.5-2.46,1.23-4.99,2.32-7.59,3.24-.97.34-1.94.68-2.92,1.01-.13.05-.27.09-.41.13-.59.16-.66.14-1.02-.36-1.02-1.39-1.95-2.84-2.82-4.33-.46-.79-.89-1.58-1.33-2.38-.1-.18-.24-.36-.18-.61h0Zm-2.18-31.62c-.96-.06-2.02.19-3.03.68-2.45,1.19-3.85,3.22-4.53,5.79-.34,1.28-.4,2.59-.17,3.91.5,2.87,1.88,5.15,4.5,6.54,2.12,1.12,4.3,1.16,6.49.15,1.7-.78,2.92-2.05,3.78-3.68.92-1.76,1.25-3.64,1.04-5.62-.23-2.2-1.09-4.09-2.69-5.63-1.46-1.4-3.17-2.18-5.39-2.13h0Zm-29.5-.02c-.48.03-.96.02-1.43.11-1.57.29-2.94,1.03-4.05,2.17-1.17,1.21-1.94,2.66-2.32,4.31-.29,1.27-.37,2.55-.14,3.84.51,2.87,1.92,5.13,4.53,6.53,1.16.62,2.43.92,3.74.82,2.47-.18,4.41-1.37,5.84-3.35,1.42-1.96,1.92-4.18,1.7-6.59-.21-2.23-1.08-4.14-2.7-5.7-1.44-1.39-3.14-2.16-5.17-2.15h0Z"/></svg>
                    </a>';
        } 
    if($telegram){  
        $output .= '<a href="' . $telegram . '" target="_blank">
    <?xml version="1.0" encoding="UTF-8"?><svg id="Layer_1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><style>.cls-1{stroke-width:0px;}</style></defs><path class="cls-1" d="m80.81,18.86c1.54-.6,3.12.75,2.79,2.37l-13.01,62.57c-.31,1.48-2.04,2.15-3.26,1.26l-17.76-12.89c-1.08-.78-2.55-.74-3.58.1l-9.85,8.03c-1.14.93-2.86.41-3.3-.99l-6.84-21.99-17.66-6.59c-1.8-.67-1.81-3.2-.02-3.89l72.49-27.96Zm-13.82,14.63c.53-.49-.11-1.33-.73-.95l-34.52,21.26c-1.32.82-1.95,2.41-1.52,3.91l3.73,13.11c.27.93,1.61.83,1.74-.13l.97-7.19c.18-1.35.83-2.6,1.83-3.53l28.49-26.48Z"/></svg>
            </a>';    
    }
    
    if($medium) {
        $output .= '<a href="' . $medium . '" target="_blank">
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" id="Layer_1" x="0px" y="0px" viewBox="0 0 1200 1227" style="enable-background:new 0 0 1200 1227;" xml:space="preserve"><g id="Layer_2" data-name="Layer 2"><g id="Layer_1-2" data-name="Layer 1"><path d="M588.67,296.36c0,163.67-131.78,296.35-294.33,296.35S0,460,0,296.36,131.78,0,294.34,0,588.67,132.69,588.67,296.36"/><path d="M911.56,296.36c0,154.06-65.89,279-147.17,279s-147.17-124.94-147.17-279,65.88-279,147.16-279,147.17,124.9,147.17,279"/><path d="M1043.63,296.36c0,138-23.17,249.94-51.76,249.94s-51.75-111.91-51.75-249.94S963.29,46.42,991.87,46.42s51.76,111.9,51.76,249.94"/></g></g></svg>
                </a>';
    } 
    if( $github){  
        $output .= '<a href="' . $github . '" target="_blank">
                    <?xml version="1.0" encoding="UTF-8"?><svg id="Layer_1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><style>.cls-1{fill-rule:evenodd;stroke-width:0px;}</style></defs><path class="cls-1" d="m51.07,13.77c-20.41,0-36.91,16.62-36.91,37.19,0,16.44,10.57,30.35,25.24,35.28,1.83.37,2.51-.8,2.51-1.78,0-.86-.06-3.82-.06-6.9-10.27,2.22-12.41-4.43-12.41-4.43-1.65-4.31-4.1-5.42-4.1-5.42-3.36-2.28.24-2.28.24-2.28,3.73.25,5.68,3.82,5.68,3.82,3.3,5.66,8.62,4.06,10.76,3.08.31-2.4,1.28-4.06,2.32-4.99-8.19-.86-16.81-4.06-16.81-18.35,0-4.06,1.47-7.39,3.79-9.97-.37-.92-1.65-4.74.37-9.85,0,0,3.12-.99,10.14,3.82,3.01-.81,6.11-1.23,9.23-1.23,3.12,0,6.29.43,9.23,1.23,7.03-4.8,10.14-3.82,10.14-3.82,2.02,5.11.73,8.93.37,9.85,2.38,2.59,3.79,5.91,3.79,9.97,0,14.28-8.62,17.42-16.87,18.35,1.34,1.17,2.51,3.39,2.51,6.9,0,4.99-.06,8.99-.06,10.22,0,.99.67,2.16,2.51,1.79,14.67-4.93,25.24-18.84,25.24-35.28.06-20.56-16.5-37.19-36.85-37.19Z"/></svg>
                </a>';
    } 

    $output .= '</div>';
    return $output;
}       
 
add_shortcode('project-socials-icon-list', 'fetch_acf_fields');

