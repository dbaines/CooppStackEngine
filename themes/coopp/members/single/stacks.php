<?php get_header( 'buddypress' ) ?>

	<div id="content" class="page-container">
		<div class="padder">

			<?php do_action( 'bp_before_member_home_content' ) ?>

			<div id="item-header" role="complementary">
				<?php locate_template( array( 'members/single/member-header.php' ), true ); ?>
			</div><!-- #item-header -->

			<div id="item-nav">
				<div class="item-list-tabs no-ajax" id="object-nav">
					<ul>
						<?php bp_get_displayed_user_nav() ?>
						<?php do_action( 'bp_member_options_nav' ) ?>
					</ul>
				</div>
			</div><!-- #item-nav -->

			<div id="item-body">
				<?php do_action( 'bp_before_member_body' );

					global $bp;

					// Set up our custom query of all stacks this member is going to
					$memberid =  $bp->displayed_user->id;
					$query_args = array(
						'post_type' => 'stack',
						'meta_key' => 'stack_users',
						'meta_value' => $memberid,
						'meta_compare' => 'IN',
						'orderby' => 'stack_date',
						'order' => 'asc'
					);
					$query = new WP_Query($query_args);

					// Echo out all the results
					if( $query->have_posts() ) :
						echo "<ul class='stacks'>";
						while ( $query->have_posts() ) : $query->the_post(); ?>
							<li class="stack" id="stack-<?php echo get_the_ID(); ?>"><?php echo stack_date(); ?> - <strong><a href="<?php echo the_permalink(); ?>"><?php echo the_title(); ?></strong></a></li>
						<?php endwhile;
						echo "</ul>";
					else : ?>
						<span class="noresults">This user is not attending any stacks</span>
					<?php endif;

				do_action( 'bp_after_member_body' ) ?>

			</div><!-- #item-body -->

			<?php do_action( 'bp_after_member_home_content' ) ?>

		</div><!-- .padder -->
	</div><!-- #content -->

	<?php get_sidebar( 'buddypress' ) ?>

<?php get_footer( 'buddypress' ) ?>