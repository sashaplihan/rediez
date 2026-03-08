<?php
/**
 * Цикл вывода музыкантов
 *
 * @package rediez
 */
?>

<div class="musicians-catalog__items">
    
    <?php if ( have_posts() ) : ?>
        
        <?php while ( have_posts() ) : the_post(); ?>
            
            <?php get_template_part( 'template-parts/musician/card-archive' ); ?>
            
        <?php endwhile; ?>
        
    <?php else : ?>
        
        <div class="musicians-catalog__empty">
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
                <p><?php esc_html_e( 'Музыканты не найдены.', 'rediez' ); ?></p>
            <?php endif; ?>
        </div>
        
    <?php endif; ?>
    
</div>

<?php
/*
 * Контейнер пагинации:
 * - При первой загрузке страницы PHP рендерит пагинацию внутри
 * - После AJAX-запроса musicians-filters.js перезаписывает содержимое
 */
?>
<div class="musicians-catalog__pagination"></div>