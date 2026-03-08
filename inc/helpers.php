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