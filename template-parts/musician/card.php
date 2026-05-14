<?php
/**
 * Карточка музыканта
 *
 * @package rediez
 */

// Получаем данные
$musician_description = carbon_get_the_post_meta( 'crb_musician_description' );
$price = carbon_get_the_post_meta( 'crb_musician_price' );
$phone = carbon_get_the_post_meta( 'crb_musician_phone' );
$email = carbon_get_the_post_meta( 'crb_musician_email' );

// Социальные сети
$telegram = carbon_get_the_post_meta( 'crb_musician_telegram' );
$instagram = carbon_get_the_post_meta( 'crb_musician_instagram' );
$viber = carbon_get_the_post_meta( 'crb_musician_viber' );
$tiktok = carbon_get_the_post_meta( 'crb_musician_tiktok' );
$vk = carbon_get_the_post_meta( 'crb_musician_vk' );
$ok = carbon_get_the_post_meta( 'crb_musician_ok' );

// Теги
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

    'performance_format' => array(
        'original' => 'Авторский репертуар',
        'covers'   => 'Кавер',
    ),
    'genres' => array(
        'pop'        => 'Поп (популярная, данс-, евро-поп…)',
        'rock'       => 'Рок (рок-н-ролл, хард-рок, альтернатива, панк, метал…)',
        'blues'      => 'Блюз (кантри-, дельта-, чикагский блюз…)',
        'jazz'       => 'Джаз (свинг, лаунж…)',
        'rnb'        => 'R&B (ритм-энд-блюз, соул, фанк…)',
        'country'    => 'Кантри (вестерн, блюграсс…)',
        'reggae'     => 'Регги (ска, рокстеди, даб)',
        'hiphop'     => 'Хип-хоп (рэп, трэп, old school)',
        'electronic' => 'Электронная музыка (хаус, техно, транс, drum and bass, чилаут…)',
        'classical'  => 'Классическая музыка (симфония, опера, соната…)',
        'folk'       => 'Фолк (народная музыка, акустический фолк…)',
        'latin'      => 'Латиноамериканская (сальса, самба, бачата, танго)',
        'chanson'    => 'Шансон / авторская песня (французский шансон, русский шансон, бардовская песня)',
        'other'      => 'Другое',
    ),
    'performer_types' => array(
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
    'lineup' => array(
        'keys'       => 'Клавишные (рояль, пианино, синтезатор, орган, аккордеон)',
        'strings'    => 'Струнные (гитара, бас-гитара, скрипка, виолончель, арфа)',
        'brass'      => 'Духовые (флейта, саксофон, труба, кларнет, гобой, тромбон)',
        'drums'      => 'Ударные (установка, перкуссия, малый барабан, ханг)',
        'folk'       => 'Народные (баян, балалайка, домра, цимбалы)',
        'electronic' => 'Электроника (семплер, драм-машина, midi-клавиши)',
        'vocal'      => 'Вокал (солист, бэк-вокалист)',
    ),
    'locations' => array(
        'minsk'   => 'Минск и Минская область',
        'brest'   => 'Брест и Брестская область',
        'vitebsk' => 'Витебск и Витебская область',
        'gomel'   => 'Гомель и Гомельская область',
        'grodno'  => 'Гродно и Гродненская область',
        'mogilev' => 'Могилёв и Могилёвская область',
    ),
);

// Собираем все теги в один массив
$all_tags = array();

// Добавляем теги в порядке настроек
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
					<?php foreach ( $all_tags as $tag ) : 
						// Регулярка: ищем пробел (необязательно) и текст в скобках
						// / \s*\(.*?\)/ — удалит "(текст)" и пробелы перед ними
						$clean_tag = preg_replace('/ \s*\(.*?\)/u', '', $tag); 
						?>
						<span><?php echo esc_html( trim($clean_tag) ); ?></span>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
            
            <!-- Описание -->
			<?php if ( ! empty( $musician_description ) ) : ?>
				<div class="musician-card__description">
					<?php echo wpautop( esc_html( $musician_description ) ); ?>
				</div>
			<?php endif; ?>
            
            <hr>
            
            <!-- Контакты -->
            <?php if ( $phone || $email || $telegram || $instagram || $viber || $tiktok || $vk || $ok ) : ?>
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
                        <?php if ( $telegram || $instagram || $viber || $tiktok || $vk || $ok ) : ?>
                            <div class="contact__bottom network">
                                
                                <?php if ( $telegram ) : ?>
                                    <a href="<?php echo esc_url( $telegram ); ?>" 
                                       class="network__icon" 
                                       target="_blank" 
                                       rel="noopener noreferrer">
                                        <img src="<?php echo esc_url( $icon_path . 'telegram-plane.svg' ); ?>" alt="Telegram">
                                    </a>
                                <?php endif; ?>
                                
                                <?php if ( $instagram ) : ?>
                                    <a href="<?php echo esc_url( $instagram ); ?>" 
                                       class="network__icon" 
                                       target="_blank" 
                                       rel="noopener noreferrer">
                                        <img src="<?php echo esc_url( $icon_path . 'instagram.svg' ); ?>" alt="Instagram">
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
                                        <img src="<?php echo esc_url( $icon_path . 'vk-icon.svg' ); ?>" alt="VK">
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