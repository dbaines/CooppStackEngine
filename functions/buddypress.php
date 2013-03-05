<?php

/* ====================================================

	CO-OPP BUDDYPRESS PLUGINS

==================================================== */

/* ====================================================

	STACKS COMPONENT
	based on bp-messages-loader.php

==================================================== */

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

class BP_Stacks_Component extends BP_Component {

	/**
	 * Start the messages component creation process
	 *
	 * @since BuddyPress (1.5)
	 */
	function __construct() {
		parent::start(
			'stacks',
			__( 'Stacks', 'buddypress' ),
			BP_PLUGIN_DIR
		);
	}

	/**
	 * Setup globals
	 *
	 */
	function setup_globals() {
		global $bp;

		// Define a slug, if necessary
		if ( !defined( 'BP_STACKS_SLUG' ) )
			define( 'BP_STACKS_SLUG', $this->id );

		// All globals for messaging component.
		// Note that global_tables is included in this array.
		$globals = array(
			'slug'                  => BP_STACKS_SLUG,
			'has_directory'         => false,
			'notification_callback' => false,
			'search_string'         => __( 'Search Stacks...', 'buddypress' ),
			'global_tables'         => $global_tables
		);

		$this->autocomplete_all = defined( 'BP_MESSAGES_AUTOCOMPLETE_ALL' );

		parent::setup_globals( $globals );
	}

	/**
	 * Setup BuddyBar navigation
	 *
	 * @global BuddyPress $bp The one true BuddyPress instance
	 */
	function setup_nav() {

		$sub_nav = array();
		$name    = sprintf( __( 'Stacks', 'buddypress' ) );

		// Add 'Messages' to the main navigation
		$main_nav = array(
			'name'                    => $name,
			'slug'                    => $this->slug,
			'position'                => 50,
			'show_for_displayed_user' => true,
			'screen_function'         => 'coopp_bp_screen_stacks_attending',
			'default_subnav_slug'     => 'attending',
			'item_css_id'             => $this->id
		);

		// Link to user messages
		// $stacks_link = trailingslashit( bp_loggedin_user_domain() . $this->slug );

		// Determine user to use
		// (from bp-forums-loader.php)
		if ( bp_displayed_user_domain() ) {
			$user_domain = bp_displayed_user_domain();
		} elseif ( bp_loggedin_user_domain() ) {
			$user_domain = bp_loggedin_user_domain();
		} else {
			return;
		}

		$stacks_link = trailingslashit( $user_domain . $this->slug );

		// Add the subnav items to the profile
		$sub_nav[] = array(
			'name'            => __( 'Attending', 'buddypress' ),
			'slug'            => 'attending',
			'parent_url'      => $stacks_link,
			'parent_slug'     => 'stacks',
			'screen_function' => 'coopp_bp_screen_stacks_attending',
			'position'        => 10
		);

		$sub_nav[] = array(
			'name'            => __( 'Requested', 'buddypress' ),
			'slug'            => 'requested',
			'parent_url'      => $stacks_link,
			'parent_slug'     => $this->slug,
			'screen_function' => 'coopp_bp_screen_stacks_requested',
			'position'        => 20
		);

		$sub_nav[] = array(
			'name'            => __( 'Calendar View', 'buddypress' ),
			'slug'            => 'calendar',
			'parent_url'      => $stacks_link,
			'parent_slug'     => $this->slug,
			'screen_function' => 'coopp_bp_screen_calendar',
			'position'        => 20,
			'user_has_access' => bp_is_my_profile()
		);

		parent::setup_nav( $main_nav, $sub_nav );
	}

	/**
	 * Sets up the title for pages and <title>
	 *
	 * @global BuddyPress $bp The one true BuddyPress instance
	 */
	function setup_title() {
		global $bp;

		if ( bp_is_messages_component() ) {
			if ( bp_is_my_profile() ) {
				$bp->bp_options_title = __( 'My Messages', 'buddypress' );
			} else {
				$bp->bp_options_avatar = bp_core_fetch_avatar( array(
					'item_id' => bp_displayed_user_id(),
					'type'    => 'thumb',
					'alt'     => sprintf( __( 'Profile picture of %s', 'buddypress' ), bp_get_displayed_user_fullname() )
				) );
				$bp->bp_options_title = bp_get_displayed_user_fullname();
			}
		}

		parent::setup_title();
	}
}

function bp_setup_stacks() {
	global $bp;
	$bp->stacks = new BP_Stacks_Component();
}
add_action( 'bp_setup_components', 'bp_setup_stacks', 6 );

/* ====================================================

	PROFILE SCREENS

==================================================== */

// List all stacks user is going to
function coopp_bp_screen_stacks_attending(){
	global $bp;
	bp_core_load_template( 'members/single/stacks' );
}

// List all stacks user has requested
function coopp_bp_screen_stacks_requested(){
	global $bp;
	bp_core_load_template( 'members/single/stacks/requested' );
}

// Show Calendar Options
function coopp_bp_screen_calendar(){
	global $bp;
	bp_core_load_template( 'members/single/stacks/calendar' );
}


?>