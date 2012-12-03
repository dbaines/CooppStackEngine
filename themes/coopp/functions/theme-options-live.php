<?php

/* ====================================================

	CO-OPP STACK ENGINE THEME
	Live Customiser

	View the changes you make to  your website
	live!

	http://ottopress.com/2012/how-to-leverage-the-theme-customizer-in-your-own-themes/
	https://gist.github.com/2968549
	http://abandon.ie/exploring-wordpress-theme-customizer/

==================================================== */

// Call our functions when the customiser is loaded
add_action( 'customize_register', 'coopp_customize' );
function coopp_customize($wp_customize){

	/* ================================================
		ANNOUNCEMENT
	================================================ */
	$wp_customize->add_section('coopp_announcements', array(
        'title'    		=> __('Announcement', 'coopp'),
        'priority' 		=> 150,
    ));

	/* Toggle */
	$wp_customize->add_setting( 'coopp_announcements[display]', array(
		'capability'    => 'edit_theme_options',
		'type'			=> 'option',
	) );
	$wp_customize->add_control( 'display_announcement', array(
		'settings' 		=> 'coopp_announcements[display]',
		'label'			=> __( 'Show announcement box?' ),
		'section'       => 'coopp_announcements',
		'type'			=> 'checkbox',
	) );

	/* Heading */
    $wp_customize->add_setting( 'coopp_announcements[heading]', array(
        'default'       => 'Welcome to the new Co-Opp!',
        'capability'    => 'edit_theme_options',
        'type'          => 'option',

    ) );
    $wp_customize->add_control( 'announcement_heading', array(
        'label'      	=> __('Heading', 'coopp'),
        'section'    	=> 'coopp_announcements',
        'settings'   	=> 'coopp_announcements[heading]',
    ) );

	/* Content */
	$wp_customize->add_setting( 'coopp_announcements[content]', array(
        'default'       => 'Announcement Text',
        'capability'    => 'edit_theme_options',
        'type'          => 'option',

    ) );
    $wp_customize->add_control( 'announcement_content', array(
        'label'      	=> __('Content', 'coopp'),
        'section'    	=> 'coopp_announcements',
        'settings'   	=> 'coopp_announcements[content]',
    ) );

	/* ================================================
		TEXT CUSTOMISATIONS
	================================================ */
	$wp_customize->add_section('coopp_text', array(
        'title'    		=> __('Text Customisations', 'coopp'),
        'priority'		=> 151,
    ));

	// View all upcoming stacks
    $wp_customize->add_setting( 'coopp_text[stack_upcoming]', array(
        'default'       => 'Be prepared, check out these future-stacks!',
        'capability'    => 'edit_theme_options',
        'type'          => 'option',

    ) );
    $wp_customize->add_control( 'text_stack_upcoming', array(
        'label'      	=> __('View all upcoming stacks', 'coopp'),
        'section'    	=> 'coopp_text',
        'settings'   	=> 'coopp_text[stack_upcoming]',
    ) );

    // View stack archive
    $wp_customize->add_setting( 'coopp_text[stack_archive]', array(
        'default'       => 'Why don\'t you live in the past some more.',
        'capability'    => 'edit_theme_options',
        'type'          => 'option',

    ) );
    $wp_customize->add_control( 'text_stack_past', array(
        'label'      	=> __('View past stacks', 'coopp'),
        'section'    	=> 'coopp_text',
        'settings'   	=> 'coopp_text[stack_archive]',
    ) );

    // Attend this stack button

    // Attend this stack button (already attending)

    // Leave stack button

    // Requested By text

    // Posted by text

    // Find out who's stacking text

    // IRL stack text

    // Footer text

	/* ================================================
		SETTINGS
	================================================ */
	$wp_customize->add_section('coopp_settings', array(
        'title'    		=> __('Website Settings', 'coopp'),
        'priority' 		=> 152,
    ));

	// Automatically add steam links to games that have a steamid
	$wp_customize->add_setting( 'coopp_settings[steam_show]', array(
		'capability'    => 'edit_theme_options',
		'type'			=> 'option',
	) );
	$wp_customize->add_control( 'show_steam_links', array(
		'settings' 		=> 'coopp_settings[steam_show]',
		'label'			=> __( 'Auto-add Steam store links to stacks that have a steamid assigned' ),
		'section'       => 'coopp_settings',
		'type'			=> 'checkbox',
	) );

	// Number of stacks per archive page
  $wp_customize->add_setting( 'coopp_settings[posts_per_page]', array(
      'default'       => '10',
      'capability'    => 'edit_theme_options',
      'type'          => 'option',

  ) );
  $wp_customize->add_control( 'posts_per_page', array(
      'label'      	=> __('Stacks per archive page', 'coopp'),
      'section'    	=> 'coopp_settings',
      'settings'   	=> 'coopp_settings[posts_per_page]',
  ) );

	// Ajax load more stacks or pagination
	$wp_customize->add_setting( 'coopp_settings[ajax_load]', array(
		'default' 		=> 'off',
		'capability'	=> 'edit_theme_options',
		'type'			=> 'option',
	) );
	$wp_customize->add_control( 'coopp_ajax_load', array(
		'label'			=> 'Pagination Style',
		'section'		=> 'coopp_settings',
		'settings'		=> 'coopp_settings[ajax_load]',
		'type'			=> 'radio',
		'choices'		=> array(
			'ajax'		=> 'Twitter-style AJAX loading',
			'pages'		=> 'Classic Pagination',
		),
	) );

	// Show permalinks

	/* ================================================
		SEO & SOCIAL NETWORKING
	================================================ */
	$wp_customize->add_section('coopp_seo', array(
        'title'    		=> __('SEO', 'coopp'),
        'priority' 		=> 153,
    ));

	// Facebook admins

	// Facebook appid

	// Google Analytics UA code
	$wp_customize->add_setting( 'coopp_seo[seo]', array(
        'default'       => 'UA-XXXX',
        'capability'    => 'edit_theme_options',
        'type'          => 'option',

    ) );
    $wp_customize->add_control( 'google_ua_code', array(
        'label'      	=> __('Google Analytics UA-Code', 'coopp'),
        'section'    	=> 'coopp_seo',
        'settings'   	=> 'coopp_seo[seo]',
    ) );

	// Meta Keywords

	// Meta Description

}

?>