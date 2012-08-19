<?php
/**
 * Co-Opp Engine Functions
 *
 */

/* ====================================================

	GENERAL SETTINGS

==================================================== */

// This theme styles the visual editor with editor-style.css to match the theme style.
add_editor_style();

// Add default posts and comments RSS feed links to <head>.
add_theme_support( 'automatic-feed-links' );

// This theme uses wp_nav_menu() in one location.
register_nav_menu( 'primary', __( 'Primary Menu' ) );

// Add support for a variety of post formats
add_theme_support( 'post-formats', array( 'aside', 'link', 'gallery', 'status', 'quote', 'image' ) );

// Add support for featured images
add_theme_support( 'post-thumbnails' );

// Removes <p> tags around the category descriptions
remove_filter('term_description','wpautop');

// Remove automatic links to feeds
// http://www.456bereastreet.com/archive/201103/controlling_and_customising_rss_feeds_in_wordpress/
remove_action('wp_head', 'feed_links', 2);
remove_action('wp_head', 'feed_links_extra', 3);
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'index_rel_link');
remove_action('wp_head', 'wp_generator');

// Removing wp-admin bar for non-admin users
if ( !current_user_can('manage_options') ) {
	add_filter( 'show_admin_bar', '__return_false' );
}

// Add our default gravatar to the admin settings
// http://wpengineer.com/502/add-avatar-to-wordpress-default/
function coopp_gravatar( $avatar_defaults ) {
	$myavatar = get_bloginfo('template_directory') . '/images/default-gravatar.png';
	$avatar_defaults[$myavatar] = 'Co-Opp';
	return $avatar_defaults;
}
add_filter( 'avatar_defaults', 'coopp_gravatar' );

/* ====================================================

	MEMBER COUNT
	checks if more than one member or if it's a past
	or future stack and returns one of six
	strings:

	Nobody went to this stack.
	Nobody is going to this stack.
	1 member is going to this stack!
	1 member went to this stack!
	2 members are going to this stack!
	2 members went to this stack!

==================================================== */

function coopp_membercount(){
	if( stack_memberstotal() > 1 ) {
		$members = "members";
		$verb = "are";
	} else {
		$members = "member";
		$verb = "is";
	}

	// Check if stack has already happened
	if( is_past_stack() ) {
		$tense = $members." went to this stack!";
		$zerotense = "Nobody went to this stack.";
	} else {
		$tense = $members." ".$verb." going to this stack!";
		$zerotense = "Nobody is going to this stack yet.";
	}

	// Build our sentences
	if ( stack_memberstotal() > 0 ) {
		return "<span class='stack_number'>".stack_memberstotal() . "</span> " . $tense;
	} else {
		return $zerotense;
	}
}

/* ====================================================

	EXTERNAL FUNCTION FILES

==================================================== */

// Default TwentyEleven Functions
//include("functions/twentyeleven.php");

// Comments Template
include("functions/comments.php");

// Shortcodes
include("functions/shortcodes.php");

// Shortcodes Helper module when editing posts
include("functions/shortcodes-helper.php");

// Theme Options
include("functions/theme-options-live.php");

// Calendar Display

// Social Networking

// Error Pages, Login and Registration

// Assorted tweaks and customisations
include("functions/assorted.php");

// Buddypress Ajax
include("functions/bp-ajax.php");