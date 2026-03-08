<?php
/**
 * Карточка мероприятия в архиве
 *
 * @package rediez
 */

$icon_path = get_template_directory_uri() . '/assets/images/icons/';
$price     = carbon_get_the_post_meta( 'crb_event_price' );
$date      = carbon_get_the_post_meta( 'crb_event_date' );

$date_formatted = $date ? date_i18n( 'd.m.Y H:i', strtotime( $date ) ) : '';
?>

<div class="events__item">
    <a href="<?php the_permalink(); ?>" class="events__link">
        <div class="events__info">

            <div class="events__top">
                <?php if ( $date_formatted ) : ?>
                    <div class="events__date date">
                        <span class="icom">
                            <img src="<?php echo esc_url( $icon_path . 'calendar-days.svg' ); ?>" alt="">
                        </span>
                        <span><?php echo esc_html( $date_formatted ); ?></span>
                    </div>
                <?php endif; ?>
            </div>

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
                    <span class="link-title__name"><?php esc_html_e( 'Подробнее', 'rediez' ); ?></span>
                    <span class="link-title__icon">
                        <img src="<?php echo esc_url( $icon_path . 'arrow-right.svg' ); ?>" alt="">
                    </span>
                </div>
            </div>

        </div>
    </a>
</div>