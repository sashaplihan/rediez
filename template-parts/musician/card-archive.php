<?php
/**
 * The template for displaying card archive
 *
 * @package rediez
 */

// Получаем данные из Carbon Fields
$price = carbon_get_the_post_meta( 'crb_musician_price' );
$performer_types = carbon_get_the_post_meta( 'crb_musician_performer_type' );

// Массив типов исполнителей
$performer_type_labels = array(
    'band'           => 'Группа',
    'solo'           => 'Сольный артист',
    'duo'            => 'Дуэт',
    'dj'             => 'DJ',
    'instrumentalist' => 'Инструменталист',
    'session'        => 'Сессионный музыкант',
);

// Получаем первый тип исполнителя
$performer_type_label = '';
if ( ! empty( $performer_types ) && isset( $performer_type_labels[ $performer_types[0] ] ) ) {
    $performer_type_label = $performer_type_labels[ $performer_types[0] ];
}

// Путь к иконкам
$icon_path = get_template_directory_uri() . '/assets/images/icons/';

// Заглушка для изображения
$placeholder = get_template_directory_uri() . '/assets/images/no-photo-rediez.svg';
?>

<div class="musicians-catalog__item artisan">
    <a href="<?php the_permalink(); ?>" class="artisan__link">
        
        <!-- Изображение -->
        <?php if ( has_post_thumbnail() ) : ?>
            <?php the_post_thumbnail( 'medium_large', array(
                'class' => 'artisan__image',
                'alt'   => get_the_title()
            ) ); ?>
        <?php else : ?>
            <img src="<?php echo esc_url( $placeholder ); ?>" 
                 alt="<?php echo esc_attr( get_the_title() ); ?>" 
                 class="artisan__image">
        <?php endif; ?>
        
        <div class="artisan__info">
            
            <!-- Название -->
            <h3 class="artisan__name"><?php the_title(); ?></h3>
            
            <!-- Тип исполнителя -->
            <?php if ( $performer_type_label ) : ?>
                <span class="artisan__style"><?php echo esc_html( $performer_type_label ); ?></span>
            <?php endif; ?>
            
            <div class="artisan__bottom">
                
                <!-- Цена -->
                <span class="artisan__price">
                    <?php if ( $price ) : ?>
                        от <?php echo esc_html( $price ); ?> BYN
                    <?php else : ?>
                        Договорная
                    <?php endif; ?>
                </span>
                
                <!-- Кнопка "Подробнее" -->
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