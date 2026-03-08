<?php
/**
 * Фильтрация и сортировка архивов
 *
 * @package rediez
 */

/**
 * Подменяем шаблон: если поиск по музыкантам, используем archive-rediez_musicians.php
 */
function rediez_musicians_search_template( $template ) {
    
    // Только для поиска на фронтенде
    if ( ! is_search() || is_admin() ) {
        return $template;
    }
    
    global $wp_query;
    
    // Проверяем: если результаты только музыканты
    $post_type = get_query_var( 'post_type' );
    
    if ( $post_type === 'rediez_musicians' || 
         ( isset( $wp_query->query['post_type'] ) && $wp_query->query['post_type'] === 'rediez_musicians' ) ) {
        
        // Ищем шаблон архива музыкантов
        $new_template = locate_template( array( 'archive-rediez_musicians.php' ) );
        
        if ( $new_template ) {
            return $new_template;
        }
    }
    
    return $template;
}
add_filter( 'template_include', 'rediez_musicians_search_template', 99 );

/**
 * Обработка поиска и сортировки для архива музыкантов
 */
function rediez_musicians_query_modifications( $query ) {
    
    if ( is_admin() || ! $query->is_main_query() ) {
        return;
    }
    
    // === ПОИСК ПО МУЗЫКАНТАМ ===
    if ( is_search() ) {
        
        // Проверяем referer (откуда пришёл пользователь)
        $referer = wp_get_referer();
        $from_musicians_archive = ( $referer && strpos( $referer, '/musicians/' ) !== false );
        
        // Если поиск с архива музыкантов - ограничиваем только музыкантами
        if ( $from_musicians_archive ) {
            $query->set( 'post_type', 'rediez_musicians' );
        }
    }
    
    // === АРХИВ МУЗЫКАНТОВ ИЛИ ПОИСК ПО НИМ ===
    if ( is_post_type_archive( 'rediez_musicians' ) || 
         ( is_search() && $query->get( 'post_type' ) === 'rediez_musicians' ) ) {
        
        // === СОРТИРОВКА ===
        if ( isset( $_GET['sort'] ) && ! empty( $_GET['sort'] ) ) {
            
            $sort = sanitize_text_field( $_GET['sort'] );
            
            switch ( $sort ) {
                
                case 'oldest':
                    $query->set( 'orderby', 'date' );
                    $query->set( 'order', 'ASC' );
                    break;
                
                case 'price_asc':
                case 'price_desc':
                    global $rediez_price_order;
                    $rediez_price_order = ( $sort === 'price_asc' ) ? 'ASC' : 'DESC';
                    add_filter( 'posts_orderby', 'rediez_custom_price_orderby', 10, 2 );
                    break;
            }
        }
        
        $query->set( 'posts_per_page', 12 );
    }
}
add_action( 'pre_get_posts', 'rediez_musicians_query_modifications' );

/**
 * Кастомная сортировка по цене с учётом постов без цены
 */
function rediez_custom_price_orderby( $orderby, $query ) {
    
    global $wpdb, $rediez_price_order;
    
    if ( ! $query->is_main_query() ) {
        return $orderby;
    }
    
    $order = isset( $rediez_price_order ) ? $rediez_price_order : 'ASC';
    
    if ( $order === 'ASC' ) {
        $orderby = "COALESCE(
            (SELECT CAST(meta_value AS UNSIGNED) 
             FROM {$wpdb->postmeta} 
             WHERE {$wpdb->postmeta}.post_id = {$wpdb->posts}.ID 
             AND {$wpdb->postmeta}.meta_key = '_crb_musician_price' 
             LIMIT 1
            ), 99999999
        ) ASC, {$wpdb->posts}.post_date DESC";
    } else {
        $orderby = "COALESCE(
            (SELECT CAST(meta_value AS UNSIGNED) 
             FROM {$wpdb->postmeta} 
             WHERE {$wpdb->postmeta}.post_id = {$wpdb->posts}.ID 
             AND {$wpdb->postmeta}.meta_key = '_crb_musician_price' 
             LIMIT 1
            ), 0
        ) DESC, {$wpdb->posts}.post_date DESC";
    }
    
    remove_filter( 'posts_orderby', 'rediez_custom_price_orderby', 10 );
    
    return $orderby;
}