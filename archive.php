<?php
/**
 * The template for displaying news archive pages 
 */
get_header();
?>

<div class="news-catalog">
    <div class="container">
        <div class="row">
            
            <div class="news-catalog__header">
                <h1 class="news-catalog__title title">
                    <?php 
                    if ( is_home() && ! is_front_page() ) {
                        single_post_title();
                    } elseif ( is_archive() ) {
                        the_archive_title();
                    } else {
                        echo 'Новости';
                    }
                    ?>
                </h1>
            </div>

            <div class="news-catalog__body">
                <?php if ( have_posts() ) : ?>
                    <section class="news">
                        <div class="news__grid">
                            <?php
                            while ( have_posts() ) :
                                the_post();
                                // Подключаем карточку новости
                                get_template_part( 'template-parts/content', 'news' );
                            endwhile;
                            ?>
                        </div>
                    </section>

                    <?php
                    // Подключаем твой шаблон пагинации
                    get_template_part( 'template-parts/pagination' );
                    ?>

                <?php else : ?>
                    <p>Новостей пока нет.</p>
                <?php endif; ?>
            </div>

        </div>
    </div>
</div>

<?php
get_footer();
