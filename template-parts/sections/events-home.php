<?php
/**
 * Секция мероприятий на главной странице
 *
 * @package rediez
 */

$page_id      = get_the_ID();
$show_section = carbon_get_post_meta( $page_id, 'show_events_section' );

if ( ! $show_section ) return;

$selected_data = carbon_get_post_meta( $page_id, 'home_selected_events' );
$post_ids      = ! empty( $selected_data ) ? wp_list_pluck( $selected_data, 'id' ) : array();

if ( empty( $post_ids ) ) return;

$events_query = new WP_Query( array(
    'post_type'      => 'rediez_events',
    'post__in'       => $post_ids,
    'orderby'        => 'post__in',
    'posts_per_page' => -1,
    'post_status'    => 'publish',
) );

if ( ! $events_query->have_posts() ) return;

$icon_path = get_template_directory_uri() . '/assets/images/icons/';
?>

<section class="events">
    <div class="container">

        <div class="events__header">
            <h2 class="events__title">Популярные <span>ивенты</span></h2>
            <a href="<?php echo esc_url( get_post_type_archive_link( 'rediez_events' ) ); ?>" class="title_link btn--primary">
                <span class="link-title__name">Все</span>
                <span class="link-title__icon">
                    <img src="<?php echo esc_url( $icon_path . 'arrow-right.svg' ); ?>" alt="">
                </span>
            </a>
        </div>

        <div class="events__grid">

            <?php while ( $events_query->have_posts() ) : $events_query->the_post();
                $price = carbon_get_the_post_meta( 'crb_event_price' );
                $date  = carbon_get_the_post_meta( 'crb_event_date' );
                $date_formatted = $date ? date_i18n( 'd.m.Y H:i', strtotime( $date ) ) : '';
            ?>

                <div class="events__item">
                    <a href="<?php the_permalink(); ?>" class="events__link">
                        <div class="events__info">

                            <?php if ( $date_formatted ) : ?>
                                <div class="events__date date">
                                    <span class="icom">
                                        <img src="<?php echo esc_url( $icon_path . 'calendar-days.svg' ); ?>" alt="">
                                    </span>
                                    <span><?php echo esc_html( $date_formatted ); ?></span>
                                </div>
                            <?php endif; ?>

                            <h3 class="events__name"><?php the_title(); ?></h3>

                            <?php if ( get_the_excerpt() ) : ?>
                                <p class="events__desc"><?php echo wp_trim_words( get_the_excerpt(), 10, '...' ); ?></p>
                            <?php endif; ?>

                            <div class="events__bottom">
                                <span class="events__price">
                                    <?php if ( $price ) : ?>
                                        <?php echo esc_html( $price ); ?> BYN
                                    <?php else : ?>
                                        Договорная
                                    <?php endif; ?>
                                </span>
                                <div class="link-title">
                                    <span class="link-title__name">Подробнее</span>
                                    <span class="link-title__icon">
                                        <img src="<?php echo esc_url( $icon_path . 'arrow-right.svg' ); ?>" alt="">
                                    </span>
                                </div>
                            </div>

                        </div>
                    </a>
                </div>

            <?php endwhile; wp_reset_postdata(); ?>

        </div>

    </div>
</section>