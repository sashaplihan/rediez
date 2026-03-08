<?php
/**
 * Заголовок архива мероприятий
 *
 * @package rediez
 */

global $wp_query;
$total        = $wp_query->found_posts;
$search_query = get_search_query();
?>

<div class="events-catalog__header">

    <?php if ( $search_query ) : ?>

        <h1 class="events-catalog__title title">
            <?php
            printf(
                esc_html__( 'Результаты поиска: %s', 'rediez' ),
                '<span>' . esc_html( $search_query ) . '</span>'
            );
            ?>
        </h1>

    <?php else : ?>

        <h1 class="events-catalog__title title">
            <?php
            if ( is_post_type_archive() ) {
                post_type_archive_title();
            } else {
                esc_html_e( 'Мероприятия', 'rediez' );
            }
            ?>
        </h1>

    <?php endif; ?>

    <?php if ( $total ) : ?>
        <p class="events-catalog__count">
            <?php
            printf(
                _n( 'Найдено %s мероприятие', 'Найдено %s мероприятий', $total, 'rediez' ),
                '<strong>' . number_format_i18n( $total ) . '</strong>'
            );
            ?>
        </p>
    <?php endif; ?>

</div>