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
					?>

					<div class="item-list-tabs no-ajax" id="subnav" role="navigation">
						<ul>

							<?php bp_get_options_nav(); ?>

						</ul>
					</div>
					<?php

					// Set up our custom query of all stacks this member is going to
					$memberid =  $bp->displayed_user->id;
					$query_args = array(
						'post_type' => 'stack',
						'meta_key' => 'stack_requestedby',
						'meta_value' => $memberid,
						'meta_compare' => 'IN',
						'orderby' => 'stack_date',
						'order' => 'DESC'
					);
					$query = new WP_Query($query_args);

					// Cool little zebra-striping snippet
					// http://css-tricks.com/snippets/php/php-zebra-striping-a-table/
					$c = 0;

					// Echo out all the results
					if( $query->have_posts() ) :
						echo "<div class='stacks-list bp-stack-list'>";
						while ( $query->have_posts() ) : $query->the_post(); ?>

							<div class="stack clearfix bp-stack <?php echo ($c++%2==1) ? "alt" : "" ?>" id="stack-<?php echo get_the_ID(); ?>">
								<div class="stack-avatar">
									<a href="<?php echo the_permalink(); ?>"><img src="<?php echo stack_art_small(); ?>"></a>
								</div>
								<div class="stack-details">
									<strong><a href="<?php echo the_permalink(); ?>"><?php echo the_title(); ?></a></strong>
									<span class="time"><?php echo date( 'l, jS F Y', strtotime( stack_date() ) ) . " at " . stack_time(); ?></span>
									<span class="people"><?php echo coopp_membercount(); ?></span>
								</div>
							</div>

						<?php endwhile;
						echo "</div>";
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