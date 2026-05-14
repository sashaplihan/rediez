<?php
/**
 * Template Name: Страница без заголовка
 */

get_header();
?>

<div class="page-content no-banner">
    <?php
    while ( have_posts() ) :
        the_post();
        ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <div class="container">
                <div class="row">
                    <div class="entry-content">
                        <?php
                        the_content();

                        // Позволяет выводить постраничную навигацию внутри контента, если используется <!--nextpage-->
                        wp_link_pages(
                            array(
                                'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'rediez' ),
                                'after'  => '</div>',
                            )
                        );
                        ?>
                    </div>

                    <div class="registration-success">
                        <div id="um-mail-redirect-container" class="registration-success__action" style="display: none;">
                            <a href="#" id="um-mail-redirect-btn" class="registration-success__btn hero_link btn--primary" target="_blank" rel="noopener noreferrer"></a>
                        </div>
                    </div>

                    <?php if ( get_edit_post_link() ) : ?>
                        <footer class="entry-footer">
                            <?php
                            edit_post_link(
                                sprintf(
                                    wp_kses(
                                        __( 'Edit <span class="screen-reader-text">%s</span>', 'rediez' ),
                                        array(
                                            'span' => array(
                                                'class' => array(),
                                            ),
                                        )
                                    ),
                                    wp_kses_post( get_the_title() )
                                ),
                                '<span class="edit-link">',
                                '</span>'
                            );
                            ?>
                        </footer>
                    <?php endif; ?>
                </div>
            </div>
        </article>
    <?php
    endwhile;
    ?>
</div>

<?php
get_footer();