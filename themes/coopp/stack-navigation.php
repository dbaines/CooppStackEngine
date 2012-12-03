<?php
	// Stack Navigation
	// navigation can change depending on customisation settings on theme

	// Load custom post type max_num_pages
	// http://wpseek.com/blog/2011/custom-post-type-pagination/89/
	global $wp_query, $query;
	$clone_page_total = $wp_query->max_num_pages;
	$wp_query->max_num_pages = $query->max_num_pages;

	// check if pagination is necessary
	global $wp_query;
	if ( $wp_query->max_num_pages > 1 ) :

		// get theme settings
		$options = get_option('coopp_settings');
		$ajaxload = $options['ajax_load'];

		// Check if we should be doing ajax stuff
		if($ajaxload == "ajax"){ ?>

			<nav class="ajax-pagination">
				<?php // check if we are on the last page
				if ( $wp_query->max_num_pages == get_query_var('paged') ) : ?>
					<a class="disabled" title="No more stacks to load">No more stacks to load.</a>
				<?php else :
					next_posts_link( __( 'Load More Stacks', 'twentyten' ) );
				endif; ?>
			</nav>
		<?php
		// If we shouldn't be doing ajax stuff, do regular pagination instead, bro.
		} else { ?>

				<nav class="classic-pagination">
					<div class="nav-previous"><?php previous_posts_link(); ?></div>
					<div class="nav-next"><?php next_posts_link(); ?></div>
				</nav><!-- #nav-above -->

		<?php }
	endif;

	// Reset wp_query->max_num_pages back to what it was
	// http://wpseek.com/blog/2011/custom-post-type-pagination/89/
	$wp_query->max_num_pages = $clone_page_total;