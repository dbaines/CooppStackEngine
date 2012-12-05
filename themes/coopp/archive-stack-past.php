<?php
/**
 * Template Name: Archives - Past Stacks
 * Description: Shows all stacks that have already taken place
 */

get_header(); ?>

	<div id="primary">
		<div class="pastStacks clearfix">

			<div class="archiveTabs clearfix">
				<a href="/future-stacks">Future Stacks</a>
				<a href="/past-stacks" class="current">Past Stacks</a>
				<a href="/stack">All Stacks</a>
			</div>

			<div class="page-container">
				<?php while ( have_posts() ) : the_post(); ?>
					<?php the_content(); ?>
				<?php endwhile; ?>
			</div>

			<?php

				// Set up our custom query of the next upcoming stack
				$options = get_option('coopp_settings');
				$query_args = array(
					'posts_per_page' => $options['posts_per_page'],
					'post_type' => 'stack',
					'meta_key' => 'stack_date',
					'meta_value' => strftime('%Y-%m-%d', time()),
					'meta_compare' => '<',
					'paged' => get_query_var('paged') ? get_query_var('paged') : 1
				);
				$query = new WP_Query($query_args);

				// The loop
				if( $query->have_posts() ) :
					echo "<div class='stack-container'>";
					while ( $query->have_posts() ) : $query->the_post();
						get_template_part('stacks/shortstack');
					endwhile; wp_reset_query();
					echo "</div>";
				else : ?>
					<span class="noresults">There haven't been any past stacks. </span>
				<?php endif;
				get_template_part('stack-navigation');

			?>

		</div>
	</div>

<?php get_footer(); ?>