<div class="forum-results">

	<h3 class="entry-title"><a href="<?php bbp_reply_url(); ?>"><?php bbp_reply_title(); ?></a></h3>

	<div class="entry-content">
		<table class="bbp-replies" id="topic-<?php bbp_topic_id(); ?>-replies">
			<thead>
				<tr>
					<th class="bbp-reply-author"><?php  _e( 'Author',  'bbpress' ); ?></th>
					<th class="bbp-reply-content"><?php _e( 'Post', 'bbpress' ); ?></th>
				</tr>
			</thead>

			<tbody>
				<tr class="bbp-reply-header">
					<td class="bbp-reply-author">

						<?php bbp_reply_author_display_name(); ?>

					</td>
					<td class="bbp-reply-content">
						<a href="<?php bbp_reply_url(); ?>" title="<?php bbp_reply_title(); ?>">#</a>

						<?php printf( __( 'Posted on %1$s at %2$s', 'bbpress' ), get_the_date(), esc_attr( get_the_time() ) ); ?>

						<span><?php bbp_reply_admin_links(); ?></span>
					</td>
				</tr>

				<tr id="reply-<?php bbp_reply_id(); ?>" <?php bbp_reply_class(); ?>>

					<td class="bbp-reply-author"><?php bbp_reply_author_link( array( 'type' => 'avatar' ) ); ?></td>

					<td class="bbp-reply-content">

						<?php bbp_reply_content(); ?>

					</td>

				</tr><!-- #topic-<?php bbp_topic_id(); ?>-replies -->
			</tbody>
		</table>

	</div><!-- .entry-content -->

</div>