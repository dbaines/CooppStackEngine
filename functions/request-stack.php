<?php

/* ====================================================

	CO-OPP STACK ENGINE
	Request a stack

	Creates a draft post ready for admin approval
	http://www.devharb.com/how-to-create-postpage-programmatically-in-wordpress-by-using-wp_insert_post/

==================================================== */

// Create a new requested stack
function createRequestedStack($stack_title, $stack_date, $stack_time, $stack_type, $stack_location, $stack_location_map, $stack_steamid, $stack_requestedby, $stack_content){

	// create $post data
	global $user_ID;
	$post = array();
	$post['post_type'] 			= "stack";
	$post['post_content'] 	= $stack_content;
	$post['post_author'] 		= null;
	$post['post_status'] 		= "draft";
	$post['post_title'] 		= $stack_title;

	// insert post to database, creates a draft
	$postid = wp_insert_post($post);

	// add custom meta data to new post (stack details)
	__update_post_meta( $postid, 'stack_date', $stack_date );
	__update_post_meta( $postid, 'stack_time', $stack_time );
	__update_post_meta( $postid, 'stack_type', $stack_type );
	__update_post_meta( $postid, 'stack_location', $stack_location );
	__update_post_meta( $postid, 'stack_location_map', $stack_location_map );
	__update_post_meta( $postid, 'stack_steamid', $stack_steamid );
	__update_post_meta( $postid, 'stack_requestedby', $stack_requestedby );

	return $postid;

}

// update meta function
function __update_post_meta( $postid, $field_name, $value='' ){
	if (empty( $value ) OR ! $value) {
		delete_post_meta( $postid, $field_name );
	} elseif ( !get_post_meta( $post_id, $field_name ) ) {
		add_post_meta( $postid, $field_name, $value );
	} else {
		update_post_meta( $postid, $field_name, $value );
	}
}

/* ====================================================

	RENDER REQUEST FORM
	renders a HTML form for users to input their request in to

==================================================== */

function renderStackForm(){

	global $current_user;
  get_currentuserinfo();
  if ($current_user->ID == 0){
  	return "<p class='requestNotLoggedIn'><em>Please log in to request a stack.</em></p>";
  }

	// Check if form has been submitted (?submit=sent)
	if ($_GET['submit'] == "sent"){

		$html = "<p class='sentRequest'>Your request has been sent!</p>";

		// get $_POST variables to display your stack details
		$stack_title = $_POST['stack_title'];
		$stack_date = $_POST['stack_date'];
		$stack_time = $_POST['stack_time'];
		$stack_type = $_POST['stack_type'];
		$stack_location = $_POST['stack_location'];
		$stack_location_map = $_POST['stack_location_map'];
		$stack_steamid = $_POST['stack_steamid'];
		$stack_requestedby = $_POST['stack_requestedby'];
		$stack_content = $_POST['stack_content'];

		// Output details for user to review
		$html .= "<section class='stackRequestDetailsBox'>";
		$html .= "<p>The details that were submitted:</p><p class='stackRequestDetails'>";
		$html .= "Title: ".stripslashes($stack_title) ."<br />";
		$html .= "Date: ".$stack_date ."<br />";
		$html .= "Time: ".$stack_time ."<br />";
		$html .= "Type: ".$stack_type ."<br />";
		$html .= "Location: ".stripslashes($stack_location) ."<br />";
		$html .= "Location Map: ".$stack_location_map."<br />";
		$html .= "Steam ID: ".$stack_steamid ."<br />";
		$html .= "Content: ".stripslashes($stack_content) ."</p>";
		$html .= "<p>Please do not reload this page. An administrator will review your request and approve it to go live on Co-Opp.</p>";
		$html .= "</section>";

		// Exit if no title has been provided
		if($stack_title == ""){
			// Output notice
			$html .= "<section><div class='sentRequest'>Sorry, you did not include a title. Please go back and include a title. This is to prevent accidental or spam submissions.</div></section>";
		} else {
			// Create Post
			$postid = createRequestedStack($stack_title, $stack_date, $stack_time, $stack_type, $stack_location, $stack_location_map, $stack_steamid, $stack_requestedby, $stack_content);

			// Get admin emails
			$admins = get_users('role=administrator');
			$admin_emails = "";
			foreach($admins as $admin){
				$admin_emails .= $admin->user_email . ",";
			}

			// Send an email to administrators
			$to = $admin_emails;
			$subject = "New Stack Requested";
			$message = "A new stack has been requested by " . $current_user->display_name .". \n";
			$message .= "Stack Title: ".$stack_title."\n";
			$message .= "Stack Time: ".$stack_date." at ".$stack_time." \n";
			$message .= "Stack Type: ".$stack_type." \n";
			$message .= "Edit/Approve: ". get_bloginfo('url') . "/wp-admin/post.php?post=" . $postid . "&action=edit";
			//wp_mail( $to, $subject, $message );
		}

	} else {

		// Start the form element
		$html =  "<form action='?submit=sent' method='post' class='stack_reqform'>";

		$html .= "<section>";
		$html .= "<label for='stack_title'>Title (Required)</label>";
		$html .= "<input type='text' name='stack_title' id='stack_title' placeholder='Stack Title' />";
		$html .= "</section>";

		$html .= "<section>";
		$html .= "<label for='stack_date'>Date</label>";
		$html .= "<input type='date' name='stack_date' id='stack_date' placeholder='dd/mm/yyyy' />";
		$html .= "</section>";

		$html .= "<section>";
		$html .= "<label for='stack_time'>Time</label>";
		$html .= "<input type='text' name='stack_time' id='stack_time' placeholder='8:00 PM AEST' />";
		$html .= "</section>";

		$html .= "<section>";
		$html .= "<label for='stack_time'>Type</label>";
		$html .= "<select id='stack_type' name='stack_type'>";
		$html .= "<option value='online'>Online Stack</option>";
		$html .= "<option value='irl'>IRL Stack</option>";
		$html .= "</select>";
		$html .= "</section>";

		$html .= "<section class='stack_irl_field'>";
		$html .= "<label for='stack_location'>Location (Optional)</label>";
		$html .= "<input type='text' name='stack_location' id='stack_location' placeholder=\"BennEh's House\" />";
		$html .= "</section>";

		$html .= "<section class='stack_irl_field'>";
		$html .= "<label for='stack_location_map'>Show Map</label>";
		$html .= "<input type='checkbox' name='stack_location_map' id='stack_location_map' />";
		$html .= "</section>";

		$html .= "<section class='stack_online_field'>";
		$html .= "<label for='stack_steamid'>Steam Game ID (Optional)</label>";
		$html .= "<input type='text' name='stack_steamid' id='stack_steamid' placeholder='440' />";
		$html .= "</section>";

		$html .= "<section>";
		$html .= "<label for='stack_content'>Post Content</label>";
		$html .= "<textarea name='stack_content' id='stack_content'></textarea>";
		$html .= "</section>";

		// Current member ID
		global $current_user;
    get_currentuserinfo();
		$html .= "<input type='hidden' id='stack_requestedby' name='stack_requestedby' value='".$current_user->ID ."' />";

		// Submit Button
		$html .= "<section class='submit-request'>";
		$html .= "<input type='submit' value='Request Stack Now!' />";
		$html .= "</section>";

		// End the form element
		$html .= "</form>";

	}

	return $html;

}