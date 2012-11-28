<?php

/**
 * bbPress - Forum Archive
 *
 * @package bbPress
 * @subpackage Theme
 */

get_header(); ?>

		<div id="container">
			<div id="content" role="main">

				<?php do_action( 'bbp_template_notices' ); ?>


				<h2 class="page-title"><?php bbp_forum_archive_title(); ?></h2>
				<div id="forum-front" class="bbp-forum-front">
					<div class="entry-content">

						<?php bbp_get_template_part( 'content', 'archive-forum' ); ?>

					</div>
				</div><!-- #forum-front -->

			</div><!-- #content -->
		</div><!-- #container -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
