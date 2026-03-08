<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Перемещение Админ-бара вниз через WordPress API
 */
function modern_move_admin_bar_to_bottom() {
    
    if ( ! is_admin_bar_showing() ) {
        return;
    }

    remove_action( 'wp_head', '_admin_bar_bump_cb' );

    wp_register_style( 'admin-bar-bottom-fix', false );

    $custom_css = '
        html { margin-bottom: 32px !important; }
        * html body { margin-bottom: 32px !important; }
        #wpadminbar { top: auto !important; bottom: 0; }
        #wpadminbar .menupop .ab-sub-wrapper { bottom: 32px; box-shadow: 2px -2px 5px rgba(0,0,0,.2); }
        @media screen and (max-width: 782px) {
            html { margin-bottom: 46px !important; }
            #wpadminbar .menupop .ab-sub-wrapper { bottom: 46px; }
        }
    ';
    
    wp_add_inline_style( 'admin-bar-bottom-fix', $custom_css );

    wp_enqueue_style( 'admin-bar-bottom-fix' );
}

add_action( 'wp_enqueue_scripts', 'modern_move_admin_bar_to_bottom' );