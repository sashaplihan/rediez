<?php
/**
 * Счётчик просмотров
 */
function rediez_set_post_views($postID) {
    $count_key = 'rediez_post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if ($count == '') {
        $count = 0;
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
    } else {
        $count++;
        update_post_meta($postID, $count_key, $count);
    }
}

function rediez_get_post_views($postID) {
    $count_key = 'rediez_post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if ($count == '') {
        return "0";
    }
    return $count;
}


/**
 * Разрешаем протокол viber:// для функции esc_url
 */
add_filter( 'kses_allowed_protocols', function ( $protocols ) {
    $protocols[] = 'viber';
    return $protocols;
} );

if ( ! function_exists( 'rediez_get_youtube_embed_url' ) ) {
    function rediez_get_youtube_embed_url( $url ) {
        
        if ( empty( $url ) ) {
            return '';
        }
        
        // YouTube Shorts: youtube.com/shorts/VIDEO_ID
        if ( preg_match( '/youtube\.com\/shorts\/([^"&?\/\s]{10,12})/i', $url, $matches ) ) {
            return 'https://www.youtube.com/embed/' . $matches[1];
        }
        
        // Стандартные форматы: watch?v=, youtu.be/, embed/
        if ( preg_match( '/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{10,12})/i', $url, $matches ) ) {
            return 'https://www.youtube.com/embed/' . $matches[1];
        }
        
        return '';
    }
}