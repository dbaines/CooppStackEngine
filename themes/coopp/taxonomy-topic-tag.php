<?php

/**
 * Topic Tag
 *
 * @package bbPress
 * @subpackage Theme
 */

get_header(); ?>

		<div id="container">
			<div id="content" role="main">

				<?php do_action( 'bbp_template_notices' ); ?>

				<h2 class="page-title"><?php printf( __( 'Topic Tag: %s', 'bbpress' ), '<span>' . bbp_get_topic_tag_name() . '</span>' ); ?></h2>
				<div id="topic-tag" class="bbp-topic-tag">

					<div class="entry-content">

						<?php bbp_breadcrumb(); ?>

						<?php bbp_topic_tag_description(); ?>

						<?php do_action( 'bbp_template_before_topic_tag' ); ?>

						<?php if ( bbp_has_topics() ) : ?>

							<?php bbp_get_template_part( 'pagination', 'topics'    ); ?>

							<?php bbp_get_template_part( 'loop',       'topics'    ); ?>

							<?php bbp_get_template_part( 'pagination', 'topics'    ); ?>

						<?php else : ?>

							<?php bbp_get_template_part( 'feedback',   'no-topics' ); ?>

						<?php endif; ?>

						<?php do_action( 'bbp_template_after_topic_tag' ); ?>

					</div>
				</div><!-- #topic-tag -->
			</div><!-- #content -->
		</div><!-- #container -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
