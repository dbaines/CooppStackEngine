<?php
/**
 * Template Name: Stack Request Form
 * Description: A form to enable users to request stacks
 */

get_header(); ?>

	<div id="primary">
		<?php while ( have_posts() ) : the_post(); ?>
			<h2 class="page-title"><?php the_title(); ?></h2>
			<div id="content" role="main" class="page-container">
				<?php get_template_part( 'content', 'page' ); ?>
				<?php echo renderStackForm(); ?>
			</div><!-- #content -->
		<?php endwhile; // end of the loop. ?>
	</div><!-- #primary -->

<?php get_footer(); ?>