<?php do_action( 'bp_before_profile_loop_content' ); ?>

<?php if ( bp_has_profile() ) : ?>

	<?php while ( bp_profile_groups() ) : bp_the_profile_group(); ?>

		<?php if ( bp_profile_group_has_fields() ) : ?>

			<?php do_action( 'bp_before_profile_field_content' ); ?>

			<div class="bp-widget <?php bp_the_profile_group_slug(); ?>">

				<h4><?php bp_the_profile_group_name(); ?></h4>

				<table class="profile-fields">

					<?php while ( bp_profile_fields() ) : bp_the_profile_field(); ?>

						<?php if ( bp_field_has_data() ) : ?>

							<tr<?php bp_field_css_class(); ?>>

								<td class="label"><?php bp_the_profile_field_name(); ?></td>

								<td class="data"><?php bp_the_profile_field_value(); ?></td>

							</tr>

						<?php endif; ?>

						<?php do_action( 'bp_profile_field_item' ); ?>

					<?php endwhile; ?>

				</table>
			</div>

			<?php do_action( 'bp_after_profile_field_content' ); ?>

		<?php endif; ?>

	<?php endwhile; ?>

	<h4>Co-Opp Statistics</h4>
	<?php
		// load buddypress global (to get id)
		global $bp;
		$memberid = $bp->displayed_user->id;
	?>
	<table class="profile-fields">
		<tbody>
			<tr>
				<td class="label">Stacks Attended</td>
				<td class="data"><a href="stacks"><?php echo get_stacks_attended_count($memberid); ?></a></td>
			</tr>
			<tr class="alt">
				<td class="label">Stacks Requested</td>
				<td class="data"><a href="stacks/requested/"><?php echo get_stacks_requested_count($memberid); ?></a></td>
			</tr>
			<tr>
				<td class="label">Stack Comments</td>
				<td class="data"><?php echo get_user_comment_count($memberid); ?> </td>
			</tr>
			<tr class="alt">
				<td class="label">Forum Post Count</td>
				<td class="data"><?php echo get_forum_postcount($memberid); ?></td>
			</tr>
		</tbody>
	</table>

	<?php do_action( 'bp_profile_field_buttons' ); ?>

<?php endif; ?>

<?php do_action( 'bp_after_profile_loop_content' ); ?>
