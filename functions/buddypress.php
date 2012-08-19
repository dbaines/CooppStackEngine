<?php 

/* ====================================================

	CO-OPP BUDDYPRESS PLUGINS

==================================================== */

/* ====================================================

	ADD STACKS TO PROFILES
	code lovingly stolen from Achievements for 
	BuddyPress by DJPaul
	http://wordpress.org/extend/plugins/achievements/

==================================================== */

// Add "stack" tab to profile page
function stack_add_bpnav(){
	global $bp, $is_member_page;

	// Add to the profile navigation
	$main_nav = array(
		'name'                => __( 'Stacks', '' ),
		'slug'                => "stacks",
		'position'            => 50,
		'screen_function'     => 'coopp_bp_screen_stacks_attending',
		'default_subnav_slug' => "attending",
		'item_css_id'         => "stacks"
	);
	bp_core_new_nav_item( $main_nav );

	// Profile "stacks" page output
	if ( bp_is_current_component( "stacks" ) ) {
		$bp->is_single_item = true;

		// Page Titles
		if ( bp_is_my_profile() && !$bp->is_single_item ) {
			$bp->bp_options_title = __( 'Stacks', '' );

		} elseif ( !bp_is_my_profile() && !$bp->is_single_item ) {
			$bp->bp_options_title = $bp->displayed_user->fullname;

		} elseif ( $bp->is_single_item ) {
			$bp->current_item = $bp->current_action;

			if ( isset( $bp->action_variables[0] ) )
				$bp->current_action = $bp->action_variables[0];
			else
				$bp->current_action = '';

			array_shift( $bp->action_variables );

			$bp->bp_options_title = apply_filters( 'dpa_get_achievement_name', 'Test' );
			$achievement_link     = $url . $bp->achievements->current_achievement->slug . '/';
			$parent_slug          = 'test';

		}

	}


}
add_action( 'bp_setup_nav', 'stack_add_bpnav' );

// List all stacks user is going to
function coopp_bp_screen_stacks_attending(){
	global $bp;

	//do_action( 'coopp_bp_screen_stacks_attending' );
	bp_core_load_template( 'members/single/stacks' );

	/*
	// Set up our custom query of all stacks this member is going to
	$memberid =  $bp->displayed_user->id;
	$query_args = array(
		'post_type' => 'stack',
		'meta_key' => 'stack_users',
		'meta_value' => $memberid,
		'meta_compare' => 'IN',
		'orderby' => 'stack_date',
		'order' => 'asc'
	);
	$query = new WP_Query($query_args);

	// Echo out all the results
	if( $query->have_posts() ) :
		echo "<ul class='stacks'>";
		while ( $query->have_posts() ) : $query->the_post(); ?>
			<li class="stack" id="stack-<?php echo get_the_ID(); ?>"><?php echo stack_date(); ?> - <strong><a href="<?php echo the_permalink(); ?>"><?php echo the_title(); ?></strong></a></li>
		<?php endwhile;
		echo "</ul>";
	else : ?>
		<span class="noresults">This user is not attending any stacks</span>
	<?php endif;
	*/

}

function dpa_screen_achievement_activity() {
	global $bp;

	do_action( 'dpa_screen_achievement_activity' );
	bp_core_load_template( apply_filters( 'dpa_screen_achievement_activity_template', 'achievements/single/home' ) );
}