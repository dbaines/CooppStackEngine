<?php

add_action( 'add_meta_boxes', 'addbox_coopp_shortcodes' );
function addbox_coopp_shortcodes(){
	add_meta_box(
		'coopp_shortcodes_helper',
		__( 'Shortcodes Reference' ),
		'coopp_shortcodes_content',
		'stack'
	);
}

// This function echoes the content of our meta box
function coopp_shortcodes_content() {
?>

A run down of shortcodes available will appear here

<div style="clear:both;"></div>

<?php 
}