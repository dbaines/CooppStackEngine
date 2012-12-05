<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 */
get_header(); ?>

	<div id="primary">
		<div class="nextStack clearfix">

			<h2 class="sectionHead">Next Stack</h2>

		<?php if ( have_posts() ) : ?>

			<?php /* Start the Loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>
				<?php // get_template_part( 'content', get_post_format() ); ?>
			<?php endwhile; ?>

		<?php else : ?>

			<span class="noresults">Sorry, no results</span>

		<?php endif; ?>

			<a href="#" class="ctaBlue"><?php $options = get_option('coopp_text'); echo $options['stack_upcoming']; ?></a>

		</div>

		<div class="pastStacks clearfix">

			<h2 class="sectionHead">Past Stacks</h2>
			<?php // include("stacks/shortstack.php"); ?>
			<a href="#" class="ctaBlue"><?php $options = get_option('coopp_text'); echo $options['stack_archive']; ?></a>

		</div>
	</div>

<?php get_footer(); ?>