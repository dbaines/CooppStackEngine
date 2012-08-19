<?php

// Disable self-trackbacks
// http://wp-snippets.com/disable-self-trackbacks/
function disable_self_ping( &$links ) {
    foreach ( $links as $l => $link )
        if ( 0 === strpos( $link, get_option( 'home' ) ) )
            unset($links[$l]);
}
add_action( 'pre_ping', 'disable_self_ping' );

