<?php
/**
 * AJAX-обработчик фильтров музыкантов
 *
 * Carbon Fields хранит set-поля по одной строке на значение:
 * meta_key: _crb_musician_genre|||0|value
 * meta_value: pop
 *
 * @package rediez
 */

add_action( 'wp_ajax_filter_musicians',        'rediez_ajax_filter_musicians' );
add_action( 'wp_ajax_nopriv_filter_musicians', 'rediez_ajax_filter_musicians' );

function rediez_ajax_filter_musicians() {

    check_ajax_referer( 'musicians_filter_nonce', 'nonce' );

    // === Получаем параметры ===
    $price_min  = isset( $_POST['price_min'] ) ? intval( $_POST['price_min'] ) : 0;
    $price_max  = isset( $_POST['price_max'] ) ? intval( $_POST['price_max'] ) : 50000;
    $sort       = isset( $_POST['sort'] )       ? sanitize_text_field( $_POST['sort'] ) : '';
    $search     = isset( $_POST['search'] )     ? sanitize_text_field( $_POST['search'] ) : '';
    $paged      = isset( $_POST['paged'] )      ? intval( $_POST['paged'] ) : 1;
    $travel     = isset( $_POST['travel'] )     ? sanitize_text_field( $_POST['travel'] ) : '';

    $events     = isset( $_POST['event'] )      ? array_map( 'sanitize_text_field', (array) $_POST['event'] )     : array();
    $formats    = isset( $_POST['format'] )     ? array_map( 'sanitize_text_field', (array) $_POST['format'] )    : array();
    $genres     = isset( $_POST['genre'] )      ? array_map( 'sanitize_text_field', (array) $_POST['genre'] )     : array();
    $performers = isset( $_POST['performer'] )  ? array_map( 'sanitize_text_field', (array) $_POST['performer'] ) : array();
    $lineups    = isset( $_POST['lineup'] )     ? array_map( 'sanitize_text_field', (array) $_POST['lineup'] )    : array();
    $locations  = isset( $_POST['location'] )   ? array_map( 'sanitize_text_field', (array) $_POST['location'] )  : array();

    // === Собираем set-фильтры ===
    $set_filters = array(
        '_crb_musician_event_types'        => $events,
        '_crb_musician_performance_format' => $formats,
        '_crb_musician_genre'              => $genres,
        '_crb_musician_performer_type'     => $performers,
        '_crb_musician_lineup'             => $lineups,
        '_crb_musician_location'           => $locations,
    );

    // Фильтруем только активные (непустые)
    $active_set_filters = array_filter( $set_filters, function( $v ) { return ! empty( $v ); } );

    // === meta_query для цены и travel ===
    $meta_query = array( 'relation' => 'AND' );

    // Цена
    $price_is_default = ( $price_min === 0 && $price_max === 50000 );
    if ( ! $price_is_default ) {
        $meta_query[] = array(
            'key'     => '_crb_musician_price',
            'value'   => array( $price_min, $price_max ),
            'type'    => 'NUMERIC',
            'compare' => 'BETWEEN',
        );
    }

    // Готовность к выездам
    if ( $travel === 'yes' ) {
        $meta_query[] = array(
            'key'     => '_crb_musician_travel',
            'value'   => 'yes',
            'compare' => '=',
        );
    }

    // === Сортировка ===
    $orderby       = 'date';
    $order         = 'DESC';
    $meta_key_sort = '';

    switch ( $sort ) {
        case 'oldest':
            $order = 'ASC';
            break;
        case 'price_asc':
            $meta_key_sort = '_crb_musician_price';
            $orderby       = 'meta_value_num';
            $order         = 'ASC';
            break;
        case 'price_desc':
            $meta_key_sort = '_crb_musician_price';
            $orderby       = 'meta_value_num';
            $order         = 'DESC';
            break;
    }

    // === Строим WP_Query ===
    $args = array(
        'post_type'      => 'rediez_musicians',
        'post_status'    => 'publish',
        'posts_per_page' => 12,
        'paged'          => $paged,
        'orderby'        => $orderby,
        'order'          => $order,
    );

    if ( count( $meta_query ) > 1 ) {
        $args['meta_query'] = $meta_query;
    }

    if ( $search ) {
        $args['s'] = $search;
    }

    if ( $meta_key_sort ) {
        $args['meta_key'] = $meta_key_sort;
    }

    // === Кастомный SQL для set-фильтров через posts_where + posts_join ===
    if ( ! empty( $active_set_filters ) ) {

        // Передаём фильтры в замыкание через use
        $filter_data = $active_set_filters;

        $join_fn = function( $join ) use ( $filter_data ) {
            global $wpdb;
            $i = 0;
            foreach ( $filter_data as $meta_key => $values ) {
                $alias = 'cfm_' . $i;
                $join .= " INNER JOIN {$wpdb->postmeta} AS {$alias} ON ({$wpdb->posts}.ID = {$alias}.post_id)";
                $i++;
            }
            return $join;
        };

        $where_fn = function( $where ) use ( $filter_data ) {
            global $wpdb;
            $i = 0;
            foreach ( $filter_data as $meta_key => $values ) {
                $alias = 'cfm_' . $i;

                // Ключ LIKE '_crb_musician_genre%'
                $key_like = $wpdb->esc_like( $meta_key ) . '%';

                // Значения: IN ('pop', 'rock')
                $escaped_values = array_map( function( $v ) use ( $wpdb ) {
                    return $wpdb->prepare( '%s', $v );
                }, $values );

                $values_in = implode( ', ', $escaped_values );

                $where .= $wpdb->prepare(
                    " AND ({$alias}.meta_key LIKE %s AND {$alias}.meta_value IN ({$values_in}))",
                    $key_like
                );

                $i++;
            }
            return $where;
        };

        $distinct_fn = function( $distinct ) {
            return 'DISTINCT';
        };

        add_filter( 'posts_join',     $join_fn );
        add_filter( 'posts_where',    $where_fn );
        add_filter( 'posts_distinct', $distinct_fn );
    }

    $query = new WP_Query( $args );

    // Убираем фильтры после запроса
    if ( ! empty( $active_set_filters ) ) {
        remove_filter( 'posts_join',     $join_fn );
        remove_filter( 'posts_where',    $where_fn );
        remove_filter( 'posts_distinct', $distinct_fn );
    }

    ob_start();

    if ( $query->have_posts() ) {
        while ( $query->have_posts() ) {
            $query->the_post();
            get_template_part( 'template-parts/musician/card-archive' );
        }
        wp_reset_postdata();
    } else {
        echo '<div class="musicians-catalog__empty"><p>Музыканты не найдены. Попробуйте изменить параметры фильтра.</p></div>';
    }

    $html = ob_get_clean();

    wp_send_json_success( array(
        'html'        => $html,
        'found_posts' => $query->found_posts,
        'max_pages'   => $query->max_num_pages,
        'paged'       => $paged,
    ) );
}