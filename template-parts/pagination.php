<?php
/**
 * The template for pagination
 */

$max_pages = $args['max_pages'] ?? $wp_query->max_num_pages;
if ( $max_pages < 2 ) return;

$paged = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;

$arrow_prev = '<svg class="pagination__icon" width="16" height="16" viewBox="0 0 16 16" fill="none"><path d="M10 12L6 8L10 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>';
$arrow_next = '<svg class="pagination__icon" width="16" height="16" viewBox="0 0 16 16" fill="none"><path d="M6 4L10 8L6 12" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>';

$pagination = paginate_links( array(
    'base'      => str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ),
    'total'     => $max_pages,
    'current'   => max( 1, $paged ),
    'type'      => 'array',
    'prev_text' => $arrow_prev,
    'next_text' => $arrow_next,
    'mid_size'  => 1,
    'end_size'  => 1,
) );

if ( ! $pagination ) return;
?>

<div class="pagination">
    <?php
    $container_opened = false;

    foreach ( $pagination as $link ) {
        $is_prev    = strpos( $link, 'prev' ) !== false;
        $is_next    = strpos( $link, 'next' ) !== false;
        $is_current = strpos( $link, 'current' ) !== false;
        $is_dots    = strpos( $link, 'dots' ) !== false;

        // Удаляем стандартный класс WP, чтобы он не мешался
        $link = str_replace( 'page-numbers', '', $link );

        if ( $is_prev ) {
            // Используем preg_replace с лимитом 1, чтобы не задеть SVG внутри
            echo preg_replace('/class=["\']/', 'class="pagination__arrow pagination__arrow--prev ', $link, 1);
        } 
        elseif ( $is_next ) {
            if ( $container_opened ) {
                echo '</div>';
                $container_opened = false;
            }
            echo preg_replace('/class=["\']/', 'class="pagination__arrow pagination__arrow--next ', $link, 1);
        } 
        else {
            if ( ! $container_opened ) {
                echo '<div class="pagination__pages">';
                $container_opened = true;
            }

            if ( $is_dots ) {
                echo '<span class="pagination__dots">...</span>';
            } else {
                $class = $is_current ? 'pagination__page pagination__page--active' : 'pagination__page';
                // Снова лимит 1, чтобы изменить только класс ссылки/спана
                echo preg_replace('/class=["\']/', 'class="' . $class . ' ', $link, 1);
            }
        }
    }

    if ( $container_opened ) echo '</div>';
    ?>
</div>