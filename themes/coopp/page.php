<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 * @since Twenty Eleven 1.0
 */

get_header(); ?>

		<div id="primary">
			<?php while ( have_posts() ) : the_post(); ?>
				<h2 class="page-title"><?php the_title(); ?></h2>
				<div id="content" role="main" class="page-container">
					<?php get_template_part( 'content', 'page' ); ?>
				</div><!-- #content -->
			<?php endwhile; // end of the loop. ?>
		</div><!-- #primary -->

<?php get_footer(); ?>