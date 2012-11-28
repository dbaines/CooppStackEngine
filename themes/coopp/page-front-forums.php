<?php

/**
 * Template Name: bbPress - Forums (Index)
 *
 * @package bbPress
 * @subpackage Theme
 */

get_header(); ?>

		<div id="container">
			<div id="content" role="main">

				<?php do_action( 'bbp_template_notices' ); ?>

				<?php while ( have_posts() ) : the_post(); ?>

					<h2 class="page-title"><?php the_title(); ?></h2>
					<div id="forum-front" class="bbp-forum-front">
						<div class="entry-content">

							<?php the_content(); ?>

							<?php bbp_get_template_part( 'content', 'archive-forum' ); ?>

						</div>
					</div><!-- #forum-front -->

				<?php endwhile; ?>

			</div><!-- #content -->
		</div><!-- #container -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
