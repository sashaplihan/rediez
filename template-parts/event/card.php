<?php
/**
 * Детальная карточка мероприятия
 * @package rediez
 */

$icon_path = get_template_directory_uri() . '/assets/images/icons/';

// Основные поля
$price        = carbon_get_the_post_meta( 'crb_event_price' );
$date         = carbon_get_the_post_meta( 'crb_event_date' );
$accept_until = carbon_get_the_post_meta( 'crb_event_accept_until' );
$venue        = carbon_get_the_post_meta( 'crb_event_venue' );

// Set-поля (метки)
$event_types = carbon_get_the_post_meta( 'crb_event_types' );
$formats     = carbon_get_the_post_meta( 'crb_event_performance_format' );
$genres      = carbon_get_the_post_meta( 'crb_event_genre' );
$locations   = carbon_get_the_post_meta( 'crb_event_location' );

// Форматируем дату для вывода
$date_formatted         = $date         ? date_i18n( 'd.m.Y H:i', strtotime( $date ) )         : '';
$accept_until_formatted = $accept_until ? date_i18n( 'd.m.Y H:i', strtotime( $accept_until ) ) : '';

// Метки для тегов
$event_type_labels = array(
    'wedding'   => 'Свадьба',
    'corporate' => 'Корпоратив',
    'anniversary' => 'Юбилей',
    'kids'      => 'Детский праздник',
    'restaurant' => 'Ресторан',
    'club'      => 'Клуб',
    'festival'  => 'Фестиваль',
    'official'  => 'Официальные мероприятия',
    'studio'    => 'Студийная запись',
);

$format_labels = array(
    'covers'       => 'Каверы',
    'original'     => 'Авторские песни',
    'instrumental' => 'Инструментал',
    'dj_set'       => 'DJ-сет',
    'background'   => 'Фон (background)',
    'live'         => 'Живой звук',
    'recording'    => 'Запись в студии',
);

$genre_labels = array(
    'pop'        => 'Поп',
    'rock'       => 'Рок',
    'jazz'       => 'Джаз',
    'rap'        => 'Рэп',
    'electronic' => 'Электронная',
    'classical'  => 'Классика',
    'folk'       => 'Народная',
    'lounge'     => 'Лаунж',
    'retro'      => 'Ретро',
);

// Собираем все теги в один массив для вывода
$tags = array();
foreach ( (array) $event_types as $val ) {
    if ( isset( $event_type_labels[ $val ] ) ) $tags[] = $event_type_labels[ $val ];
}
foreach ( (array) $formats as $val ) {
    if ( isset( $format_labels[ $val ] ) ) $tags[] = $format_labels[ $val ];
}
foreach ( (array) $genres as $val ) {
    if ( isset( $genre_labels[ $val ] ) ) $tags[] = $genre_labels[ $val ];
}
?>

<div class="event-detail__grid">
    <div class="event-detail__wrapper event-card">

        <div class="event-card__top">
            <h1 class="event-card__title title"><?php the_title(); ?></h1>
            <?php if ( $price ) : ?>
                <div class="event-card__price">
                    <span class="icon">
                        <img src="<?php echo esc_url( $icon_path . 'money-icon.svg' ); ?>" alt="">
                    </span>
                    <span><?php echo esc_html( $price ); ?> BYN</span>
                </div>
            <?php endif; ?>
        </div>

        <div class="event-cart__top">
            <?php if ( $date_formatted ) : ?>
                <div class="event-cart__date date">
                    <span class="icon">
                        <img src="<?php echo esc_url( $icon_path . 'calendar-days.svg' ); ?>" alt="">
                    </span>
                    <span><?php echo esc_html( $date_formatted ); ?></span>
                </div>
            <?php endif; ?>

            <?php if ( $venue ) : ?>
                <div class="event-cart__place date">
                    <span class="icon">
                        <img src="<?php echo esc_url( $icon_path . 'location-icon.svg' ); ?>" alt="">
                    </span>
                    <span><?php echo esc_html( $venue ); ?></span>
                </div>
            <?php endif; ?>
        </div>

        <?php if ( ! empty( $tags ) ) : ?>
            <div class="event-card__tags tags">
                <?php foreach ( $tags as $tag ) : ?>
                    <span><?php echo esc_html( $tag ); ?></span>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <?php if ( get_the_content() ) : ?>
            <div class="event-card__description">
                <?php the_content(); ?>
            </div>
        <?php endif; ?>

        <div class="event-cart__bottom">
            <?php if ( get_the_date() ) : ?>
                <div class="event-cart__countdown">
                    <span>Размещено: </span>
                    <span><?php echo human_time_diff( get_the_time( 'U' ), current_time( 'timestamp' ) ) . ' назад'; ?></span>
                </div>
            <?php endif; ?>

            <?php if ( $accept_until_formatted ) : ?>
                <div class="event-cart__accepted">
                    <span>Приём откликов до: </span>
                    <span><?php echo esc_html( $accept_until_formatted ); ?></span>
                </div>
            <?php endif; ?>
        </div>

    </div>
</div>