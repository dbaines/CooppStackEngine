<?php
/**
 * The template for displaying Archive pages.
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 * @since Twenty Eleven 1.0
 */

get_header(); ?>

		<section id="primary">
			<div id="content" role="main">

			<div class="archiveTabs clearfix">
				<a href="/future-stacks">Future Stacks</a>
				<a href="/past-stacks">Past Stacks</a>
				<a href="/stack" class="current">All Stacks</a>
			</div>

			<?php

				// Set up our custom query of the next upcoming stack
				$options = get_option('coopp_settings');
				$query_args = array(
					'post_type' => 'stack',
					'meta_key' => 'stack_date',
					'orderby' => 'stack_date',
					'order' => 'DESC',
					'posts_per_page' => $options['posts_per_page'],
					'paged' => get_query_var('paged') ? get_query_var('paged') : 1
				);
				$query = new WP_Query($query_args);

				// The loop
				if( $query->have_posts() ) :
					while ( $query->have_posts() ) : $query->the_post();
						echo "<div class='stack-container'>";
						get_template_part('stacks/shortstack');
						echo "</div>";
					endwhile;
				else : ?>
					<span class="noresults">According to our very accurate statistics, there have never ever actually been any stacks. That shit is whack, yo. </span>
				<?php endif;
				get_template_part('stack-navigation');

			?>

			</div><!-- #content -->
		</section><!-- #primary -->

<?php get_footer(); ?>