<?php
/*
Plugin Name: Co-Opp Stack Engine
Plugin URI:  http://co-opp.net
Description: A "stack" post type along with member registration for the stack
Version:     1.0
Author:      David Baines
Author URI:  http://dbaines.com
License:     GPL2

/*

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

/* ====================================================

	STACK POST TYPES AND META BOXES

==================================================== */

// The stack post type
include("functions/post-type.php");

// Request Stacks (creating draft posts and rendering forms)
include("functions/request-stack.php");

// Meta boxes to go along with the stack post type
include("functions/metaboxes.php");

// Add to dashboard
include("functions/dashboard.php");

// Make stacks searchable

// Template functions
include("functions/template-functions.php");

// Load admin styles and javascript
add_action( 'admin_init', 'stack_admin_files' );
function stack_admin_files(){
	wp_register_style( 'stackEngineAdminStyles', plugins_url('styles/admin.css', __FILE__) );
	wp_register_script( 'stackEngineAdminScripts', plugins_url('js/stack-plugins.js', __FILE__) );
	wp_enqueue_style( 'stackEngineAdminStyles' );
	wp_enqueue_script( 'stackEngineAdminScripts' );
}

// Stack image sizes
add_image_size( 'fullstack', 960, 665, true );
add_image_size( 'shortstack', 305, 245, true );

/* ====================================================

	STACK ENGINE OPTIONS

==================================================== */

/* ====================================================

	JOINING STACKS AND LISTING STACKING MEMBERS

==================================================== */
include("functions/attendees.php");

/* ====================================================

	BUDDYPRESS PLUGINS

==================================================== */

include( "functions/buddypress.php" );

/* ====================================================

    BBPRESS PLUGINS

==================================================== */

include( "functions/bbpress-newposts.php" );

/* ====================================================

	NOTIFICATIONS AND ALERTS

==================================================== */

/* ====================================================

    REGISTER DEFAULT CO-OPP THEME

==================================================== */
register_theme_directory( WP_PLUGIN_DIR . "/coopp-stackengine/themes" );

/* ====================================================

    EXPORT STACKS AS ICAL FORMAT

==================================================== */
include("functions/ical.php");


?>