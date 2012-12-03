<?php
/**
 * Template Name: Archives - Future Stacks
 * Description: Shows all stacks that haven't taken place yet
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * http://codex.wordpress.org/Displaying_Posts_Using_a_Custom_Select_Query
 */

get_header(); ?>

	<div id="primary">
		<div class="futureStacks clearfix">

			<div class="archiveTabs clearfix">
				<a href="../future-stacks" class="current">Future Stacks</a>
				<a href="../past-stacks">Past Stacks</a>
				<a href="../stack">All Stacks</a>
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
					'post_type' => 'stack',
					'meta_key' => 'stack_date',
					'meta_value' => strftime('%Y-%m-%d', time()),
					'meta_compare' => '>=',
					'posts_per_page' => $options['posts_per_page'],
					'paged' => get_query_var('paged') ? get_query_var('paged') : 1
				);
				$query = new WP_Query($query_args);

				// The loop
				if( $query->have_posts() ) :
					while ( $query->have_posts() ) : $query->the_post();
						get_template_part('stacks/bigstack');
					endwhile;
				else : ?>
					<span class="noresults">Sorry, there are no upcoming stacks.</span>
				<?php endif;
				get_template_part('stack-navigation');

			?>

		</div>
	</div>

<?php get_footer(); ?>