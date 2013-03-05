<?php

/* ====================================================

	BBPRESS UNREAD POSTS

	Uses a meta field called coopp_viewed_by

	This code will add an [unread] tag next to posts
	that don't have the user id inside that meta
	field.

	When a user views a topic, it adds their ID
	to the meta field.

	When a user replies to a topic it empties the
	meta field and adds their ID to the field.

	Forum loop checks for each topic inside the forum
	and checks if the user id is inside any of the
	meta fields for those topics. If it finds a topic
	with the user ID not in it, it adds an [unread]
	tag to the forum.

	If you are reading this and want to adapt this in
	to a stand-alone plugin you are more than welcome
	to :)

==================================================== */

/* ====================================================
	POST ICONS AS FUNCTIONS
==================================================== */

function bbp_viewed_by_icon_new(){
	return "<div class='bbpresss_unread_posts_icon new'>New Posts</div>";
}

function bbp_viewed_by_icon_old(){
	return "<div class='bbpresss_unread_posts_icon old'>No New Posts</div>";
}

/* ====================================================
	RETURN A LIST OF USERS IN VIEW_BY FOR SPECIFIC THREAD
==================================================== */

function bbp_viewed_by($postid){
	return get_post_meta($postid,"coopp_viewed_by");
}

/* ====================================================
	CHECK IF USER HAS VIEWED TOPIC
==================================================== */

function bbp_viewed_by_hasviewed($threadid,$member){
	$members = bbp_viewed_by($threadid);
	if ( in_array($member, $members) ) {
		return true;
	} else {
		return false;
	}
}

/* ====================================================
	ADD USER TO VIEWED_BY
==================================================== */

// Add a user to the viewed by meta
function bbp_viewed_by_add($member, $postid){

	// check if user id exists
	if ( !get_current_user_id() ) {
		return;
	}

	// check if the user is already in array
	// we don't need to add them if they are already in it
	$existing_viewed_by = bbp_viewed_by($postid);
	if ( in_array($member, $existing_viewed_by) ) {
		return;
	}

	// if the user isn't already in the viewed_by list, add them to it now
	add_post_meta( $postid, 'coopp_viewed_by', $member );
}

/* ====================================================
	ADD CURRENT USER TO VIEWED_BY FOR CURRENT TOPIC
==================================================== */

function bbp_viewed_by_add_currentmember_currentthread(){

	//delete_post_meta( get_the_ID(), 'coopp_viewed_by' );

	// get current user id
	$currentid = get_current_user_id();

	// call bbp_viewed_by_add
	bbp_viewed_by_add($currentid, get_the_ID());
}

// Automatically add user to the viewed_by meta when viewing a post
add_action('bbp_template_before_replies_loop','bbp_viewed_by_add_currentmember_currentthread');

/* ====================================================
	RESET FIELDS ON NEW REPLY
	when a user replies to a topic, empty the viewed_by
	field and add only their id
==================================================== */

function bbp_viewed_by_replied($postid){

	// get the current topic id
	$topicid = get_the_ID();

	// get current member id
	$member = get_current_user_id();

	// reset the viewed_by field by running update instead of add
	delete_post_meta($topicid,"coopp_viewed_by");
	add_post_meta( $topicid, 'coopp_viewed_by', $member );
}

// Run the function every time someone creates a reply
add_action('bbp_new_reply_post_extras','bbp_viewed_by_replied');

/* ====================================================
	TOPIC LOOP ADD UNREAD TAGS
==================================================== */
function bbp_viewed_by_threadlabel(){
	$threadid = get_the_ID();
	$viewed_by = bbp_viewed_by($threadid);

	//print_r($viewed_by);

	if ( bbp_viewed_by_hasviewed($threadid, get_current_user_id() ) ) {
		echo bbp_viewed_by_icon_old();
	} else {
		echo bbp_viewed_by_icon_new();
	}

}
add_action('bbp_theme_before_topic_title','bbp_viewed_by_threadlabel');

/* ====================================================
	FORUM LOOP ADD UNREAD TAGS
==================================================== */

function bbp_viewed_by_forumlabel(){

	global $post;
	$temppost = $post;

	//global $wp_query;
	//$tempquery = $wp_query;

	// Get IDs
	$forumid = get_the_ID();
	$memberid = get_current_user_id();

	// Get all topics inside this forum
	$topicsarg = array(
		'post_type'      => 'topic', // Narrow query down to bbPress topics
		'post_parent'    => $forumid,      // Forum ID
		'post_status'    => $default_post_status,      // Post Status
		'meta_key'       => '_bbp_last_active_time',   // Make sure topic has some last activity time
		'order'          => 'DESC',                    // 'ASC', 'DESC'
		'posts_per_page' => bbp_get_topics_per_page(), // Topics per page
		'paged'          => bbp_get_paged(),           // Page Number
		's'              => $default_topic_search,     // Topic Search
		'show_stickies'  => $default_show_stickies,    // Ignore sticky topics?
		'max_num_pages'  => false,                     // Maximum number of pages to show
		// compare a meta_query, returns only posts where the user id is NOT IN the viewed_by meta key (posts that the user hasn't seen)
		/* We should be able to query NOT IN from here according to Codex, but this code does not work, it returns posts with the user's ID in it regardless
		'meta_query' => array(
			array(
				'key' => 'coopp_viewed_by',
				'value' => $memberid,
				'compare' => 'NOT IN'
			)
		)
		*/
	);
	$topicslist = new WP_Query( $topicsarg );

	// Loop through each of the posts
	if( $topicslist->have_posts() ) :
		$unread = false;

		while( $topicslist->have_posts() ) : $topicslist->the_post();
			if( $unread == false ) {
				// if the $memberid is not in the viewed_by field
				if ( !bbp_viewed_by_hasviewed(get_the_ID(), $memberid) ) {
					// print an unread tag
					echo bbp_viewed_by_icon_new();
					// mark unread as true so we can stop looping, we only need one match
					$unread = true;
				}
			}
		endwhile;

		// if the while loop has completed but $unread is still false, then there are no new posts
		if($unread == false) :
			echo bbp_viewed_by_icon_old();
		endif;

	// if there are no posts as all, show no new posts icon
	else :

		echo bbp_viewed_by_icon_old();

	endif;

	// wp_reset_postdata();
	// wp_reset_query();
	// rewind_posts();
	// none of those above worked properly, so I've restored $post via tempoaray variable
	setup_postdata($temppost);

}
add_action('bbp_theme_before_forum_title','bbp_viewed_by_forumlabel');

/* ====================================================
	ADD MARK ALL AS READ TO FORUM TOPICS LIST
==================================================== */
function bbp_viewed_by_marktopicsread(){

	if( !isset( $_GET['action'] ) || $_GET['action'] != 'bbp_viewedby_marktopicsread' )
		return;

	// Get IDs
	$forumid = get_the_ID();
	$memberid = get_current_user_id();

	// Get all topics inside this forum
	$topicsarg = array(
		'post_type'      => 'topic', // Narrow query down to bbPress topics
		'post_parent'    => $forumid,      // Forum ID
		'post_status'    => $default_post_status,      // Post Status
		'meta_key'       => '_bbp_last_active_time',   // Make sure topic has some last activity time
		'order'          => 'DESC',                    // 'ASC', 'DESC'
		'posts_per_page' => bbp_get_topics_per_page(), // Topics per page
		'paged'          => bbp_get_paged(),           // Page Number
		's'              => $default_topic_search,     // Topic Search
		'show_stickies'  => $default_show_stickies,    // Ignore sticky topics?
		'max_num_pages'  => false,                     // Maximum number of pages to show
	);
	$topics = new WP_Query( $topicsarg );

	// Loop through each of the posts
	if( $topics->have_posts() ) :

		while( $topics->have_posts() ) : $topics->the_post();
			$postid = get_the_ID();
			bbp_viewed_by_add($memberid,$postid);
		endwhile;

	endif;

	wp_reset_query();

}
add_action( 'init', 'bbp_viewed_by_marktopicsread' );

function bbp_viewed_by_marktopicsread_button(){
	// check if user id exists
	if ( !get_current_user_id() ) {
		return;
	}
	$url = esc_url( wp_nonce_url( add_query_arg( 'action', 'bbp_viewedby_marktopicsread', bbp_get_user_profile_url() ), 'mark_topics_read' ) );
	echo "<div class='coopp-viewedby-buttons'><a href='".$url."' class='button'>Mark all topics read</a></div>";
}
add_action("bbp_template_after_topics_loop","bbp_viewed_by_marktopicsread_button");