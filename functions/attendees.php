<?php

/* ====================================================

	CO-OPP STACK ENGINE
	Attendees

==================================================== */

require_once(ABSPATH.'wp-includes/pluggable.php');

/* ====================================================

	ADD ATTENDEE
	$stack = the post_id of the stack
	$id = the member id

==================================================== */

function add_attendee($stack){

	// exit if not logged in
	if (!is_user_logged_in()){
		return false;
	};

	// Get array of existing members
	$stack_members = get_post_meta($stack,"stack_users");

	// Get current memberid
	global $current_user;
    get_currentuserinfo();
    $member = $current_user->ID;
    //$member = 7;

	if ( in_array($member, $stack_members) ) {
		// User is already in array, do nothing
		//echo "User is already attending";
	} else {
		// User is not already in array, update meta with member id
		add_post_meta( $stack, 'stack_users', $member );
	}
	//print_r( get_post_meta($stack, 'stack_users') );
	//delete_post_meta($stack,'stack_users');

}

// Check if ?action=join is present
if( $_GET['action'] == "join" ) {
	// Get the eventid from the ?event variable
	$eventid = $_GET['event'];
	// Run the add_attendee function
	add_attendee($eventid);
}

/* ====================================================

	REMOVE ATTENDEE

==================================================== */

function remove_attendee($stack){

	// exit if not logged in
	if (!is_user_logged_in()){
		return false;
	};

	// Get current memberid
	global $current_user;
    get_currentuserinfo();
    $member = $current_user->ID;
    // Remove the ID from stack_users
    delete_post_meta( $stack, 'stack_users', $member );
}

// Check if ?action=leave_stack is present
if( $_GET['action'] == "leave_stack" ) {
	// Get the eventid from ?event variable
	$eventid = $_GET['event'];
	remove_attendee($eventid);
}

/* ====================================================

	CHECK IF CURRENT USER IS ALREADY JOINED
	returns true if they are

	if( stack_going() ) {echo "i'm going!";}

==================================================== */

function stack_going(){
	$eventid = get_the_ID();
	$stack_members = get_post_meta($eventid,"stack_users");
	// Get current memberid
	global $current_user;
    get_currentuserinfo();
    $member = $current_user->ID;
    // Check if in array
    if ( in_array($member, $stack_members) ) {
		return true;
	} else {
		return false;
	}
}

/* ====================================================

	TEAM GENERATION
	divides the stackers by a number and outputs
	them in to lists

==================================================== */

function generateStackTeams($postid, $number){

	// get stackers
	$members = get_post_meta($postid,"stack_users");
	//$members = Array(1,3,1,3,1,3,1,3);
	// randomise stackers
	shuffle($members);
	// count stackers
	$numberOfMembers = count($members);
	// divide by input
	$teamNumbers = ceil($numberOfMembers / $number);
	// split the stackers list by teamNumbers
	$teamsArray = array_chunk($members, $teamNumbers);

	// Create new team markup variable
	$teamMarkup = "";

	// cycle through each team
	foreach($teamsArray as $key => $team){
		$teamMarkup .= "<section><h4>Team ".($key+1)."</h4><ul>";
		foreach($team as $teamMember){
			// get member details
			$memberName = get_userdata($teamMember)->display_name;
			$gamingName = xprofile_get_field_data( 'Gaming Name', $teamMember );
			$avatar = get_avatar( $teamMember, '20' );
			$profilelink = bp_core_get_user_domain( $teamMember );
			// output the member details
			$teamMarkup .= "<li><a href='". $profilelink ."''>";
			$teamMarkup .= $avatar;
			$teamMarkup .= $memberName;
			$teamMarkup .= "</a>";
			if($gamingName != ""){
				$teamMarkup .= " <span class='gname'>(".$gamingName.")</span>";
			}
			$teamMarkup .= "</li>";
		}
		$teamMarkup .= "</ul></section>";
	}

	return $teamMarkup;

}