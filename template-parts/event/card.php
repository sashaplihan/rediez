<?php
/**
 * Детальная карточка мероприятия
 * @package rediez
 */

$icon_path = get_template_directory_uri() . '/assets/images/icons/';

// Основные поля — единый стиль через carbon_get_post_meta
$post_id      = get_the_ID();
$description  = carbon_get_post_meta( $post_id, 'crb_event_description' );
$price        = carbon_get_post_meta( $post_id, 'crb_event_price' );
$date         = carbon_get_post_meta( $post_id, 'crb_event_date' );
$accept_until = carbon_get_post_meta( $post_id, 'crb_event_accept_until' );
$venue        = carbon_get_post_meta( $post_id, 'crb_event_venue' );

// Форматируем дату для вывода
$date_formatted         = $date         ? date_i18n( 'd.m.Y H:i', strtotime( $date ) )         : '';
$accept_until_formatted = $accept_until ? date_i18n( 'd.m.Y H:i', strtotime( $accept_until ) ) : '';

/**
 * Справочники меток (labels) — синхронизировано с Carbon Fields
 * Вынесено в массив для удобного обхода
 */
$tags_config = array(
    'crb_event_types' => array(
        'corporate'    => 'Корпоративное мероприятие',
        'wedding'      => 'Свадьба, банкет, юбилей',
        'kids'         => 'Детский праздник',
        'registration' => 'Выездная регистрация/поздравление',
        'concert'      => 'Концерт/трибьют',
        'music'        => 'Музыкальное сопровождение',
        'dj_set'       => 'DJ-сет',
        'other'        => 'Другое',
    ),
    'crb_event_performer_type' => array(
        'band'            => 'Группа',
        'solo'            => 'Сольный артист',
        'session'         => 'Сессионный музыкант',
        'vocalist'        => 'Вокалист',
        'instrumentalist' => 'Инструменталист',
        'duo'             => 'Дуэт',
        'trio'            => 'Трио',
        'quartet'         => 'Квартет',
        'dj'              => 'DJ',
        'event_dj'        => 'Event-DJ',
        'other'           => 'Другое',
    ),
    'crb_event_performance_format' => array(
        'original' => 'Авторский репертуар',
        'covers'   => 'Кавер',
    ),
    'crb_event_genre' => array(
        'pop'        => 'Поп (популярная музыка, данс-поп, синти-поп, евро-поп)',
        'rock'       => 'Рок (рок-н-ролл, хард-рок, панк-рок, альтернативный рок, метал)',
        'blues'      => 'Блюз (кантри-блюз, дельта-блюз, чикагский блюз)',
        'jazz'       => 'Джаз (свинг, бибоп, лаунж, фьюжн, регтайм)',
        'rnb'        => 'R&B (ритм-энд-блюз, соул, фанк, contemporary R&B)',
        'country'    => 'Кантри (вестерн, блюграсс, аутло-кантри)',
        'reggae'     => 'Регги (ска, рокстеди, даб)',
        'hiphop'     => 'Хип-хоп (рэп, трэп, осознанный хип-хоп, old school)',
        'electronic' => 'Электронная музыка (хаус, техно, дабстеп, транс, drum and bass, эмбиент, чилаут, нью-эйдж)',
        'classical'  => 'Классическая музыка (симфония, опера, камерная, соната)',
        'folk'       => 'Фолк (народная музыка, акустический фолк, инди-фолк)',
        'latin'      => 'Латиноамериканская (сальса, самба, реггетон, бачата, танго)',
        'chanson'    => 'Шансон / авторская песня (французский шансон, русский шансон, бардовская песня)',
        'other'      => 'Другое',
    ),
    'crb_event_lineup' => array(
        'keys'       => 'Клавишные (рояль, пианино, синтезатор, орган, аккордеон)',
        'strings'    => 'Струнные (гитара, бас-гитара, скрипка, виолончель, арфа)',
        'brass'      => 'Духовые (флейта, саксофон, труба, кларнет)',
        'drums'      => 'Ударные (установка, перкуссия, малый барабан, ханг)',
        'folk'       => 'Народные (баян, балалайка, домра, цимбалы)',
        'electronic' => 'Электроника (семплер, драм-машина, midi-клавиши)',
        'vocal'      => 'Вокал (солист, бэк-вокалист)',
    ),
    'crb_event_location' => array(
        'minsk'   => 'Минск и Минская область',
        'brest'   => 'Брест и Брестская область',
        'vitebsk' => 'Витебск и Витебская область',
        'gomel'   => 'Гомель и Гомельская область',
        'grodno'  => 'Гродно и Гродненская область',
        'mogilev' => 'Могилёв и Могилёвская область',
    ),
);

// Собираем все теги в один массив
$tags = array();
foreach ( $tags_config as $meta_key => $labels ) {
    $meta_values = (array) carbon_get_the_post_meta( $meta_key );
    foreach ( $meta_values as $val ) {
        if ( isset( $labels[ $val ] ) ) {
            $tags[] = $labels[ $val ];
        }
    }
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
                <?php foreach ( $tags as $tag ) : 
                    // Очищаем текст от скобок и лишних пробелов перед ними
                    $clean_tag = preg_replace('/ \s*\(.*?\)/u', '', $tag); 
                ?>
                    <span><?php echo esc_html( trim( $clean_tag ) ); ?></span>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

		<?php if ( $description ) : ?>
			<div class="event-card__description">
				<?php echo wp_kses_post( nl2br( esc_html( $description ) ) ); ?>
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