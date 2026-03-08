<?php
/**
 * Цикл вывода мероприятий
 *
 * @package rediez
 */
?>

<div class="events-catalog__items">

    <?php if ( have_posts() ) : ?>

        <?php while ( have_posts() ) : the_post(); ?>

            <?php get_template_part( 'template-parts/event/card-archive' ); ?>

        <?php endwhile; ?>

    <?php else : ?>

        <div class="events-catalog__empty">
            <?php if ( get_search_query() ) : ?>
                <p>
                    <?php
                    printf(
                        esc_html__( 'По запросу "%s" ничего не найдено. Попробуйте изменить критерии поиска.', 'rediez' ),
                        '<strong>' . esc_html( get_search_query() ) . '</strong>'
                    );
                    ?>
                </p>
            <?php else : ?>
                <p><?php esc_html_e( 'Мероприятия не найдены.', 'rediez' ); ?></p>
            <?php endif; ?>
        </div>

    <?php endif; ?>

</div>

<div class="events-catalog__pagination"></div>