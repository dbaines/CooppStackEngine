<?php

/* ====================================================

	CO-OPP STACK ENGINE
	Template functions

	Shortcuts and aliases for stack meta data
	and common functions

==================================================== */

global $post;
$globalid = $post->ID;

// Returns the memberid for the requested by field
function stack_requested_by(){
	return get_post_meta(get_the_ID(),"stack_requestedby",true);
}

// Checks if there was a request for this stack
function stack_requested(){
	if(stack_requested_by() == 0){
		return false;
	} else {
		return true;
	}
}

// Date
function stack_date(){
	return get_post_meta(get_the_ID(),"stack_date",true);
}

// Time
function stack_time(){
	return get_post_meta(get_the_ID(),"stack_time",true);
}

// Date and Time
function stack_datetime(){
	$date = get_post_meta(get_the_ID(),"stack_date",true);
	$time = get_post_meta(get_the_ID(),"stack_time",true);
	return $date ." at ". $time;
}

// Stack Location
function stack_location(){
	return get_post_meta(get_the_ID(),"stack_location",true);
}

// Stack Type
function stack_type(){
	return get_post_meta(get_the_ID(),"stack_type",true);
}

// Returns the memberid for the requested by field
function stack_steamid(){
	return get_post_meta(get_the_ID(),"stack_steamid",true);
}

// Checks how many users are attending the stack and returns only the number
function stack_memberstotal(){
	return count(stack_memberlist());
}

function stack_memberlist(){
	$eventid = get_the_ID();
	$stack_members = get_post_meta($eventid,"stack_users");
	return $stack_members;
}

// Links - return array of links
function stack_links_array(){
	return get_post_meta(get_the_ID(), "stack_link_list");
}

// Links - number of links
function stack_links_number(){
	$linkArray = get_post_meta(get_the_ID(), "stack_link_list");
	return count($linkArray[0]);
}

// Links - display particular text
function stack_link_text($id){
	$linkArray = get_post_meta(get_the_ID(), "stack_link_list");
	return $linkArray[0][$id]['text'];
}

// Links - display particular URL
function stack_link_url($id){
	$linkArray = get_post_meta(get_the_ID(), "stack_link_list");
	return $linkArray[0][$id]['url'];
}

// Links - pre-made link list
function stack_link_display(){
	$linkArray = get_post_meta(get_the_ID(), "stack_link_list");
	// Create a UL element for us to store the links in
	$linkList = "<ul class='linksList'>\n";
	// Run through each link in the meta and create a list element inside our UL
	foreach($linkArray[0] as $link){
		$linkList .= "<li class='link'><a href='".$link['url']."' title='".$link['text']."'>".$link['text']."</a></li>\n";
	}
	// Add a steam link if needed
	if(stack_steamid()){
		$linkList .= '<li><a href="http://store.steampowered.com/app/'. stack_steamid() .'/" title="View game on the Steam Store" class="steam">Steam Store Page</a></li>';
	}
	// End UL
	$linkList .= "</ul>\n";
	// Return compiled list
	return $linkList;
}

// Is Past Stack? Returns true if todays date is past the stack date
function is_past_stack(){
	// get our two dates in time format
	$stack_date = strtotime(stack_date());
	$today = strtotime(date('Y-m-j'));
	if($stack_date < $today) {
		return true;
	} else {
		return false;
	}
}

// RSS Feed for stacks
function stack_feed_url(){
	return get_bloginfo('url')."/?post_type=stack&feed=rss2";
}
function stack_feed(){
	return "<link href=".stack_feed_url()." rel='alternate' type='application/atom+xml' title='Stack Feed' />";
}

// Get large stack artwork, returns default image if none set
function stack_art_large(){
	if( has_post_thumbnail() ) {
		$fullImage = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'fullstack' );
		$fullImage = $fullImage[0];
		return $fullImage;
	} else {
		return bloginfo('url') . '/wp-content/plugins/coopp-stackengine/images/default_large.png';
	}
}
// Get small stack artwork, returns default image if none set
function stack_art_small(){
	if( has_post_thumbnail() ) {
		$fullImage = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'shortstack' );
		$fullImage = $fullImage[0];
		return $fullImage;
	} else {
		return bloginfo('url') . '/wp-content/plugins/coopp-stackengine/images/default_small.png';
	}
}

// Check if particular member id is going to stack
function stack_user_going($member){
	$eventid = get_the_ID();
	$stack_members = get_post_meta($eventid,"stack_users");
    // Check if in array
    if ( in_array($member, $stack_members) ) {
		return true;
	} else {
		return false;
	}
}

/* ====================================================

	USER STATISTICS FUNCTIONS

==================================================== */

// Return the number of comments the user has made
function get_user_comment_count($memberid){
	global $wpdb;
	$where = 'WHERE comment_approved = 1 AND user_id = '.$memberid;
	$comment_counts = (array) $wpdb->get_results("
			SELECT COUNT( * ) AS total
			FROM {$wpdb->comments}
			{$where}
		", object);
	return $comment_counts[0]->total;
}

// stacks requested
function get_stacks_requested_count($memberid){
	$stacks_requested_query_args = array(
		'post_type' => 'stack',
		'meta_query' => array(
			array(
				'key' => 'stack_requestedby',
				'value' => $memberid,
				'compare' => 'IN',
			)
		)
	);
	$stacks_requested_query = new WP_Query($stacks_requested_query_args);
	return $stacks_requested_query->found_posts;
}

// stacks attended
function get_stacks_attended_count($memberid){
	$stacks_attended_query_args = array(
		'post_type' => 'stack',
		'meta_query' => array(
			array(
				'key' => 'stack_users',
				'value' => $memberid,
				'compare' => 'IN',
			)
		)
	);
	$stacks_attended_query = new WP_Query($stacks_attended_query_args);
	return $stacks_attended_query->found_posts;
}

// forum post count
function get_forum_postcount($memberid){
	// get forum stats
	$topics = bbp_get_user_topic_count_raw( $memberid );
	$replies = bbp_get_user_reply_count_raw( $memberid );
	return ($topics + $replies);
}