<?php

/* ====================================================

	GENERIC COMMENTS TEMPLATE

==================================================== */
if ( ! function_exists( 'coopp_comments' ) ) :
	function coopp_comments( $comment, $args, $depth ) {

		$GLOBALS ['comment'] = $comment;
		if ( '' == $comment->comment_type ) :

			coopp_comments_template($comment, $args, $depth);

		else : ?>
			<li class="post pingback">
			<p><?php _e( 'Pingback: ', 'twentyten' ); ?><?php comment_author_link(); ?><?php edit_comment_link ( __('edit', 'twentyten'), '&nbsp;&nbsp;', '' ); ?></p>
		<?php endif;

	}
endif;

/* ====================================================

	PRE-STACK COMMENTS
	only show comments that were made on or before
	the stack_date();

==================================================== */
if ( ! function_exists( 'coopp_comments_past' ) ) :
	function coopp_comments_past( $comment, $args, $depth ) {
		$GLOBALS ['comment'] = $comment;

		$stack_date = strtotime(stack_date());
		if ( '' == $comment->comment_type ) :

			// Compare stack date to the comment date
			$comment_date = strtotime(get_comment_date());
			if($comment_date <= $stack_date) :
				coopp_comments_template($comment, $args, $depth);
			endif;
		endif;

	}
endif;

/* ====================================================

	POST-STACK COMMENTS
	only show comments that were made after the
	stack_date();

==================================================== */
if ( ! function_exists( 'coopp_comments_post' ) ) :
	function coopp_comments_post( $comment, $args, $depth ) {
		$GLOBALS ['comment'] = $comment;


		$stack_date = strtotime(stack_date());
		if ( '' == $comment->comment_type ) :

			// Compare stack date to the comment date
			$comment_date = strtotime(get_comment_date());
			if($comment_date > $stack_date) :
				coopp_comments_template($comment, $args, $depth);
			endif;

		endif;
	}
endif;

/* ====================================================

	COMMENTS TEMPLATE
	The actual output of the comments

==================================================== */

function coopp_comments_template($comment, $args, $depth){

	// Load some additional details if this is a comment for a stack
	if( "stack" == get_post_type() ) :
		// Check if this user is going or if they requested this stack
		// We'll add some additional classes to the comment_class if they did either
		$additional_classes = "";
		$user_going = false;
		$requested_by = false;
		$community_leader = false;
		if( $comment->user_id == stack_requested() ){
			$additional_classes .= " requested";
			$requested_by = true;
		}
		if( stack_user_going($comment->user_id) ) {
			$additional_classes .= " attending";
			$user_going = true;
		}
		/*
		if ( groups_is_user_member( $comment->user_id, 2 ) ) {
			$additional_classes .= " commleader";
			$community_leader = true;
		}
		*/
	endif;
	?>

	<li <?php comment_class($additional_classes); ?> id="li-comment-<?php comment_ID(); ?>">

	    <div id="comment-<?php comment_ID(); ?>">
		    <div class="comment-left">
		    	<?php
		    		echo get_avatar( $comment, 48 );
		    		if( "stack" == get_post_type() ) :
			    		if( $community_leader == true ) {
			    			echo "<span class='commenticon commleader' title='Community Leader'>Community Leader</span>";
			    		}
			    		if($requested_by == true) {
			    			echo "<span class='commenticon requested' title='Requested By User'>Requested By User</span>";
			    		}
			    		if( $user_going == true ) {
			    			echo "<span class='commenticon going' title='Stacker'>Stacker</span>";
			    		}
		    		endif;
		    	?>
		    </div>
		    <div class="comment-right">
		    	<div class="comment-author vcard">
		    		<?php printf( __( '<cite class="fn">%s</cite>', 'twentyten' ), get_comment_author_link() ); ?>
		    	</div>
		    	<div class="comment-posted-date">
		    		<?php
		    			// Time Ago before certain time
		    			// http://wp-snippets.com/display-time-agotwitter-style/
		    			$human_time = human_time_diff(get_comment_time('U'), current_time('timestamp')) . ' ago';
		    			$robot_time = get_comment_time() . " on " . get_comment_date();
		    			$time_difference = current_time('timestamp') - get_comment_time('U');
		    			if($time_difference < 172800 ) {
		    				echo $human_time;
		    			} else {
		    				echo $robot_time;
		    			}
		    		?>
		    	</div>
		    	<?php if ( $comment->comment_approved == '0' ) : ?>
					<span class="comment-moderation"><?php _e( 'Your comment is awaiting moderation.', 'twentyten' ); ?></span><br />
				<?php endif; ?>
				<div class="comment-body"><?php comment_text(); ?></div>
		    </div>
		    <div class="comment-actions clearfix">
				<div class="reply">
					<?php
						// Don't show the reply button if the stack has already happened and this is a pre-stack comment
						if( is_past_stack() ) {
							$stack_date = strtotime(stack_date());
							$comment_date = strtotime(get_comment_date());
							if($comment_date > $stack_date) :
								comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) );
							endif;
						} else {
							comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) );
						}
					?>
				</div>
				<div class="permalink">
            		<a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">Permalink</a>
            	</div>
            	<?php edit_comment_link( __( 'Edit', 'twentyten' ),'<div class=edit>','</div>' ); ?>
	            <?php delete_comment_link(get_comment_ID());  ?>
			</div>
		</div>

    <?php # end li omitted, for some reason wordpress adds it anyway, adding it in as you would will only break things
}

/* ====================================================

	COMMENTS FORM
	http://coding.smashingmagazine.com/2011/02/22/using-html5-to-transform-wordpress-twentyten-theme/

==================================================== */
add_filter('comment_form_default_fields', 'comments_form');
function comments_form() {

	$req = get_option('require_name_email');
	$fields =  array(
		'author' => '<p class="comment-fields">' . '<label for="author">' . __( 'Name' ) . ( $req ? '<span>*</span>' : '' ) .
		'</label><input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . ' placeholder = "What should we call you?"' . ( $req ? ' required' : '' ) . '/></p>',

		'email'  => '<p class="comment-fields"><label for="email">' . __( 'Email' ) . ( $req ? '<span>*</span>' : '' ) .
		'</label><input id="email" name="email" type="email" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30"' . $aria_req . ' placeholder="How can we reach you?"' . ( $req ? ' required' : '' ) . ' /></p>',

		'url'    => '<p class="comment-fields"><label for="url">' . __( 'Website' ) .
		'</label><input id="url" name="url" type="url" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" placeholder="Have you got a website?" /></p>'
	);
	return $fields;
}

/* ====================================================

	COMMENT BUTTONS
	adds spam and delete buttons to comments

==================================================== */
function delete_comment_link($id) {
  if (current_user_can('edit_post')) {
	echo '<div class="delete"><a href="'.admin_url("comment.php?action=cdc&c=$id").'">Delete</a></div>';
	echo '<div class="spam"><a href="'.admin_url("comment.php?action=cdc&dt=spam&c=$id").'">Spam</a></div>';
  }
}