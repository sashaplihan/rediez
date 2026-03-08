<?php
/**
 * Карточка музыканта
 *
 * @package rediez
 */

// Получаем данные
$price = carbon_get_the_post_meta( 'crb_musician_price' );
$phone = carbon_get_the_post_meta( 'crb_musician_phone' );
$email = carbon_get_the_post_meta( 'crb_musician_email' );

// Социальные сети
$telegram = carbon_get_the_post_meta( 'crb_musician_telegram' );
$whatsapp = carbon_get_the_post_meta( 'crb_musician_whatsapp' );
$viber = carbon_get_the_post_meta( 'crb_musician_viber' );
$tiktok = carbon_get_the_post_meta( 'crb_musician_tiktok' );
$vk = carbon_get_the_post_meta( 'crb_musician_vk' );
$ok = carbon_get_the_post_meta( 'crb_musician_ok' );

// Теги
$event_types = carbon_get_the_post_meta( 'crb_musician_event_types' );
$performance_format = carbon_get_the_post_meta( 'crb_musician_performance_format' );
$genres = carbon_get_the_post_meta( 'crb_musician_genre' );
$performer_types = carbon_get_the_post_meta( 'crb_musician_performer_type' );
$lineup = carbon_get_the_post_meta( 'crb_musician_lineup' );
$locations = carbon_get_the_post_meta( 'crb_musician_location' );
$travel = carbon_get_the_post_meta( 'crb_musician_travel' );

// Путь к иконкам
$icon_path = get_template_directory_uri() . '/assets/images/icons/';

// Массив меток для тегов (в порядке как в Carbon Fields)
$tag_labels = array(
    'event_types' => array(
        'wedding' => 'Свадьба',
        'corporate' => 'Корпоратив',
        'anniversary' => 'Юбилей',
        'kids' => 'Детский праздник',
        'restaurant' => 'Ресторан',
        'club' => 'Клуб',
        'festival' => 'Фестиваль',
        'Official' => 'Официальные мероприятия',
        'studio' => 'Студийная запись',
    ),
    'performance_format' => array(
        'covers' => 'Каверы',
        'original' => 'Авторские песни',
        'instrumental' => 'Инструментал',
        'dj_set' => 'DJ-сет',
        'background' => 'Фон',
        'live' => 'Живой звук',
    ),
    'genres' => array(
        'pop' => 'Поп',
        'rock' => 'Рок',
        'jazz' => 'Джаз',
        'rap' => 'Рэп',
        'electronic' => 'Электронная',
        'classical' => 'Классика',
        'folk' => 'Народная',
        'lounge' => 'Лаунж',
        'retro' => 'Ретро, диско',
        'author' => 'Авторская песня',
    ),
    'performer_types' => array(
        'band' => 'Группа',
        'solo' => 'Сольный артист',
        'duo' => 'Дуэт',
        'dj' => 'DJ',
        'instrumentalist' => 'Инструменталист',
        'session' => 'Сессионный музыкант',
    ),
    'lineup' => array(
        'vocal' => 'Вокал',
        'brass' => 'Духовые',
        'strings' => 'Струнные',
        'drums' => 'Ударные',
        'electronic' => 'Электронные',
    ),
    'locations' => array(
        'minsk' => 'Минск',
        'brest' => 'Брест',
        'vitebsk' => 'Витебск',
        'gomel' => 'Гомель',
        'grodno' => 'Гродно',
        'mogilev' => 'Могилёв',
    ),
);

// Собираем все теги в один массив
$all_tags = array();

// Добавляем теги в порядке настроек
if ( $event_types ) {
    foreach ( $event_types as $tag ) {
        if ( isset( $tag_labels['event_types'][$tag] ) ) {
            $all_tags[] = $tag_labels['event_types'][$tag];
        }
    }
}

if ( $performance_format ) {
    foreach ( $performance_format as $tag ) {
        if ( isset( $tag_labels['performance_format'][$tag] ) ) {
            $all_tags[] = $tag_labels['performance_format'][$tag];
        }
    }
}

if ( $genres ) {
    foreach ( $genres as $tag ) {
        if ( isset( $tag_labels['genres'][$tag] ) ) {
            $all_tags[] = $tag_labels['genres'][$tag];
        }
    }
}

if ( $performer_types ) {
    foreach ( $performer_types as $tag ) {
        if ( isset( $tag_labels['performer_types'][$tag] ) ) {
            $all_tags[] = $tag_labels['performer_types'][$tag];
        }
    }
}

if ( $lineup ) {
    foreach ( $lineup as $tag ) {
        if ( isset( $tag_labels['lineup'][$tag] ) ) {
            $all_tags[] = $tag_labels['lineup'][$tag];
        }
    }
}

if ( $locations ) {
    foreach ( $locations as $tag ) {
        if ( isset( $tag_labels['locations'][$tag] ) ) {
            $all_tags[] = $tag_labels['locations'][$tag];
        }
    }
}

if ( $travel === 'yes' ) {
    $all_tags[] = 'Готов к выездам';
}
?>

<div class="musician-detail__grid">
    
    <!-- Левая колонка: главное изображение -->
    <div class="musician-detail__left">
        <?php if ( has_post_thumbnail() ) : ?>
            <?php the_post_thumbnail( 'large', array( 'alt' => get_the_title() ) ); ?>
        <?php else : ?>
            <img src="<?php echo esc_url( get_template_directory_uri() . '/img/placeholder-musician.jpg' ); ?>" 
                 alt="<?php echo esc_attr( get_the_title() ); ?>">
        <?php endif; ?>
    </div>
    
    <!-- Правая колонка: информация -->
    <div class="musician-detail__right">
        <div class="musician-detail__wrapper musician-card">
            
            <!-- Верхняя часть: название и цена -->
            <div class="musician-card__top">
                <h1 class="musician-card__title title"><?php the_title(); ?></h1>
                
                <?php if ( $price ) : ?>
                    <div class="musician-card__price">
                        <span class="icon">
                            <img src="<?php echo esc_url( $icon_path . 'money.svg' ); ?>" alt="">
                        </span>
                        <span><?php echo esc_html( $price ); ?> BYN / час</span>
                    </div>
                <?php endif; ?>
            </div>
            
            <!-- Теги -->
            <?php if ( ! empty( $all_tags ) ) : ?>
                <div class="musician-card__tags tags">
                    <?php foreach ( $all_tags as $tag ) : ?>
                        <span><?php echo esc_html( $tag ); ?></span>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            
            <!-- Описание -->
            <?php if ( get_the_content() ) : ?>
                <div class="musician-card__description">
                    <?php the_content(); ?>
                </div>
            <?php endif; ?>
            
            <hr>
            
            <!-- Контакты -->
            <?php if ( $phone || $email || $telegram || $whatsapp || $viber || $tiktok || $vk || $ok ) : ?>
                <div class="musician-card__contact contact">
                    <h2>Связаться с нами:</h2>
                    <div class="contact__wrap">
                        
                        <!-- Телефон и Email -->
                        <?php if ( $phone || $email ) : ?>
                            <div class="contact__top">
                                <?php if ( $phone ) : 
                                    $phone_clean = preg_replace( '/[^0-9+]/', '', $phone );
                                    ?>
                                    <a href="tel:<?php echo esc_attr( $phone_clean ); ?>">
                                        <span>
                                            <img src="<?php echo esc_url( $icon_path . 'phone.svg' ); ?>" alt="">
                                        </span>
                                        <?php echo esc_html( $phone ); ?>
                                    </a>
                                <?php endif; ?>
                                
                                <?php if ( $email ) : ?>
                                    <a href="mailto:<?php echo esc_attr( $email ); ?>">
                                        <span>
                                            <img src="<?php echo esc_url( $icon_path . 'envelope.svg' ); ?>" alt="">
                                        </span>
                                        <?php echo esc_html( $email ); ?>
                                    </a>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                        
                        <!-- Социальные сети -->
                        <?php if ( $telegram || $whatsapp || $viber || $tiktok || $vk || $ok ) : ?>
                            <div class="contact__bottom network">
                                
                                <?php if ( $telegram ) : ?>
                                    <a href="<?php echo esc_url( $telegram ); ?>" 
                                       class="network__icon" 
                                       target="_blank" 
                                       rel="noopener noreferrer">
                                        <img src="<?php echo esc_url( $icon_path . 'telegram.svg' ); ?>" alt="Telegram">
                                    </a>
                                <?php endif; ?>
                                
                                <?php if ( $whatsapp ) : 
                                    $whatsapp_clean = preg_replace( '/[^0-9]/', '', $whatsapp );
                                    ?>
                                    <a href="https://wa.me/<?php echo esc_attr( $whatsapp_clean ); ?>" 
                                       class="network__icon" 
                                       target="_blank" 
                                       rel="noopener noreferrer">
                                        <img src="<?php echo esc_url( $icon_path . 'whatsapp.svg' ); ?>" alt="WhatsApp">
                                    </a>
                                <?php endif; ?>
                                
                                <?php if ( $viber ) : 
                                    $viber_clean = preg_replace( '/[^0-9]/', '', $viber );
                                    ?>
                                    <a href="viber://chat?number=<?php echo esc_attr( $viber_clean ); ?>" 
                                       class="network__icon">
                                        <img src="<?php echo esc_url( $icon_path . 'viber.svg' ); ?>" alt="Viber">
                                    </a>
                                <?php endif; ?>
                                
                                <?php if ( $tiktok ) : ?>
                                    <a href="<?php echo esc_url( $tiktok ); ?>" 
                                       class="network__icon" 
                                       target="_blank" 
                                       rel="noopener noreferrer">
                                        <img src="<?php echo esc_url( $icon_path . 'tiktok.svg' ); ?>" alt="TikTok">
                                    </a>
                                <?php endif; ?>
                                
                                <?php if ( $vk ) : ?>
                                    <a href="<?php echo esc_url( $vk ); ?>" 
                                       class="network__icon" 
                                       target="_blank" 
                                       rel="noopener noreferrer">
                                        <img src="<?php echo esc_url( $icon_path . 'vk.svg' ); ?>" alt="VK">
                                    </a>
                                <?php endif; ?>
                                
                                <?php if ( $ok ) : ?>
                                    <a href="<?php echo esc_url( $ok ); ?>" 
                                       class="network__icon" 
                                       target="_blank" 
                                       rel="noopener noreferrer">
                                        <img src="<?php echo esc_url( $icon_path . 'odnoklassniki.svg' ); ?>" alt="Одноклассники">
                                    </a>
                                <?php endif; ?>
                                
                            </div>
                        <?php endif; ?>
                        
                    </div>
                </div>
            <?php endif; ?>
            
        </div>
    </div>
    
</div>