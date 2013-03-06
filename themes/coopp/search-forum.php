<?php

	$reply_id = get_the_ID();

?>

	<tr class="bbp-reply-header">
		<td colspan="2">

			<?php printf( __( '%1$s at %2$s', 'bbpress' ), get_the_date(), esc_attr( get_the_time() ) ); ?>
			<?php /* <a href="<?php bbp_reply_url(); ?>" title="<?php bbp_reply_title(); ?>" class="bbp-reply-permalink">#<?php bbp_reply_id(); ?></a> */ ?>
			<a href="<?php bbp_reply_url($reply_id); ?>" class="bbp-reply-permalink">» <?php bbp_reply_title(); ?></a>

		</td>
	</tr>

	<tr id="post-<?php bbp_reply_id(); ?>" <?php bbp_reply_class(); ?>>

		<td class="bbp-reply-author">

			<?php do_action( 'bbp_theme_before_reply_author_details' ); ?>

			<?php echo bbp_reply_author_link( array( 'post_id' => $reply_id, 'sep' => '<br />', 'show_role' => false ) ); ?>
			<?php if ( xprofile_get_field_data( 'Gaming Name', bbp_get_reply_author_id() ) != "" ) {
				echo "<span class='gaming-name'>AKA ".xprofile_get_field_data( 'Gaming Name', bbp_get_reply_author_id() ) ."</span>";
			} ?>
			<?php echo bbp_get_reply_author_role(); ?>

			<?php if ( is_super_admin() ) : ?>

				<?php do_action( 'bbp_theme_before_reply_author_admin_details' ); ?>

				<div class="bbp-reply-ip"><?php bbp_author_ip( bbp_get_reply_id(get_the_ID()) ); ?></div>

				<?php do_action( 'bbp_theme_after_reply_author_admin_details' ); ?>

			<?php endif; ?>

			<?php do_action( 'bbp_theme_after_reply_author_details' ); ?>

		</td>

		<td class="bbp-reply-content">

			<?php do_action( 'bbp_theme_before_reply_content' ); ?>

			<?php bbp_reply_content(); ?>

			<?php do_action( 'bbp_theme_after_reply_content' ); ?>

		</td>

	</tr><!-- #post-<?php bbp_topic_id($reply_id); ?> -->