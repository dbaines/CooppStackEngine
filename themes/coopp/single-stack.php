<?php
/**
 * The Template for displaying all single posts.
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 * @since Twenty Eleven 1.0
 */

get_header(); ?>

		<div class="singleStack">

				<?php while ( have_posts() ) : the_post(); ?>

					<?php include("stacks/bigstack.php"); ?>
					<?php comments_template( '', true ); ?>

				<?php endwhile; // end of the loop. ?>
				
		</div><!-- #primary -->

<?php get_footer(); ?>