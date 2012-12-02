
<?php /*
	<article class="stack stack-short clearfix">

		<div class="stackArt">
			<img src="<?php echo stack_art_small() ?>" alt="" title="" />
			<?php if(stack_type() == "irl"){ ?>
				<div class="stackIRL">IRL Stack!</div>
			<?php } ?>
		</div>
		<div class="stackDetails">
			<hgroup class="stackInfo">
				<h2><?php echo the_title(); ?></h2>
				<h3><?php echo date( 'l, jS F Y', strtotime( stack_date() ) ) . " at " . stack_time(); ?></h3>
			</hgroup>
			<div class="stackMembers">
				<?php echo coopp_membercount(); ?>
			</div>
			<div class="stackTextMeta">
				<a href="<?php echo the_permalink(); ?>#comments" class="comments">Comments (<?php echo get_comments_number() ?>)</a>
				<?php edit_post_link('Edit Stack', '<span class="edit">', '</span>'); ?>
			</div>
		</div>
		<div class="stackLink">
			<a href="<?php echo the_permalink(); ?>" class="ir" title="View Full Stack Details">View Stack</a>
		</div>

	</article>
	*/ ?>

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
