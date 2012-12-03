<?php

add_action( 'init', 'register_cpt_stack' );

function register_cpt_stack() {

    $labels = array(
		'name'               => _x( 'Stacks', 'stack' ),
		'singular_name'      => _x( 'Stack', 'stack' ),
		'add_new'            => _x( 'Add New Stack', 'stack' ),
		'add_new_item'       => _x( 'Add New Stack', 'stack' ),
		'edit_item'          => _x( 'Edit Stack', 'stack' ),
		'new_item'           => _x( 'New Stack', 'stack' ),
		'view_item'          => _x( 'View Stack', 'stack' ),
		'search_items'       => _x( 'Search Stacks', 'stack' ),
		'not_found'          => _x( 'No Stacks found', 'stack' ),
		'not_found_in_trash' => _x( 'No Stacks found in Trash', 'stack' ),
		'parent_item_colon'  => _x( 'Parent Stack:', 'stack' ),
		'menu_name'          => _x( 'Stacks', 'stack' ),
    );

    $args = array(
		'labels'              => $labels,
		'hierarchical'        => true,
		'description'         => 'description',
		'taxonomies'          => array( 'category' ),
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'menu_position'       => 5,
		//'menu_icon'         => '',
		'show_in_nav_menus'   => true,
		'publicly_queryable'  => true,
		'exclude_from_search' => false,
		'has_archive'         => true,
		'query_var'           => true,
		'can_export'          => true,
		'rewrite'             => true,
		'capability_type'     => 'post',
		'supports'            => array( 'title', 'editor', 'author', 'thumbnail', 'custom-fields', 'trackbacks', 'comments', 'revisions', 'page-attributes', 'post-formats' ),
    );

    register_post_type( 'stack', $args );

}