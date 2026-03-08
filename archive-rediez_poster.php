<?php
/**
 * The template for displaying Poster Archive (Афиша)
 * @package rediez
 */

get_header(); ?>

<div class="poster-catalog">
    <div class="container">
        <div class="row">
            <div class="poster-catalog__header">
                <h1 class="poster-catalog__title title">Афиша</h1>
            </div>
            <div class="poster-catalog__body">
                <section class="poster">
                    <div class="poster__grid">

                        <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); 
                            // Получаем внешнюю ссылку из Carbon Fields
                            $external_url = carbon_get_post_meta( get_the_ID(), 'poster_external_url' );
                            
                            // Если ссылка есть — ведем на неё, если нет — на внутреннюю страницу
                            $final_link = ! empty( $external_url ) ? esc_url( $external_url ) : get_permalink();
                            
                            // Атрибуты для внешних ссылок
                            $link_attr = ! empty( $external_url ) ? ' target="_blank" rel="nofollow"' : '';
                        ?>

                            <div class="poster__item">
                                <a href="<?php echo $final_link; ?>" class="poster-slide__link"<?php echo $link_attr; ?>>
                                    <div class="poster-slide__image">
                                        <?php if ( has_post_thumbnail() ) : ?>
                                            <?php the_post_thumbnail( 'large', [ 'alt' => get_the_title() ] ); ?>
                                        <?php else : ?>
                                            <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/no-image.jpg" alt="<?php the_title(); ?>">
                                        <?php endif; ?>
                                    </div>

                                    <div class="poster-slide__content">
                                        <div class="poster-slide__date date">
                                            <span class="icom">
                                                <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/icons/calendar-days.svg" alt="calendar">
                                            </span>
                                            <span><?php echo get_the_date( 'd.m.Y H.i' ); ?></span>
                                        </div>

                                        <h3 class="poster-slide__name"><?php the_title(); ?></h3>

                                        <div class="poster-slide__description">
                                            <?php 
                                                echo wp_trim_words( get_the_excerpt(), 15, '...' ); 
                                            ?>
                                        </div>

                                        <div class="link-title">
                                            <span class="link-title__name">Подробнее</span>
                                            <span class="link-title__icon">
                                                <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/icons/arrow-right.svg" alt="arrow">
                                            </span>
                                        </div>
                                    </div>
                                </a>
                            </div>

                        <?php endwhile; endif; ?>

                    </div> </section>

                <?php 
                get_template_part( 'template-parts/pagination' ); 
                ?>

            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>