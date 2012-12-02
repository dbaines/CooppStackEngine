<?php

/**
 * Single View
 *
 * @package bbPress
 * @subpackage Theme
 */

get_header(); ?>

		<div id="container">
			<div id="content" role="main">

				<?php do_action( 'bbp_template_notices' ); ?>

				<h2 class="page-title"><?php bbp_view_title(); ?></h2>
				<div id="bbp-view-<?php bbp_view_id(); ?>" class="bbp-view">
					<div class="entry-content">

						<?php bbp_get_template_part( 'content', 'single-view' ); ?>

					</div>
				</div><!-- #bbp-view-<?php bbp_view_id(); ?> -->

			</div><!-- #content -->
		</div><!-- #container -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>