<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>

	<?php // META TAGS ?>

	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0;">
	<meta name="author" content="Co-Opp.net" />
	<meta name="description" content="Co-Opp.net, stacking games since games could be stacked." />
	<meta name="keywords" content="stacking games, australian gaming community" />

	<?PHP // THE TITLE ?>

	<title><?php
		/*
		 * Print the <title> tag based on what is being viewed.
		 */
		global $page, $paged;

		wp_title( '|', true, 'right' );

		// Add the blog name.
		bloginfo( 'name' );

		// Add the blog description for the home/front page.
		$site_description = get_bloginfo( 'description', 'display' );
		if ( $site_description && ( is_home() || is_front_page() ) )
			echo " | $site_description";

		// Add a page number if necessary:
		if ( $paged >= 2 || $page >= 2 )
			echo ' | ' . sprintf( __( 'Page %s', 'twentyeleven' ), max( $paged, $page ) );

		?></title>

	<?php // LINKS & STYLESHEETS ?>

	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="stylesheet" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
	<link rel="shortcut icon" href="<?php bloginfo( 'url' ); ?>/favicon.ico" />
	<link rel="apple-touch-icon" href="<?php bloginfo( 'url' ); ?>/apple.png" />
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,400,700,600,800' rel='stylesheet' type='text/css'>

	<?php // IMPORTANT JAVASCRIPTS IN HEADER, VIP STATUS ?>

	<script src="<?php bloginfo( 'template_url' ); ?>/js/modernizr.js"></script>

	<?php // FEEDS ?>

	<link href="<?php echo stack_feed_url(); ?>" rel='alternate' type='application/atom+xml' title='Co-Opp.net Stack Feed' />
	<link href="<?php bloginfo('comments_rss2_url'); ?>" rel="alternate" type="application/atom+xml" title="Co-Opp.net Comments" />

	<?php // SOCIAL SHARE ICONS
		// if you're on a single post, use the featured image 
		// otherwise, fall back to a generic co-opp image 

		if(is_single() && has_post_thumbnail()){
			$thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'thumbnail' );
			$thumbnail = $thumbnail[0];
			
			// Facebook thumbnail
			echo "<meta property='og:image' content='".$thumbnail."' />";

			// Everywhere else
			echo "<link rel='image_src' href='".$thumbnail."' />";

		}

	?>

	<?php // MORE SOCIAL NETWORKING STUFF ?>

	<meta property="og:type" content="" />
	<meta property="og:site_name" content="" />
	<meta property="fb:admins" content="" />
	<meta property="fb:app_id" content="" />

	<?php // WORDPRESS STUFF
		if ( is_singular() && get_option( 'thread_comments' ) )
			wp_enqueue_script( 'comment-reply' );
		wp_head();
	?>
</head>

<body <?php body_class(); ?>>

	<header class="header header-large static clearfix">
		<div class="cFull">
			<a class="logo ir" href="<?php echo bloginfo("url"); ?>"><h1>Co-Opp</h1></a>

			<?php if( is_user_logged_in() ) { ?>

				<div class="userinfo">
					<?php 
						$notifications = bp_core_get_notifications_for_user( bp_loggedin_user_id(), 'object' );
						$messages = !empty( $notifications ) ? count( $notifications ) : 0;
						if( $messages == 1 ) {$messageverb = "message";} else {$messageverb = "messages";} 
					?>
					<a class="userinfo-messages <?php if( $messages > 0 ){echo "new";}?>" href="<?php echo bp_loggedin_user_domain() ?>messages" title="<?php echo $messages; ?> new <?php echo $messageverb; ?>">
						<?php echo $messages; ?>
					</a>
					<a class="userinfo-name" href="<?php echo bp_loggedin_user_domain(); ?>" title="View Your Profile">
						<?php bp_loggedin_user_avatar( 'type=thumb&width=22&height=22' ); ?>
						<?php echo get_user_meta(get_current_user_id(), 'nickname', true ); ?>
					</a>
					<a class="userinfo-settings ir" href="<?php echo bp_loggedin_user_domain(); ?>settings" title="Your Settings">Settings</a>
					<a class="userinfo-logout ir" href="<?php echo wp_logout_url( wp_guess_url() ); ?>" title="Log Out">Log out</a>
				</div>

			<?php } else { ?>

				<form action="<?php echo get_option('home'); ?>/wp-login.php" method="post" class="login">
					<div class="loginFields">
						<input type="text" name="log" id="log" value="<?php echo wp_specialchars(stripslashes($user_login), 1) ?>" size="20" />
						<input type="password" name="pwd" id="pwd" />
						<input type="hidden" name="redirect_to" value="<?php echo $_SERVER['REQUEST_URI']; ?>" />
					</div>
					<div class="loginActions">
						<input type="submit" value="Login" />
						<span><a href="<?php echo get_bloginfo('url'); ?>/register">Register</a> | <a href="<?php echo get_bloginfo('url'); ?>/wp-login.php?action=lostpassword">Password Recovery</a>
					</div>
				</form>

			<?php } ?>

		</div>
	</header>

	<section class="navigation clearfix">
		<div class="cFull">
			<?php wp_nav_menu( array( 'container' => false, 'menu_id' => 'nav', 'theme_location' => 'primary', 'fallback_cb' => 'bp_dtheme_main_nav' ) ); ?>
		</div>
	</section>

	<section class="pagebg clearfix">
		<?php get_template_part( 'announcement' ); ?>
		<div class="cFull">
