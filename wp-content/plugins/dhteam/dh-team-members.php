<?php
/**
 * DHTeam plugin.
 *
 * Display Team members page
 *
 * @package DHTeam
 * @author Dan Harabor
 */

/**
 * Plugin Name: DHTeam
 * Plugin URI: https://github.com/hardanro/wordpress-dhteam/
 * Description: Adding 
 * Author: Dan Harabor
 * Version: 1.0
 * Domain Path: /languages
 * License: GPL-2.0+
 */

//How many team members will be displayed on the team members page
if ( !defined( 'TEAM_MEMBERS_PER_PAGE' ) ) {
	define( 'TEAM_MEMBERS_PER_PAGE', 12);
}

//Width of the members thumbnail displayed
if ( !defined( 'TEAM_MEMBERS_THUMBNAIL_WIDTH' ) ) {
	define( 'TEAM_MEMBERS_THUMBNAIL_WIDTH', 318);
}

//Height of the members thumbnail displayed
if ( !defined( 'TEAM_MEMBERS_THUMBNAIL_HEIGHT' ) ) {
	define( 'TEAM_MEMBERS_THUMBNAIL_HEIGHT', 180);
}

// Our custom post type function
add_action( 'init', 'dh_create_posttype' );

function dh_create_posttype() {
    register_post_type( 'team_members',
        // Custom Post Type Options
        array(
            'labels' => array(
                'name' => __( 'Team Members' ),
                'singular_name' => __( 'Singular film' )
            ),
            'public' => true,
            'has_archive' => true,
            'publicly_queryable'  => true,
            'rewrite' => array('slug' => 'team'),
            'supports' => array('title', 'editor', 'thumbnail')
        )
    );
    //Register custom taxonomy (Department) for team_members
	register_taxonomy("Department", "team_members" , array("hierarchical" => true, "label" => "Department", "singular_label" => "Department", "rewrite" => true));
}

//Register custom meta fields for Position, Twitter URL, and Facebook URL.
add_action("admin_init", "dh_admin_init");

function dh_admin_init(){
	add_meta_box("position-meta", "Position", "dh_position", "team_members", "normal", "low");
	add_meta_box("twitter_url-meta", "Twitter", "dh_twitter_url", "team_members", "normal", "low");
	add_meta_box("facebook_url-meta", "Facebook", "dh_facebook_url", "team_members", "normal", "low");
}

function dh_position(){
	global $post;
	$custom = get_post_custom($post->ID);
	$position = $custom["position"][0];
	?>
	<label>Position:</label>
	<input name="position" size="4" value="<?php echo $position; ?>" />
	<?php
}

function dh_twitter_url(){
	global $post;
	$custom = get_post_custom($post->ID);
	$twitter_url = $custom["twitter_url"][0];
	?>
	<label><?php _e("Twitter url") ?>:</label>
	<input name="twitter_url" value="<?php echo $twitter_url; ?>" />
	<?php
}

function dh_facebook_url(){
	global $post;
	$custom = get_post_custom($post->ID);
	$facebook_url = $custom["facebook_url"][0];
	?>
	<label><?php _e("Facebook url") ?>:</label>
	<input name="facebook_url" value="<?php echo $facebook_url; ?>" />
	<?php
}

//save custom post meta fields details when updating in admin
function dh_save_details(){
	global $post;

	update_post_meta($post->ID, "position", sanitize_text_field($_POST["position"]));
	update_post_meta($post->ID, "twitter_url", sanitize_text_field($_POST["twitter_url"]));
	update_post_meta($post->ID, "facebook_url", sanitize_text_field($_POST["facebook_url"]));
	//update_post_meta($post->ID, "producers", $_POST["producers"]);
}
add_action('save_post', 'dh_save_details');

//Add jquery to wordpress theme if it doesn't exist
function dh_theme_scripts() {
	wp_enqueue_script('jquery');
}
add_action('wp_enqueue_scripts', 'dh_theme_scripts');
