<?php 

/* ====================================================

	CO-OPP STACK ENGINE
	Custom Meta Boxes for use with the "stack"
	post type

	1. Date & Time of Stack
	2. SteamID of Game
	3. Requested By
	4. Related Links
	5. Stack Type

	http://codex.wordpress.org/Function_Reference/add_meta_box
	http://codex.wordpress.org/Function_Reference/add_post_meta
	http://codex.wordpress.org/Function_Reference/update_post_meta

==================================================== */

/* ====================================================

	CREATE THE META BOX

==================================================== */
add_action( 'add_meta_boxes', 'addbox_stacks' );
function addbox_stacks(){
	add_meta_box(
		'stack_meta',
		__( 'Stack Details' ),
		'addbox_stacks_content',
		'stack',
		'normal',
		'high'
	);
}

/* ====================================================

	CONTENT FOR THE META BOX

==================================================== */
function addbox_stacks_content($post){
	// verification
	wp_nonce_field( plugin_basename(__FILE__), 'coopp_metanonce' );
	// content of box
	global $post;
	?>

	<div class='stack_meta'>
		<section class="stack_datetime">
			<label for="stack_date">Date</label><input type="date" name="stack_date" value="<?php echo get_post_meta($post->ID,"stack_date",true); ?>" />
			<label for="stack_time" class="secondary">Time</label><input type="text" name="stack_time" value="<?php echo get_post_meta($post->ID,"stack_time",true); ?>" />
		</section>
		<section>
			<label for="stack_type">Type</label>
			<select name="stack_type">
				<option value="online" <?php if(get_post_meta($post->ID,"stack_type",true) == "online"){echo "selected";} ?>>Online Stack</option>
				<option value="irl" <?php if(get_post_meta($post->ID,"stack_type",true) == "irl"){echo "selected";} ?>>IRL Stack</option>
			</select>
		</section>
		<section>
			<label for="stack_location">Location</label>
			<textarea name="stack_location"><?php echo get_post_meta($post->ID,"stack_location",true); ?></textarea>
		</section>
		<section>
			<label for="stack_steamid">Steam GameID</label><input type="text" name="stack_steamid" value="<?php echo get_post_meta($post->ID,"stack_steamid",true); ?>" />
		</section>
		<section>
			<label for="stack_requestedby">Requested By</label>
			<select type="text" name="stack_requestedby" id="stack_requestedby" />
				<option value="0">No Request</option>
				<?php
				// lookup all users
				$user_args = array(
					// order by display name in alphabetical order
					'orderby' => 'display_name'
				);
				$wp_user_query = new WP_User_Query($user_args);
				$members = $wp_user_query->get_results();
				// check against empty results
				if(!empty($members)){
					foreach($members as $member){
						$member_info = get_userdata($member->ID);
						$member_id = get_post_meta($post->ID, 'users', true);
						$requestedby = get_post_meta($post->ID,'stack_requestedby',true);
						if( $member_info->ID == $requestedby ) {
							echo "<option value='".$member_info->ID."' selected>".$member_info->display_name."</option>";
						} else {
							echo "<option value='".$member_info->ID."'>".$member_info->display_name."</option>";
						}
					}
				} else {
					echo "<option>No members found</option>";
				}
				?>
			</select>
			<label for="stack_requestedby_filter" class="secondary">Filter</label><input type="text" name="stack_requestedby_filter" class="filter_requestedby" />
		</section>
		<section>
			<label for="stack_links">Links</label>
			<div class="links_list">
				<?php
					$linkArray = get_post_meta(get_the_ID(), "stack_link_list");
					foreach($linkArray[0] as $link){
						echo '<div class="stack_link"><input type="text" name="stack_links_text[]" value="'.$link['text'].'" placeholder="text" />&nbsp;<input type="text" name="stack_links_url[]" value="'.$link['url'].'" placeholder="url" /><span class="stack_link_delete">Delete</span></div>';
					}
				?>
			</div>
			<button class="stack_add_link">+ Link</button>
		</section>
	</div>

	<?php
}

/* ====================================================

	SAVING FUNCTION

==================================================== */

add_action( 'save_post', 'coopp_save_postdate', 1);
function coopp_save_postdate($post_id){

	// check if autosave - don't do anything until being submitted
	if (defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
		return;
	// verify authorisation, save_post can be triggered at other times
	if( !wp_verify_nonce( $_POST['coopp_metanonce'], plugin_basename( __FILE__ ) ) )
		return;
	// check permissions
	// a little sideways compatability if we ever need to check against page permissions
	if( 'page' == $_POST['post_type'] ) {
		if( !current_user_can( 'edit_page', $post_id ) )
			return;
	} else {
		if( !current_user_can( 'edit_post', $post_id ) )
			return;
	}

	// if you get this far, you can save the data
	$stack_date = $_POST['stack_date'];
	$stack_time = $_POST['stack_time'];
	$stack_type = $_POST['stack_type'];
	$stack_location = $_POST['stack_location'];
	$stack_steamid = $_POST['stack_steamid'];
	$stack_requestedby = $_POST['stack_requestedby'];

	// Iterate through link boxes
	$links_list = array();
	$links = count($_POST["stack_links_text"]);
	for( $i = 0; $i < $links; $i++ ){
		// Build mini-array for this link
		if(!empty($_POST["stack_links_text"][$i])){
			$minilink = array(
				"text" => $_POST["stack_links_text"][$i],
				"url" => $_POST["stack_links_url"][$i]
			);
			array_push($links_list, $minilink);
		}
	}

	// Save data to post meta
	update_post_meta( $post_id, 'stack_date', $stack_date );
	update_post_meta( $post_id, 'stack_time', $stack_time );
	update_post_meta( $post_id, 'stack_type', $stack_type );
	update_post_meta( $post_id, 'stack_location', $stack_location );
	update_post_meta( $post_id, 'stack_steamid', $stack_steamid );
	update_post_meta( $post_id, 'stack_requestedby', $stack_requestedby );
	update_post_meta( $post_id, 'stack_link_list', $links_list);
}