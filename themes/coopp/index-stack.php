<?php
/**
 * Template Name: Co-Opp Stack Homepage
 * Description: Shows the next stack, last stack and buttons to view future stacks and past stacks
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

		<div class="nextStack clearfix">

			<h2 class="sectionHead">Next Stack</h2>

			<?php

				// Set up our custom query of the next upcoming stack
				$query_args = array(
					'post_type' => 'stack',
					'meta_key' => 'stack_date',
					'meta_value' => strftime('%Y-%m-%d', time()),
					'meta_compare' => '>=',
					'posts_per_page' => 1
				);
				$query = new WP_Query($query_args);

				// The loop
				if( $query->have_posts() ) :
					while ( $query->have_posts() ) : $query->the_post();
						get_template_part('stacks/bigstack');
					endwhile;
				else : ?>
					<span class="noresults">Sorry, no upcoming stacks :(</span>
				<?php endif;

			?>

			<a href="future-stacks" class="ctaBlue"><?php $options = get_option('coopp_text'); echo $options['stack_upcoming']; ?></a>

		</div>

		<div class="pastStacks clearfix">

			<h2 class="sectionHead">Past Stacks</h2>
			<div class="stacks">
			<?php

				// Set up our custom query of the last previous stack
				$query_args = array(
					'post_type' => 'stack',
					'meta_key' => 'stack_date',
					'meta_value' => strftime('%Y-%m-%d', time()),
					'meta_compare' => '<',
					'posts_per_page' => 1
				);
				$query = new WP_Query($query_args);

				// The loop
				if( $query->have_posts() ) :
					while ( $query->have_posts() ) : $query->the_post();
						get_template_part('stacks/shortstack');
					endwhile;
				else : ?>
					<span class="noresults">Sorry, no past stacks :(</span>
				<?php endif;

			?>
			</div>
			<a href="past-stacks" class="ctaBlue"><?php $options = get_option('coopp_text'); echo $options['stack_archive']; ?></a>

		</div>
		
<?php get_footer(); ?>