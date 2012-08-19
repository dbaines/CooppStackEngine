<?php
/**
 * The template for displaying Comments.
 *
 * The area of the page that contains both current comments
 * and the comment form. The actual display of comments is
 * handled by a callback to twentyeleven_comment() which is
 * located in the functions.php file.
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 * @since Twenty Eleven 1.0
 */

// http://wordpress.stackexchange.com/questions/46335/get-comments-after-specific-date

?>
	<div id="comments">
	<?php if ( post_password_required() ) : ?>
		<p class="nopassword"><?php _e( 'This post is password protected. Enter the password to view any comments.', 'twentyeleven' ); ?></p>
	</div><!-- #comments -->

	<?php
			/* Stop the rest of comments.php from being processed,
			 * but don't kill the script entirely -- we still have
			 * to fully load the template.
			 */
			return;
		endif;
	?>

	<?php if ( have_comments() ) : ?>

		<div class="commentsTabs clearfix">
			<?php if(is_past_stack()){ ?>
				<h2 data-comments="pre">Pre-Stack Comments</h2>
				<h2 class="active" data-comments="post">Post-Stack Comments</h2>
			<?php } else { ?>
				<h2 class="active" data-comments="pre">Pre-Stack Comments</h2>
			<?php } ?>
		</div>

		<div class="comments-container">

			<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
			<nav id="comment-nav-above">
				<h1 class="assistive-text"><?php _e( 'Comment navigation', 'twentyeleven' ); ?></h1>
				<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'twentyeleven' ) ); ?></div>
				<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'twentyeleven' ) ); ?></div>
			</nav>
			<?php endif; // check for comment navigation ?>

			<ol class="commentlist prestack">
				<?php
					wp_list_comments( array( 'callback' => 'coopp_comments_past' ) );
				?>
			</ol>

			<?php if(is_past_stack()){ ?>
			<ol class="commentlist poststack">
				<?php
					wp_list_comments( array( 'callback' => 'coopp_comments_post' ) );
				?>
			</ol>
			<?php } ?>

			<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
			<nav id="comment-nav-below">
				<h1 class="assistive-text"><?php _e( 'Comment navigation', 'twentyeleven' ); ?></h1>
				<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'twentyeleven' ) ); ?></div>
				<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'twentyeleven' ) ); ?></div>
			</nav>
			<?php endif; // check for comment navigation ?>

		<?php
			/* If there are no comments and comments are closed, let's leave a little note, shall we?
			 * But we don't want the note on pages or post types that do not support comments.
			 */
			elseif ( ! comments_open() && ! is_page() && post_type_supports( get_post_type(), 'comments' ) ) :
		?>
			<p class="nocomments"><?php _e( 'Comments are closed.', 'twentyeleven' ); ?></p>
		<?php endif; ?>

		<div class="comment-form-container">
			<?php comment_form(); ?>
		</div>

	</div>

</div><!-- #comments -->
