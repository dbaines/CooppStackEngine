<?php

/**
 * BuddyPress - Users Header
 *
 * @package BuddyPress
 * @subpackage bp-default
 */

?>

<?php do_action( 'bp_before_member_header' ); ?>

<div id="item-header-avatar">
	<a href="<?php bp_displayed_user_link(); ?>">

		<?php bp_displayed_user_avatar( 'type=full' ); ?>

	</a>
</div><!-- #item-header-avatar -->

<div id="item-header-content">

	<h2>
		<a href="<?php bp_displayed_user_link(); ?>"><?php bp_displayed_user_fullname(); ?></a>
	</h2>

	<span class="user-nicename">@<?php bp_displayed_user_username(); ?></span>
	<span class="activity"><?php bp_last_activity( bp_displayed_user_id() ); ?></span>

	<?php do_action( 'bp_before_member_header_meta' ); ?>

	<div id="item-meta">

		<?php if ( bp_is_active( 'activity' ) ) : ?>

			<div id="latest-update">

				<?php bp_activity_latest_update( bp_displayed_user_id() ); ?>

			</div>

		<?php endif; ?>

		<div id="item-buttons">
			<?php do_action( 'bp_member_header_actions' ); ?>
			<?php

			  // Loop through the profile fields
				if ( bp_has_profile() ) :
					while ( bp_profile_groups() ) :
						bp_the_profile_group();
						if ( bp_profile_group_has_fields() ) :

							// Only get the Social Networking fields
							if (bp_get_the_profile_group_name() == "Social Networking") :
								while ( bp_profile_fields() ) : bp_the_profile_field();
									if ( bp_field_has_data() ) :

										// Display Fields
										global $field;
										$name = $field->name;
										$value = $field->data->value = bp_unserialize_profile_field( $field->data->value );

										echo "<a href='".$value."' target='_blank'".bp_get_field_css_class('icon')." title='".$name."'><i></i></a>";

									endif;
								endwhile;
							endif;
						endif;
					endwhile;
				endif;
			?>
		</div><!-- #item-buttons -->

		<?php
		/***
		 * If you'd like to show specific profile fields here use:
		 * bp_member_profile_data( 'field=About Me' ); -- Pass the name of the field
		 */
		 do_action( 'bp_profile_header_meta' );

		 ?>

	</div><!-- #item-meta -->

</div><!-- #item-header-content -->

<?php do_action( 'bp_after_member_header' ); ?>

<?php do_action( 'template_notices' ); ?>