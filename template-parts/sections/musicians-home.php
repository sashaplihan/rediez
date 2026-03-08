<?php
/**
 * Секция Музыкантов для Главной страницы
 */

$page_id = get_the_ID();
$show_section = carbon_get_post_meta( $page_id, 'show_musicians_section' );

if ( $show_section ) :
    $selected_data = carbon_get_post_meta( $page_id, 'home_selected_musicians' );
    $post_ids = !empty( $selected_data ) ? wp_list_pluck( $selected_data, 'id' ) : [];

    if ( !empty( $post_ids ) ) :
        $musicians_query = new WP_Query( array(
            'post_type'      => 'rediez_musicians',
            'post__in'       => $post_ids,
            'orderby'        => 'post__in',
            'posts_per_page' => -1,
        ) );

        $performer_type_labels = array(
            'band'            => 'Группа',
            'solo'            => 'Сольный артист',
            'duo'             => 'Дуэт',
            'dj'              => 'DJ',
            'instrumentalist' => 'Инструменталист',
            'session'         => 'Сессионный музыкант',
        );

        $placeholder = get_template_directory_uri() . '/assets/images/no-photo-rediez.svg';
        $icon_path   = get_template_directory_uri() . '/assets/images/icons/';

        if ( $musicians_query->have_posts() ) : ?>

        <section class="musicians">
            <div class="container">
                <div class="musicians__header">
                    <h2 class="musicians__title">Топ <span>музыканты</span></h2>

                    <a href="<?php echo get_post_type_archive_link( 'rediez_musicians' ); ?>" class="title_link btn--primary">
                        <span class="link-title__name">Все</span>
                        <span class="link-title__icon">
                            <img src="<?php echo $icon_path; ?>arrow-right.svg" alt="">
                        </span>
                    </a>
                </div>

                <div class="musicians__slider swiper">
                    <div class="swiper-wrapper">

                        <?php while ( $musicians_query->have_posts() ) : $musicians_query->the_post();
                            $price           = carbon_get_the_post_meta( 'crb_musician_price' );
                            $performer_types = carbon_get_the_post_meta( 'crb_musician_performer_type' );
                            $performer_label = '';
                            if ( !empty( $performer_types ) && isset( $performer_type_labels[ $performer_types[0] ] ) ) {
                                $performer_label = $performer_type_labels[ $performer_types[0] ];
                            }
                        ?>

                            <div class="musicians__slide swiper-slide">
                                <a href="<?php the_permalink(); ?>" class="musicians__link">

                                    <?php if ( has_post_thumbnail() ) : ?>
                                        <?php the_post_thumbnail( 'medium_large', array(
                                            'class' => 'musicians__image',
                                            'alt'   => get_the_title(),
                                        ) ); ?>
                                    <?php else : ?>
                                        <img src="<?php echo esc_url( $placeholder ); ?>"
                                             alt="<?php echo esc_attr( get_the_title() ); ?>"
                                             class="musicians__image">
                                    <?php endif; ?>

                                    <div class="musicians__info">
                                        <h3 class="musicians__name"><?php the_title(); ?></h3>

                                        <?php if ( $performer_label ) : ?>
                                            <span class="musicians__style"><?php echo esc_html( $performer_label ); ?></span>
                                        <?php endif; ?>

                                        <div class="musicians__bottom">
                                            <span class="musicians__price">
                                                <?php if ( $price ) : ?>
                                                    от <?php echo esc_html( $price ); ?> BYN
                                                <?php else : ?>
                                                    Договорная
                                                <?php endif; ?>
                                            </span>
                                            <div class="link-title">
                                                <span class="link-title__name">Подробнее</span>
                                                <span class="link-title__icon">
                                                    <img src="<?php echo $icon_path; ?>arrow-right.svg" alt="">
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                </a>
                            </div>

                        <?php endwhile; wp_reset_postdata(); ?>

                    </div>
                    <div class="musicians__navigation swiper-button-prev"></div>
                    <div class="musicians__navigation swiper-button-next"></div>
                    <div class="musicians__pagination swiper-pagination"></div>
                </div>
            </div>
        </section>

        <?php endif;
    endif;
endif; ?>