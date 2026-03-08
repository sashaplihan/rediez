<?php
/**
 * Секция Афиш для Главной страницы
 */

$page_id = get_the_ID();
// Проверяем чекбокс. В Carbon Fields он вернет true, если галочка стоит.
$show_section = carbon_get_post_meta( $page_id, 'show_poster_section' );

if ( $show_section ) : 
    $selected_data = carbon_get_post_meta( $page_id, 'home_selected_posters' );
    $post_ids = !empty($selected_data) ? wp_list_pluck( $selected_data, 'id' ) : [];

    if ( !empty($post_ids) ) :
        $poster_query = new WP_Query( array(
            'post_type'      => 'rediez_poster',
            'post__in'       => $post_ids,
            'orderby'        => 'post__in', 
            'posts_per_page' => -1,
        ) );

        if ( $poster_query->have_posts() ) : ?>

        <section class="poster">
            <div class="container">
                <div class="poster__header">
                    <h2 class="poster__title">Интерактивная <span>афиша</span></h2>
                    
                    <a href="<?php echo get_post_type_archive_link( 'rediez_poster' ); ?>" class="title_link btn--primary">
                        <span class="link-title__name">Все</span>
                        <span class="link-title__icon">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/icons/arrow-right.svg" alt="">
                        </span>
                    </a>
                </div>

                <div class="poster__slider swiper">
                    <div class="swiper-wrapper">

                        <?php while ( $poster_query->have_posts() ) : $poster_query->the_post(); 
                            $external_url = carbon_get_post_meta( get_the_ID(), 'poster_external_url' );
                            $final_link = ! empty( $external_url ) ? esc_url( $external_url ) : get_permalink();
                        ?>

                            <div class="poster-slide swiper-slide">
                                <a href="<?php echo $final_link; ?>" class="poster-slide__link">
                                    <div class="poster-slide__image">
                                        <?php if ( has_post_thumbnail() ) : ?>
                                            <?php the_post_thumbnail( 'large' ); ?>
                                        <?php endif; ?>
                                    </div>

                                    <div class="poster-slide__content">
                                        <div class="poster-slide__date date">
                                            <span class="icom">
                                                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/icons/calendar-days.svg" alt="">
                                            </span>
                                            <span><?php echo get_the_date( 'd.m.Y H.i' ); ?></span>
                                        </div>

                                        <h3 class="poster-slide__name"><?php the_title(); ?></h3>
                                        
                                        <div class="poster-slide__descr">
                                            <?php echo wp_trim_words( get_the_excerpt(), 12, '...' ); ?>
                                        </div>

                                        <div class="link-title">
                                            <span class="link-title__name">Подробнее</span>
                                            <span class="link-title__icon">
                                                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/icons/arrow-right.svg" alt="">
                                            </span>
                                        </div>
                                    </div>
                                </a>
                            </div>

                        <?php endwhile; wp_reset_postdata(); ?>

                    </div>
                    <div class="poster__navigation swiper-button-prev"></div>
                    <div class="poster__navigation swiper-button-next"></div>
                    <div class="poster__pagination swiper-pagination"></div>
                </div>
            </div>
        </section>

        <?php endif; 
    endif; 
endif; ?>