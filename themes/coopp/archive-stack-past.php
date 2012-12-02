<?php
/**
 * Template Name: Archives - Past Stacks
 * Description: Shows all stacks that have already taken place
 */

get_header(); ?>

	<div id="primary">
		<div class="pastStacks clearfix">

			<div class="archiveTabs clearfix">
				<a href="../future-stacks">Future Stacks</a>
				<a href="../past-stacks" class="current">Past Stacks</a>
				<a href="../stack">All Stacks</a>
			</div>

			<div class="page-container">
				<?php while ( have_posts() ) : the_post(); ?>
					<?php the_content(); ?>
				<?php endwhile; ?>
			</div>

			<?php

				// Set up our custom query of the next upcoming stack
				$query_args = array(
					'post_type' => 'stack',
					'meta_key' => 'stack_date',
					'meta_value' => strftime('%Y-%m-%d', time()),
					'meta_compare' => '<'
				);
				$query = new WP_Query($query_args);

				// The loop
				if( $query->have_posts() ) :
					while ( $query->have_posts() ) : $query->the_post();
						get_template_part('stacks/shortstack');
					endwhile;
				else : ?>
					<span class="noresults">There haven't been any past stacks. </span>
				<?php endif;

			?>

			stack navigation

		</div>
	</div>

<?php get_footer(); ?>