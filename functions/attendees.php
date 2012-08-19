<?php

/* ====================================================

	CO-OPP STACK ENGINE
	Attendees

	New database table (wp_attendees)
	* (key) stack_id (id of stack post)
	* attending (a list of userids that are attending)

	http://codex.wordpress.org/Creating_Tables_with_Plugins

==================================================== */

require_once(ABSPATH.'wp-includes/pluggable.php');

/* ====================================================

	ADD ATTENDEE
	$stack = the post_id of the stack
	$id = the member id

==================================================== */

function add_attendee($stack){

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

	if( stack_going ) {echo "i'm going!";}

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